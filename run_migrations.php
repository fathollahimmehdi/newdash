<?php
// فقط یک بار autoload را require کن
require __DIR__ . '/vendor/autoload.php';

use Core\Database;

// اتصال به دیتابیس از Database.php
$mysqli = Database::getInstance();

// مسیر پوشه migrations
$migrationsDir = __DIR__ . '/migrations/';
$files = scandir($migrationsDir);
sort($files);

foreach ($files as $file) {
    if (!preg_match('/\.sql$/', $file)) continue;

    // بررسی اجرای قبلی
    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM migrations WHERE file=? AND status='applied'");
    $stmt->bind_param("s", $file);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "Skipping $file (already applied)\n";
        continue;
    }

    echo "Applying migration: $file ... ";

    $sql = file_get_contents($migrationsDir . $file);
    $success = true;
    $errorMsg = null;

    if ($mysqli->multi_query($sql)) {
        do {
            if ($result = $mysqli->store_result()) $result->free();
        } while ($mysqli->more_results() && $mysqli->next_result());
        echo "Success\n";
    } else {
        $success = false;
        $errorMsg = $mysqli->error;
        echo "Failed: $errorMsg\n";
    }

    // ثبت وضعیت در جدول migrations
    $stmt = $mysqli->prepare("INSERT INTO migrations (file, status, error_message) VALUES (?, ?, ?)");
    $status = $success ? 'applied' : 'failed';
    $stmt->bind_param("sss", $file, $status, $errorMsg);
    $stmt->execute();
    $stmt->close();

    if (!$success) break;
}

$mysqli->close();
echo "All migrations processed.\n";
