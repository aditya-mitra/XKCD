<?php
    require __DIR__ . '/config.php';
    require __DIR__ . '/db.php';

    if(!isset($argv) || !is_array($argv) || !isset($argv[1]) || $argv[1] != $cron_run_pass) {

        echo "invalid credentials provided";
        return;
        
    }

    $stmt = $con->prepare("SELECT * FROM cron_runs LIMIT 1");
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows <= 0) {
        echo 'the cron_runs table is empty' . "\n";
        return;
    }

    $result = $result->fetch_assoc();
    $last_runs = $result['lastRuns'];
    $success_runs = $result['sucessfulRuns'];
    $rid = $result['id'];

    if($last_runs > $cron_run_max_limit) {
        echo 'exceeded MAX LIMIT of cron runs' . "\n";
        return;
    }

    // get the number of comic urls
    $responseData = file_get_contents( $xkcdLink['base_url'] . '/' . $xkcdLink['info']);
    $jsonData = json_decode($responseData,true);
    // get a specific random comic
    $responseData = file_get_contents($xkcdLink['base_url'] . '/' . rand(1, $jsonData['num']) . '/' . $xkcdLink['info'] );
    $jsonData = json_decode($responseData, true);

    $stmt = $con->prepare('SELECT * FROM subscribers WHERE isActive = 1');
    $stmt->execute();
    $results = $stmt->get_result();

    $persons_sent = 0;

    foreach($results as $res) {
        $to = $res['email'];
        $token = $res['token'];

        $subject = '[XKCD] Your next comic has arrived';
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
        
        if($res === true) {
            echo 'email was sent to ' . $to . "\n";
            $persons_sent = $persons_sent + 1;
        }
    }

    // update successful runs and last runs

    $success_runs = $success_runs + 1;
    $last_runs = $last_runs + 1;

    $stmt = $con->prepare("UPDATE cron_runs SET sucessfulRuns=? , lastRuns=? WHERE id=?");
    $stmt->bind_param('iii', $success_runs, $last_runs, $rid);
    $stmt->execute();

    echo 'Mails were sent to ' . $persons_sent . ' people' . "\n\n";
?>