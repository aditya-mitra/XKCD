<?php
    require __DIR__ . '/lib/config.php';
    require __DIR__ . '/lib/db.php';
    
    $clientMessage = '';
    if(isset($_POST['email']) && !empty($_POST['email'])) {
        $email = ($_POST['email']);
        
        if(filter_var($email,FILTER_VALIDATE_EMAIL) === false) {
            $clientMessage = 'Please enter a valid email!';
        } else {
            
            // TODO: check if the email already exists
            
            // insert the user into the database
            $token = md5($email . 'subscribe' . date(DATE_RFC822));
            $stmt = $con->prepare('INSERT INTO subscribers (email, token) VALUES (?,?)');
            $stmt->bind_param('ss',$email, $token);
            $stmt->execute();

            // send verification mail

            $to = $email;
            $subject = '[XKCD] Please verify your email';
            $url = $serverLink . "/verify.php?email=$to&token=$token";
            $msg ="
                    <html>
                        <head>
                            <title>Please verify your email</title>
                        </head>
                        <body>
                            <h3>Hello,</h3>
                            <p>Please click on <strong><a href=\"$url\">this link</a></strong> to start receiving mails.</p>

                            <hr>

                            <p>If the clicking on the above link does not work, you may paste <code>$url</code> into the address bar of your browser.<p>
                        </body>
                    </html> 
                ";
            $headers =  "From: $mailSender". "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; // required to show the email as html otherwise it would be shown as plain text
            $headers .= "MIME-Version: 1.0" . "\r\n";

            $res = mail($to, $subject, $msg, $headers);
            echo "<strong>response</strong> $res";
            if($res === true){
                $clientMessage = 'A verification email has been sent to your account. Please verify it to start receiving comics.';
            } else {
                $clientMessage = 'Email could not be sent to the address specified. Please enter a valid one.';
            }
        }
    } else if(filter_has_var(INPUT_POST, 'submit')) {
        $clientMessage = 'Please fill in the email field!';
    }
?>

<head>
    <title>XKCD Mailer | Home</title>
    <link rel="stylesheet" href="assets/css/subscribe-form.css">
</head>

<body>
    <main>
        <h1 class="heading-1">XKCD Mailer 2</h1>

        <div class="card-form">
            <form class="signup" method="POST" action="<?php echo isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '' ; ?>">
                <div class="form-title">
                    Sign Up for the XKCD Newsletter!
                </div>
                <div class="form-body">
                    <div class="row">
                        <input type="text" placeholder="Email Address*" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $email : ''; ?>">
                    </div>
                </div>
                <div class="rule"></div>
                <div class="form-footer">
                    <button type="submit">Sign Me Up!<span class="fa fa-thumbs-o-up"></span></button>
                    <!-- <a>Not Now!<span class="fa fa-ban"></span></a> -->
                    <?php if($clientMessage != ''): ; ?>
                        <div class="error"><?php echo $clientMessage ?></div>
                    <?php endif; ?>
                </div>
            </form>
        </div>

    </main>
</body>