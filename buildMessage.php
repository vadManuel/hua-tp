<?php

function buildMessage($activation_link, $username) {
    $message = '
        <body style="margin: 0; box-sizing: border-box; font-family: sans-serif; color: #8F9BB3; font-size: 14px; padding: 0; border-top: 2px solid #26334D; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; background-color: white; height: 100%; line-height: 1.6; width: 100%;">
            <table style="margin: 0; padding: 0; box-sizing: border-box; font-family: sans-serif; color: #8F9BB3; font-size: 14px; line-height: 22px; width: 100%; background-color: white;">
                <tr style="margin: 0; padding: 0; box-sizing: border-box; font-family: sans-serif; color: #8F9BB3; font-size: 14px; line-height: 22px;">
                <td style="margin: 0; padding: 0; box-sizing: border-box; font-family: sans-serif; color: #8F9BB3; font-size: 14px; line-height: 22px; vertical-align: top;"></td>
                <td width="400" style="font-size: 14px; box-sizing: border-box; font-family: sans-serif; color: #8F9BB3; padding: 0; line-height: 22px; vertical-align: top; margin: 0 auto; display: block; max-width: 400px; clear: both;">
                    <div style="padding: 0; box-sizing: border-box; font-family: sans-serif; color: #8F9BB3; font-size: 14px; line-height: 22px; margin: 0 auto; max-width: 400px; display: block;">
                    <table width="100%" cellpadding="0" cellspacing="0" style="margin: 0; padding: 0; box-sizing: border-box; font-family: sans-serif; color: #8F9BB3; font-size: 14px; line-height: 22px;">
                        <tr style="margin: 0; padding: 0; box-sizing: border-box; font-family: sans-serif; color: #8F9BB3; font-size: 14px; line-height: 22px;">
                        <td style="margin: 0; padding: 0; box-sizing: border-box; font-family: sans-serif; color: #8F9BB3; font-size: 14px; line-height: 22px; vertical-align: top; text-align: center;">
                            <h1>Hua!</h1>
                        </td>
                        </tr>
                        <tr style="margin: 0; padding: 0; box-sizing: border-box; font-family: sans-serif; color: #8F9BB3; font-size: 14px; line-height: 22px;">
                        <td style="margin: 0; padding: 0; box-sizing: border-box; font-family: sans-serif; color: #8F9BB3; font-size: 14px; line-height: 22px; vertical-align: top;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 0; padding: 0; box-sizing: border-box; font-family: sans-serif; color: #8F9BB3; font-size: 14px; line-height: 22px;">
                            <tr style="margin: 0; padding: 0; box-sizing: border-box; font-family: sans-serif; color: #8F9BB3; font-size: 14px; line-height: 22px;">
                                <td style="font-size: 14px; margin: 0; box-sizing: border-box; line-height: 22px; vertical-align: top; color: #8F9BB3; padding: 20px 0; font-family: sans-serif; background: #ffffff; border-radius: 3px; box-shadow: 0 0 0 1px #D8DDE2;">
                                <p style="margin: 0; box-sizing: border-box; font-family: sans-serif; color: #8F9BB3; font-size: 14px; line-height: 22px; font-weight: normal; margin-bottom: 0; padding: 0 20px;"><strong style="margin: 0; padding: 0; box-sizing: border-box; font-family: sans-serif; font-size: 14px; line-height: 22px; color: #596C80;">Hello, '.ucfirst($username).'! Please confirm your email address</strong>,
                                    to activate your account. If you received this by mistake or weren\'t expecting it, please disregard this email.</p>
                                </td>
                            </tr>
                            <tr style="margin: 0; padding: 0; box-sizing: border-box; font-family: sans-serif; color: #8F9BB3; font-size: 14px; line-height: 22px;">
                                <td style="margin: 0; padding: 0; box-sizing: border-box; font-family: sans-serif; color: #8F9BB3; font-size: 14px; line-height: 22px; vertical-align: top; padding-top: 20px;">
                                <a href="'.$activation_link.'" style="line-height: 22px; margin: 0; box-sizing: border-box; font-family: sans-serif; color: #ffffff; font-size: 18px; padding: 20px; display: block; font-weight: bold; background: rgb(197, 88, 48); border-radius: 3px; text-decoration: none; text-align: center;">Confirm email address</a>
                                </td>
                            </tr>
                            </table>
                        </td>
                        </tr>
                    </table>
                    </div>
                </td>
                </tr>
            </table>
            </body>
            <div style="margin: 0; padding: 0; box-sizing: border-box; font-family: sans-serif; color: #8F9BB3; font-size: 14px; line-height: 22px; width: 100%; clear: both;">
            <table width="100%" style="margin: 0; box-sizing: border-box; font-family: sans-serif; color: #8F9BB3; font-size: 14px; line-height: 22px; padding: 40px 20px; background: white;">
                <tr style="margin: 0; padding: 0; box-sizing: border-box; font-family: sans-serif; color: #8F9BB3; font-size: 14px; line-height: 22px;">
                <td style="margin: 0; box-sizing: border-box; line-height: 22px; vertical-align: top; padding: 20px 0; font-family: sans-serif; color: #8F9BB3; text-align: center; font-size: 12px;">
                    <a href="'.$activation_link.'" style="margin: 0; padding: 0; box-sizing: border-box; font-family: sans-serif; line-height: 22px; color: inherit; font-size: 12px; text-decoration: none;">'.$activation_link.'</a>
                </td>
                </tr>
            </table>
            </div>
        </body>';
    return $message;
}