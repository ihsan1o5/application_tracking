
<?php
	ob_start();
	session_start();
	if(!isset($_SESSION['username'])){
    header('Location: applypage.php');
}
	$session_role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
	<?php 
		include('include/top-other.php'); 
		include('include/db_connect.php');
		?>
<body>

	<?php 
		include('include/navigation.php'); 

		if(isset($_GET['delete'])){
			$get_id = $_GET['delete'];
			$search_office = "SELECT * FROM office WHERE office_id = '$get_id'";
			$search_office_run = mysqli_query($con, $search_office);
			if(mysqli_num_rows($search_office_run) > 0){
				$delete_office = "DELETE FROM office WHERE office_id = '$get_id'";
				$delete_office_run = mysqli_query($con, $delete_office);
				if($delete_office_run){
					echo "<script> window.alert('Office has been Deleted Successfully:'); </script>";
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
							<a href="all_offices.php" class="active">
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
						
						<h3>All Offices</h3>

						<form action="">
							<div class="row container" style="margin-left: 8px;">
								<div class="col-sm-8">
									<div class="row">
										<div class="col-xs-4">
											<div class="form-group">
												<select name="" id="bulk">
													<option value="delete">
														Delete
													</option>
													<option value="admin">
														Change to Main Office
													</option>
													<option value="Other">
														Change to Sub Office
													</option>
												</select>
											</div>
										</div>
										<div class="col-xs-8">
											&nbsp&nbsp&nbsp
											<input type="submit" class="btn btn-primary" value="Apply">

											<a href="add_office.php" class="btn btn-success">Add New</a>
										</div>
									</div>
								</div>
								<div class="col-md-6"></div>
							</div>
						</form>

						<table class="table table-bordered table-hover a-table">
							<thead>
								<tr>
									<th>Sr No</th>
									<th>Office Name</th>
									<th>Office Head</th>
									<th>Address</th>
									<th>Edit</th>
									<th>Delete</th>
								</tr>
							</thead>
							<tbody>

			<?php 

				$fetch_office = "SELECT * FROM office ORDER BY office_id DESC";
				$fetch_office_run = mysqli_query($con, $fetch_office);
				if(mysqli_num_rows($fetch_office_run) > 0){
					while($row = mysqli_fetch_array($fetch_office_run)){

						$office_id      = $row['office_id'];
						$office_name    = ucfirst($row['office_name']);
						$office_head    = ucfirst($row['office_head']);
						$office_address = $row['office_address'];
					
			?>

								<tr>
									<td>
										<?php echo $office_id; ?>
											
									</td>
									<td>
										<?php echo $office_name; ?>
											
									</td>
									<td>
										<?php echo $office_head; ?>
											
									</td>
									<td>
										<?php echo $office_address; ?>
											
									</td>
									<td>
										<input type="submit" value="Edit" class="btn btn-primary o-edt" id="<?php echo $office_id; ?>">
									</td>
									<td>
										<a href="all_offices.php?delete=<?php echo $office_id; ?>" class="btn btn-danger">Delete</a>
									</td>
								</tr>
				<?php }} ?>
							</tbody>
						</table>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Insert Edit Office Data -->

	<?php
		if(isset($_POST['edit-submit'])){
			$off_id = $_POST['office_id'];
			$e_office_name = $_POST['e-office_name'];
			$e_office_head = $_POST['e-head'];
			$e_office_address = $_POST['e-address'];

			$update_query = "UPDATE `office` SET `office_name`='$e_office_name',`office_head`='$e_office_head',`office_address`='$e_office_address' WHERE office_id = '$off_id'";
			$run = mysqli_query($con, $update_query);

			if($run){
				echo "<script>alert('Office Recrod hase been Udated')</script>";
			}else{
				echo "<script>alert('Office Record has not been Updated')</script>";
			}
			
		}
	?>

	<!-- Insert Edit Office Data Ended -->

	<!-- Bootstrap modal for Editing -->

	<div class="modal fade" id="office-edit">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					Edit Office Detials

					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div id="office_data">
						
					</div>
				</div>
				<div class="modal-footer">
					Online Application Tracking System
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap modal for Editing Ended -->


<!-- Footer -->
		<?php include('include/footer.php'); ?>
	<!--// Footer -->
</body>
</html>