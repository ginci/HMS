<?php ob_start(); ?>

<?php require_once '../libraries/functions.inc.php'; 
    if (!isset($_SESSION['nurse_username'])){
        header("location:nurse_login.php");
        exit();
    } 

    $nurse_username = $_SESSION['nurse_username'];
    $result = get_patient('nurses', 'nurse_username', $nurse_username);
    if ($result) {
        $nurse = $result;
        $nurse_fullname = ucfirst($nurse['name']);
        $nurse_image = $nurse['image'];
        $nurse_phone = $nurse['phone'];
        $nurse_id = $nurse['nurse_id'];
        $nurse_address = $nurse['address'];
        $nurse_username = $nurse['nurse_username'];
    }



?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>UNTH Ituku-Ozalla</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        
