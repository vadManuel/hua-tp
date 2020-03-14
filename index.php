<?php

session_start();
$request = $_SERVER['REQUEST_URI'];

if (isset($_SESSION['loggedin'])) {
    switch ($request) {
        case '/':
        case '':
        case '/index':
        case '/home':
            require __DIR__ . '/main/index.php';
            break;
        case '/profile':
            require __DIR__ . '/main/profile.php';
            break;
        case '/logout':
            require __DIR__ . '/authentication/logout.php';
            break;
        default:
            http_response_code(404);
            require __DIR__ . '/404.html';
    }
} else {
    switch ($request) {
        case '/':
        case '':
        case '/index':
            require __DIR__ . '/authentication/index.php';
            break;
        case '/login':
            require __DIR__ . '/authentication/login.php';
            break;
        case '/signup':
            require __DIR__ . '/authentication/signup.php';
            break;
        case '/register':
            require __DIR__ . '/authentication/register.php';
            break;
        case '/activate':
            require __DIR__ . '/authentication/activate.php';
            break;
        default:
            http_response_code(404);
            require __DIR__ . '/404.html';
    }
}
