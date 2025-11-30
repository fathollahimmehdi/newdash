<?php
class BaseController {


    protected $data = [];
    protected $sidebarMenu = [];

    public function __construct($role = 'User') {
        $this->data['currentUser'] = $_SESSION['user_name'] ?? 'Guest';
        $this->data['role'] = $_SESSION['role'] ?? 'guest';

        // تاریخ و ساعت
        $this->data['currentDate'] = date('Y-m-d H:i');

         $this->data['pageTitle'] = '';  // عنوان صفحه
        $this->data['breadcrumb'] = []; // آرایه breadcrumbs


        $this->sidebarMenu = $this->getMenuByRole($role);
    }

    protected function getMenuByRole($role) {
        $menus = [
            'Admin' => [
                [
                    'title' => 'Dashboard',
                    'icon' => 'ti-dashboard',
                    'children' => [
                        ['title' => 'Home', 'link' => 'dashboard-home.php'],
                        ['title' => 'Analytics', 'link' => 'dashboard-analytics.php'],
                    ]
                ],
                [
                    'title' => 'Apps',
                    'icon' => 'ti-layout-grid2',
                    'children' => [
                        ['title' => 'Calendar', 'link' => 'app-calendar.html'],
                        ['title' => 'Chat app', 'link' => 'app-chat.html'],
                        ['title' => 'Support Ticket', 'link' => 'app-ticket.html'],
                    ]
                ],
                [
                    'title' => 'Inbox',
                    'icon' => 'ti-email',
                    'children' => [
                        ['title' => 'Mailbox', 'link' => 'app-email.html'],
                        ['title' => 'Compose Mail', 'link' => 'app-compose.html'],
                    ]
                ],
            ],
            'Manager' => [
                [
                    'title' => 'Dashboard',
                    'icon' => 'ti-dashboard',
                    'children' => [
                        ['title' => 'Home', 'link' => 'dashboard-home.php'],
                        ['title' => 'Reports', 'link' => 'dashboard-reports.php'],
                    ]
                ],
                [
                    'title' => 'Tasks',
                    'icon' => 'ti-check-box',
                    'children' => [
                        ['title' => 'All Tasks', 'link' => 'tasks-all.php'],
                        ['title' => 'Add Task', 'link' => 'tasks-add.php'],
                    ]
                ],
            ],
            'User' => [
                [
                    'title' => 'Dashboard',
                    'icon' => 'ti-dashboard',
                    'children' => [
                        ['title' => 'Home', 'link' => 'dashboard-home.php'],
                    ]
                ],
                [
                    'title' => 'My Tasks',
                    'icon' => 'ti-check-box',
                    'children' => [
                        ['title' => 'My Tasks', 'link' => 'tasks-my.php'],
                    ]
                ],
            ],
            'guest' => [
                [
                    'title' => 'Dashboard',
                    'icon' => 'ti-dashboard',
                    'children' => [
                        ['title' => 'Home', 'link' => 'dashboard-home.php'],
                    ]
                ],
                [
                    'title' => 'My Tasks',
                    'icon' => 'ti-check-box',
                    'children' => [
                        ['title' => 'My Tasks', 'link' => 'tasks-my.php'],
                    ]
                ],
            ],
        ];

        return $menus[$role] ?? $menus['User'];
    }

    protected function view($viewFile, $extraData = []) {
        $this->data = array_merge($this->data, $extraData);
        require "src/views/$viewFile.php";
    }

    protected function setPage($title, $breadcrumb = []) {
        $this->data['pageTitle'] = $title;
        $this->data['breadcrumb'] = $breadcrumb;
    }
}
