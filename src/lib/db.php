<?php

$host = getenv( 'DATABASE_HOST' ) ?  getenv( 'DATABASE_HOST' ) : 'localhost';
$user = getenv( 'DATABASE_USER' ) ? getenv( 'DATABASE_USER' ) : 'root';
$db   = getenv( 'DATABASE_NAME' ) ? getenv( 'DATABASE_NAME' ) : 'xkcd-mailer';
$pwd = getenv( 'DATABASE_PASSWORD' ) ? getenv( 'DATABASE_PASSWORD' ) : '';

$con = new mysqli( $host, $user, $pwd, $db );

if ($con->connect_errno) {
	die( 'Connection failed: ' . $con->connect_error );
}