<?php
	
	ob_start();
	session_start();

	if(!isset($_SESSION['username'])){
		header('Location: applypage.php');
	}

	$user_id      = $_SESSION['id'];
	$username    = $_SESSION['username'];
    $office      = $_SESSION['office'];
    $role        = $_SESSION['role'];
	$session_type = $_SESSION['type'];
?>
<!DOCTYPE html>
<html lang="en">
	<?php 
		include('include/top-apply.php');
		include('include/db_connect.php');
	?>
<body>
	<div class="container">

		<!-- Top Images -->
		<div class="banner">
			<img src="images/uomlogo.png" width="120" id="uomlogo" alt="">
			<img src="images/uom-pic2.jpg" width="100%" height="200" alt="">
		</div>
		<!--// Top Images -->

		<!-- Navbar -->
		<div class="navbar">
			<div class="logo">
				<h2>Application Tracking System</h2>
			</div>
			<ul>

		<?php
			if(isset($_SESSION['username'])):
		?>

				<li>
					<a href="logout.php?type=<?php echo "user"; ?>"><i class="fas fa-lock"></i> SignOut</a>
				</li>
		<?php endif ?>
				<li>
					<a href=""><i class="fas fa-lock-open"></i> SignUp</a>
				</li>
			</ul>
		</div>
		<!--// Navbar -->

		<div class="all-application-form">
			<div class="top">
				<h1>Your All Applications</h1>
			</div>
			
			<div class="all-applications">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Application Subject</th>
							<th>Submission date</th>
							<th>Current Office</th>
							<th>
								Check all Details
							</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$select_query = "SELECT * FROM applications WHERE applicant_id = '$user_id'";
							$run = mysqli_query($con, $select_query);
							$number_of_rows = mysqli_num_rows($run);
							if($number_of_rows > 0){
								while($row = mysqli_fetch_array($run)){
									$application_id = $row['application_id'];
									$office_id = $row['office_id'];
									$select_office = "SELECT * FROM office WHERE office_id = '$office_id'";
									$run_office = mysqli_query($con, $select_office);
									$result = mysqli_fetch_array($run_office);
									$office_name = $result['office_name'];
						?>
						<tr>
							<td>
								<?php echo $row['subject']; ?>
							</td>
							<td>
								<?php echo $row['received_date']; ?>
							</td>
							<td>
								<?php echo $office_name; ?>
							</td>
							<td>
								<a href="all_details.php?appli_id=<?php echo $application_id; ?>" class="btn btn-primary">Check all Details</a>
							</td>
						</tr>
						<?php }}else{ ?>
						<tr>
							<td colspan="4">
								<h3 style="text-align: center;">
									You have not submitted any application yet!
								</h3>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>

		<?php include('include/footer.php'); ?>

	</div>
</body>
</html>