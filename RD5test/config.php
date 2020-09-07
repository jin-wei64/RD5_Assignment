<?php	
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = 'root';
	$dbname = 'netbank';
	$link = mysqli_connect ( $dbhost, $dbuser, $dbpass, $dbname, 8889 ) or die ( mysqli_connect_error() );
	$result = mysqli_query ( $link, "set names utf8");
?>
