<?php
    require __DIR__ . '/config.php';
    require __DIR__ . '/db.php';

    // get the number of comic urls
    $responseData = file_get_contents( $xkcdLink['base_url'] . '/' . $xkcdLink['info']);
    $jsonData = json_decode($responseData,true);
    // get a specific random comic
    $responseData = file_get_contents($xkcdLink['base_url'] . '/' . rand(1, $jsonData['num']) . '/' . $xkcdLink['info'] );
    $jsonData = json_decode($responseData, true);

    $stmt = $con->prepare('SELECT * FROM subscribers WHERE isActive = 1');
    $stmt->execute();
    $results = $stmt->get_result();

    foreach($results as $res) {
        $to = $res['email'];
        $token = $res['token'];
        echo 'sending to '.$to;

        $subject = '[XKCD] Your next comic has arrived';
        $url = $serverLink . "/unsubscribe.php?email=$to&token=$token";
        // TODO: center all the contents after h3
        $msg = "
        <html>
            <head>
                <title>The next comic is here</title>
            </head>
            <body>
                <h3>Hi,</h3>
                
                <img src='" . $jsonData['img'] . "' alt='" . $jsonData['alt'] . "'><br>

                <p>To know more about this comic, <strong><a href='" . $xkcdLink['base_url'] . '/' . $jsonData['num'] . "'>click here</a></strong>.<p>

                <hr>

                <em>Click <u><a href=\"$url\">here</a></u> to unsubscribe for XKCD.</em>
            </body>
        </html>
        ";

        $headers =  "From: $mailSender". "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; // required to show the email as html otherwise it would be shown as plain text
        $headers .= "MIME-Version: 1.0" . "\r\n";

        $res = mail($to, $subject, $msg, $headers);
        echo "res = $res";
    }
?>