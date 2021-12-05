<?php
    function getRandomXKCD($xkcdLink) {
        // get the number of comic urls
        $responseData = file_get_contents( $xkcdLink['base_url'] . '/' . $xkcdLink['info']);
        $jsonData = json_decode($responseData,true);
        // get a specific random comic
        $responseData = file_get_contents($xkcdLink['base_url'] . '/' . rand(1, $jsonData['num']) . '/' . $xkcdLink['info'] );
        $jsonData = json_decode($responseData, true);

        return $jsonData;
    }
?>