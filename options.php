<?php 
require_once 'libraries/functions.inc.php';
if(isset($_GET['delete_doc'])){
	$id = $_GET['delete_doc'];
	global $link;
	$err_flag = false;
	if(!empty($id)) {
		$doc_id = sanitize($id);
	}else{
		$err_flag == true;
		header('location:add_doctor.php');
		exit();
	}
	if ($err_flag === false) {
		$sql = "DELETE FROM doctors WHERE doc_id = '$doc_id'";
		$query = mysqli_query($link,$sql);
	if ($query) {
		header('location:add_doctor.php');
		exit();
	} else{
		return mysqli_error($link);
	}
	}
}

	if(isset($_GET['delete_nur'])){
	$id = $_GET['delete_nur'];
	global $link;
	$err_flag = false;
	if(!empty($id)) {
		$nur_id = sanitize($id);
	} else{
		$err_flag == true;
		header('location:add_nurse.php');
		exit();
	}
	if ($err_flag === false) {
		$sql = "DELETE FROM nurses WHERE nurse_id = '$nur_id'";
		$query = mysqli_query($link,$sql);
	if ($query) {
		header('location:add_nurse.php');
		exit();
	} else{
		return mysqli_error($link);
	}
	}
}

if(isset($_GET['delete_pat'])){
	$id = $_GET['delete_pat'];
	global $link;
	$err_flag = false;
	if(!empty($id)) {
		$pat_id = sanitize($id);
	} else{
		$err_flag == true;
		header('location:add_patient.php');
		exit();
	}
	if ($err_flag === false) {
		$sql = "DELETE FROM patients WHERE pat_id = '$pat_id'";
		$query = mysqli_query($link,$sql);
	if ($query) {
		header('location:add_patient.php');
		exit();
	} else{
		return mysqli_error($link);
	}
	}
}