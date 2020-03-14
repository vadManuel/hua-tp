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
    // Base
    case '/':
    case '':
    case '/index':
        require __DIR__ . ($loggedin ? '/main/index.php' : '/authentication/index.php');
        break;

    // Private uris
    case '/home':
        require __DIR__ . ($loggedin ? '/main/index.php' : '/authentication/index.php');
        break;
    case '/profile':
        require __DIR__ . ($loggedin ? '/main'.$uri.'.php' : '/authentication/index.php');
        break;

    // Public uris
    case '/reset':
    case '/signup':
        require __DIR__ . ($loggedin ? '/main/home' : '/authentication'.$uri.'.php');
        break;

    default:
        http_response_code(404);
        require __DIR__ . '/404.html';
}

?>