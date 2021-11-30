<h2>We are going to miss you</h2>

<?php
    require __DIR__ . '/lib/db.php';

    if (isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['token']) && !empty($_GET['token'])) {
        $email = $_GET['email'];
        $token = $_GET['token'];

        $stmt = $con->prepare('SELECT * FROM subscribers WHERE email=? AND token=? AND isActive=1');
        $stmt->bind_param('ss', $email, $token);
        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows <= 0) {
            echo 'we could not find the corresponding email id in our subscriptions';
        } else {
            $stmt = $con->prepare('DELETE FROM subscribers WHERE email =?');
            $stmt->bind_param('s', $email);
            $stmt->execute();

            echo 'you have successfully unsubscribed!';
        }
        
    } else {
        // redirect to 404 page
        echo 'params missing';
    }
?>