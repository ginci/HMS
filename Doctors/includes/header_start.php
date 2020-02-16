<?php ob_start(); ?>

<?php require_once '../libraries/functions.inc.php'; 
    if (!isset($_SESSION['doc_username'])){
        header("location:doc_login.php");
        exit();
    } 

    $doc_username = $_SESSION['doc_username'];
    $result = fetch_user('doctors', 'doc_username', $doc_username);
    if ($result) {
        $doc = $result;
        $doc_fullname = ucfirst($doc['doc_fullname']);
        $doc_image = $doc['image'];
        $doc_phone = $doc['phone'];
        $doc_id = $doc['doc_id'];
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>UNTH Ituku-ozalla</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
