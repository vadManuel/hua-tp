<?php

session_start();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <link rel='icon' type='image/png' href='../media/favicon.png' />
        <link rel='manifest' href='../manifest.json' />
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        
        <title>My Account</title>
        <link href='../style/custom.css' rel='stylesheet' type='text/css'>
    </head>
    <body class='outer'>
        <div class='middle'>
            <div class='d-flex flex-column align-items-center justify-content-center flex-nowrap' style='height:100%'>
                <!-- Judge the professor for not letting me use bootstrap -->
                <a href='..'>
                    <img style='height:140px;' src='../media/hua_logo.png' alt='' />
                </a>
                <!-- <div style='width:64px;height:64px;margin-bottom:-67px;z-index:1;border-radius:100%;background-color:white;'></div>
                <div style='width:70px;height:70px;border-radius:100%;background-color:rgb(8,81,114);'></div> -->
                <!-- <div class='fs-14' style='padding-top:1rem;color:#8F9BB3;font-weight:bold;'>Sign In</div> -->
                
                <form action='./calls/login.php' method='post' class='d-flex flex-column auth-form-container' style='padding:1rem 2rem;margin-top:3rem;'>

                    <input class='auth-input fullwidth fs-12' type='email' name='email' placeholder='+ Email' id='email' required>
                    <input class='auth-input fullwidth fs-12' style='margin-top:1rem;' type='password' name='password' placeholder='+ Password' id='password' required>
                    <?php
                        echo '<p class="fs-10 d-flex justify-content-between flex-row flex-wrap" style="color:red;margin-top:5px;">
                            <span id="foo" style="display:none;">&#9785; '.$_SESSION['display_error'].'</span>
                            <a href="reset" class="anchor">Forgot password?</a>
                        </p>';

                        if (isset($_SESSION['display_error']) && !empty($_SESSION['display_error'])) {
                            echo '<script>document.getElementById("foo").style = "display:block"</script>';
                            // echo '<script>
                            //     window.setTimeout(() => { document.getElementById("foo").style = "display:block" }, 5000)
                            // </script>';
                        }
                        // echo '<p class="fs-08" style="color:gray;text-align:right;margin-top:5px;"><a class="anchor">Forgot password?</a></p>';
                    ?>

                    <button class='auth-button fullwidth fs-14' style='margin-top:4rem;border-radius:3px;' type='submit'>Sign In</button>
                    <p class='fs-10' style='color:gray;text-align:center;margin-top:2rem;'>Don't have an account? <a class='anchor' href='./signup.php'>Sign Up</a></p>
                </form>
            </div>
        </div>
    </body>
</html>
