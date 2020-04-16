<?php

session_start();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <link rel='icon' type='image/png' href='media/favicon.png' />
        <link rel='manifest' href='manifest.json' />
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <title>Register</title>
        <link href='style/custom.css' rel='stylesheet' type='text/css'>
    </head>
    <body class='outer'>
        <div class='d-flex align-items-center'>
            <img style='height:5rem;' src='../media/hua_logo.png' alt='' />
        </div>
        <div class='middle'>
            <div class='d-flex flex-column align-items-center justify-content-center flex-nowrap' style='height:100%'>
                <!-- Judge the professor for not letting me use bootstrap -->
                <img style='height:140px;' src='media/hua_logo.png' alt='' />
                <!-- <div class='fs-14' style='padding-top:1rem;color:#8F9BB3;font-weight:bold;'>Sign In</div> -->
                
                <form action='authentication/calls/login.php' method='post' autocomple='off' class='d-flex flex-column auth-form-container' style='padding:1rem 2rem;margin-top:3rem;'>
                    <input class='auth-input fullwidth fs-12' type='username' name='username' placeholder='+ Username' id='username' required>
                    <input class='auth-input fullwidth fs-12' style='margin-top:1rem;' type='password' name='password' placeholder='+ Password' id='password' minlength='8' maxlength='20' required>

                    <?php
                        // echo '<p class="fs-10 d-flex justify-content-between flex-row flex-wrap" style="color:red;margin-top:5px;">
                        //     <span id="foo" style="display:none;">&#9785; '.$_SESSION['display_error'].'</span>
                        //     <a class="anchor">Forgot password?</a>
                        // </p>';

                        // if (isset($_SESSION['display_error']) && !empty($_SESSION['display_error'])) {
                        //     echo '<script>document.getElementById("foo").style = "display:block"</script>';
                        // }
                    ?>

                    <button class='auth-button fullwidth fs-14' style='margin-top:4rem;border-radius:3px;' type='submit'>Login</button>
    
                </form>
            </div>
        </div>
    </body>
    <!-- <body>
        <div class='container'>
            <h1>Login</h1>
            <form action='login.php' method='post' autocomplete='off'>
                <input type='text' name='username' placeholder='Username' id='username' required>
                <input type='password' name='password' placeholder='Password' id='password' minlength='8' maxlength='20' required>

                <input type='submit' value='Sign In'>

            </form>
        </div>
    </body> -->
</html>
