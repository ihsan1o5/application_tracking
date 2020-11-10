
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

	$select_record = "SELECT * FROM applicants WHERE username = '$username'";
	$run = mysqli_query($con, $select_record);
	$row = mysqli_fetch_array($run);

	$id         = $row['applicant_id'];
	$first_name = $row['first_name'];
	$last_name  = $row['last_name'];
	$username   = $row['username'];
	$email      = $row['email'];
	$cnic       = $row['cnic'];
	$password   = $row['password'];
	$role       = $row['role'];
	$image      = $row['image'];
	$department = $row['department'];
	$office     = $row['office'];
	$address    = $row['address'];
	$type       = $row['type'];


?>

<!DOCTYPE html>
<html lang="en">
	<?php include('include/top-other.php'); ?>
<body>

	<?php include('include/navigation.php'); ?>

	<div class="container body">
		<div class="pages">

			<div class="row">
				<div class="col-md-12">
					<ul class="menu1">
						<li>
							<a href="profile.php" class="active">
										Profile Page
									</a>
						</li>
		<?php if($session_role == 'admin' || $session_role == 'office_head'): ?>				
						<li>
							<a href="add_employee.php">
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
						
						<h3>Your Profile Details</h3>

						<center>
							<img src="images/<?php echo $image; ?>" class="rounded-circle img-thumbnail p-image" width="30%" height="30%" alt="Your Image">
						</center>
						
						<table class="table table-bordered table-hover t-details" style="color: #fff;">
							<tbody>
								<tr>
									<th width="30%">Your Id:</th>
									<td><?php echo $id; ?></td>
								</tr>
								<tr>
									<th width="30%">Name:</th>
									<td><?php echo $first_name." ".$last_name; ?></td>
								</tr>
								<tr>
									<th width="30%">Username:</th>
									<td><?php echo $username; ?></td>
								</tr>
								<tr>
									<th width="30%">Email Address:</th>
									<td><?php echo $email; ?></td>
								</tr>
								<tr>
									<th width="30%">Password:</th>
									<td>********</td>
								</tr>
								<tr>
									<th width="30%">CNIC:</th>
									<td><?php echo $cnic; ?></td>
								</tr>
								<tr>
									<th width="30%">Department:</th>
									<td><?php echo $department; ?></td>
								</tr>
								<tr>
									<th width="30%">Office:</th>
									<td><?php echo $office; ?></td>
								</tr>
								<tr>
									<th width="30%">Your Role:</th>
									<td><?php echo $role; ?></td>
								</tr>
								<tr>
									<th width="30%">Your Address:</th>
									<td><?php echo $address; ?></td>
								</tr>
							</tbody>
						</table>
							<div class="row">
								<div class="col-md-12 form-group">
									<input type="submit" class="btn btn-primary edt" value="Edit" id="<?php echo $user_id; ?>" style="float: right; margin-right: 12px;">
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Edit User Record -->

	<?php

		if(isset($_POST['edit_submit'])){
			$user         = $_POST['user'];
			$e_f_name     = $_POST['e-first_name'];
			$e_l_name     = $_POST['e-last_name'];
			$e_username   = $_POST['e-username'];
			$e_email      = $_POST['e-email'];
			$e_cnic       = $_POST['e-cnic'];
			$e_password   = $_POST['e-password'];
			$e_department = $_POST['e-department'];
			$e_image      = $_FILES["e_image"]["name"];
			$e_tmp_name   = $_FILES["e_image"]["emp_name"];
			$e_address    = $_POST['e-address'];

			$crypt_pass = md5($e_password);

			$insert_update = "UPDATE `applicants` SET `first_name`='$e_f_name',`last_name`='$e_l_name',`username`='$e_username',`email`='$e_email',`cnic`='$e_cnic',`password`='$crypt_pass',`image`='$e_image',`department`='$e_department',`address`='$e_address' WHERE applicant_id = '$user'";
			$run_update = mysqli_query($con, $insert_update);

			if(isset($run_update)){
				move_uploaded_file($e_tmp_name, "images/$e_image");
			echo "<script>alert('Your Profile Has been Updated')</script>";
			}else{
				echo "<script>alert('User Recrod Has not been Updated')</script>";
			}
		}

	?>

	<!-- Edit User Record ended -->

	<!-- Editing Modal -->

	<div class="modal fade" id="edit-modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h3>Edit User Record</h3>
					
					<button class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">
					<div id="applicant_data">
						
					</div>
				</div>

				<div class="modal-footer">
					Online Application Tracking System!
				</div>

			</div>
		</div>
	</div>


	<!-- Footer -->
		<?php include('include/footer.php'); ?>
	<!--// Footer -->
</body>
</html>