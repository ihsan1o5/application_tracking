
<?php
	ob_start();
	session_start();
	if(!isset($_SESSION['username'])){
    header('Location: applypage.php');
}

	$session_role = $_SESSION['role'];
	$username     = $_SESSION['username'];
	$office       = $_SESSION['office'];

?>

<!DOCTYPE html>
<html lang="en">
	<?php include('include/top-other.php'); ?>
<body>

	<?php include('include/navigation.php'); ?>

	<?php include('include/db_connect.php'); ?>

	<?php
		$errors = array();
		if(isset($_GET['delete'])){
			$d_user_id = $_GET['delete'];
			$select_user = "SELECT * FROM applicants WHERE applicant_id = $d_user_id";
			$select_run = mysqli_query($con, $select_user);
			if(mysqli_num_rows($select_run) > 0){
				$delete_user = "DELETE FROM applicants WHERE applicant_id = $d_user_id";
				$delete_run = mysqli_query($con, $delete_user);
				if($delete_run){
					array_push($errors, "User Has been Deleted!");
				}else{
					array_push($errors, "User Has not been Deleted!");
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
							<a href="add_employee.php">
										Add Employee
									</a>
						</li>
						<li>
							<a href="all_employees.php" class="active">
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

	<!-- PHP for bulk options -->

	<?php
		if(isset($_POST['checkboxes'])){
			foreach ($_POST['checkboxes'] as $userid) {
				$bulk_options = $_POST['bulk-options'];
				
				if($bulk_options == 'admin'){
					
					$update_query = "UPDATE `applicants` SET `role`='admin' WHERE applicant_id = '$userid'";
					$update_query_run = mysqli_query($con, $update_query);

				}else if($bulk_options == 'office_head'){

					$update_query = "UPDATE `applicants` SET `role`='office_head' WHERE applicant_id = '$userid'";
					$update_query_run = mysqli_query($con, $update_query);

				}else if($bulk_options == 'employee'){

					$update_query = "UPDATE `applicants` SET `role`='employee' WHERE applicant_id = '$userid'";
					$update_query_run = mysqli_query($con, $update_query);

				}else{
					echo "<script>alert('Please select an option first...')</script>";
				}
			}
		}
	?>

	<!-- PHP for bulk options -->


			<div class="row">
				<div class="col-md-12">
					<div class="main-page">
						
						<h3>All Users</h3>
						
						<?php if(count($errors) > 0): ?>
							<div class="error">
								<?php foreach ($errors as $error): ?>
									<p><?php echo $error; ?></p>
								<?php endforeach ?>
							</div>
						<?php endif ?>

						<form action="" method="post">
							<div class="row">
								<div class="col-sm-8">
									<div class="row container">
										<div class="col-xs-4">
											<div class="form-group">
												<select name="bulk-options" class="form-control">
													<option value="">
														Choose an Option...
													</option>
													<option value="admin">
														Change to Admin
													</option>
													<option value="office_head">
														Change to Office Head
													</option>
													<option value="employee">
														Change to Employee
													</option>
												</select>
											</div>
										</div>
										<div class="col-xs-8">
											&nbsp&nbsp&nbsp
											<input type="submit" class="btn btn-primary" value="Apply">

											<a href="add_employee.php" class="btn btn-success">Add New</a>
										</div>
									</div>
								</div>
								<div class="col-md-6"></div>
							</div>
						<table class="table table-bordered table-hover a-table">
							<thead>
								<tr>
									<th><input type="checkbox" id="selectallboxes"></th>
									<th>No:</th>
									<th>Name</th>
									<th>Username</th>
									<th>Office</th>
									<th>Image</th>
									<th>Role</th>
									<th>Edit</th>
									<th>Delete</th>
								</tr>
							</thead>
							<tbody>

		<?php
			if($session_role == 'admin'){
				$select_data = "SELECT * FROM applicants ORDER BY applicant_id DESC";
			}else if($session_role == 'office_head'){
				$select_data = "SELECT * FROM applicants WHERE office = '$office' ORDER BY applicant_id DESC";
			}
			$select_run = mysqli_query($con, $select_data);
			if(mysqli_num_rows($select_run) > 0){
				while ($row = mysqli_fetch_array($select_run)) {
					$user_id    = $row['applicant_id'];
					$first_name = ucfirst($row['first_name']);
					$last_name  = ucfirst($row['last_name']);
					$username   = $row['username'];
					$email      = $row['email'];
					$office     = $row['office'];
					$cnic       = $row['cnic'];
					$image      = $row['image'];
					$role       = $row['role'];
				
		?>

								<tr>
									<td> <input type="checkbox" class="checkboxes" name="checkboxes[]" value="<?php echo $user_id; ?>"> </td>
									<td><?php echo $user_id; ?></td>
									<td><?php echo $first_name." ".$last_name;?></td>
									<td><?php echo $username; ?></td>
									<td><?php echo $office; ?></td>
									<td><img src="images/<?php echo $image; ?>" width="40" alt="Image"></td>
									<td>
										<?php 
											if($role == 'admin'){
												echo "Admin";
											}else if($role == 'office_head'){
												echo "Office Head";
											}else if($role == 'employee'){
												echo "Employee";
											}
										?>
									</td>
									<td>
										<input type="submit" class="btn btn-primary edt" value="Edit" id="<?php echo $user_id; ?>">
									</td>
									<td>
										<a href="all_employees.php?delete=<?php echo $user_id?>" class="btn btn-danger">
											Delete
										</a>
									</td>
								</tr>

					<?php }} ?>

							</tbody>
						</table>
					</form>

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
			$e_tmp_image      = $_FILES["e_image"]["tmp_name"];
			$e_address    = $_POST['e-address'];

			$crypt_pass = md5($e_password);

			$insert_update = "UPDATE `applicants` SET `first_name`='$e_f_name',`last_name`='$e_l_name',`username`='$e_username',`email`='$e_email',`cnic`='$e_cnic',`password`='$crypt_pass',`image`='$e_image',`department`='$e_department',`address`='$e_address' WHERE applicant_id = '$user'";
			$run_update = mysqli_query($con, $insert_update);

			if(isset($run_update)){
				move_uploaded_file($e_tmp_image, "images/$e_image");
			echo "<script>alert('User Recrod Has been Updated')</script>";
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
		<?php include('include/footer.php') ?>
	<!--// Footer -->

</body>
</html>