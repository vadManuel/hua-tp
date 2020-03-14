<?php

session_start();
$request = $_SERVER['REQUEST_URI'];

// Grabs the important part of the uri
preg_match('/\~vadmanuel\/cop4710_final(.*)/i', $request, $match);
// Grabs path+filename without any file type
preg_match('/.+?(?=\.|$)/i', $match[1], $check);

$uri = $check[0];

// loggedin: bool
$loggedin = !!isset($_SESSION['loggedin']);

// Testing router
echo    '<div style="bottom:0;position:absolute">loggedin: '.($loggedin ? 'true' : 'false')
        .'<br>request: '.$request
        .'<br>check: "'.json_encode($check, JSON_HEX_TAG)
        .'"<br>uri: "'.json_encode($uri, JSON_HEX_TAG).'"</div>';

switch ($uri) {
    // Root
    case '/':
    case '':
        if ($loggedin) {
            // ($uri != '/home') ?: header('Location /home');
            require __DIR__ . '/main/index.php';
        } else {
            // ($uri != '/') ?: header('Location /');
            require __DIR__ . '/authentication/index.php'; 
        }
        // require __DIR__ . ($loggedin ? '/main/index.php' : '/authentication/index.php');
        break;
    case '/home':
        if ($loggedin) {
            // header('Location '.$uri);
            require __DIR__ . '/main/index.php';
        } else {
            // header('Location /');
            require __DIR__ . '/authentication/index.php'; 
        }
        // require __DIR__ . ($loggedin ? '/main'.$uri.'.php' : '/authentication/index.php');
        break;
    case '/index':
    // Private uris
    case '/profile':
        if ($loggedin) {
            // header('Location '.$uri);
            require __DIR__ . '/main'.$uri.'.php';
        } else {
            // header('Location /');
            require __DIR__ . '/authentication/index.php'; 
        }
        // require __DIR__ . ($loggedin ? '/main'.$uri.'.php' : '/authentication/index.php');
        break;
    // Public uris
    case '/login':
    case '/signup':
    case '/register':
    case '/activate':
        if ($loggedin) {
            // header('Location /home');
            require __DIR__ . '/main/index.php';
        } else {
            // header('Location /');
            require __DIR__ . '/authentication'.$uri.'.php'; 
        }
        // require __DIR__ . ($loggedin ? '/main/home' : '/authentication'.$uri.'.php');
        break;
    case '/logout':
        if ($loggedin) {
            // header('Location /logout');
            require __DIR__ . '/authentication/logout.php';
        } else {
            // header('Location /');
            require __DIR__ . '/authentication/index.php'; 
        }
        // require __DIR__ . ($loggedin ? '/authentication/logout.php' : '/authentication/index.php');
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/404.html';
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <link rel='icon' type='image/png' href='media/favicon.png' />
        <link rel='manifest' href='manifest.json' />
        <meta name='viewport' content='width=device-width, initial-scale=1'>
    </head>
<html>