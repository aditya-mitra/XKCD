<?php

function sendXKCDMail($subscriber, $serverLink, $jsonData, $xkcdLink, $mailSender) {
    $to = $subscriber['email'];
    $token = $subscriber['token'];

    $subject = '[XKCD Mailer] Your next comic has arrived';
    $url = $serverLink . "/unsubscribe.php?email=$to&token=$token";
    
    // TODO: center all the contents after h3
    $dt = date(DATE_RFC822);
    
    $msg = "
    <html>
        <head>
            <title>The next comic is here</title>
        </head>
        <body>
            <span style=\"opacity: 0\"> $dt </span>

            <h3>Hi,</h3>
            <h4>Here goes your next comic.</h4>
            
            <img src='" . $jsonData['img'] . "' alt='" . $jsonData['alt'] . "'>

            <p>To know more about this comic, <strong><a href='" . $xkcdLink['base_url'] . '/' . $jsonData['num'] . "'>click here</a></strong>.<p>

            <hr>

            <em>Click <u><a href=\"$url\">here</a></u> to unsubscribe for XKCD.</em>

            <span style=\"opacity: 0\"> $dt </span>
        </body>
    </html>
    "; // the span at the beginning and end of body will avoid gmail trimming content

    $headers =  "From: $mailSender". "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; // required to show the email as html otherwise it would be shown as plain text
    $headers .= "MIME-Version: 1.0" . "\r\n";

    $res = mail($to, $subject, $msg, $headers);

    return $res;
}

?>