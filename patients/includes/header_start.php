<?php ob_start(); ?>

<?php require_once '../libraries/functions.inc.php'; 
    if (!isset($_SESSION['card_id'])){
        header("location:patient_login.php");
        exit();
    }
    $card_id = $_SESSION['card_id'];
    $result = get_patient('patients', 'card_id', $card_id);
    if ($result) {
        $patient = $result;
        $patient_fullname = ucfirst($patient['fullname']);
        $patient_image = $patient['image'];
        $patient_phone = $patient['phone'];
        $patient_card_number = $patient['card_id'];
        $patient_address = $patient['address'];
        $patient_age = $patient['age'];
        $patient_nok_fullname = $patient['nok_name'];
        $patient_nok_number = $patient['nok_phone'];
        $patient_date_enroll = $patient['date_enroll'];
        $current_date = time();
        $marital_stat = $patient['marital_status'];
        $status = $patient['status'];
        $patient_id = $patient['pat_id'];
        $patient_status = $patient['status'];


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
