<?php
    require __DIR__ . '/lib/config.php';
    require __DIR__ . '/lib/db.php';
    require __DIR__ . '/lib/helpers/send_confirmation_mail.php';
    require __DIR__ . '/lib/helpers/check_and_insert_subscription.php';
    
    $clientMessage = '';
    
    if(isset($_POST['email']) && !empty($_POST['email'])) {
        $email = ($_POST['email']);
        
        if(filter_var($email,FILTER_VALIDATE_EMAIL) === false) {
            $clientMessage = 'Please enter a valid email!';
        } else {

            if(checkEmailExists($con, $email)) {
                $clientMessage = 'This email is already registered. You can try subscribing with a new email!';
                $email = '';
            } else {
                $token = md5($email . 'subscribe' . date(DATE_RFC822));
                insertNewSubscriber($con, $email, $token);
    
                $sendStatus = sendConfirmationMail($email, $token, $mailSender, $serverLink);
                
                echo "<strong>response = $sendStatus</strong>";
                if($sendStatus === true){
                    $clientMessage = 'A verification email has been sent to your account. Please verify it to start receiving comics.';
                } else {
                    $clientMessage = 'Email could not be sent to the address specified. Please enter a valid one.';
                }
            }

        }
    } else if(filter_has_var(INPUT_POST, 'submit')) {
        $clientMessage = 'Please fill in the email field!';
    }
?>

<head>
    <title>XKCD Mailer | Home</title>
    <link rel="stylesheet" href="assets/css/subscribe-form.css">
    <link rel="stylesheet" href="assets/css/subscribe-flash.css">
    <link rel="stylesheet" href="assets/css/form-loader.css">
</head>

<body>
    <?php if($clientMessage != ''): ; ?>
        <div class="flash-message"><?php echo $clientMessage ; ?></div>
    <?php endif; ?>

    <main>
        <h1 class="heading-1">XKCD Mailer</h1>

        <div class="card-form">
            <form class="signup" method="POST" action="<?php echo isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '' ; ?>">
                <div class="form-title">
                    Sign Up for the XKCD Newsletter!
                </div>
                <div class="form-body">
                    <div class="row">
                        <input type="text" placeholder="Email Address*" name="email" class="form-control" value="<?php echo isset($email) ? $email : ''; ?>">
                    </div>
                </div>
                <div class="rule"></div>
                <div class="form-footer">
                    <button type="submit" id="sign-up">Sign Me Up!</button>
                </div>
            </form>
        </div>

        <div class="outer-loader" id="outer-loader-id" style="display: none;">
			<div class="ball ball-1"></div>
			<div class="ball ball-2"></div>
			<div class="ball ball-3"></div>
			<div class="ball ball-4"></div>
		</div>

    </main>
</body>

<script src="assets/js/subscribe-form.js"></script>