<?php 

define("HOST", 'localhost');
define('USERNAME', 'root');
define('PASSWORD', "");
define('DBNAME', 'ahsdb');

$link = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);

// if ($link) {
// 	echo 'Yes';
// } else {
// 	echo 'no';
// }