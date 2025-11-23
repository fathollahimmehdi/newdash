<?php
// ====================================================================
// setup.php — نصب اولیه پروژه (Idempotent)
// ====================================================================
// ✔ ساخت فولدرها
// ✔ دانلود Bootstrap, Alpine.js, DataTables
// ✔ ساخت دیتابیس و اجرای مایگریشن‌ها
// ✔ اجرای Seed ها
// ✔ تولید فایل config.php و database.php در صورت عدم وجود
// ====================================================================

error_reporting(E_ALL);
ini_set('display_errors', 1);

$root = __DIR__;

// -----------------------------
// 1) Load .env
// -----------------------------
$envFile = $root . '/.env';
if (!file_exists($envFile)) {
    die("⚠️ فایل .env موجود نیست. لطفاً .env.example را کپی و ویرایش کنید.
");
}

function parseEnv($filepath) {
    $env = [];
    $lines = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        if (!str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $env[trim($key)] = trim($value);
    }
    return $env;
}

$env = parseEnv($envFile);

// -----------------------------
// 2) Create required folders
// -----------------------------
$folders = [
    '/public/assets/css',
    '/public/assets/js',
    '/public/assets/images',
    '/src/config',
    '/src/controllers',
    '/src/models',
    '/src/views',
    '/migrations',
    '/seeds',
    '/logs',
    '/vendor'
];

foreach ($folders as $folder) {
    $path = $root . $folder;
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
        echo "📁 Created: $path
";
    }
}

// -----------------------------
// 3) Download assets if missing
// -----------------------------
function downloadAsset($url, $savePath) {
    if (file_exists($savePath)) return;

    echo "⬇️ Downloading asset: $url
";
    $data = @file_get_contents($url);
    if ($data === false) {
        echo "❌ Failed: $url — لطفاً دستی دانلود کنید.
";
        return;
    }
    file_put_contents($savePath, $data);
    echo "✔ Saved: $savePath
";
}

downloadAsset('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', $root . '/public/assets/css/bootstrap.min.css');
downloadAsset('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', $root . '/public/assets/js/bootstrap.bundle.min.js');
downloadAsset('https://unpkg.com/alpinejs@3.12.0/dist/cdn.min.js', $root . '/public/assets/js/alpine.min.js');
downloadAsset('https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js', $root . '/public/assets/js/datatables.min.js');

// -----------------------------
// 4) MySQL connection + database creation
// -----------------------------
$dbHost = $env['DB_HOST'];
$dbPort = $env['DB_PORT'];
$dbName = $env['DB_DATABASE'];
$dbUser = $env['DB_USERNAME'];
$dbPass = $env['DB_PASSWORD'];

try {
    $pdo = new PDO("mysql:host=$dbHost;port=$dbPort", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✔ Connected to MySQL server.
";

    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    echo "✔ Database ensured: $dbName
";

    $pdo = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (Exception $e) {
    die("❌ DB Error: " . $e->getMessage());
}

// -----------------------------
// 5) Run migrations
// -----------------------------
$migrationTable = "CREATE TABLE IF NOT EXISTS migrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    file VARCHAR(255) UNIQUE,
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->exec($migrationTable);

$migrationFiles = glob($root . '/migrations/*.sql');

foreach ($migrationFiles as $mf) {
    $file = basename($mf);
    $check = $pdo->prepare("SELECT file FROM migrations WHERE file = ?");
    $check->execute([$file]);

    if ($check->fetch()) {
        echo "➡️ Migration already applied: $file
";
        continue;
    }

    $sql = file_get_contents($mf);
    try {
        $pdo->exec($sql);
        $pdo->prepare("INSERT INTO migrations (file) VALUES (?)")->execute([$file]);
        echo "✔ Migration applied: $file
";
    } catch (Exception $e) {
        echo "❌ Migration failed ($file): {$e->getMessage()}
";
    }
}

// -----------------------------
// 6) Run seed files (with log)
// -----------------------------
$seedLog = $root . '/logs/seeds.log';
$appliedSeeds = file_exists($seedLog) ? file($seedLog, FILE_IGNORE_NEW_LINES) : [];

$seedFiles = glob($root . '/seeds/*.sql');

foreach ($seedFiles as $sf) {
    $file = basename($sf);
    if (in_array($file, $appliedSeeds)) {
        echo "➡️ Seed already applied: $file
";
        continue;
    }

    $sql = file_get_contents($sf);
    try {
        $pdo->exec($sql);
        file_put_contents($seedLog, $file . "
", FILE_APPEND);
        echo "✔ Seed applied: $file
";
    } catch (Exception $e) {
        echo "❌ Seed failed ($file): {$e->getMessage()}
";
    }
}

// -----------------------------
// 7) Generate config.php
// -----------------------------
$configPath = $root . '/src/config/config.php';
if (!file_exists($configPath)) {
    $content = "<?php
return [
    'app' => [
        'name' => '{$env['APP_NAME']}',
        'version' => '{$env['APP_VERSION']}',
        'env' => '{$env['APP_ENV']}',
        'debug' => {$env['APP_DEBUG']},
        'timezone' => '{$env['APP_TIMEZONE']}'
    ]
];";
    file_put_contents($configPath, $content);
    echo "✔ Created: config.php
";
}

// -----------------------------
// 8) Generate database.php
// -----------------------------
$dbConfig = $root . '/src/config/database.php';
if (!file_exists($dbConfig)) {
    $content = "<?php
return [
    'driver' => 'mysql',
    'host' => '{$env['DB_HOST']}',
    'port' => '{$env['DB_PORT']}',
    'database' => '{$env['DB_DATABASE']}',
    'username' => '{$env['DB_USERNAME']}',
    'password' => '{$env['DB_PASSWORD']}',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci'
];";
    file_put_contents($dbConfig, $content);
    echo "✔ Created: database.php
";
}

// -----------------------------
// DONE
// -----------------------------

echo "
🎉 Setup complete. Project is ready!
";