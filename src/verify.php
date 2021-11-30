<?php
    require_once __DIR__ . '/lib/db.php';
    if(isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['token']) && !empty($_GET['token'])) {
        $email = $_GET['email'];
        $token = $_GET['token'];

        $stmt = $con->prepare('SELECT * FROM subscribers WHERE email =? AND token=?');
        $stmt->bind_param('ss',$email,$token);
        $stmt->execute();

        $results = $stmt->get_result();
        if($results->num_rows > 0) {
            $stmt = $con->prepare('UPDATE subscribers SET isActive=1 WHERE email =?');
            $stmt->bind_param('s',$email);
            $stmt->execute();
            if($stmt->affected_rows > 0) {
                echo 'your email has been verified!';
            } else {
                echo 'you email has already been verified';
            }
            // redirect to index page
        } else {
            // redirect to 404 page
            echo 'not found';
        }
    } else {
        echo 'error - email and token were not found';
    }

?>