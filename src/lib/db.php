<?php

$db_host = getenv( 'DATABASE_HOST' ) ?  getenv( 'DATABASE_HOST' ) : 'localhost';
$db_user = getenv( 'DATABASE_USER' ) ? getenv( 'DATABASE_USER' ) : 'root';
$db_name   = getenv( 'DATABASE_NAME' ) ? getenv( 'DATABASE_NAME' ) : 'xkcd-mailer';
$db_password = getenv( 'DATABASE_PASSWORD' ) ? getenv( 'DATABASE_PASSWORD' ) : '';

$con = new mysqli( $db_host, $db_user, $db_password, $db_name );

if ($con->connect_errno) {
	die( 'Connection failed: ' . $con->connect_error );
}