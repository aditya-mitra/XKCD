<?php require __DIR__ . '/lib/layout/header.php' ; ?>

<?php
    require_once __DIR__ . '/lib/db.php';
    require __DIR__ . '/lib/helpers/check_and_verify.php';

    $email = null;
    $message = null;

    if(isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['token']) && !empty($_GET['token'])) {
        $email = $_GET['email'];
        $token = $_GET['token'];

        $doesExist = checkEmailBeforeActivation($con, $email, $token);

        if($doesExist === true) {
            $wasActivated = activateSubscriber($con, $email);
            
            if($wasActivated === true) {
                $message = 'Your email has now been verified';
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
    <link rel="stylesheet" href="assets/css/verify-success.css">
</head>
<body>
    <div class="container" id="mobile">
        <div class= "text-container">
            <h1>✔ Email Verified</h1>
            <p><?php echo isset($message) ? $message : '' ; ?> | <span class="verified-email"><u><?php echo isset($email) ? $email : '' ; ?></span></u></p>
            <a href="/" class= "button">Go to app now</a>
        </div>
    </div>
</body>

<?php require __DIR__ . '/lib/layout/footer.php' ; ?>