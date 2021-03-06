<?php require __DIR__ . '/lib/layout/header.html' ; ?>

<head>
    <title>XKCD Mailer | Unsubscribe</title>
    <link rel="stylesheet" href="assets/css/unsubscribe-form.css">
</head>

<?php
    require __DIR__ . '/lib/db.php';
    require __DIR__ . '/lib/helpers/check_and_unsubscribe.php';
    
    $message = null;
    $email = null;
    $token = null;
    $status_done = false;

    if (isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['token']) && !empty($_GET['token'])) {
        $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);
        $token = filter_var($_GET['token'], FILTER_SANITIZE_STRING);
        
        $message = 'Do you want to unsubscribe?';
    } else if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['token']) && !empty($_POST['token'])) {

        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $token = filter_var($_POST['token'], FILTER_SANITIZE_STRING);

        $emailExist = doesEmailExist($con, $email, $token);
        
        if($emailExist === false) {
            $message = 'We could not find the corresponding email in our subscriptions!';
        } else {
            deleteEmailForUnsubscription($con, $email);

            $message =  'You have successfully unsubscribed!';
        } 
        
        $status_done = true;
    } else {
        header('Location: /404.php');
        exit();
    }
?>

<div class="container">
	<div class="inner-container">
        <div class="bottom">
            <h2 class="title"><?php echo isset($message) ? $message : '' ; ?></h2>
            <p class="subtitle">If you want, you can always re-subscribe to XKCD.</p>
            <div class="buttons">
                <form method="POST" action="<?php echo isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '' ; ?>">
                    <input type="hidden" name="email" value="<?php echo isset($email) ? $email : ''; ?>">
                    <input type="hidden" name="token" value="<?php echo isset($token) ? $token : ''; ?>">
                    <?php if($status_done === false): ; ?>
                        <button id="unsubscribe" type="submit">Unsubscribe</button>
                        <button id="cancel">Cancel</button>
                    <?php else: ; ?>
                        <button id="cancel">Go to Home</button>
                    <?php endif ; ?>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="assets/js/unsubscribe-form.js"></script>

<?php require __DIR__ . '/lib/layout/footer.html' ; ?>