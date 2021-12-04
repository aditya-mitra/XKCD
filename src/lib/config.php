<?php
    $mailSender = 'gamersinstinct8@gmail.com';
    $serverLink = isset($_SERVER['PORT']) ? '' : 'http://localhost/php-aditya-mitra/src';
    $xkcdLink = array('base_url'=>'https://xkcd.com', 'info'=>'info.0.json');
    $cron_run_pass = getenv( 'CRON_PASS' ) ? getenv( 'CRON_PASS' ) : 'simple-cron-pass';
?>