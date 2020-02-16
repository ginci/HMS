<?php 
session_start();
require_once 'db.config.php';
require "phpmailer/PHPMailerAutoload.php";

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

function check_duplicate_registration($table, $colum1, $col1_value, $colum2, $col2_value){
	global $link;
	$sql = "SELECT * FROM $table WHERE $colum1 = '$col1_value' AND $colum2 = $col2_value";
	$query = mysqli_query($link, $sql);
	if (mysqli_num_rows($query) > 0) {
		return true;
	}else{
		return false;
	}
}

function check_duplicate_result($table, $colum1, $col1_value, $colum2, $col2_value, $colum3, $col3_value, $colum4, $col4_value, $colum5, $col5_value, $colum6, $col6_value, $colum7, $col7_value){
	global $link;
	$sql = "SELECT * FROM $table WHERE $colum1 = '$col1_value' AND $colum2 = '$col2_value' AND $colum3 = '$col3_value' AND $colum4 = '$col4_value' AND $colum5 = '$col5_value' AND $colum6 = '$col6_value' AND $colum7 = '$col7_value'";
	$query = mysqli_query($link, $sql);
	if (mysqli_num_rows($query) > 0) {
		return true;
	}else{
		return false;
	}
}

function check_duplicate_result2($table, $colum1, $col1_value, $colum2, $col2_value, $colum3, $col3_value, $colum4, $col4_value, $colum5, $col5_value, $colum6, $col6_value, $colum7, $col7_value, $colum8, $col8_value){
	global $link;
	$sql = "SELECT * FROM $table WHERE $colum1 = '$col1_value' AND $colum2 = '$col2_value' AND $colum3 = '$col3_value' AND $colum4 = '$col4_value' AND $colum5 = '$col5_value' AND $colum6 = '$col6_value' AND $colum7 = '$col7_value' AND $colum8 = '$col8_value'";
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

function add_news($post, $file = null){
	$err_flag = false;
	$errors = array();
	global $link;

	if ($post['type'] !== "") {
		$type = sanitize($post['type']);
	}else{
		$errors['type'] = "Please enter your type of broadcast";
		$err_flag = true;
	}

	if (!empty($post['title'])) {
		$title = sanitize($post['title']);
		$title = strtolower($title);
	} else {
		$errors['title'] = "Please enter the title";
		$err_flag = true;
	}

	if (!empty($post['body'])) {
		$body = sanitize($post['body']);
	}else{
		$errors['body'] = "Please enter your body of the news";
		$err_flag = true;
	}

	if ($file != null) {
		$response = sanitize_staff_image($file, $errors);
		if ($response) {
			$broad_image = $response;
		} else {
			$err_flag = true;
		}
	} else {
		$errors['img_err'] = "Please select a profile image";
		$err_flag = true;
	}

	if ($err_flag == false) {
		$sql = "INSERT INTO news (type,title, image, body) VALUES ('$type','$title', '$broad_image', '$body')";
		$query = mysqli_query($link, $sql);
		if ($query) {
			return true;
		}else{
			$errors[] = "Could not insert into DB consult programer!";
			return $errors;
		}
	}else{
		return $errors;
	}
}

// function to send mail to staff
function send_staff_mail($to, $subject, $firstname, $password){
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host = 'mail.boj.sch.ng';
	$mail->Port = 587;
	$mail->SMTPAuth=true;
	$mail->SMTPSecure='tls';

	$mail->Username='info@boj.sch.ng';
	$mail->Password='+n}u0w91QDW-';

	$mail->setFrom('info@boj.sch.ng','BOJ');
	$mail->addAddress($to);
	$mail->addReplyTo('info@boj.sch.ng');

	$mail->isHTML(true);
	$mail->Subject=$subject;
	$mail->Body='
		<table style="margin:0px auto;width:60%;">

			<tr style="height: 50px;background:#660066;">

				<td style="padding: 5px;background:#660066;"><img src="http://www.boj.sch.ng/images/favicon.png" alt="homepage" class="light-logo" style="float: left;" /><span style="display: inline-block;font-size: 24px;height: 30px;margin: 8px;color: #fff; font-weight: bolder;">BISHOP OTUBELU JUNIORATE</span></td>

			</tr>
			<tr style="padding: 5px;">
				<td><h2>Welcome to BOJ</h2></td>
			</tr>

			<tr>

				<td>
					<h3>Hello '.$firstname.',</h3>
					<p style="font-size: 16px;text-indent: 50px;">
						Welcome to BISHOP OTUBELU JUNIORATE NIKE GROUP OF SCHOOL, We are excited about the opportunity to get to know you, and we are looking forward to a happy and productive Education to the students. We aim to help in developing students Christian faith and moral character, productive research and to mentor students as they begin to take responsibility for their own decisions, determine their own attitudes and form their own opinions as to what life is all about.
					</p>
					
					<p>
						<h2>Your login Details is listed below: </h2><hr>
						<p style="font-size: 18px;"><a href="www.boj.sch.ng/BOJ/login.php">Click here to Login</a></p>
						<p style="font-size: 18px;"><b>Email: </b>'.$to.'</p>
						<p style="font-size: 18px;"><b>Password: </b>'.$password.'</p>
					</p>
				</td>

			</tr>

			<tr style="height: 70px;border-top: 1px solid #eee;">

				<td align="center" style="padding: 5px;"><hr>Powered by Confidence</td>

			</tr>

		</table>
	
	';
	if (!$mail->send()) {
		return false;
	}else{
		return true;
	}
}





// fetch 2 latest event
function fetch_events(){
	global $link;
	$events = [];
	$sql = "SELECT * FROM events";
	$query = mysqli_query($link, $sql);
	if ($query) {
		while ($row = mysqli_fetch_assoc($query)) {
			$events[] = $row;
		}
		return $events;
	}else{
		return false;
	}
}



// sanitize staff image
function sanitize_staff_image($file, &$errors){
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

	$file_dir = 'uploads/staff/boj';
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

// election candidate
// sanitize staff image
function sanitize_inec_image($file, &$errors){
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

	$file_dir = 'uploads/inec/boj';
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
function sanitize_image($file, &$errors){
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

	$file_dir = 'uploads/students/boj';
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

function sanitize_result($file){
	$file_type = $file['name'];

    $safe_extensions = array('xlsx');
    $file_ext = explode('.', $file_type);
    $file_ext = end($file_ext);
    $file_ext = strtolower($file_ext);

    if (in_array($file_ext, $safe_extensions)) {
    	return true;
	}else{
		return false;
	}
}


function register_staff($post, $file = null){
	$err_flag = false;
	$errors = array();
	global $link;

	if ($post['title'] !== "") {
		$title = sanitize($post['title']);
	} else {
		$errors['title'] = "Please select your title";
		$err_flag = true;
	}

	if (!empty($post['fname'])) {
		$firstname = sanitize($post['fname']);
	} else {
		$errors['fullname'] = "Please enter your firstname";
		$err_flag = true;
	}

	if (!empty($post['lname'])) {
		$lastname = sanitize($post['lname']);
	} else {
		$errors['lname'] = "Please enter your lastname";
		$err_flag = true;
	}

	if ($post['gender'] !== "") {
		$gender = sanitize($post['gender']);
	} else {
		$errors['gen'] = "Please select your gender";
		$err_flag = true;
	}

	if ($post['department'] !== "") {
		$department = sanitize($post['department']);
	} else {
		$errors['department'] = "Please select your department";
		$err_flag = true;
	}

	if (!empty($post['phone'])) {
		$phone = sanitize($post['phone']);
	} else {
		$errors['phone'] = "Please select your phone";
		$err_flag = true;
	}

	if (!empty($post['school'])) {
		$school = sanitize($post['school']);
	} else {
		$errors['school'] = "Please select your school";
		$err_flag = true;
	}

	if ($post['deg_acquired'] !== "") {
		$deg_acquired = sanitize($post['deg_acquired']);
	} else {
		$errors['deg_acquired'] = "Please select deg_acquired";
		$err_flag = true;
	}
	
	if ($post['subject1'] !== "") {
		$subject1 = sanitize($post['subject1']);
	} else {
		$errors['subject1'] = "Please select subject1";
		$err_flag = true;
	}

	if ($post['subject2'] !== "") {
		$subject2 = sanitize($post['subject2']);
	} else {
		$errors['subject2'] = "Please select subject2";
		$err_flag = true;
	}

	if ($file != null) {
		$response = sanitize_staff_image($file, $errors);
		if ($response) {
			$staff_image = $response;
		} else {
			$err_flag = true;
		}
	} else {
		$errors['img_err'] = "Please select a profile image";
		$err_flag = true;
	}

	if (!empty($post['email'])) {
		$email = sanitize($post['email']);
	} else {
		$errors['email'] = "Please enter your email";
		$err_flag = true;
	}

	if (isset($email)) {
		if (check_duplicate('staff', 'email', $email)) {
			$errors['dup_em'] = 'Sorry, a user has already registerd with this email address.';
			$err_flag = true;
			return $errors;
		}
	}

	$uniq_password = $phone.rand(10,1000);
	$subject = "Welcome to Bishop Otubelu Juniorate";  
	$password = password_hash($uniq_password, PASSWORD_DEFAULT);		


	if ($err_flag === false) {
		$sql = "INSERT INTO staff (title, firstname, lastname, gender, email, phone, deg_acquire, subject1, subject2, staff_image, department, school, password) VALUES ('$title', '$firstname', '$lastname', '$gender', '$email', '$phone', '$deg_acquired', '$subject1', '$subject2', '$staff_image', '$department', '$school', '$password')";
		$query = mysqli_query($link, $sql);

		if ($query) {
			$result = send_staff_mail($email, $subject, $firstname, $uniq_password);
			if ($result) {
				return true;
			}else{
				$err_flag = true;
				$errors['mail'] = "Could not send Mail";
				return $errors;
			}
			
		} else {
			$errors['reg'] = "New user registration failed!";
			return $errors;
		}
	} return $errors;
}


// adding election candidates
function register_candidate($post, $file = null){
	$err_flag = false;
	$errors = array();
	global $link;

	if ($post['position'] !== "") {
		$position = sanitize($post['position']);
	} else {
		$errors['position'] = "Please select position";
		$err_flag = true;
	}

	if (!empty($post['fullname'])) {
		$fullname = sanitize($post['fullname']);
	} else {
		$errors['fullname'] = "Please enter firstname";
		$err_flag = true;
	}

	if ($post['gender'] !== "") {
		$gender = sanitize($post['gender']);
	} else {
		$errors['gen'] = "Please select gender";
		$err_flag = true;
	}

	if ($post['level'] !== "") {
		$level = sanitize($post['level']);
	} else {
		$errors['gen'] = "Please select level";
		$err_flag = true;
	}

	if (!empty($post['reg_number'])) {
		$reg_number = sanitize($post['reg_number']);
	} else {
		$errors['reg_number'] = "Please enter reg number";
		$err_flag = true;
	}

	if (!empty($post['manifest'])) {
		$manifest = sanitize($post['manifest']);
	} else {
		$errors['manifest'] = "Please enter Manifest";
		$err_flag = true;
	}

	

	if ($file != null) {
		$response = sanitize_inec_image($file, $errors);
		if ($response) {
			$candi_image = $response;
		} else {
			$err_flag = true;
		}
	} else {
		$errors['img_err'] = "Please select a profile image";
		$err_flag = true;
	}


	if ($err_flag === false) {
		$sql = "INSERT INTO election_candidates (position_id, full_name, gender, level, reg_number, manifest, candi_image) VALUES ('$position', '$fullname','$gender',  '$level', '$reg_number', '$manifest', '$candi_image')";
		$query = mysqli_query($link, $sql);
		if ($query) {
			return true;
		} else {
			$errors['reg'] = "Could not add candidate!";
			return $errors;
		}
	} else{
		return $errors;
	}
}



// student registration
function register_student($post, $file = null){
	$err_flag = false;
	$errors = array();
	global $link;

	if (!empty($post['fullname'])) {
		$fullname = sanitize($post['fullname']);
	} else {
		$errors['fullname'] = "This Field is required";
		$err_flag = true;
	}

	if (!empty($post['sponsor_fullname'])) {
		$sponsor_fullname = sanitize($post['sponsor_fullname']);
	} else {
		$errors['sponsor_fullname'] = "This Field is required";
		$err_flag = true;
	}

	if ($post['gender'] !== "") {
		$gender = sanitize($post['gender']);
	} else {
		$errors['gender'] = "This Field is required";
		$err_flag = true;
	}

	if ($post['class'] !== "") {
		$class = sanitize($post['class']);
	} else {
		$errors['class'] = "This Field is required";
		$err_flag = true;
	}

	if ($post['sub_class'] !== "") {
		$sub_class = sanitize($post['sub_class']);
	} else {
		$errors['sub_class'] = "This Field is required";
		$err_flag = true;
	}


	if ($post['type'] !== "") {
		$type = sanitize($post['type']);
	} else {
		$errors['type'] = "This Field is required";
		$err_flag = true;
	}

	if (!empty($post['sponsor_phone'])) {
		$sponsor_phone = sanitize($post['sponsor_phone']);
	} else {
		$errors['sponsor_phone'] = "This Field is required";
		$err_flag = true;
	}

	
	if (!empty($post['sponsor_address'])) {
		$sponsor_address = sanitize($post['sponsor_address']);
	} else {
		$errors['sponsor_address'] = "This Field is required";
		$err_flag = true;
	}

	if (!empty($post['year_admit'])) {
		$year_admit = sanitize($post['year_admit']);
	} else {
		$errors['year_admit'] = "This Field is required";
		$err_flag = true;
	}

	if (!empty($post['dob'])) {
		$dob = sanitize($post['dob']);
	} else {
		$errors['dob'] = "This Field is required";
		$err_flag = true;
	}

	if (!empty($post['sponsor_occupation'])) {
		$sponsor_occupation = sanitize($post['sponsor_occupation']);
	} else {
		$errors['sponsor_occupation'] = "This Field is required";
		$err_flag = true;
	}


	if ($file != null) {
		$response = sanitize_image($file, $errors);
		if ($response) {
			$student_image = $response;
		} else {
			$err_flag = true;
		}
	} else {
		$errors['img_err'] = "Please select a profile image";
		$err_flag = true;
	}


	
	if (isset($year_admit)) {
		$school_id = "BOJ".$year_admit.mt_rand(1000, 9999);
	}

	if (isset($school_id)) {
		if (check_duplicate('students', 'reg_number', $school_id)) {
			$errors['dup_id'] = 'School ID has Taken try Again!';
			$err_flag = true;
			return $errors;
		}
	}

	if (isset($school_id)) {
		$password = password_hash($school_id, PASSWORD_DEFAULT);
	}else {
		$err_flag = true;
		$errors['pass_match'] = "Password Issue!";
	}



	if ($err_flag === false) {
		$sql = "INSERT INTO students (reg_number, fullname, gender, class, type, dob, spon_address, spon_phone, spon_fullname, year_admit, sub_class, sponsor_occupation, password, student_image) VALUES ('$school_id', '$fullname', '$gender', '$class', '$type', '$dob', '$sponsor_address', '$sponsor_phone', '$sponsor_fullname', '$year_admit','$sub_class', '$sponsor_occupation', '$password','$student_image')";
		$query = mysqli_query($link, $sql);

		if ($query) {
			return true;
		} else {
			$errors['reg'] = "New user registration failed!";
			return $errors;
		}
	} return $errors;
}



// fetch courses by ID
function course_by_id($course_id){
	global $link;
	$sql = "SELECT * FROM courses WHERE course_id = '$course_id'";
	$query = mysqli_query($link, $sql);
	if (mysqli_num_rows($query) > 0) {
		$row = mysqli_fetch_array($query);
		return $row;
	}else{
		return false;
	}
}

// login function
function login_user($post){
	$err_flag = false;
	$errors = array();
	global $link;
	if (!empty($post['email'])) {
		if (sanitize_email($post['email'])) {
			$email = $post['email'];
		}else{
			$errors['email'] = "Please enter a valid email";
			$err_flag = true;
		}
	} else {
		$errors['email'] = "Please enter your email";
		$err_flag = true;
	}
	if (!empty($post['password'])) {
		$password = sanitize($post['password']);
	} else {
		$errors['password'] = "Please enter your password";
		$err_flag = true;
	}

	if ($err_flag === false) {
		$sql = "SELECT * FROM staff WHERE email= '$email'";
		$query = mysqli_query($link, $sql);
		if (mysqli_num_rows($query) > 0) {
			$row = mysqli_fetch_array($query);
			$enc_pass = $row['password'];
			if (password_verify($password, $enc_pass)) {
				$staff_id = $row['staff_id'];
				$_SESSION['user_id'] = $staff_id;
				return true;
			}else{
				$errors['pass_ver'] = "Invalid Login details";
				return $errors;
			}
		}else{
			$errors[] = $email;
			$errors['pass_ver'] = "Invalid Login details";
			return $errors;
		}return $errors;
	}return $errors;
}

// uploading midterm result
function upload_mid_term($post){
	$err_flag = false;
	$errors = array();
	global $link;

	$subject = sanitize($post['subject']);
	$class = sanitize($post['class']);
	$staff_id = sanitize($post['staff_id']);
	$sub_class = sanitize($post['sub_class']);
	// result
	$test1 = sanitize($post['text1']);
	$test2 = sanitize($post['text2']);
	$note = sanitize($post['note']);
	$assign1 = sanitize($post['assign1']);
	$assign2 = sanitize($post['assign2']);
	$mid_term = sanitize($post['mid_term']);
	$staff_id = sanitize($post['staff_id']);
	$session = sanitize($post['session']);

	if (!empty($post['student_id'])) {
		foreach ($post['student_id'] as $student_id) {
			$sql = "INSERT INTO boj_result (student_id,staff_id, subject, year, class, sub_class, term, test_1, text1_date, test_2, test2_date, note_check, note_date, assignment_1, ass1_date, assignment_2, ass2_date, mid_term_test, mid_date) VALUES ('$student_id', '$staff', '$subject', '$year', '$class', '$sub_class', '$term', '$test1', '$test1_date', '$test2', '$test2_date', '$note', '$note_date', '$assign1', '$assign1_date', '$assign2', '$assign2_date', '$mid_term', '$mid_term_date', $total )";
			
			$query = mysqli_query($link, $sql);
			if ($query) {
				return true;
			}else{
				return false;
			}
		}
	}

}


// Take attendence
function take_attendence($post){
	$err_flag = false;
	$errors = array();
	global $link;

	$date_attend = sanitize($post['date_attend']);
	$course_id = sanitize($post['course_id']);
	$staff_id = sanitize($post['staff_id']);
	$session = sanitize($post['session']);

	if (!empty($post['student_id'])) {
		foreach ($post['student_id'] as $student_id) {
			// Update the registered course by increasse of 1
			$sql = "UPDATE registered_courses SET attendence = attendence + 1 WHERE student_id = '$student_id' AND course_id = '$course_id'";
			$query = mysqli_query($link, $sql);
				// inserting into attendece
				$sql = "INSERT INTO attendence (staff_id, course_id, student_id) VALUES ('".$staff_id."', '".$course_id."', '".$student_id."')";
				$query = mysqli_query($link, $sql);		
		}

		// Inserting into the attend date
		$sql = "INSERT INTO attend_dates (staff_id, course_id, session) VALUES ('".$staff_id."', '".$course_id."','".$session."')";
		$query = mysqli_query($link, $sql);
		if ($query) {
			return true;
		}else{
			$errors[] = "Could not take attendence1";
			return $errors;
		}
	}else{
		$errors[] = "You did not take any attendence";
		return $errors;
	}
}

// fetch uploaded result
function fetch_uploaded_result(){
	global $link;
	$allResult = [];
	$sql = "SELECT * FROM uploaded_results ORDER BY date_uploaded DESC";
	$query = mysqli_query($link, $sql);
	if ($query) {
		while ($row = mysqli_fetch_assoc($query)) {
			$allResult[]  = $row;
		}return $allResult;
	}return false;
}

// fetch all attendence
function fetch_all_attendence($course_id, $session){
	global $link;
	$attendence = [];
	$sql = "SELECT registered_courses.*, students.fullname, students.reg_number FROM registered_courses INNER JOIN students ON registered_courses.student_id = students.student_id WHERE registered_courses.course_id = '$course_id' AND registered_courses.year = '$session' ORDER BY students.reg_number";
	$query = mysqli_query($link, $sql);
	if (mysqli_num_rows($query) > 0) {
		while ($row = mysqli_fetch_assoc($query)) {
			$attendence[] = $row;
		}return $attendence;
	}else{
		return false;
	}
}

// fetch all student by student id
function get_student($student_id){
	global $link;
	$staffs = [];
	$sql = "SELECT * FROM students WHERE student_id = '$student_id'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while($row = mysqli_fetch_assoc($query)){
				$staffs[] = $row;
			}
			return $staffs;
		}
	} return false;
}

// fetch student grade 
function get_student_grade($student_id){
	global $link;
	$candidates = [];
	$sql = "SELECT cgpa.*, courses.* FROM cgpa INNER JOIN courses ON cgpa.course_id = courses.course_id WHERE cgpa.student_id = '$student_id'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while($row = mysqli_fetch_assoc($query)){
				$candidates[] = $row;
			}
			return $candidates;
		}
	} return false;
}



// fetch attendence by selected date
function fetch_attend_by_date($staff_id, $course_id, $date){
	global $link;
	$attend = [];
	$sql = "SELECT attendence.*, students.fullname, students.reg_number, students.year_admit FROM attendence INNER JOIN students ON attendence.student_id = students.student_id WHERE staff_id = '$staff_id' AND course_id = '$course_id' AND date_attend = '$date' ORDER BY attendence.date_attend DESC";
	$query = mysqli_query($link, $sql);
	if (mysqli_num_rows($query) > 0) {
		while ($row = mysqli_fetch_assoc($query)) {
			$attend[] = $row;
		}return $attend;
	}else{
		return false;
	}
}

// format date
// function format_date($date)
// {
// 	$date = date("l, F j, Y", $date);
// 	return $date;
// }

// view attendence by course and staff
function view_attendence($staff_id, $course_id, $session){
	global $link;
	$attend_dates = [];
	$sql = "SELECT attend_dates.*, courses.* FROM attend_dates INNER JOIN courses ON attend_dates.course_id = courses.course_id WHERE attend_dates.staff_id = '$staff_id' AND attend_dates.course_id = '$course_id' AND attend_dates.session = '$session' ORDER BY attend_dates.date_attend";
	$query = mysqli_query($link, $sql);
	if (mysqli_num_rows($query) > 0) {
		while ($row = mysqli_fetch_assoc($query)) {
			$attend_dates[] = $row;
		}return $attend_dates;
	}else{
		return false;
	}
}


// fetch total number of attendence taken
function total_attendence($staff_id, $course_id, $session){
	global $link;
    $sql = "SELECT * FROM attend_dates WHERE staff_id = '$staff_id' AND course_id = '$course_id' AND session = '$session'";
    $query = mysqli_query($link, $sql);
    $num_rows = mysqli_num_rows($query);
	return $num_rows;

}


// count student by level
function total_students($level){
	global $link;
    $sql = "SELECT * FROM students WHERE class = '$level'";
    $query = mysqli_query($link, $sql);
    $num_rows = mysqli_num_rows($query);
	return $num_rows;
} 

// count student by class
function total_students1($student_class, $sub_class){
	global $link;
    $sql = "SELECT * FROM students WHERE class = '$student_class' AND sub_class = '$sub_class'";
    $query = mysqli_query($link, $sql);
    $num_rows = mysqli_num_rows($query);
	return $num_rows;
}

// Update profile
function update_user($post, $file, $staff_id){
	global $link;
	$errors = [];
	$err_flag = false;

	if (!empty($post['newFname'])) {
		$newFname = sanitize($post['newFname']);
	}else{
		$err_flag = true;
		$errors['newFname'] = "Enter your firstname";
	}

	if (!empty($post['newLname'])) {
		$newLname = sanitize($post['newLname']);
	}else{
		$err_flag = true;
		$errors['newLname'] = "Enter your Lastname";
	}

	if ($file != null) {
		$response = sanitize_image($file, $errors);
		if ($response) {
			$staff_image = $response;
		} else {
			$err_flag = true;
		}
	} else {
		$errors['img_err'] = "Please select a profile image";
		$err_flag = true;
	}

	if ($err_flag === false) {
		$sql = "UPDATE staff SET firstname = '$newFname', lastname = '$newLname', staff_image = '$staff_image' WHERE staff_id = '$staff_id' ";
		$query = mysqli_query($link, $sql);
		if ($query) {

			$body = get_email_body('am gift', $newFname, $staff_image);
				$send_mail = send_mail($email, $newFname, 'verify Account - Aptech ComputerEduaction',"am gift");
				if ($send_mail) {
					return true;
				}else{
					$errors[] = " verification Could not be sent";
					return $errors;
				}
			return true;
		}else{
			$errors["query"] = "Could not update profile";
			return $errors;
		}
	}
}

// fetch subject
function get_subjects(){
	global $link;
	$categories = [];
	$sql = "SELECT * FROM subjects ORDER BY subjects.subject ASC";
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

// Fetch the student that registered for a particular course and set
function fetch_reg_student($course, $year_admit){
	global $link;
	$students = [];
	$sql = "SELECT registered_courses.*, students.*,  courses.* FROM registered_courses INNER JOIN students ON registered_courses.student_id = students.student_id INNER JOIN courses ON registered_courses.course_id = courses.course_id WHERE registered_courses.course_id = '$course' AND registered_courses.year = '$year_admit' ORDER BY students.reg_number";

	$query = mysqli_query($link, $sql);
	if($query){
		if (mysqli_num_rows($query) > 0) {
			while ($row = mysqli_fetch_assoc($query)) {
				$students[] = $row;
			}
			return $students;
		}else {
			return false;
		}
	}else {
		return false;
	}
}

// Fetch the student that registered for a particular course and set
function fetch_student_by_class($class, $sub_Class){
	global $link;
	$students = [];
	$sql = "SELECT * FROM students WHERE students.class = '$class' AND students.sub_class = '$sub_Class' ORDER BY students.fullname";
	$query = mysqli_query($link, $sql);
	if($query){
		if (mysqli_num_rows($query) > 0) {
			while ($row = mysqli_fetch_assoc($query)) {
				$students[] = $row;
			}
			return $students;
		}else {
			return false;
		}
	}else {
		return false;
	}
}


// calculating grade
function calculate_grade($total_score){
	if ($total_score >= 70) {
		$grade = "A";
		return $grade;
	}elseif ($total_score >= 60) {
		$grade = "B";
		return $grade;
	}elseif ($total_score >= 50) {
		$grade = "C";
		return $grade;
	}elseif ($total_score >= 40) {
		$grade = "A";
		return $grade;
	}elseif ($total_score >= 0) {
		$grade = "F";
		return $grade;
	}
	
}

// Fetch the result of a particular class
function student_result($class, $sub_Class, $term, $year, $student_id){
	global $link;
	$students = [];
	$sql = "SELECT * FROM boj_result WHERE boj_result.class = '$class' AND boj_result.sub_class = '$sub_Class' AND boj_result.term = '$term' AND boj_result.year = '$year' AND boj_result.student_id = '$student_id' ORDER BY boj_result.subject";
	$query = mysqli_query($link, $sql);
	if($query){
		if (mysqli_num_rows($query) > 0) {
			while ($row = mysqli_fetch_assoc($query)) {
				$students[] = $row;
			}
			return $students;
		}else {
			return false;
		}
	}else {
		return false;
	}
}

function fetch_student_result($class, $sub_Class, $term, $year, $subject){
	global $link;
	$students = [];
	$sql = "SELECT * FROM boj_result WHERE boj_result.class = '$class' AND boj_result.sub_class = '$sub_Class' AND boj_result.term = '$term' AND boj_result.year = '$year' AND boj_result.subject = '$subject' ORDER BY boj_result.subject";
	$query = mysqli_query($link, $sql);
	if($query){
		if (mysqli_num_rows($query) > 0) {
			while ($row = mysqli_fetch_assoc($query)) {
				$students[] = $row;
			}
			return $students;
		}else {
			return false;
		}
	}else {
		return false;
	}
}

// Curl function smart sms solution to send by post
function sendsms_post ($url, array $params) {     
	$params = http_build_query($params);     
	$ch = curl_init();           
	curl_setopt($ch, CURLOPT_URL,$url);     
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);     
	curl_setopt($ch, CURLOPT_POST, 1);     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);          
	$output=curl_exec($ch);       
	curl_close($ch);     
	return $output;         
}

// function to check sms units
function check_unit_bal(){
	$url = 'http://api.smartsmssolutions.com/smsapi.php';
	$username = 'aptechgiants@gmail.com';
	$password = '1234567890';
	// echo $reciever;
	$sms_array = array (                 
		'username'  => $username,                 
		'password'  => $password,                
		'balance' => true                              
	);
// calling the curl Funtions to get balanc sms
	$post_sms = sendsms_post($url, $sms_array); 
	if ($post_sms) {
		return $post_sms;
	}
}


// Sending bulk sms
function send_staffs_sms($post){
	global $link;
	$errors = [];
	$contact = [];
	$err_flag = false;

	if (!empty($post['message'])) {
		$message = sanitize($post['message']);
	}else{
		$err_flag = true;
		$errors['message'] = "Enter your Message";
		return $errors;
	}

	if ($err_flag === false) {
		
		// Fetching all staff contacts
		$sql = "SELECT * FROM staff";
		$query = mysqli_query($link, $sql);

		if ($query) {
			if (mysqli_num_rows($query) > 0) {
				while ($row = mysqli_fetch_assoc($query)) {
					$contacts[] = $row['phone'];
				}
				$reciever = implode(",",$contacts);
				// parameters to send sms
				$sender = "CSC ESUT";
				$url = 'http://api.smartsmssolutions.com/smsapi.php';
				$username = 'aptechgiants@gmail.com';
				$password = '1234567890';
				echo $reciever;
				$sms_array = array (                 
					'username'  => $username,                 
					'password'  => $password,                 
					'message'   => $message,                 
					'sender'    => $sender,                 
					'recipient' => $reciever                           
				);	

				$response = sendsms_post($url, $sms_array);
				if ($response) {
					return true;
				}else{
					$errors['send'] = "Could not send sms Check your Units";
					return $errors;
				}
			}else{
				$errors['pho'] = "No contact found";
				return $errors;
			}
		}else{
			$errors['con'] = "Cant fetch contact from DB";
			return $errors;
		}
	}else{
		return $errors;
	}
}



// Sending students sms
function send_students_sms($post){
	global $link;
	$errors = [];
	$contact = [];
	$err_flag = false;

	if ($post['level'] !=="") {
		$level = sanitize($post['level']);
	} else {
		$errors['level'] = "Please select student level";
		$err_flag = true;
	}

	if (!empty($post['message'])) {
		$message = sanitize($post['message']);
	}else{
		$err_flag = true;
		$errors['message'] = "Enter your Message";
		return $errors;
	}

	if ($err_flag === false) {
		
		// Fetching all staff contacts
		$sql = "SELECT * FROM students WHERE level = '$level'";
		$query = mysqli_query($link, $sql);

		if ($query) {
			if (mysqli_num_rows($query) > 0) {
				while ($row = mysqli_fetch_assoc($query)) {
					$contacts[] = $row['phone'];
				}
				$reciever = implode(",",$contacts);
				// parameters to send sms
				$sender = "CSC ESUT";
				$url = 'http://api.smartsmssolutions.com/smsapi.php';
				$username = 'aptechgiants@gmail.com';
				$password = '1234567890';
				$sms_array = array (                 
					'username'  => $username,                 
					'password'  => $password,                 
					'message'   => $message,                 
					'sender'    => $sender,                 
					'recipient' => $reciever                           
				);	

				$response = sendsms_post($url, $sms_array);
				if ($response) {
					return true;
				}else{
					$errors['send'] = "Could not send sms Check your Units";
					return $errors;
				}
			}else{
				$errors['pho'] = "No contact found";
				return $errors;
			}
		}else{
			$errors['con'] = "Cant fetch contact from DB";
			return $errors;
		}
	}else{
		return $errors;
	}
}

// checking election Status
function check_election_status_access($position_id, $reg_number){
	global $link;
	// checking for duplicate
	$duplicate_vote = check_duplicate_registration('count_voters', 'position_id', $position_id, 'voter_reg', $reg_number);
	if ($duplicate_vote) {
		return true;
	}else{
		return false;
	}
}




function check_access_level($staff_id){
	global $link;
	$sql = "SELECT staff_role FROM staff WHERE staff_id = '$staff_id'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			$row = mysqli_fetch_array($query);
			$staff_id = $row['staff_role'];
			if ($staff_id == 1) {
				return true;
			}else{
				return false;
			}
		}return false;
	}return false;
}

function get_student_name($school_id){
	global $link;
	$sql = "SELECT fullname FROM students WHERE reg_number = '$school_id'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			$row = mysqli_fetch_array($query);
			$student_name= $row['fullname'];
			return $student_name;
		}return false;
	}return false;
}

// fetch teacher fullname
function get_staff_name($staff_id){
	global $link;
	$sql = "SELECT lastname, firstname FROM staff WHERE staff_id = '$staff_id'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			$row = mysqli_fetch_array($query);
			$firstname= $row['firstname'];
			$lastname= $row['lastname'];
			$fullname = $firstname." ".$lastname;
			return $fullname;
		}return false;
	}return false;
}

// get result id from result table
function  get_result_id($student_class, $sub_class, $term, $year, $staff_id, $subject, $student_id){
	global $link;
	$sql = "SELECT mid_term_id FROM boj_result WHERE boj_result.class = '$student_class' AND boj_result.sub_class = '$sub_class' AND boj_result.term = '$term' AND boj_result.year = '$year' AND boj_result.staff_id = '$staff_id' AND boj_result.student_id = '$student_id' AND boj_result.subject = '$subject' ORDER BY boj_result.subject";;
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			$row = mysqli_fetch_array($query);
			$boj_result_id = $row['mid_term_id'];
			return $boj_result_id;
		}return false;
	}return false;
}

// getting individual result
function  get_result_by_subject($student_class, $sub_class, $term, $year, $subject, $student_id){
	global $link;
	$sql = "SELECT * FROM boj_result WHERE boj_result.class = '$student_class' AND boj_result.sub_class = '$sub_class' AND boj_result.term = '$term' AND boj_result.year = '$year' AND boj_result.student_id = '$student_id' AND boj_result.subject = '$subject'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while($row = mysqli_fetch_assoc($query)){
				$result[] = $row;
			}
			return $result;
		}
	}return false;
}

// fetching student behavior
function  get_studetn_behavior($mid_term_id){
	global $link;
	$sql = "SELECT * FROM behavior WHERE behavior.boj_result_id = '$mid_term_id'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while($row = mysqli_fetch_assoc($query)){
				$result[] = $row;
			}
			return $result;
		}
	}return false;
}



// Cast voter
function cast_vote($post, $fullname, $student_reg_number, $student_level){
	$err_flag = false;
	$errors = [];
	global $link;
	$date = time();

	if (!empty($post['elect_id'])) {
		$elect_id = sanitize($post['elect_id']);
	} else {
		$errors['cat'] = "Please enter your course_title";
		$err_flag = true;
	}

	if (!empty($post['position_id'])) {
		$position_id = sanitize($post['position_id']);
	} else {
		$errors['cat'] = "Please enter your position_id";
		$err_flag = true;
	}

	
	if ($err_flag === false) {
		// checking for duplicate
		$duplicate_vote = check_duplicate_registration('count_voters', 'position_id', $position_id, 'voter_reg', $student_reg_number);
		if (!$duplicate_vote) {
			$sql = "UPDATE election_candidates SET num_votes = num_votes + 1 WHERE elect_id = '$elect_id'";
			$query = mysqli_query($link, $sql);
			if ($query) {
				$sql = "INSERT INTO count_voters (position_id, elect_id, voter_name, voter_reg, voter_level) VALUES ('$position_id', '$elect_id', '$fullname', '$student_reg_number','$student_level')";
				$query = mysqli_query($link, $sql);
				if ($query) {
					return true;
				}else{
					$errors['post'] = "Could not Cast Vote";
					return $errors;
				}
			} else {
				$errors['post'] = "Ooops! Something went wrong.";
				return $errors;
			}
		}else {
			$errors['post'] = "Sorry you can only cast one vote per position";
			return $errors;
		}
	} else{
		return $errors;
	}

}

// fetch assignment by level
function fetch_level_assign($level){
	global $link;
	$assignments = [];
	$sql = "SELECT assignments.*, staff.firstname, staff.lastname, staff.staff_image, courses.course_title, courses.course_code, courses.semester FROM assignments INNER JOIN staff ON assignments.staff_id = staff.staff_id INNER JOIN courses ON assignments.course_id = courses.course_id WHERE assignments.ass_level = '$level'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while($row = mysqli_fetch_assoc($query)){
				$assignments[] = $row;
			}
			return $assignments;
		}
	} return false;
}

function fetch_staff_assign($staff_id){
	global $link;
	$assignments = [];
	$sql = "SELECT assignments.*, staff.firstname, staff.lastname, staff.staff_image, courses.course_title, courses.course_code, courses.semester FROM assignments INNER JOIN staff ON assignments.staff_id = staff.staff_id INNER JOIN courses ON assignments.course_id = courses.course_id WHERE assignments.staff_id = '$staff_id'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while($row = mysqli_fetch_assoc($query)){
				$assignments[] = $row;
			}
			return $assignments;
		}
	} return false;
}

function format_date($date_in_sec){
	$date_in_sec = date('D j M Y', $date_in_sec);
	return $date_in_sec;
}

// format date in time
function format_time($date_in_sec){
	$date_in_sec = date('H : i : s', $date_in_sec);
	return $date_in_sec;
}



// admin Fetch result function
function fetch_result($course_code, $set_level){
	global $link;
	$results = [];
	$sql = "SELECT * FROM dept_result WHERE dept_result.course_code = '$course_code' AND dept_result.set_level = '$set_level'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while($row = mysqli_fetch_assoc($query)){
				$results[] = $row;
			}
			return $results;
		}
	} return false;
}

// fetch all staff
function get_all_staff(){
	global $link;
	$staffs = [];
	$sql = "SELECT * FROM staff";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while($row = mysqli_fetch_assoc($query)){
				$staffs[] = $row;
			}
			return $staffs;
		}
	} return false;
}



// fetch candidates by level
function count_voters_by_level($elect_id, $level){
	global $link;
	$staffs = [];
	$sql = "SELECT * FROM count_voters WHERE elect_id = '$elect_id' AND voter_level = '$level'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		$count = mysqli_num_rows($query);
		return $count;
	} return false;
}

// fetch candidates by level
function count_voters_by_position($position_id, $level){
	global $link;
	$staffs = [];
	$sql = "SELECT * FROM count_voters WHERE position_id = '$position_id' AND voter_level = '$level'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		$count = mysqli_num_rows($query);
		return $count;
	} return false;
}

// count votes by cadidate
function count_voters_by_candidate($position_id){
	global $link;
	$staffs = [];
	$sql = "SELECT * FROM count_voters WHERE position_id = '$position_id'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		$count = mysqli_num_rows($query);
		return $count;
	} return false;
}

function get_candidates($position_id){
	global $link;
	$candidates = [];
	$sql = "SELECT election_candidates.*, position.* FROM election_candidates INNER JOIN position ON election_candidates.position_id = position.position_id WHERE election_candidates.position_id = '$position_id'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while($row = mysqli_fetch_assoc($query)){
				$candidates[] = $row;
			}
			return $candidates;
		}
	} return false;
}


// fetching all election candidate
function get_all_candidate(){
	global $link;
	$staffs = [];
	$sql = "SELECT election_candidates.*, position.* FROM election_candidates INNER JOIN position ON election_candidates.position_id = position.position_id ";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while($row = mysqli_fetch_assoc($query)){
				$staffs[] = $row;
			}
			return $staffs;
		}
	} return false;
}

// fetch all position
function get_all_position(){
	global $link;
	$staffs = [];
	$sql = "SELECT * FROM position";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while($row = mysqli_fetch_assoc($query)){
				$staffs[] = $row;
			}
			return $staffs;
		}
	} return false;
}



// fetch all students
function get_all_student(){
	global $link;
	$students = [];
	$sql = "SELECT * FROM students";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while($row = mysqli_fetch_assoc($query)){
				$students[] = $row;
			}
			return $students;
		}
	} return false;
}

// fetch student by level
function students_by_level($level){
	global $link;
	$students = [];
	$sql = "SELECT * FROM students WHERE level = '$level'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while($row = mysqli_fetch_assoc($query)){
				$students[] = $row;
			}
			return $students;
		}
	} return false;
}


// fetch staff by id
function get_each_staff($staff_id){
	global $link;
	$sql = "SELECT * FROM staff WHERE staff_id = '$staff_id'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			$row = mysqli_fetch_array($query);
			$staffs = $row;
			return $staffs;
		}
	} return false;
}


// fetch student by id
function get_each_student($student_id){
	global $link;
	$sql = "SELECT * FROM students WHERE student_id = '$student_id'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			$row = mysqli_fetch_array($query);
			$students = $row;
			return $students;
		}
	} return false;
}

// remove staff
function remove_staff($post){
	global $link;
	$staff_id = sanitize($post['staff_id']);
	$sql = "DELETE FROM staff WHERE staff.staff_id = '$staff_id'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		return true;
	}return false;
}

// remove electorial candidate
function remove_candidate($post){
	global $link;
	$elect_id = sanitize($post['elect_id']);
	$sql = "DELETE FROM election_candidates WHERE elect_id = '$elect_id'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		$sql = "DELETE FROM count_voters WHERE elect_id = '$elect_id'";
		$query = mysqli_query($link, $sql);
		if ($query) {
			return true;
		}else{
			return false;
		}
	}return false;
}

// remove student
function remove_student($password, $staff_email, $student_id){
	global $link;
	$errors = [];
	if (authentication($staff_email, $password)) {
		$sql = "DELETE * FROM students WHERE students.student_id = '$student_id'";
		$query = mysqli_query($link, $sql);
		if ($query) {
			return true;
		}else{
			$errors['query'] = "Could not remove student";
			return $errors;
		}
	}else{
		$errors['authen'] = "Incorrect password";
		return $errors;
	}
	
}

// Uppdate staff role
function upgrade_staff($staff_id){
	global $link;
	$sql = "UPDATE staff SET staff_role = staff_role + 1 WHERE staff_id = '$staff_id'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		return true;
	}return false;
}

function upgrade_students($level){
	global $link;
	$sql = "UPDATE students SET level = level + 100 WHERE level = '$level'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		return true;
	}return false;
}

// degrade staff
function degrade_staff($staff_id){
	global $link;
	$sql = "UPDATE staff SET staff_role = staff_role - 1 WHERE staff_id = '$staff_id'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		return true;
	}return false;
}

// fetch course by level
function course_level($level){
	global $link;
    $sql = "SELECT level FROM courses WHERE level = '$level'";
    $query = mysqli_query($link, $sql);
    if ($query) {
    	$total_row = mysqli_num_rows($query);
    	return $total_row;
    }else{
    	return false;
    } 
}

function grades($reg_number, $grade){
	global $link;
    $sql = "SELECT grade FROM dept_result WHERE reg_number = '$reg_number' AND grade = '$grade'";
    $query = mysqli_query($link, $sql);
    if ($query) {
    	$total_row = mysqli_num_rows($query);
    	return $total_row;
    }else{
    	return false;
    } 
}

// update profile
function update_profile_pix($student_id, $file){
	global $link;
	$err_flag = false;
	$errors = [];
	if ($file !== null) {
		$response = sanitize_image($file, $errors);
		if ($response) {
			$updated_image = $response;
		} else {
			$err_flag = true;
		}
	} else {
		$errors['img_err'] = "Please select a profile image";
		$err_flag = true;
	}

	if ($err_flag == false) {
		$sql = "UPDATE students SET student_image = '$updated_image' WHERE student_id = '$student_id'";
		$query = mysqli_query($link, $sql);
		
		if ($query) {
			return true;
		}else{
			$errors['con'] = "Could not update profile image";
			return $errors;
		}
	}else{
		return $errors;
	}
}

// fetch course with level and semester
function fetch_courses($level, $semester){
	global $link;
	$course = [];
	$sql = "SELECT * FROM courses WHERE level = '$level' AND semester = '$semester'";
	$query = mysqli_query($link, $sql);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while($row = mysqli_fetch_assoc($query)){
				$course[] = $row;
			}
			return $course;
		}
	} return false;
}



// add Position
function add_position($post)
{
	global $link;
	$errors = [];
	$err_flag = false;

	if (!empty($post['position'])) {
		$position = sanitize($post['position']);
	} else {
		$errors['position'] = "Please enter your position";
		$err_flag = true;
	}

	if ($err_flag === false) {
		$result = check_duplicate('position', 'positions', $position);
		if ($result === true) {
			$errors['dup'] = "Position already added";
			return $errors;
		}else{
			$sql = "INSERT INTO position (positions) VALUES ('$position')";
			$query = mysqli_query($link, $sql);
			if ($query) {
				return true;
			}else{
				$errors['con'] = "Could not add Position";
				return $errors;
			}
		}
		
	}return $errors;

}


// Register course
function register_course($post){

	global $link;
	$errors = array();
	$student_id = sanitize($post['student_id']);
	$year_admit = sanitize($post['year_admit']);
	if (!empty($post['course_id'])) {
		foreach ($post['course_id'] as $course_id) {
			$sql = "INSERT INTO registered_courses (student_id, course_id, year) VALUES ('$student_id', '$course_id', '$year_admit')";
			$query = mysqli_query($link, $sql);
		}
		if ($query) {
			return true;
		}else{
			$errors[] = "Could not register course ";
			return $errors;
		}
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
