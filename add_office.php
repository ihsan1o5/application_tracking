
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
	<?php include('include/top-other.php'); ?>
<body>

	<?php include('include/navigation.php'); ?>

	<?php
		
		include('include/db_connect.php');

		if(isset($_POST['submit'])){
			$office_name = $_POST['office_name'];
			$office_head = $_POST['head'];
			$off_address = $_POST['address'];

			
			$check_office = "SELECT * FROM office WHERE office_name = '$office_name'";
			$check_office_run = mysqli_query($con, $check_office);

			if(mysqli_num_rows($check_office_run) > 0){
				$error = "This Office is already Registered";
			}else{

				$insert_office = "INSERT INTO `office`(`office_name`, `office_head`, `office_address`) VALUES ('$office_name','$office_head','$off_address')";
				$insert_office_run = mysqli_query($con, $insert_office);

				if($insert_office_run){
					$msg = "Office has been added Successfully";
				}else{
					$error = "Office has not been added";
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
							<a href="add_office.php" class="active">
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
						
						<h3>Add New Office</h3>

						<?php if(isset($error)){ ?>
							<p class="error" style="text-align: center; color: red;"><?php echo $error; ?></p>
						<?php }else if(isset($msg)){ ?>
							<p class="error" style="text-align: center; color: green;"><?php echo $msg; ?></p>
						<?php } ?>

						<form class="form-style" action="" method="post">
							<div class="row">
								<div class="col-md-6 form-group">
								<label for="name">Office Name:</label>
								<input type="text" placeholder="Enter Office Name" class="form-control" required name="office_name">
							</div>
							<div class="col-md-6 form-group">
								<label for="head">Office Head:</label>
								<input type="text" placeholder="Office Head" class="form-control" required name="head">
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 form-group">
								<label for="address">
										Office Address:
									</label>
								<input type="text" placeholder="Office Address" class="form-control" required name="address">
							</div>
						</div>

						<div class="row">
							<div class="col-md-12 form-group">
								<input type="Submit" value="Submit" class="btn btn-primary" style="float: right; margin-left: 10px;" name="submit">
								<input type="Reset" value="Reset" class="btn btn-danger" style="float: right;">
							</div>
						</div>
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>


<!-- Footer -->
		<div class="footer">
			<div class="footer-contents">
				<i class="fas fa-heart"> &nbsp
					<span>&copy 2019</span> &nbsp
				</i> Developed By | Ihsan Ulah Siddique <a href="#">ihsanullahi501@gmail.com</a> 0346-2100165
			</div>
		</div>
	<!--// Footer -->
	<!-- jQuery -->
		<script src="js/jquery.min.js"></script>
		<script src="js/myjsfile.js"></script>
	<!--// jQuery -->
</body>
</html>