<?php
    function checkEmailExists($con, $email) {
        $stmt = $con->prepare('SELECT * FROM subscribers WHERE email=?');
        $stmt->bind_param('s',$email);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            return true;
        }
        return false;
    }

    function insertNewSubscriber($con, $email, $token) {
        $stmt = $con->prepare('INSERT INTO subscribers (email, token) VALUES (?,?)');
        $stmt->bind_param('ss',$email, $token);
        $stmt->execute();
    }

?>