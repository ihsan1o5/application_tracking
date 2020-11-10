<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include('include/top-other.php'); ?>
</head>
<body>
	<!-- Bootstrap Modals -->

	<!-- Modal for Application Details -->
	<div id="application-details" class="modal fade">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					Application Details
					
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-2"></div>
						<div class="col-md-8">
							<h2>The University of Malakand</h2>
						</div>
						<div class="col-md-2">
							<img src="images/uomlogo.png" width="80" alt="">
						</div>
					</div>
					<div id="e_details">
							
					</div>
				</div>
				<div class="modal-footer">
					Online Application Tracking System
				</div>
			</div>
		</div>
	</div>
	<!-- // Modal for Application Details -->


	<!-- Modal for Application Forwarding -->

	<?php
		$off_q = "SELECT * FROM office ORDER BY office_id";
		$off_q_run = mysqli_query($con, $off_q);
		if(mysqli_num_rows($off_q_run) > 0){
	?>

	<?php

		if(isset($_GET['msg'])){
			$msg = $_GET['msg'];
			echo "<script>alert('$msg')</script>";
		}

	?>

	<div class="modal fade" id="forwardmodal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					Forward Application

					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form action="modalinsert.php" method="post" id="insert_form">
						<div class="row">
							<div class="col-md-12 form-group">
								<label for="">
									Select Option:
								</label>
								<select name="office_n" id="office_n" class="form-control" required="">
									<option value="">
										Select an Office Name..
									</option>
									<?php
										while($off_row = mysqli_fetch_array($off_q_run)){
									?>
									<option value="<?php echo $off_row['office_name']; ?>">
										<?php echo $off_row['office_name']; ?>
									</option>
									<?php
										}}
									?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 form-group" id="hidden_id">
								<label for="office_No">
									Enter Office Number:
								</label>
								<input type="text" class="form-control" placeholder="Enter Office Number" name="office_no" id="office_no" required="">
							</div>
							<div class="col-md-6 form-group">
								<label for="office_No">
									Application Number:
								</label>
								<input type="text" class="form-control" placeholder="Application Number" name="appli_no" id="applli_no" required="" value="">
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<input type="submit" class="btn btn-primary right" value="Forward" id="insert" name="insert" style="float: right;">
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					Online Application Tracking System
				</div>
			</div>
		</div>
	</div>
	<!-- // Modal for Application Forwarding -->

	<!-- Modal for Application Assigning -->

	<?php

		$select_emp = "SELECT * FROM applicants WHERE office = '$office'";
		$select_emp_run = mysqli_query($con, $select_emp);
		if(mysqli_num_rows($select_emp_run) > 0){

	?>

	<?php
		if(isset($_GET['a_msg'])){
			$msg = $_GET['msg'];
			echo "<script>alert('$msg')</script>";
		}
	?>

	<div class="modal fade" id="assign-to">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					Assign Application To Employee
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form action="modalinsert.php" method="post">
						<div class="row">
							<div class="col-md-12 form-group">
								<label for="name">
									Select An Employee Name:
								</label>
								<select name="employee" id="" class="form-control" required="">
									<option value="">
										Choose An Employee Name...
									</option>
									<?php
										while($row = mysqli_fetch_array($select_emp_run)){
				$first_name = ucfirst($row['first_name']);
				$last_name  = ucfirst($row['last_name']);
				$employee_id = $row['applicant_id'];
									?>
								<option value="<?php echo $employee_id; ?>">
									<?php echo $first_name." ".$last_name; ?>
								</option>
								<?php }} ?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 form-group">
								
								<input type="hidden" placeholder="Office Number" class="form-control" required="" name="office_no" value="<?php echo $office; ?>">
								
							</div>
							<div class="col-md-6 form-group">
								
								<input type="hidden" placeholder="Application Number" class="form-control" name="app_no" id="app" value="">

							</div>
						</div>
						<div class="row">
							<div class="col-md-6 form-group">
								<input type="hidden" class="form-control" name="f_employee" value="<?php echo $emp_id; ?>">
							</div>
							<div class="col-md-6">
								<input type="submit" class="btn btn-primary" value="Assign" style="float: right;" name="assign">
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					Online Application Tracking System
				</div>
			</div>
		</div>
	</div>

	<!-- // Modal for Application Assigning -->

	<!-- Modal for Giving remarks to an Application -->

	<?php
		if(isset($_GET['re_msg'])){
			$remsg = $_GET['re_msg'];
			echo "<script>alert('$remsg')</script>";
		}
	?>

	<div class="modal fade" id="remarks-app">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					Give Your Remarks

					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form action="modalinsert.php" method="post">
						<div class="row">
							<div class="col-md-12 form-group">
								<label for="subject">
									Subject:
								</label>
								<input type="text" placeholder="Enter Subject" class="form-control" name="remarks-subject" required="">
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 form-group">
								<label for="remarks">
									Remarks:
								</label>
								<textarea name="remarks-body" cols="30" rows="5" placeholder="Enter Remarks" class="form-control" required=""></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 form-group">
								<input type="hidden" placeholder="Application Number" class="form-control" name="application-id" id="re-app">
							</div>
							<div class="col-md-4 form-group">
								<input type="hidden" placeholder="Employee ID" class="form-control" name="employee-id" value="<?php echo $emp_id; ?>">
							</div>
							<div class="col-md-4 form-group">
								<input type="hidden" placeholder="Office ID" class="form-control" name="office-id" value="<?php echo $office_id; ?>">
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<input type="submit" class="btn btn-primary" value="Submit" name="in-remarks" style="float: right;">
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					Online Application Tracking System
				</div>
			</div>
		</div>
	</div>

	<!-- // Modal for Giving remarks to an Application -->

	<!-- Modal for Changing Status -->

	<div class="modal fade" id="change-status">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					Change Status

					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					
				</div>
				<div class="modal-footer">
					Online Application Tracking System
				</div>
			</div>
		</div>
	</div>

	<!-- // Modal for Changing Status -->

	<!-- View Notification Modal -->
	<div class="modal fade" id="notification">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					Notifications

					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div id="notification-data">
						
					</div>
				</div>
				<div class="modal-footer">
					Online Application tracking system!
				</div>
			</div>
		</div>
	</div>
	<!-- View Notification Modal Ended -->

	<!-- Add Notification Modal -->

	<?php
		$select_office = "SELECT * FROM office ORDER BY office_id DESC";
		$select_office_run = mysqli_query($con, $select_office);

	?>

	<div class="modal fade" id="add-noti">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h3>Add New Notification</h3>
					
					<button class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">
					<form action="notification.php" method="post">
						<div class="row">
							<div class="col-md-12 form-group">
								<select name="office" class="form-control" required="">
									<option value="">
										Choose an Option...
									</option>
									<option value="0">
										For All Offices
									</option>
		<?php
		if(mysqli_num_rows($select_office_run) > 0){
			while($office_row = mysqli_fetch_array($select_office_run)){
				$office_id   = $office_row['office_id'];
				$office_name = $office_row['office_name'];
		?>
									<option value="<?php echo $office_id; ?>">
										<?php echo "For ".$office_name; ?>
									</option>
					<?php }} ?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 form-group">
								<label for="">
									Subject:
								</label>
								<input type="text" class="form-control" placeholder="Subject" name="subject" required="">
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 form-group">
								<label for="">
									Body:
								</label>
								<textarea name="body" id="" cols="30" rows="5" class="form-control" placeholder="Notification goes here" required=""></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<input type="submit" class="btn btn-primary" value="Submit" name="submit" style="float: right;">
							</div>
						</div>
					</form>
				</div>

				<div class="modal-footer">
					Online Application Tracking System!
				</div>

			</div>
		</div>
	</div>

	<!-- Add Notification Modal ended -->

	<!-- Edit Notification modal -->
		<div class="modal fade" id="edit-noti">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Edit Notification

						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<div id="edit-not">
							
						</div>
					</div>
					<div class="modal-footer">
						Online application tracking system
					</div>
				</div>
			</div>
		</div>
	<!-- Edit Notification modal ended -->
	<!-- // Bootstrap Modals -->
</body>
</html>