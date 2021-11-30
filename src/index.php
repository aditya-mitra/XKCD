<?php
    require __DIR__ . '/lib/db.php';
    $clientMessage = '';
    if(isset($_POST['email']) && !empty($_POST['email'])) {
        $email = ($_POST['email']);
        
        if(filter_var($email,FILTER_VALIDATE_EMAIL) === false) {
            $clientMessage = 'Please enter a valid email!';
        } else {
            
            // TODO: check if the email already exists
            
            // insert the user into the database
            $token = md5($email);
            $stmt = $con->prepare('INSERT INTO subscribers (email, token) VALUES (?,?)');
            $stmt->bind_param('ss',$email, $token);
            $stmt->execute();

            if($stmt->affected_rows != 0) {
                // send verification mail

                echo 'sending verification mail';

                $to = $email;
                $subject = 'Xkcd Comics Subscription';
                $url = "https://google.com/verification.php?email=$email&token=$token";
                $msg ="
                            <html>
                            <head>
                                <title>Subscription Email</title>
                            </head>
                            <body'>
                                send mail function working
                            </body>
                        </html> 
                    ";
                $headers =  "From: gamersinstinct8@gmail.com". "\r\n";

                $res = mail($to, $subject, $msg, $headers);
                echo "res = $res";
            } else {
                echo 'mail sending failed';
            }
            
        }

        $clientMessage = '';
    } else if(filter_has_var(INPUT_POST, 'submit')) {
        $clientMessage = 'Please fill in the email field!';
    }
?>


<main>
    <h1>XKCD Mailer</h1>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div>
            <label>Email</label>
            <input type="text" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $email : ''; ?>">
            <?php if($clientMessage != ''): ?>
                <div class="error"><?php echo $clientMessage ?></div>
            <?php endif; ?>
            <button type="submit">Submit</button>
        </div>
    </form>
</main>