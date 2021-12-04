<?php

    function checkEmailBeforeActivation($con, $email, $token) {
        $stmt = $con->prepare('SELECT * FROM subscribers WHERE email =? AND token=?');
        $stmt->bind_param('ss',$email,$token);
        $stmt->execute();

        $results = $stmt->get_result();
        if($results->num_rows > 0) {
            return true;
        }
        return false;
    }

    function activateSubscriber($con, $email) {
        $newToken = md5($email . 'unsubscribe' . date(DATE_RFC822));
        $stmt = $con->prepare('UPDATE subscribers SET isActive=1, token=? WHERE email =?');
        $stmt->bind_param('ss', $newToken, $email);
        $stmt->execute();
        if($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }

?>