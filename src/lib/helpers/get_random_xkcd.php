<?php
    function getRandomXKCD($xkcdLink) {
        echo 'getting a random comic from XKCD API' . "\n";
        
        // get the number of comic urls
        $responseData = file_get_contents( $xkcdLink['base_url'] . '/' . $xkcdLink['info']);
        $jsonData = json_decode($responseData,true);
        // get a specific random comic
        $responseData = file_get_contents($xkcdLink['base_url'] . '/' . rand(1, $jsonData['num']) . '/' . $xkcdLink['info'] );
        $jsonData = json_decode($responseData, true);

        return $jsonData;
    }

    function getImageEncodedFile($imgLink) {
        echo 'getting the image from the img url of the comic' . "\n\n";
        
        $imageFile = file_get_contents($imgLink);
        $encodedImageFile = chunk_split(base64_encode($imageFile));

        return $encodedImageFile;
    }
?>