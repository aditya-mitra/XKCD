<?php

function sendConfirmationMail($to, $token, $mailSender, $serverLink) {
    
    $subject = '[XKCD] Please verify your email';
    $url = $serverLink . "/verify.php?email=$to&token=$token";
    $msg ="
            <html>
                <head>
                    <title>Please verify your email</title>
                </head>
                <body>
                    <h3>Hello,</h3>
                    <p>Please click on <strong><a href=\"$url\">this link</a></strong> to start receiving mails.</p>

                    <hr>

                    <p>If the clicking on the above link does not work, you may paste <code>$url</code> into the address bar of your browser.<p>
                </body>
            </html> 
        ";
    $headers =  "From: $mailSender". "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; // required to show the email as html otherwise it would be shown as plain text
    $headers .= "MIME-Version: 1.0" . "\r\n";

    $res = mail($to, $subject, $msg, $headers);

    return $res;
}

?>