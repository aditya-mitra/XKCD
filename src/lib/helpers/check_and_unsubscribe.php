<?php

    function doesEmailExist($con, $email, $token) {
        $stmt = $con->prepare('SELECT * FROM subscribers WHERE email=? AND token=? AND isActive=1');
        $stmt->bind_param('ss', $email, $token);
        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows <= 0) {
            return false;
        }

        return true;
    }

    function deleteEmailForUnsubscription($con, $email) {
        $stmt = $con->prepare('DELETE FROM subscribers WHERE email =?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
    }

?>