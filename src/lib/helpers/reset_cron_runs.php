<?php

    function resetCronRuns($con) {
        $stmt = $con->prepare("SELECT * FROM cron_runs LIMIT 1");
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows <= 0) {
            echo 'the cron_runs table is empty' . "\n";
            return;
        }
        
        $result = $result->fetch_assoc();
        $rid = $result['id'];

        $stmt = $con->prepare("UPDATE cron_runs SET lastRuns=0 WHERE id=?");
        $stmt->bind_param('i', $rid);

        $stmt->execute();
    }
?>