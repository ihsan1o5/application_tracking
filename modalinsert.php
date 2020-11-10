
<?php
	ob_start();
	session_start();
	if(!isset($_SESSION['username'])){
    header('Location: applypage.php');
}

	$session_role = $_SESSION['role'];
	$username     = $_SESSION['username'];
	$office       = $_SESSION['office'];

	include('include/db_connect.php');

	$find_user_id = "SELECT * FROM applicants WHERE username = '$username'";
	$find_user_id_run = mysqli_query($con, $find_user_id);
	if(mysqli_num_rows($find_user_id_run) > 0){
		$find_user_row = mysqli_fetch_array($find_user_id_run);
		$user_id = $find_user_row['applicant_id'];
	}

	$find_office_id = "SELECT * FROM office WHERE office_name = '$office'";
	$find_office_id_run = mysqli_query($con, $find_office_id);
	if(mysqli_num_rows($find_office_id_run) > 0){
		$find_office_row = mysqli_fetch_array($find_office_id_run);
		$user_office_id = $find_office_row['office_id'];
	}

?>

<?php
	
	function checkKeys($con, $randStr){
		$query = "SELECT * FROM receiving";
		$run   = mysqli_query($con, $query);

		while($row = mysqli_fetch_array($run)){
			if($row['number'] == $randStr){
				$keyExist = true;
				break;
			}else{
				$keyExist = false;
				break;
			}
		return $keyExist;
		}
	}

	function generateKey($con){
		$keyLength = 4;
		$str = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$randStr = substr(str_shuffle($str),0, $keyLength);

		$checkKey = checkKeys($con, $randStr);

		while($checkKey == true){
			$randStr = substr(str_shuffle($str),0, $keyLength);
			$checkKey = checkKeys($con, $randStr);
		}
		return $randStr;
	}

	/*=============================================*/
				// Forwarding Application
	/*=============================================*/

	if(isset($_POST['insert'])){
		$office_name = $_POST['office_n'];
		$application_id   = $_POST['appli_no'];
		$office_no   = $_POST['office_no'];

		/* ===================================== */
						// Office ID
			$office_id = "SELECT * FROM office WHERE office_name = '$office_name'";
			$office_id_run = mysqli_query($con, $office_id);
			if(mysqli_num_rows($office_id_run) > 0){
				$office_row = mysqli_fetch_array($office_id_run);
				$to_office_id = $office_row['office_id'];
			}

		/* ===================================== */


		/* ===================================== */
					// Application Details

		$select_appli = "SELECT * FROM applications WHERE application_id = '$application_id'";
		$select_appli_run = mysqli_query($con, $select_appli);
		if(mysqli_num_rows($select_appli_run) > 0){
			$application_row = mysqli_fetch_array($select_appli_run);

			$application_id = $application_row['application_id'];
			$application_no = $application_row['application_no'];
			$employee_id = $application_row['employee_id'];
			$from_office_id = $application_row['office_id'];

			
		}

		/* ===================================== */
		$number = generateKey($con);
		
		$update_appli = "UPDATE `applications` SET `office_id`= '$to_office_id', `employee_id`='0', `status`='new' WHERE application_id = '$application_id'";
		$update_appli_run = mysqli_query($con, $update_appli);

		if($update_appli_run){
			$receiving_date = date('d-m-Y');
			$insert_receiving = "INSERT INTO `receiving`(`application_no`, `office_id`, `received_date`, `r_number`) VALUES ('$application_no','$to_office_id','$receiving_date','$number')";
				mysqli_query($con, $insert_receiving);
			
			$search_forward = "SELECT * FROM forwarding WHERE application_no = '$application_no' and forward_from = '$user_office_id'";
			$search_forward_run = mysqli_query($con, $search_forward);
			if(mysqli_num_rows($search_forward_run) > 0){
				$forwarding_date = date('d-m-Y');
				$update_forward = "UPDATE `forwarding` SET `employee_id`='$user_id', `forwarding_date`= '$forwarding_date', `forward_to`= '$to_office_id', `status`='completed' WHERE application_no = '$application_no' and forward_from = '$user_office_id' and status = 'processing'";
				mysqli_query($con, $update_forward);
			}

			$forwarding_date = date('d-m-Y');
			$insert_forward = "INSERT INTO `forwarding`(`application_no`, `employee_id`, `forwarding_date`, `forward_from`, `forward_to`, `status`, `r_number`) VALUES ('$application_no', '0', '', '$to_office_id', '0', 'processing', '$number')";
			$full_insert = mysqli_query($con, $insert_forward);
			
			if($full_insert){
				complete($application_id, $user_id, $from_office_id);
				delete_status($application_id, $from_office_id, $user_id);
				$msg = "Application forwarded Successfully!!";
				header("Location:index.php?msg=".$msg);
			}else{
				$msg = "Sorry can't forwarded!!";
				header("Location:index.php?msg=".$msg);
			}

		}else{
			$msg = "Application id has not been updated Successfully!!";
			header("Location:index.php?msg=".$msg);
		}
		
		
	}

	/*=============================================*/
				// Forwarding Application ended
	/*=============================================*/


	/*=============================================*/
				// Assiging Application
	/*=============================================*/


	if(isset($_POST['assign'])){

		include('include/db_connect.php');

		$employee_id    = $_POST['employee'];
		$office_name    = $_POST['office_no'];
		$application_no = $_POST['app_no'];
		$f_employee_name= $_POST['f_employee'];

		/*============Office ID==============*/

		$office_query = "SELECT * FROM office WHERE office_name = '$office_name'";
		$office_query_run = mysqli_query($con, $office_query);
		$office_q_r_row = mysqli_fetch_array($office_query_run);
		$office_id = $office_q_r_row['office_id'];

		/*============Office ID End==============*/


		/*===========Employee name===============*/

		$employee_query = "SELECT * FROM applicants WHERE applicant_id = '$employee_id'";
		$employee_query_run = mysqli_query($con, $employee_query);
		$row = mysqli_fetch_array($employee_query_run);

		$employee_f  = $row['first_name'];
		$employee_l  = $row['last_name'];

		/*===========Employee name End===============*/

		$up_emp = "UPDATE `applications` SET `employee_id`='$employee_id', `status`='assigned', `employee_status`='new' WHERE application_id = '$application_no'";

		if(mysqli_query($con, $up_emp)){

			$receiving_date   = date('d-m-Y');
			$insert_receiving_record = "INSERT INTO `r_assign`(`application_id`, `office_id`, `employee_id`, `receiving_date`) VALUES ('$application_no', '$office_id', '$employee_id', '$receiving_date')";

			$insert_assign_record = mysqli_query($con, $insert_receiving_record);

			if($insert_assign_record){

				$search_row = "SELECT * FROM f_assign WHERE application_id = '$application_no' and to_employee = '0'";
				$search_row_run = mysqli_query($con, $search_row);
				if(mysqli_num_rows($search_row_run) > 0){
					$f_date = date('d-m-Y');
					$update_forward_assign = "UPDATE `f_assign` SET `to_employee`='$employee_id',`forward_date`='$f_date' WHERE application_id = '$application_no' and from_employee = '$user_id'";
					$update_forward_assign_run = mysqli_query($con, $update_forward_assign);
					
				}
				
				$insert_forward_assign = "INSERT INTO `f_assign`(`application_id`, `office_id`, `from_employee`, `to_employee`, `forward_date`) VALUES ('$application_no', '$office_id', '$employee_id', '0', '')";
					$insert_forward_assign_run = mysqli_query($con, $insert_forward_assign);
									

				if($insert_forward_assign){
					delete_status($application_no, $office_id, $f_employee_name);
					$msg = "Application has been Assigned to $employee_f $employee_l";
					header("Location:index.php?msg=".$msg);
				}else{
					$msg = "Receiving Records Not inserted Successfully please try again";
					header("Location:index.php?msg=".$msg);
				}
				
		}else{
			$msg = "Application Assigning record not inserted Successfully please try again";
			header("Location:index.php?msg=".$msg);
		}

			
		}else{
			$msg = "Application has not been Assigned Successfully";
			header("Location:index.php?a_msg=".$msg);
		}
	}

	/*=============================================*/
				// Assigning Application Ended
	/*=============================================*/


	/*=============================================*/
				// Remarks for an Application
	/*=============================================*/

	if(isset($_POST['in-remarks'])){

		include('include/db_connect.php');

		$date           = date('d-m-Y');
		$employee_id    = $_POST['employee-id'];
		$office_id      = $_POST['office-id'];
		$application_id = $_POST['application-id'];
		$remarks_subject= $_POST['remarks-subject'];
		$remarks_body   = $_POST['remarks-body'];

		$insert = "INSERT INTO `remarks`(`application_id`, `office_id`, `employee_id`, `remarks_subject`, `remarks_body`, `date`) VALUES ('$application_id', '$office_id', '$employee_id', '$remarks_subject', '$remarks_body', '$date')";

		$run = mysqli_query($con, $insert);

		if($run){
			$up_emp = "UPDATE `applications` SET `employee_status`='remarked' WHERE application_id = '$application_id'";
			mysqli_query($con, $up_emp);
			$re_msg = "Remarks has been Saved Successfully";
			header('Location: index.php?re_msg='.$re_msg);
		}else{
			$re_msg = "Remarks has not been Saved Successfully";
			header('Location: index.php?re_msg='.$re_msg);
		}
	}

	/*=============================================*/
			// Remarks for an Application ended
	/*=============================================*/

	function complete($application_id, $user_id, $from_office_id){
		include('include/db_connect.php');
			
			$select = "SELECT * FROM applications WHERE application_id = '$application_id'";
			$select_run     = mysqli_query($con, $select);
			$select_row     = mysqli_fetch_array($select_run);
			$ap_id          = $select_row['application_id'];
			$applicant_id   = $select_row['applicant_id'];
			$subject        = $select_row['subject'];
			$body           = $select_row['body'];
			$completed_date = date('d-m-Y');

			$insert_complete = "INSERT INTO `completed`(`application_id`, `applicant_id`, `subject`, `body`, `completed_date`, `office_id`, `employee_id`) VALUES ('$ap_id','$applicant_id','$subject','$body','$completed_date','$from_office_id','$user_id')";
			mysqli_query($con, $insert_complete);
	}

	function delete_status($application_id, $office_id, $employee_id){

		include('include/db_connect.php');

		$query = "DELETE FROM status WHERE application_id = '$application_id' and office_id = '$office_id' and employee_id = '$employee_id'";
		$run = mysqli_query($con, $query);
	}

?>