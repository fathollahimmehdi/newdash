<?php
class DashboardController {

    public function index() {
        // داده‌های نمونه
        $data = [
            'users_count' => 12,
            'sales' => 4200
        ];

        // بارگذاری ویو
       
        require 'src/views/dashboard.php';
    }
}
