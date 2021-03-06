<?php
// global prefix
// mostly used for local development
$prefix = stripslashes($GLOBALS['prefix']);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <link rel='icon' type=<?php echo '"'.$prefix.'image/png"'; ?> href=<?php echo '"'.$prefix.'media/favicon.png"'; ?> />
        <link rel='manifest' href=<?php echo '"'.$prefix.'manifest.json"'; ?> />
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">

        <title>Page Not Found</title>
    </head>
    <body style='display:table;position:absolute;top:0;left:0;height:98vh;width:98vw;'>
        <div style='display:table-cell;vertical-align:middle;'>
            <div style='display:flex;flex-direction:column;align-items:center;justify-content:center;height:100%;'>
                <div style='width:350px;'>
                <?php
                    echo '
                        <div style="display:flex;flex-direction:row;justify-content:space-between;padding:.1rem .25rem;background-color:rgb(240,240,245);">
                            <a href="'.$prefix.'" style="font-size:1.5rem;text-decoration:none;color:#8F9BB3;font-weight:bold;font-family:\"Roboto\",sans-serif;"><span style="margin-left:6.7rem">404</span><br><span style="margin-left:0rem">Page</span><br><span style="margin-left:3rem">Not</span><br><span style="margin-left:5rem">Found</span></a>
                            <a href="'.$prefix.'" style="font-size:1.5rem;text-decoration:none;color:#8F9BB3;font-weight:bold;font-family:\"Roboto\",sans-serif;">So<br>sad, Alexa<br>play<br>Despacito 2.0</a>
                        </div>
                        <div style="display:flex;flex-direction:row;justify-content:space-between;padding:.1rem .25rem;">
                            <a href="'.$prefix.'" style="font-size:1.5rem;text-decoration:none;color:#ccd5e6;font-weight:bold;font-family:\"Roboto\",sans-serif;">So<br>sad, Alexa<br>play<br>Despacito 2.0</a>
                            <a href="'.$prefix.'" style="font-size:1.5rem;text-decoration:none;color:#ccd5e6;font-weight:bold;font-family:\"Roboto\",sans-serif;">So<br>sad, Alexa<br>play<br>Despacito 2.0</a>
                        </div>
                    ';
                ?>
                </div>
            </div>
        </div>
    </body>
</html>
