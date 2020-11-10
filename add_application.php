<?php
	
	ob_start();
	session_start();

	if(!isset($_SESSION['username'])){
		header('Location: applypage.php');
	}

	$session_user = $_SESSION['username'];
	$session_type = $_SESSION['type'];



/*======= Code for Generating the Application Number: ========*/

	include('include/db_connect.php');

	function checkKeys($con, $randStr){
		$sql    = "SELECT application_no FROM applications";
		$result = mysqli_query($con, $sql);

		while($row = mysqli_fetch_array($result)){
			if($row['application_no'] == $randStr){
				$keyExists = true;
				break;
			} else {
				$keyExists = false;
			}
			return $keyExists;
		}
	}

	function generateKey($con){
		$keyLength = 8;
		$str       = "_1234567890-ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$randStr   = substr(str_shuffle($str),0, $keyLength);

		$checkKey  = checkKeys($con, $randStr);

		while($checkKey == true){
			$randStr   = substr(str_shuffle($str),0, $keyLength);
			$checkKey  = checkKeys($con, $randStr);
		}

		return $randStr;
	}

	

/*====== // Code for Generating the Application Number: ======*/

	function check($con, $randStr){
		$query = "SELECT * FROM receiving";
		$run   = mysqli_query($con, $query);

		while($row = mysqli_fetch_array($run)){
			if($row['r_number'] == $randStr){
				$keyExist = true;
				break;
			}else{
				$keyExist = false;
				break;
			}
		return $keyExist;
		}
	}

	function generate($con){
		$keyLength = 4;
		$str = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$randStr = substr(str_shuffle($str),0, $keyLength);

		$checkKey = check($con, $randStr);

		while($checkKey == true){
			$randStr = substr(str_shuffle($str),0, $keyLength);
			$checkKey = check($con, $randStr);
		}
		return $randStr;
	}

?>
<!DOCTYPE html>
<html lang="en">
	<?php include('include/top-apply.php'); ?>
<body>
	<div class="container">

		<!-- Top Images -->
		<div class="banner">
			<img src="images/uomlogo.png" width="120" id="uomlogo" alt="">
			<img src="images/uom-pic2.jpg" width="100%" height="200" alt="">
		</div>
		<!--// Top Images -->

		<!-- Navbar -->
			<?php include('include/apply_navbar.php'); ?>


		<!-- Application Submission PHP code -->

			<?php

				$received_date  = date('d-m-Y');

				if(isset($_POST['submit-1'])){
					$subject        = $_POST['subject'];
					$body           = $_POST['body'];
					$applicant_name = $_POST['applicant_name'];
					$office_name    = $_POST['office_name'];
					$application_no = generateKey($con);
					$your_name      = $_POST['applicant_name'];
					$office_number = $_POST['app_no'];
					$submit_to_office = $_POST['submit_office'];
					$application_type = 'written';



				/*======= Getting the Applicant id: ========*/

					$check_applicant = "SELECT * FROM applicants WHERE username = '$session_user'";
					$check_applicant_run = mysqli_query($con, $check_applicant);

					if(mysqli_num_rows($check_applicant_run) > 0){
						$row = mysqli_fetch_array($check_applicant_run);

						$applicant_id     = $row['applicant_id'];
						$applicant_f_name = $row['first_name'];
						$applicant_l_name = $row['last_name'];

						$full_name = $applicant_f_name.' '.$applicant_l_name;

					}else{
						$error = "You are not Registered please Register your self first";
					}

				/*======= // Getting the Applicant id: ========*/

				/*======= Getting the Office id: ========*/


					$office = $_POST['submit_office'];
					$check_office     = "SELECT * FROM office WHERE office_name = '$office'";
					$check_office_run = mysqli_query($con, $check_office);
					if(mysqli_num_rows($check_office_run) > 0){
						$row = mysqli_fetch_array($check_office_run);
						$office_id   = $row['office_id'];
					} else {
						$error = "The System have a Technical error please try again later";
					}

					
				/*======= // Getting the Office id: ========*/

				/*======= Now to insert Application: ========*/

					if(!empty($application_no) or !empty($applicant_id) or !empty($office_id)){

						$insert_applicaion = "INSERT INTO `applications`(`to_office`, `subject`, `body`, `file`, `office_number`, `application_no`, `applicant_id`, `office_id`, `received_date`, `employee_id`, `status`, `employee_status`, `application_type`) VALUES ('$office_name','$subject','$body','','$office_number','$application_no','$applicant_id','$submit_to_office','$received_date','0','new','','$application_type')";
						$insert_applicaion_run = mysqli_query($con, $insert_applicaion);
						if($insert_applicaion_run){

							$number = generate($con);
							$date = date('d-m-Y');
							$insert_receiving = "INSERT INTO `receiving`(`application_no`, `office_id`, `received_date`, `r_number`) VALUES ('$application_no','$submit_to_office','$date','$number')";
								mysqli_query($con, $insert_receiving);

							$insert_forwarding = "INSERT INTO `forwarding`(`application_no`, `employee_id`, `forwarding_date`, `forward_from`, `forward_to`, `status`, `r_number`) VALUES ('$application_no','0','0','$submit_to_office','0', 'processing', '$number')";
							mysqli_query($con, $insert_forwarding);

							echo "<script>
					alert('Congratulations! Your Application is submitted Successfully. You can search your application with the number ( $application_no )');
	</script>";

						} else {
							echo "<script>
					alert('Sorry! Your Application has not been submitted Successfully');
	</script>";
						}

					}else{
						echo "<script>
						alert('Please! Fill All the credincials carefully');
						</script>";
					}

				/*======= // Now to insert Application: ========*/



				}
			?>


		<!-- // Application Submission PHP code -->

		<!--// Navbar -->

		<div class="application-form">
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<h1>Application Submission Form</h1>
				</div>
				<div class="col-md-2">
					<img src="images/uomlogo.png" width="110" alt="">
				</div>
			</div>

			<!-- Form Selection Buttons -->

			<div class="choice-button">
				<div class="choice-form">
					<span>Write An Application</span>
				</div>
				<div class="choice-file">
					<span>Attach A File</span>
				</div>
			</div>

			<!-- Form Selection Buttons Ended -->

			<form action="" id="form-app" method="post" class="appli-form">
	
				<div>
					<div class="row">
						<div class="col-md-4 form-group">
							<label for="number">
								Application Number:
							</label>
							<input type="text" placeholder="Application Number" name="app_no" required="" class="form-control">
						</div>
						<div class="col-md-4"></div>
						<div class="col-md-4 form-group app-head">
							<p>Respected Sir:</p>
							<label for="Office Name">
								Office Name:
							</label>
							<input type="text" name="office_name" class="form-control" placeholder="Enter Office Name" required="">
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-group">
							<label for="subject">
								Application Subject:
							</label>
							<textarea name="subject" id="" cols="30" rows="3" class="form-control" placeholder="The Subject goes here...." required=""><?php
								if(isset($subject)){
									echo $subject;
								}
								?></textarea>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-group">
							<label for="body">
								Application Body:
							</label>
							<textarea name="body" id="" cols="30" rows="10" class="form-control" placeholder="Application Body goes here...." required=""><?php
								if(isset($body)){
									echo $body;
								}
								?></textarea>
						</div>
					</div>
				</div>

				<div class="captions">
					<div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-3"></div>
						<div class="col-md-3"></div>
						<div class="col-md-3 form-group">
							<label for="name">
								Your Name:
							</label>
							<input type="text" placeholder="Your Name" class="form-control" name="applicant_name" required="" value="<?php if(isset($your_name)){echo $your_name; }?>">
							<br>
							<label for="date">
								Date:
							</label>
							<input type="text" placeholder="Today is.." class="form-control" name="date" required="" value="<?php echo $received_date; ?>">
							<br>
							<label for="sir">
								Submit To:
							</label>
							<select name="submit_office" class="form-control">
								<option value="">
									Select Office...
								</option>

						<?php
							$select_office = "SELECT * FROM office";
							$select_office_run = mysqli_query($con, $select_office);
							if(mysqli_num_rows($select_office_run) > 0){
								while($row = mysqli_fetch_array($select_office_run)){
									$submit_office_id = $row['office_id'];
									$office_name = $row['office_name'];
									?>
									<option value="<?php echo $submit_office_id; ?>">
										<?php echo ucfirst($office_name); ?>
									</option>
									<?php
								}
							}
						?>

							</select>

							<br>

						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<input type="submit" class="btn btn-primary" value="Submit" name="submit-1" style="float: right; margin-left: 10px;">

							<input type="reset" class="btn btn-danger" value="Reset" style="float: right; margin-left: 10px;">

							<a href="add_application.php" class="btn btn-success" style="float: right;">
								Back
							</a>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-12 last-note">
						<label for="note">
							Important Note!
						</label>
						<p>
							At the submission of application we will provide a number you must note that. Because that will help you in tracking your application thank you:
						</p>
					</div>
				</div>
			</form>

			<?php

				$date = date('d-m-Y');

				if(isset($_POST['submit-2'])){
					$file = $_FILES['file']['name'];
					$file_tmp = $_FILES['file']['tmp_name'];
					$submit_to = $_POST['office'];
					$applicant_name = $_POST['applicant_name'];
					$date = $_POST['date'];
					$application_no = generateKey($con);
					$application_type = 'file';
					$office_number = $_POST['app_no'];


					/*======= Getting the Applicant id: ========*/

						$check_applicant = "SELECT * FROM applicants WHERE username = '$session_user'";
						$check_applicant_run = mysqli_query($con, $check_applicant);

						if(mysqli_num_rows($check_applicant_run) > 0){
							$row = mysqli_fetch_array($check_applicant_run);

							$applicant_id     = $row['applicant_id'];
							$applicant_f_name = $row['first_name'];
							$applicant_l_name = $row['last_name'];

							$full_name = $applicant_f_name.' '.$applicant_l_name;

						}else{
							$error = "You are not Registered please Register your self first";
						}

					/*======= // Getting the Applicant id: ========*/


					/*=======  Now Insert Application:  ========*/

					$insert_application = "INSERT INTO `applications`(`to_office`, `subject`, `body`, `file`, `office_number`, `application_no`, `applicant_id`, `office_id`, `received_date`, `employee_id`, `status`, `employee_status`, `application_type`) VALUES ('','','','$file','$office_number','$application_no','$applicant_id','$submit_to','$date','0','new','','$application_type')";
					$insert_application_run = mysqli_query($con, $insert_application);

					if($insert_application_run){
							$number = generate($con);
							$date = date('d-m-Y');
							$insert_receiving = "INSERT INTO `receiving`(`application_no`, `office_id`, `received_date`, `r_number`) VALUES ('$application_no','$submit_to','$date','$number')";
							mysqli_query($con, $insert_receiving);

							$insert_forwarding = "INSERT INTO `forwarding`(`application_no`, `employee_id`, `forwarding_date`, `forward_from`, `forward_to`, `status`, `r_number`) VALUES ('$application_no','0','0','$submit_to','0', 'processing', '$number')";
							mysqli_query($con, $insert_forwarding);

							$upload_dir = "/opt/lampp/htdocs/application_tracking/application_files";

							if(!move_uploaded_file($file_tmp, "application_files/$file")){
								echo "<script>
									alert('File Not Saved...!');
								</script>";
							}

							echo "<script>
								alert('Congratulations! Your Application is submitted Successfully. You can search your application with the number ( $application_no )');
								</script>";
					} else {
							echo "<script>
							alert('Sorry! Your Application has not been submitted Successfully');
							</script>";
						}

					/*======= Now Insert Application Ended =====*/
				}

			?>

			<form method="post"  class="form-attach" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-4 form-group">
						<label for="number">
							Application Number:
						</label>
						<input type="text" placeholder="Application Number" name="app_no" required="" class="form-control">
					</div>
					<div class="col-md-4"></div>
					<div class="col-md-4 form-group app-head"></div>
				</div>
				
				<div>
					<input type="file" class="form-control" name="file" required="">
				</div>

				<div class="captions">
					<div class="row form-group">
						<div class="col-md-3"></div>
						<div class="col-md-3"></div>
						<div class="col-md-3"></div>
						<div class="col-md-3 form-group">
							<label for="name">
								Your Name:
							</label>
							<input type="text" placeholder="Your Name" class="form-control" name="applicant_name" required="" value="<?php if(isset($your_name)){echo $your_name; }?>">
							<br>
							<label for="date">
								Date:
							</label>
							<input type="text" placeholder="Today is.." class="form-control" name="date" required="" value="<?php echo $date; ?>">
							<br>
							<label for="sir">
								Submit To:
							</label>
							<select name="office" class="form-control">
								<option value="">
									Select Office...
								</option>

						<?php
							$select_office = "SELECT * FROM office";
							$select_office_run = mysqli_query($con, $select_office);
							if(mysqli_num_rows($select_office_run) > 0){
								while($row = mysqli_fetch_array($select_office_run)){
									$submit_office_id = $row['office_id'];
									$office_name = $row['office_name'];
									?>
									<option value="<?php echo $submit_office_id; ?>">
										<?php echo ucfirst($office_name); ?>
									</option>
									<?php
								}
							}
						?>

							</select>

							<br>

						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<input type="submit" class="btn btn-primary" value="Submit" name="submit-2" style="float: right; margin-left: 10px;">

							<input type="reset" class="btn btn-danger" value="Reset" style="float: right; margin-left: 10px;">

							<a href="add_application.php" class="btn btn-success" style="float: right;">
								Back
							</a>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-12 last-note">
						<label for="note">
							Important Note!
						</label>
						<p>
							At the submission of application we will provide a number you must note that. Because that will help you in tracking your application thank you:
						</p>
					</div>
				</div>

			</form>

		</div>

		<!--// Image Sliders -->

		<?php include('include/footer.php'); ?>

	</div>

</body>
</html>