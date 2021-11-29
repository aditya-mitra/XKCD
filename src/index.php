<?php
    $errorMessage = '';
    if(isset($_POST['email']) && !empty($_POST['email'])) {
        $email = ($_POST['email']);
        echo $email . 'was the email';
        
        if(filter_var($email,FILTER_VALIDATE_EMAIL) === false) {
            $errorMessage = 'Please enter a valid email!';
        }

        $errorMessage = '';
    } else if(filter_has_var(INPUT_POST, 'submit')) {
        $errorMessage = 'Please fill in the email field!';
    }
?>


<main>
    <h1>XKCD Mailer</h1>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div>
            <label>Email</label>
            <input type="text" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $email : ''; ?>">
            <?php if($errorMessage != ''): ?>
                <div class="error"><?php echo $errorMessage ?></div>
            <?php endif; ?>
            <button type="submit">Submit</button>
        </div>
    </form>
</main>