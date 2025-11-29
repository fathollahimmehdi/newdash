<?php
// autoload controllers
spl_autoload_register(function($class) {
    if(file_exists("src/controllers/$class.php"))  require "src/controllers/$class.php";
    if(file_exists("src/models/$class.php")) require "src/models/$class.php";
});

// بررسی پارامترها
$controller = $_GET['controller'] ?? 'DashboardController';
$action = $_GET['action'] ?? 'index';


if(class_exists($controller)) {
    $c = new $controller();
    if(method_exists($c, $action)) {
        $c->$action();
    } else {
        echo "Action not found";
    }
} else {
    echo "Controller not found";
}
