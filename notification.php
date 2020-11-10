
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

	$select_record = "SELECT * FROM office WHERE office_name = '$office'";
	$run = mysqli_query($con, $select_record);
	$row = mysqli_fetch_array($run);

	$office_id = $row['office_id'];
	

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
							<a href="all_applications.php">
								All Applications
							</a>
						</li>
						<li>
							<a href="notification.php" class="active">
								Notifications
							</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="row">
				
				<div class="col-md-12">
					<div class="main-page">
						
						<h3>All Notifications</h3>
					<?php if($session_role == 'admin' or $session_role == 'office_head'): ?>		
						<input type="submit" class="btn btn-success" value="Add New Notification" data-target="#add-noti" data-toggle="modal" style="float: right; margin: 0 28px 15px 0;">

					<?php endif ?>

						<table class="table table-bordered table-hover a-table">
							<thead>
								<tr>
									<th>Sr No:</th>
									<th>Subject</th>
									<th>Date</th>
									<th>Office Name</th>
									<th>View</th>
									<th>Edit</th>
									<th>Delete</th>
								</tr>
							</thead>
							<tbody>

			<?php
				$select_query = "SELECT * FROM notifications WHERE office_id = '$office_id' or office_id = '0'";
				$select_query_run = mysqli_query($con, $select_query);
				if(mysqli_num_rows($select_query_run)){
					while($row = mysqli_fetch_array($select_query_run)){

						$notification_id = $row['notification_id'];
						$subject = substr($row['subject'], 0, 30);
						$date = $row['date'];

						$offi_id = $row['office_id'];

						$office_query = "SELECT * FROM office WHERE office_id = '$offi_id'";
						$office_query_run = mysqli_query($con, $office_query);
						$office_row = mysqli_fetch_array($office_query_run);

						$office_name = $office_row['office_name'];

			?>

								<tr>
									<td>
										<?php echo $notification_id; ?>
									</td>
									<td>
										<?php echo $subject."..."; ?>
									</td>
									<td>
										<?php echo $date; ?>
									</td>
									<td>
										<?php
											if($offi_id == '0'){
										 echo $office;
										 }else{
										 echo $office_name;
										 } ?>
									</td>
									<td>
										<input type="submit" class="btn btn-success noti-view" value="View" id="<?php  echo $notification_id; ?>">
									</td>
									<td>
										<input type="submit" class="btn btn-primary edit-noti" value="Edit" id="<?php echo $notification_id; ?>">
									</td>
									<td>
										<a href="notification.php?delete=<?php echo $notification_id; ?>" class="btn btn-danger">Delete</a>
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

	<!-- Edit User Record -->

	<?php

		if(isset($_POST['submit'])){
			$office_id    = $_POST['office'];
			$subject      = $_POST['subject'];
			$body         = $_POST['body'];
			$date         = date('d-m-Y');
			

			$insert = "INSERT INTO `notifications`(`subject`, `body`, `date`, `office_id`, `status`) VALUES ('$subject','$body','$date','$office_id','new')";
			$run = mysqli_query($con, $insert);

			if(isset($run)){
			echo "<script>alert('Notification has been send successfully..!')</script>";
			}else{
				echo "<script>alert('Notification has not been send successfully please try again..!')</script>";
			}
		}

		if(isset($_GET['delete'])){
			$noti_id = $_GET['delete'];
			$delete_query = "DELETE FROM notifications WHERE notification_id = $noti_id";
			$delete_run = mysqli_query($con, $delete_query);
			if($delete_run){
				echo "<script>alert('Notification has been Deleted...!')</script>";
			}else{
				echo "<script>alert('Notification has not been Deleted please try again...!')</script>";
			}
		}

		if(isset($_POST['edit'])){
			$edit_id = $_POST['edit_id'];

			$e_subject = $_POST['e-subject'];
			$e_body    = $_POST['e-body'];

			$update_query = "UPDATE `notifications` SET `subject`='$e_subject',`body`='$e_body' WHERE notification_id = '$edit_id'";
			$run = mysqli_query($con, $update_query);
			if($run){
				echo "<script>alert('Notification has been updated...!')</script>";
			}else{
				echo "<script>alert('Notification has not been updated please try again...!')</script>";
			}
		}

	?>

	<!-- Edit User Record ended -->


	<!-- Modals -->
		<?php include('modals.php'); ?>
	<!-- Modals Ended -->
	<!-- Footer -->
		<?php include('include/footer.php'); ?>
	<!--// Footer -->
</body>
</html>