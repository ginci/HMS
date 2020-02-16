<?php 
session_start();
require_once 'db.config.php';
require "vendor/autoload.php";
require "mailer.php";

// Helpers functions

function sanitize($input){
	global $link;
	$input = htmlspecialchars(strip_tags(trim($input)));
	$input = mysqli_real_escape_string($link, $input);
	return $input;
}

function sanitize_email($email){
	global $link;
	$email = trim($email);
	$email = filter_var($email,FILTER_VALIDATE_EMAIL);
	if ($email) {
		return true;
	} return false;
}

function check_duplicate($table, $column, $value){
	global $link;
	$sql = "SELECT * FROM $table WHERE $column = '$value'";
	$query = mysqli_query($link, $sql);
	if (mysqli_num_rows($query) > 0) {
		return true;
	}else{
		return false;
	}
}

function check_duplicate_appt($table, $column_1, $column_2, $value_1, $value_2){
	global $link;
	$sql = "SELECT * FROM $table WHERE $column_1 = '$value_1' AND $column_2 = '$value_2' ";
	$query = mysqli_query($link, $sql);
	if (mysqli_num_rows($query) > 0) {
		return true;
	}else{
		return false;
	}
}

function verify_password($email, $raw_password){
	global $link;
	$sql = "SELECT password FROM authors WHERE email = '$email'";
	$query =mysqli_query($link, $sql);
	if (mysqli_num_rows($query) > 0) {
		$row = mysqli_fetch_array($query);
		$encript_pass = $row['password'];
		$verify_pass = password_verify($encript_pass,$raw_password);
		if ($verify_pass) {
			return $encript_pass;
		}else{
			return false;
		}
	}
}

function book_appointment($post){
	$err_flag = false;
	$errors = array();
	global $link;
	$card_id = $post['card_id'];
	$doc_id = sanitize($post['doc_id']);
	$date = date("Y-m-d");
	$time = date('H:i:s', time());
	$dupl_appt = check_duplicate_appt('appointments', 'doc_id', 'card_id', $doc_id, $card_id);

	if ($err_flag ==false && $dupl_appt == false) {
		$sql = "INSERT INTO appointments (card_id, doc_id, appt_date, appt_time) VALUES ('$card_id','$doc_id', '$date', '$time')";
		$query = mysqli_query($link, $sql);
		if ($query) {
			return true;
		}else{
			$errors[] = "Could not Craete Appointment";
			return $errors;
		}
	}else{
		return $errors;
	}
}

// sanitize staff image
function sanitize_doc_image($file, &$errors){
	$err_flag = false;
	$name = $file['name'];
	$size = $file['size'];
	$type = $file['type'];
	$tmp = $file['tmp_name'];

	$safe_extensions = array('jpg', 'png', 'jpeg', 'gif', 'bmp');
	$file_ext = explode('/', $type);
 	$file_ext = end($file_ext);
	$file_ext = strtolower($file_ext);

	if (!in_array($file_ext, $safe_extensions)) {
		$errors['img_err'] = "Sorry, upload an image file";
		$err_flag = true;
		return false;
	}

	if ($size > 512000) {
		$errors['img_size'] = "Image is too large (upload an image size less than 512kb)";
		$err_flag = true;
		return false;
	}

	$file_dir = 'uploads/doctors/doc';
	$image_path = $file_dir.uniqid().time().'.'.$file_ext;

	if ($err_flag === false) {
		$result = move_uploaded_file($tmp, $image_path);
		if ($result) {
			return $image_path;
		} else {
			return false;
		}
	} return false;
}

// Sanitize student image
function sanitize_nurse_image($file, &$errors){
	$err_flag = false;
	$name = $file['name'];
	$size = $file['size'];
	$type = $file['type'];
	$tmp = $file['tmp_name'];

	$safe_extensions = array('jpg', 'png', 'jpeg', 'gif', 'bmp');
	$file_ext = explode('/', $type);
 	$file_ext = end($file_ext);
	$file_ext = strtolower($file_ext);

	if (!in_array($file_ext, $safe_extensions)) {
		$errors['img_err'] = "Sorry, upload an image file";
		$err_flag = true;
		return false;
	}

	if ($size > 512000) {
		$errors['img_size'] = "Image is too large (upload an image size less than 512kb)";
		$err_flag = true;
		return false;
	}

	$file_dir = 'uploads/nurses/nurse';
	$image_path = $file_dir.uniqid().time().'.'.$file_ext;

	if ($err_flag === false) {
		$result = move_uploaded_file($tmp, $image_path);
		if ($result) {
			return $image_path;
		} else {
			return false;
		}
	} return false;
}

function sanitize_pat_image($file, &$errors){
	$err_flag = false;
	$name = $file['name'];
	$size = $file['size'];
	$type = $file['type'];
	$tmp = $file['tmp_name'];

	$safe_extensions = array('jpg', 'png', 'jpeg', 'gif', 'bmp');
	$file_ext = explode('/', $type);
 	$file_ext = end($file_ext);
	$file_ext = strtolower($file_ext);

	if (!in_array($file_ext, $safe_extensions)) {
		$errors['img_err'] = "Sorry, upload an image file";
		$err_flag = true;
		return false;
	}

	if ($size > 512000) {
		$errors['img_size'] = "Image is too large (upload an image size less than 512kb)";
		$err_flag = true;
		return false;
	}

	$file_dir = 'uploads/patients/pat';
	$image_path = $file_dir.uniqid().time().'.'.$file_ext;

	if ($err_flag === false) {
		$result = move_uploaded_file($tmp, $image_path);
		if ($result) {
			return $image_path;
		} else {
			return false;
		}
	} return false;
}

// adding doctors
function add_doctor($post, $file = null){
	$err_flag = false;
	$errors = array();
	global $link;

	$fname = sanitize($post['fname']);
	$lname = sanitize($post['lname']);
	$phone = sanitize($post['phone']);
	$days = sanitize($post['day']);
	$day =  explode("&", $days); //issuee
	$r_day = str_replace("amp;","", $day);
	$day_1 = $r_day[0];
	$day_2 = $r_day[1];
	$shift = ucfirst(sanitize($post['shift']));
	$address = sanitize($post['address']);
	$age = sanitize($post['age']);
	$gender = sanitize($post['gender']);
	$email =  sanitize($post['email']);
	$state =  sanitize($post['state']);
	$lga = sanitize($post['lga']);
	$spec = sanitize($post['specialization']);
	$qual = sanitize($post['qualification']);
	$uni = sanitize($post['university']);
	$fullname = $fname." ".$lname;
	// creating username
	$fname = ucfirst($fname);
	$fletter = substr($lname, 0, 1);
	
	$phone = sanitize($post['phone']);
	$lnum = substr($phone, -3, 4);

	$username = $fletter.$fname.$lnum;
	// $uniq_password = mt_rand(100000,999999); 
	$uniq_password = $phone;
	$password = password_hash($uniq_password, PASSWORD_DEFAULT);
	$url = 'http://' . $_SERVER['SERVER_NAME'] . '/HMS/admin/doctors/doc_login.php'; 
	$message = "Your Registration has been completed succecfully, Welcome to UNTH Ituku-Ozalla Dr <strong>$fullname</strong>, Your working days are <strong>$days</strong>, and you're on the <strong>$shift</strong> Shift, Your Login details: username is <strong>$username</strong> and password: <strong>$phone</strong> click on the liink to Log-in $url";

	if ($file != null) {
		$response = sanitize_doc_image($file, $errors);
		if ($response) {
			$doc_image = $response;
		} else {
			$err_flag = true;
		}
	} else {
		$errors['img_err'] = "Please select a profile image";
		$err_flag = true;
	}

	$result = check_duplicate('doctors', 'doc_fullname', $fullname);
	if ($err_flag === false && $result == false) {
		$sql = "INSERT INTO doctors (doc_fullname, phone, shift, address, age, image, gender, email, state, lga, specialization, qualification, doc_username, day_1, day_2, password, university) VALUES ('$fullname', '$phone', '$shift', '$address', '$age', '$doc_image', '$gender', '$email', '$state', '$lga', '$spec', '$qual', '$username','$day_1','$day_2', '$password', '$uni')";
		$query = mysqli_query($link, $sql);
		if ($query) {
				
				$response = sendmail($email, $message);
				return true;
			
		} else {
			$errors['reg'] = mysqli_error($link);
			return $errors;
		}
	} return $errors;
}

// adding nurses
function add_nurses($post, $file = null){
	$err_flag = false;
	$errors = array();
	global $link;

	$fname = sanitize($post['fname']);
	$lname = sanitize($post['lname']);
	$phone = sanitize($post['phone']);
	$address = sanitize($post['address']);
	$age = sanitize($post['age']);
	$gender = sanitize($post['gender']);
	$email =  sanitize($post['email']);
	$state =  sanitize($post['state']);
	$lga = sanitize($post['lga']);
	$shift = sanitize($post['shift']);
	$uni = sanitize($post['university']);	
	$qual = sanitize($post['qualification']);
	$fullname = $fname." ".$lname;
	// creating username
	$fname = ucfirst($fname);
	$fletter = substr($lname, 0, 1);
	
	$phone = sanitize($post['phone']);
	$lnum = substr($phone, -3, 4);

	$username = $fletter.$fname.$lnum;
	// $uniq_password = mt_rand(100000,999999); 
	$uniq_password = $phone;
	$password = password_hash($uniq_password, PASSWORD_DEFAULT);
	$url = 'http://' . $_SERVER['SERVER_NAME'] . '/HMS/admin/nurses/nurse_login.php'; 
	$message = "Your Registration has been completed succecfully, Welcome to UNTH Ituku-Ozalla Nurse $fullname, Your Login details: username is <strong>$username</strong> and password: <strong>$phone</strong> click on the liink to Log-in $url";

	if ($file != null) {
		$response = sanitize_doc_image($file, $errors);
		if ($response) {
			$doc_image = $response;
		} else {
			$err_flag = true;
		}
	} else {
		$errors['img_err'] = "Please select a profile image";
		$err_flag = true;
	}


	if ($err_flag === false) {
		$sql = "INSERT INTO nurses (name, phone, address, shift, age, image, gender, email, state, lga, university, qualification, nurse_username, password) VALUES ('$fullname', '$phone', '$address', '$shift',  '$age', '$doc_image', '$gender', '$email', '$state', '$lga', '$uni','$qual', '$username', '$password')";
		$query = mysqli_query($link, $sql);
		if ($query) {
				
				$response = sendmail($email, $message);
				return true;
			
		} else {
			$errors['reg'] = mysqli_error($link);
			return $errors;
		}
	} return $errors;
}


// adding patients
function add_patient($post, $file = null){
	$err_flag = false;
	$errors = array();
	global $link;

	$fullname = sanitize($post['fullname']);
	$phone = sanitize($post['phone']);
	$age = sanitize($post['age']);
	$address = sanitize($post['address']);
	$email = sanitize($post['email']);
	$gender = sanitize($post['gender']);
	$state = sanitize($post['state']);
	$lga = sanitize($post['lga']);
	$marital_stat = sanitize($post['marital_status']);
	$bldgrp = sanitize($post['bldgrp']);
	$genotype = sanitize($post['genotype']);
	$disability_stat = sanitize($post['disability_status']);
	$name_nok = sanitize($post['NOK_name']);
	$phone_nok = sanitize($post['NOK_phone']);
	$uniname = strtoupper(substr($fullname, -2, 2));
	$card_id = $uniname.substr($phone, -4, 2);

	$uniq_password = $phone;
	$password = password_hash($uniq_password, PASSWORD_DEFAULT);
	$url = 'http://'.$_SERVER['SERVER_NAME'].'/HMS/admin/patients/patient_login.php';

	$message = "Welcome to UNTH Ituku-Ozalla, We are here to provide credible comformation to your well-being. Login details: Card ID is $card_id and password: $phone, click on the link to login into your profile $url";
	if ($file != null) {
		$response = sanitize_pat_image($file, $errors);
		if ($response) {
			$pat_image = $response;
		} else {
			$err_flag = true;
		}
	} else {
		$errors['img_err'] = "Please select a profile image";
		$err_flag = true;
	}

	if ($err_flag === false) {
		$sql = "INSERT INTO patients (fullname, phone, address, age, email, state, lga, marital_status, bloodgroup, genotype, disability_status, nok_name, nok_phone, image, gender, password, card_id) VALUES ('$fullname', '$phone', '$address', '$age', '$email', '$state', '$lga', '$marital_stat', '$bldgrp', '$genotype', '$disability_stat', '$name_nok', '$phone_nok','$pat_image','$gender', '$password',  '$card_id')";
		$query = mysqli_query($link, $sql);

		if ($query) {
			$response = sendmail($email, $message);
				return true;
			
		} else {
			$errors['reg'] = mysqli_error($link);
			return $errors;
		}
	} return $errors;
}


// login function
function login_doctor($post){
	$err_flag = false;
	$errors = array();
	global $link;
	
	$username = sanitize($post['doc_username']);

	$password = sanitize($post['password']);

	if ($err_flag === false) {
		$sql = "SELECT * FROM doctors WHERE doc_username = '$username'";
		$query = mysqli_query($link, $sql);
		if (mysqli_num_rows($query) > 0) {
			$row = mysqli_fetch_array($query);
			$enc_pass = $row['password'];
			if (password_verify($password, $enc_pass)) {
				$patient_id = $row['doc_username'];
				$_SESSION['doc_username'] = $patient_id;
				return true;
			}else{
				$errors['pass_ver'] = "Invalid Login details";
				return $errors;
			}
		}else{
			$errors['pass_ver'] = "Invalid Login details";
			return $errors;
		}return $errors;
	}return $errors;
}


// login nurse
function login_nurse($post){
	$err_flag = false;
	$errors = array();
	global $link;
	
	$username = sanitize($post['nurse_username']);

	$password = sanitize($post['password']);

	if ($err_flag === false) {
		$sql = "SELECT * FROM nurses WHERE nurse_username = '$username'";
		$query = mysqli_query($link, $sql);
		if (mysqli_num_rows($query) > 0) {
			$row = mysqli_fetch_array($query);
			$enc_pass = $row['password'];
			if (password_verify($password, $enc_pass)) {
				$patient_id = $row['nurse_username'];
				$_SESSION['nurse_username'] = $patient_id;
				return true;
			}else{
				$errors['pass_ver'] = "Invalid Login details";
				return $errors;
			}
		}else{
			$errors['pass_ver'] = "Invalid Login details";
			return $errors;
		}return $errors;
	}return $errors;
}

// login function
function login_patient($post){
	$err_flag = false;
	$errors = array();
	global $link;
	
	$card_id = sanitize($post['card_id']);

	$password = sanitize($post['password']);

	if ($err_flag === false) {
		$sql = "SELECT * FROM patients WHERE card_id = '$card_id'";
		$query = mysqli_query($link, $sql);
		if (mysqli_num_rows($query) > 0) {
			$row = mysqli_fetch_array($query);
			$enc_pass = $row['password'];
			if (password_verify($password, $enc_pass)) {
				$card_id = $row['card_id'];
				$_SESSION['card_id'] = $card_id;
				return true;
			}else{
				$errors['pass_ver'] = "Invalid Login details";
				return $errors;
			}
		}else{
			$errors['pass_ver'] = "Invalid Login details";
			return $errors;
		}return $errors;
	}return $errors;
}

function add_vitals($post){
	$err_flag = false;
	$errors = array();
	global $link;

	$bldpressure = sanitize($post['bldpressure']).'mmHg';
	$pulse_rate = sanitize($post['pulse_rate']).'PRA';
	$temperature = sanitize($post['temperature']).'°C';
	$weight = sanitize($post['weight']).'Kg';
	$height = sanitize($post['height']).'M';
	$card_id = sanitize($post['card_id']);

	if ($err_flag === false) {
		$sql = "INSERT INTO vitals (bldpressure, pulse_rate, temperature, weight, height, card_id) VALUES ('$bldpressure', '$pulse_rate', '$temperature', '$weight', '$height', '$card_id')";
		$query = mysqli_query($link, $sql);
		if ($query) {
				return true;
		} else {
			$errors['reg'] = mysqli_error($link);
			return $errors;
		}
	} return $errors;
}
// fetch patient by antenantal card number
function get_patient($table, $column, $table_id){
	global $link;
	$sql = "SELECT * FROM $table WHERE $column = '$table_id'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			$row = mysqli_fetch_array($query);
			$user = $row;
			return $user;
		}return false;
	}return false;
}

function get_visits($table, $column, $table_id){
	global $link;
	$sql = "SELECT * FROM $table WHERE $column = '$table_id'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			$row = mysqli_fetch_assoc($query);
			$user = $row;
			return $user;
		}return false;
	}return false;
}

// fetching appointments
function get_all_appointment($card_id){
	global $link;
	$user = [];
	$sql = "SELECT * FROM visits INNER JOIN vitals ON visits.card_id = vitals.card_id WHERE visits.card_id = '$card_id' ORDER BY visits.visit_date ASC";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while ($row = mysqli_fetch_assoc($query)) {
				$user[] = $row;
			}
			return $user;
		}return false;
	}return mysqli_error($link);
}

// fetching appointments
function get_pat_appointment(){
	global $link;
	$user = [];
	$sql = "SELECT * FROM visits INNER JOIN doctors ON visits.doc_id = doctors.doc_id INNER JOIN vitals ON visits.card_id = vitals.card_id ORDER BY visits.visit_date ASC";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while ($row = mysqli_fetch_assoc($query)) {
				$user[] = $row;
			}
			return $user;
		}return false;
	}return false;
}

// fetch patients
function get_today_appointment(){
	global $link;
	$date = date("Y-m-d");
	$categories = [];
	$sql = "SELECT * FROM appointments INNER JOIN doctors ON appointments.doc_id = doctors.doc_id INNER JOIN patients ON appointments.card_id = patients.card_id WHERE appointments.appt_date = '$date'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while ($row = mysqli_fetch_assoc($query)) {
				$categories[] = $row;
			}
			return $categories;
		} else return false;
	} return mysqli_errno($link);
}

function get_doctor_appointment($doc_id){
	global $link;
	$date = time();
	$date = format_date($date);
	$categories = [];
	$sql = "SELECT * FROM appointments INNER JOIN doctors ON appointments.doc_id = doctors.doc_id INNER JOIN patients ON appointments.card_id = patients.card_id WHERE appointments.doc_id = '$doc_id' ORDER BY appointments.appt_date ASC";
	$query = mysqli_query($link, $sql);

	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while ($row = mysqli_fetch_assoc($query)) {
				$categories[] = $row;
			}
			return $categories;
		} else return false;
	} return false;
}

function get_vitals($card_id){
 	global $link;
 	$vitals = [];
 	$sql = "SELECT * FROM vitals WHERE card_id = '$card_id'";
 	$query = mysqli_query($link, $sql);
 	if ($query) {
 	if (mysqli_num_rows($query) > 0) {
			while ($row = mysqli_fetch_assoc($query)) {
				$vitals[] = $row;
			}
			return $vitals;
		} else return false;
	} return mysqli_error($link);
}
// format date
// function format_date($date)
// {
// 	$date = date("l, F j, Y", $date);
// 	return $date;
// }


// fetch doctors
function get_all_doctors(){
	global $link;
	$categories = [];
	$sql = "SELECT * FROM doctors";
	$query = mysqli_query($link, $sql);

	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while ($row = mysqli_fetch_assoc($query)) {
				$categories[] = $row;
			}
			return $categories;
		} else return false;
	} return false;
}

function get_all_nurses(){
	global $link;
	$categories = [];
	$sql = "SELECT * FROM nurses";
	$query = mysqli_query($link, $sql);

	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while ($row = mysqli_fetch_assoc($query)) {
				$categories[] = $row;
			}
			return $categories;
		} else return false;
	} return false;
}




// fetch patients
function get_all_patients(){
	global $link;
	$categories = [];
	$sql = "SELECT * FROM patients ORDER BY patients.date_enroll DESC";
	$query = mysqli_query($link, $sql);

	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while ($row = mysqli_fetch_assoc($query)) {
				$categories[] = $row;
			}
			return $categories;
		} else return false;
	} return false;
}

// generte card number
function generate_patient_id(){
	global $link;
	$sql = "SELECT pat_id FROM patients ORDER BY patients.date_enroll DESC LIMIT 1";
	$query = mysqli_query($link, $sql);

	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while ($row = mysqli_fetch_array($query)) {
				$last_id = $row;
			}
			$ant_number = $last_id['pat_id'] + 1;
			$ant_number = str_pad($ant_number,4,"0",STR_PAD_LEFT);
			return $ant_number;
		} else return false;
	} return false;
}


function get_doctor_name($doc_id){
	global $link;
	$sql = "SELECT doc_fullname FROM doctors WHERE doc_id = '$doc_id'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			$row = mysqli_fetch_array($query);
			$doctor_name= $row['doc_fullname'];
			return $doctor_name;
		}return false;
	}return false;
}


function format_date($date_in_sec){
	$date_in_sec = date('D j M Y', $date_in_sec);
	return $date_in_sec;
}

function format_date2($date_in_sec){
	$date_in_sec = date('j M Y', $date_in_sec);
	return $date_in_sec;
}
function format_db_date($db_date){
	$date = date('l/M/Y');
	return $date;
}
// checking for doctors on duty
function get_doc_appoint(){
	global $link;
	$doctors = [];
	$time = time(); 
	$current_day = date("l");
	$sql = "SELECT * FROM doctors WHERE doctors.day_1 = '$current_day' OR doctors.day_2 = '$current_day'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while($row = mysqli_fetch_assoc($query)){
				$doctors[] = $row;
			}
			return $doctors;
		}
	} return false;
}

function get_pat_appointments($card_id){
	global $link;
	$appoint = [];
	$sql = "SELECT * FROM appointments INNER JOIN doctors ON appointments.doc_id = doctors.doc_id WHERE card_id = '$card_id'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while($row = mysqli_fetch_assoc($query)){
				$appoint[] = $row;
			}
			return $appoint;
		}
	} return false;


}

// format date in time
function format_time($date_in_sec){
	$date_in_sec = date('H : i : s', $date_in_sec);
	return $date_in_sec;
}


function doc_report($post){

	global $link;
	$errors = [];
	$date = time();
	$date = format_date($date);
	$card_id = sanitize($post['card_id']);
	$doc_id = sanitize($post['doc_id']);
	$report = sanitize($post['report']);
	$prescription = sanitize($post['prescription']);
	$patient_name = sanitize($post['patient_name']);

	$sql = "INSERT INTO visits (patient_name, card_id, report, doc_id, prescription, visit_date) VALUES ('$patient_name', '$card_id', '$report', '$doc_id', '$prescription', '$date')";
	$query = mysqli_query($link, $sql);
	if ($query) {
		$sql = "UPDATE appointments SET status = status + 1 WHERE doc_id = '$doc_id'";
		$query = mysqli_query($link, $sql);
		if ($query) {
			$sql = "UPDATE patients SET status = status + 1 WHERE card_id = '$card_id'";
			$query = mysqli_query($link, $sql);
			return true;
		}else{
			$errors['db'] = "Database Error1";
			return $errors;
		}
	}else{
		$errors['db'] = mysqli_error($link);
		return $errors;
	}
}



function fetch_user($table, $column, $table_id){
	global $link;
	$sql = "SELECT * FROM $table WHERE $column = '$table_id'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			$row = mysqli_fetch_array($query);
			$user = $row;
			return $user;
		}return false;
	}return false;
}
