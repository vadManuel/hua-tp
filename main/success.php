<?php

session_start();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <link rel='icon' type='../image/png' href='../media/favicon.png' />
        <link rel='manifest' href='../manifest.json' />
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <title>Successful Order</title>
        <link href='../style/custom.css' rel='stylesheet' type='text/css'>
    </head>
    <body class='outer'>
        <div class='middle'>
            <div class='d-flex flex-column align-items-center justify-content-center flex-nowrap' style='height:100%;'>
                <div style='width:350px;'>
                    <div class='d-flex flex-row justify-content-between' style='margin:.1rem .25rem;background-color:rgb(240,240,245);'>
                        <a href='../' class='fs-15' style='text-decoration:none;color:#8F9BB3;font-weight:bold;'>Nice<br>Order, <?php echo ucfirst($_SESSION['username']); ?><br>I'm<br>Proud of You</a>
                        <a href='./' class='fs-15' style='text-decoration:none;color:#ccd5e6;font-weight:bold;'>Click<br>here to go<br>back<br>to the store</a>
                    </div>
                    <div class='d-flex flex-row justify-content-between' style='margin:.1rem .25rem;'>
                        <a href='../' class='fs-15' style='text-decoration:none;color:#ccd5e6;font-weight:bold;'>Click<br>here to go<br>back<br>to the store</a>
                        <a href='../' class='fs-15' style='text-decoration:none;color:#8F9BB3;font-weight:bold;'>Nice<br>Order, <?php echo ucfirst($_SESSION['username']); ?><br>I'm<br>Proud of You</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>