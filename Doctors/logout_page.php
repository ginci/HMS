<?php 
require_once '../libraries/functions.inc.php';
session_destroy();
header("location:logout.php");
exit();
 ?>