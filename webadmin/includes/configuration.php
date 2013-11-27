<?php
/*
* Database & Site Configuration
*/

$db_hostname = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'lhcp';
$db_build = 'mysql';

// Error checker
try {
	$db = new PDO($db_build.':host='.$db_hostname.';dbname='.$db_name, $db_username, $db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo 'Error: '.$e->getMessage();
}
?>
