<?php
require_once 'BaseController.php';
//require_once 'src/models/TaskModel.php'; // اگر مدل Task داری
//require_once 'src/models/UserModel.php'; // اگر مدل User داری

class DashboardController extends BaseController {

    public function __construct() {
        // فرض کن کاربر Admin است، بعداً از session role بگیری
        parent::__construct($_SESSION['role'] ?? 'User');
    }

    public function index() {
        // داده‌های نمونه یا از مدل بگیر
        $users_count = 12; // UserModel::countAll();
        $open_tasks = 5;   // TaskModel::countOpenByUser($_SESSION['user_id']);
        $sales = 4200;     // از مدل Sales یا داده نمونه

        // عنوان صفحه و breadcrumb
        $this->setPage('Dashboardam', [
            ['title' => 'Home', 'link' => 'index.php'],
            ['title' => 'Dashboard', 'link' => '']
        ]);

        // ارسال به view
        $this->view('dashboard', [
            'users_count' => $users_count,
            'open_tasks' => $open_tasks,
            'sales' => $sales
        ]);

    }

    public function getShortQuote($maxWords = 14) {
        $url = "https://api.quotable.io/random";

    $context = stream_context_create([
        "ssl" => [
            "verify_peer" => false,
            "verify_peer_name" => false,
        ],
    ]);

    $response = file_get_contents($url, false, $context);
    if (!$response) return "No quote found.";

    $data = json_decode($response, true);
    $quote = $data['content'] ?? '';

    $words = explode(' ', $quote);
    if (count($words) > $maxWords) {
        $words = array_slice($words, 0, $maxWords);
        $quote = implode(' ', $words) . '...';
    }

    return $quote;
    }
}
