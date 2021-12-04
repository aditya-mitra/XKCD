<?php
    require_once __DIR__ . '/lib/db.php';

    $email = null;
    $message = null;

    if(isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['token']) && !empty($_GET['token'])) {
        $email = $_GET['email'];
        $token = $_GET['token'];

        $stmt = $con->prepare('SELECT * FROM subscribers WHERE email =? AND token=?');
        $stmt->bind_param('ss',$email,$token);
        $stmt->execute();

        $results = $stmt->get_result();
        if($results->num_rows > 0) {
            $newToken = md5($email . 'unsubscribe' . date(DATE_RFC822));
            $stmt = $con->prepare('UPDATE subscribers SET isActive=1, token=? WHERE email =?');
            $stmt->bind_param('ss', $newToken, $email);
            $stmt->execute();
            if($stmt->affected_rows > 0) {
                $message = 'Your email has now been verified';
            } else {
                $message = 'Your email has already been verified';
            }
        } else {
            // redirect to 404 page
            echo 'not found';
        }
    } else {
        // still redirect to 404 page
        // echo 'error - email and token were not found';
    }

?>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/verify-success.css">
</head>
<body>
    <div class="container" id="mobile">
        <div class= "text-container">
            <h1><i class="fa fa-check-circle" aria-hidden="true" style="color: #E6A1C3;"></i> Email Verified</h1>
            <p><?php echo isset($message) ? $message : '' ; ?> | <span class="verified-email"><u><?php echo isset($email) ? $email : '' ; ?></span></u></p>
            <a href="/" class= "button">Go to app now</a>
        </div>
    </div>
</body>