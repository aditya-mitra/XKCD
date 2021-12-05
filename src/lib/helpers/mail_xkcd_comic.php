<?php


function sendXKCDMail($subscriber, $serverLink, $jsonData, $encodedImageFile, $xkcdLink, $mailSender) {
    echo 'attempting mail send to ' . $subscriber['email'] . "\n";
    
    $to = $subscriber['email'];
    $token = $subscriber['token'];

    $subject = '[XKCD Mail] Your next comic has arrived';
    $url = $serverLink . "/unsubscribe.php?email=$to&token=$token";

    $boundry = date(DATE_RFC822);

    $headers =  "From: $mailSender". "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: multipart/mixed;";
    $headers .= "boundary = $boundry\r\n";

    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    $msg = "--$boundry\r\n";
    $msg .= 'Content-type:text/html;charset=UTF-8' . "\r\n";
    $msg .= 'Content-Transfer-Encoding: 8bit' . "\r\n";
    $msg .= "\r\n";
    $msg .= "
    <html>
        <head>
            <title>The next comic is here</title>
        </head>
        <body>
            <span style=\"opacity: 0\"> $boundry </span>

            <h3>Hi,</h3>
            <h4>Here goes your next comic.</h4>
            
            <img src='" . $jsonData['img'] . "' alt='" . $jsonData['alt'] . "'>

            <p>To know more about this comic, <strong><a href='" . $xkcdLink['base_url'] . '/' . $jsonData['num'] . "'>click here</a></strong>.<p>

            <hr>

            <em>Click <u><a href=\"$url\">here</a></u> to unsubscribe for XKCD.</em>

            <span style=\"opacity: 0\"> $boundry </span>
        </body>
    </html>
    "; // the span at the beginning and end of body will avoid gmail trimming content
    $msg .= "\r\n";

     
    $imageFileName = 'image.png';
    
    $msg .= "--$boundry\r\n";
    $msg .= "Content-Type: image/png; name=".$imageFileName."\r\n";
    $msg .= "Content-Disposition: attachment; filename=$imageFileName\r\n";
    $msg .= 'Content-Transfer-Encoding: base64'."\r\n";
    $msg .= 'X-Attachment-Id: '.rand(1000, 99999)."\r\n\r\n";
    $msg .=  $encodedImageFile;

    $res = mail($to, $subject, $msg, $headers);

    return $res;
}

?>