
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

	$fetch_id = "SELECT * FROM applicants WHERE username = '$username'";
	$run = mysqli_query($con, $fetch_id);
	$row = mysqli_fetch_array($run);

	$user_id = $row['applicant_id'];

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
							<a href="all_offices.php">
										All Offices
									</a>
						</li>
			<?php endif ?>
		<?php endif ?>
						<li>
							<a href="all_applications.php" class="active">
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
						
						<h3>All Applications</h3>

						<table class="table table-bordered a-table">
							<thead>
								<tr>
									<th>Application No</th>
									<th>Subject</th>
									<th>Current Office</th>
									<th>Received date</th>
									<th>Show Application</th>
								</tr>
							</thead>
							<tbody>
						
					<?php

					$select_applications = "SELECT * FROM applications WHERE applicant_id = '$user_id'";
					$app_run = mysqli_query($con, $select_applications);
					$num_rows = mysqli_num_rows($app_run);
					if($num_rows > 0){
						while($app_row = mysqli_fetch_array($app_run)){
							$application_id = $app_row['application_id'];
							$office_id = $app_row['office_id'];
							$select_office = "SELECT * FROM office WHERE office_id = '$office_id'";
							$o_run = mysqli_query($con, $select_office);
							$r = mysqli_fetch_array($o_run);
							$office_name = $r['office_name'];
					?>

								<tr>
									<td>
										<?php echo $application_id; ?>
									</td>
									<td>
										<?php echo $app_row['subject']; ?>
									</td>
									<td>
										<?php echo $office_name; ?>
									</td>
									<td>
										<?php echo $app_row['received_date']; ?>
									</td>
									<td>
										<input type="button" name="view" value="View Details" id="<?php echo $application_id; ?>" class="btn btn-primary view_data">
									</td>
								</tr>
								
					<?php
						}

					}else{ ?>

						<tr>
							<td colspan="5">
								<h3 style="text-align: center;">You have not submitted any application</h3>
							</td>
						</tr>

					<?php
						}
					?>

							</tbody>
						</table>
						
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Page -->
		<?php include('modals.php'); ?>
	<!-- Modal Page ended -->

	<!-- Footer -->
		<?php include('include/footer.php'); ?>
	<!--// Footer -->
</body>
</html>