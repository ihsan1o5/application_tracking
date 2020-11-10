
<?php
	ob_start();
	session_start();
	if(!isset($_SESSION['username'])){
    header('Location: applypage.php');
}

	$session_role   = $_SESSION['role'];
	$session_office = $_SESSION['office'];

?>

<!DOCTYPE html>
<html lang="en">
	<?php include('include/top-other.php'); ?>
<body>

	<?php include('include/navigation.php'); ?>

	<?php include('include/db_connect.php'); ?>

	<?php

		$errors = array();

		if(isset($_POST['submit'])){
			$first_name = mysqli_real_escape_string($con, $_POST['first_name']);
			$last_name  = mysqli_real_escape_string($con, $_POST['last_name']);
			$username   = mysqli_real_escape_string($con, $_POST['username']);
			$username_trim = preg_replace("/\s+/",'', $username);
			$email      = mysqli_real_escape_string($con, $_POST['email']);
			$cnic       = mysqli_real_escape_string($con, $_POST['cnic']);
			$password   = mysqli_real_escape_string($con, $_POST['password']);
			$role       = mysqli_real_escape_string($con, $_POST['role']);
			$image      = $_FILES['image']['name'];
			$tmp_name   = $_FILES['image']['tmp_name'];
			$department = mysqli_real_escape_string($con, $_POST['department']);
			$office     = mysqli_real_escape_string($con, $_POST['office']);
			$address    = mysqli_real_escape_string($con, $_POST['address']);

			$crypt_password = md5($password);

			$check_query = "SELECT * FROM applicants WHERE username = '$username' or email = '$email' or cnic = '$cnic'";
			$check_run = mysqli_query($con, $check_query);

			if($username != $username_trim){
				array_push($errors, "Don't use Spaces/Uppercase letters in Username");
			}else if(mysqli_num_rows($check_run) > 0){
				array_push($errors, "User already Exist");
			}else if(empty($role)){
				array_push($errors, "Please Select your Designation");
			}else if(empty($office)){
				array_push($errors, "Please Select your office");
			}else if(count($errors) == 0){
				$insert_data = "INSERT INTO `applicants`(`first_name`, `last_name`, `username`, `email`, `cnic`, `password`, `role`, `image`, `department`, `office`, `address`, `type`) VALUES ('$first_name','$last_name','$username','$email','$cnic','$crypt_password','$role','$image','$department','$office','$address','user')";
				$insert_run = mysqli_query($con, $insert_data);
				if($insert_run){
					move_uploaded_file($tmp_name, "images/$image");
					array_push($errors, "Congratulations! Registeration Successfull:");
				}else{
					array_push($errors, "Error! Regiteration failed:");
				}
			}
		}


	?>

	<div class="container body">
		<div class="pages">

			<div class="row">
				<div class="col-md-12">
					<ul class="menu1">
						<li>
							<a href="profile.php">
										Profile Page
									</a>
						</li>
		<?php if($session_role == 'admin' || $session_role == 'office_head'): ?>
						<li>
							<a href="add_employee.php" class="active">
										Add Employee
									</a>
						</li>
						<li>
							<a href="all_employees.php">
										All Employees
									</a>
						</li>
			<?php if($session_role == 'admin'): ?>
						<li>
							<a href="add_office.php">
										Add Office
									</a>
						</li>
						<li>
							<a href="all_offices.php">
										All Offices
									</a>
						</li>
			<?php endif ?>
		<?php endif ?>
						<li>
							<a href="all_applications.php">
										All Applications
									</a>
						</li>
						<li>
							<a href="notification.php">
								Notifications
							</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="row">
				
				<div class="col-md-12">
					<div class="main-page">
						
						<h3>Add New User</h3>

						<?php if(count($errors) > 0): ?>
								<div class="error">
									<?php foreach($errors as $error): ?>
									<p><?php echo $error; ?></p>
								<?php endforeach; ?>
								</div>
						<?php endif; ?>

						<form class="form-style" action="" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-6 form-group">
									<label for="first_name">First Name:</label>
									<input type="text" class="form-control" placeholder="First Name" required="" name="first_name" value="<?php if(isset($first_name)){echo $first_name;} ?>">
								</div>
								<div class="col-md-6 form-group">
									<label for="last_name">
										Last Name:
									</label>
									<input type="text" class="form-control" placeholder="Last Name" required="" name="last_name" value="<?php if(isset($last_name)){echo $last_name;} ?>">
								</div>
							</div>

							<div class="row">
								<div class="col-md-6 form-group">
									<label for="username">
										Username:
									</label>
									<input type="text" class="form-control" placeholder="Username" required="" name="username" value="<?php if(isset($username)){echo $username;} ?>">
								</div>
								<div class="col-md-6 form-group">
									<label for="email">
										Email:
									</label>
									<input type="email" placeholder="Email" class="form-control" name="email" required="" value="<?php if(isset($email)){echo $email;} ?>">
								</div>
							</div>

							<div class="row">
								<div class="col-md-6 form-group">
									<label for="cnic">
										CNIC:
									</label>
									<input type="text" class="form-control" placeholder="CNIC" required="" name="cnic" value="<?php if(isset($cnic)){echo $cnic;} ?>">
								</div>
								<div class="col-md-6 form-group">
									<label for="password">
										Password:
									</label>
									<input type="password" class="form-control" placeholder="Password" name="password" required="">
								</div>
							</div>

							<div class="row">
								<div class="col-md-6 form-group">
									<label for="department">
										Department:
									</label>
									<input type="text" placeholder="Department" class="form-control" name="department" required="" value="<?php if(isset($department)){echo $department;} ?>">
								</div>
								<div class="col-md-6 form-group">
									<label for="image">
										Image:
									</label>
									<input type="file" required="" name="image" class="form-control"
									value="<?php if(isset($image)){echo $image;} ?>">
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 form-group">
									<label for="role">
										Designation:
									</label>
									<select name="role" class="form-control">
										<option value="" selected="">
											Choose one....
										</option>
										
							<?php if($session_role == 'admin'): ?>
										<option value="admin">
											Admin
										</option>
										<option value="office_head">
											Office Head
										</option>
							<?php endif ?>

										<option value="employee">
											Employee
										</option>
									</select>
								</div>
								<div class="col-md-6 form-group">
									<label for="office">
										Office:
									</label>
									<select name="office" class="form-control">
										<option value="" selected="">
											Choose one...
										</option>

				<?php
					if($session_role == 'admin'){
						$select_office = "SELECT * FROM office ORDER BY office_id DESC";
					}else if($session_role == 'office_head'){
						$select_office = "SELECT * FROM office WHERE office_name = '$session_office'";
					}
					$select_office_run = mysqli_query($con, $select_office);
					if(mysqli_num_rows($select_office_run) > 0){
						while ($row = mysqli_fetch_array($select_office_run)) {
							$office_id   = $row['office_id'];
							$office_name = $row['office_name'];
							echo "<option value='".$office_name."'>".ucfirst($office_name)."</option>"; 
						 }}  ?>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 form-group">
									<label for="address">
										Address:
									</label>
									<textarea name="address" class="form-control" cols="30" rows="2" placeholder="Address" required="" value="<?php if(isset($address)){echo $address;}?>"></textarea>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<input type="submit" class="btn btn-primary" value="Submit" style="float: right;
									margin-left: 10px;" name="submit">
									<input type="reset" class="btn btn-danger" value="Reset" style="float: right;">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include('include/footer.php'); ?>
	<!-- jQuery -->
		<script src="js/jquery.min.js"></script>
		<script src="js/myjsfile.js"></script>
	<!--// jQuery -->
</body>
</html>