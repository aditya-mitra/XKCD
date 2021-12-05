<?php
    require __DIR__ . '/config.php';
    require __DIR__ . '/db.php';
    require __DIR__ . '/helpers/mail_xkcd_comic.php';
    require __DIR__ . '/helpers/get_random_xkcd.php';

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

    $jsonData = getRandomXKCD($xkcdLink);

    $stmt = $con->prepare('SELECT * FROM subscribers WHERE isActive = 1');
    $stmt->execute();
    $results = $stmt->get_result();

    $persons_sent = 0;

    foreach($results as $subscriber) {
        $res = sendXKCDMail($subscriber, $serverLink, $jsonData, $xkcdLink, $mailSender);
        
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