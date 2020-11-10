<?php

	if(isset($_POST['appli_id'])){
		$output = "";
		include('include/db_connect.php');

		$select_app = "SELECT * FROM applications WHERE application_id = '".$_POST['appli_id']."'";
		$result = mysqli_query($con, $select_app);

		$output .= '
			<div class="table-responsive">
				<table class="table table-bordered">
		';
		while ($row = mysqli_fetch_array($result)) {
			$eppem = $row['applicant_id'];
			$application_type = $row['application_type'];

			$employee_name = "SELECT * FROM applicants WHERE applicant_id = '$eppem'";
			$employee_name_run = mysqli_query($con, $employee_name);
			$name = mysqli_fetch_array($employee_name_run);

			$f_name = $name['first_name'];
			$l_name = $name['last_name'];


				if($application_type == 'written'){
					$output .= '

								<div class="row" id="side-caption">
									<div class="col-md-2"></div>
									<div class="col-md-3"></div>
									<div class="col-md-3"></div>
									<div class="col-md-4">
										<p>
											Respected Sir:
										</p>
										<p>
											University of Malakand
										</p>
										<p>
											Department of '.$row['to_office'].'
										</p>
									</div>
								</div>
								<div class="row app-subject">
											<div class="col-md-12">
												<label for="subject">
													<h5>Application Subject</h5>
												</label>
												<p id="subject">
													'.$row["subject"].'
												</p>
											</div>
										</div>

										<div class="row app-body">
											<div class="col-md-12">
												<label for="body">
													<h5>Sir,</h5>
												</label>
												<p>
													'.$row["body"].'
												</p>
											</div>
										</div>
										<div class="row end-details">
											<div class="col-md-3"></div>
											<div class="col-md-3"></div>
											<div class="col-md-2"></div>
											<div class="col-md-4">
												<p>
													<label for="">Name:</label>&nbsp&nbsp '.$f_name." ".$l_name.'
												</p>
												<p>
													<label for="">Date:</label>&nbsp&nbsp&nbsp&nbsp
													'.$row['received_date'].'
												</p>
											</div>
										</div>
											';
				}else if ($application_type == 'file') {
					$output .= '
							<div>
								<img src="application_files/'.$row['file'].'"width="100%" height="100%">
							</div>
					';
				}

			
		}
		$output .= "</table></div>";
		echo $output;

	}

	if(isset($_POST['user_id'])){
		include('include/db_connect.php');

		$output = '';
		$user = $_POST['user_id'];
		
		$select_user = "SELECT * FROM applicants WHERE applicant_id = '$user'";
		$run = mysqli_query($con, $select_user);
		$number_of_rows = mysqli_num_rows($run);

		$r = mysqli_fetch_array($run);

		if($number_of_rows > 0){
			$output .= '

				<form action="all_employees.php" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-6 form-group">
									<label for="first_name">First Name:</label>
									<input type="text" class="form-control" placeholder="First Name" required="" name="e-first_name" value="'.$r['first_name'].'">
								</div>
								<div class="col-md-6 form-group">
									<label for="last_name">
										Last Name:
									</label>
									<input type="text" class="form-control" placeholder="Last Name" required="" name="e-last_name" value="'.$r['last_name'].'">
								</div>
							</div>

							<div class="row">
								<div class="col-md-6 form-group">
									<label for="username">
										Username:
									</label>
									<input type="text" class="form-control" placeholder="Username" required="" name="e-username" value="'.$r['username'].'">
								</div>
								<div class="col-md-6 form-group">
									<label for="email">
										Email:
									</label>
									<input type="email" placeholder="Email" class="form-control" name="e-email" required="" value="'.$r['email'].'">
								</div>
							</div>

							<div class="row">
								<div class="col-md-6 form-group">
									<label for="cnic">
										CNIC:
									</label>
									<input type="text" class="form-control" placeholder="CNIC" required="" name="e-cnic" value="'.$r['cnic'].'">
								</div>
								<div class="col-md-6 form-group">
									<label for="password">
										Password:
									</label>
									<input type="password" class="form-control" placeholder="Password" name="e-password" required="">
								</div>
							</div>

							<div class="row">
								<div class="col-md-6 form-group">
									<label for="department">
										Department:
									</label>
									<input type="text" placeholder="Department" class="form-control" name="e-department" required="" value="'.$r['department'].'">
								</div>
								<div class="col-md-6 form-group">
									<label for="image">
										Image:
									</label>
									<input type="file" required="" name="e_image" class="form-control"
									value="">
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 form-group">
									<label for="address">
										Address:
									</label>
									<textarea name="e-address" class="form-control" cols="30" rows="2" placeholder="Address" required="">'.$r['address'].'</textarea>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<input type="submit" class="btn btn-primary" value="Update" style="float: right;
									margin-left: 10px;" name="edit_submit">
									<input type="hidden" value="'.$user.'" name="user">
								</div>
							</div>
						</form>

			';
		}
		echo $output;

	}

	if(isset($_POST['office_id'])){

		include('include/db_connect.php');

		$office_id = $_POST['office_id'];
		$output = '';
		$select_query = "SELECT * FROM office WHERE office_id = '$office_id'";
		$run = mysqli_query($con, $select_query);
		$num_rows = mysqli_num_rows($run);
		$r = mysqli_fetch_array($run);

		if($num_rows > 0){
			$output .= '

				<form action="all_offices.php" method="post">
							<div class="row">
								<div class="col-md-6 form-group">
								<label for="name">Office Name:</label>
								<input type="text" placeholder="Enter Office Name" class="form-control" required name="e-office_name" value="'.$r['office_name'].'">
							</div>
							<div class="col-md-6 form-group">
								<label for="head">Office Head:</label>
								<input type="text" placeholder="Office Head" class="form-control" required name="e-head" value="'.$r['office_head'].'">
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 form-group">
								<label for="address">
										Office Address:
									</label>
								<input type="text" placeholder="Office Address" class="form-control" required name="e-address" value="'.$r['office_address'].'">
							</div>
						</div>

						<div class="row">
							<div class="col-md-12 form-group">
								<input type="Submit" value="Update" class="btn btn-primary" style="float: right; margin-left: 10px;" name="edit-submit">
								<input type="hidden" name="office_id" value="'.$office_id.'">
							</div>
						</div>
						</form>

			';
		}
		echo $output;
	}

	if(isset($_POST['notification_id'])){
		include('include/db_connect.php');

		$notification_id = $_POST['notification_id'];

		$update_query = "UPDATE `notifications` SET `status`='readed' WHERE notification_id = '$notification_id'";
		mysqli_query($con, $update_query);

		$output = '';
		$select = "SELECT * FROM notifications WHERE notification_id = '$notification_id'";
		$select_run = mysqli_query($con, $select);
		$num_rows = mysqli_num_rows($select_run);
		$row = mysqli_fetch_array($select_run);
		if($num_rows > 0){

			$output .= '

				<div class="row">
					<div class="col-md-12">
						<label>Subject:</label>
						<p style="text-align: center;">
							'.$row["subject"].'
						</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label>Body:</label>
						<p style="text-align: justify;">
							'.$row["body"].'
						</p>
					</div>
				</div>

			';

		}
		echo $output;
	}

	if(isset($_POST['edit_noti_id'])){

		include('include/db_connect.php');

		$edit_notification_id = $_POST['edit_noti_id'];
		$edit_query = "SELECT * FROM notifications WHERE notification_id = '$edit_notification_id'";
		$edit_query_run = mysqli_query($con, $edit_query);
		$edit_row = mysqli_fetch_array($edit_query_run);

		$output = '';
		$edit_id = $edit_row['notification_id'];
		$subject = $edit_row['subject'];
		$body    = $edit_row['body'];

		$output .= '
				
				<form action="notification.php" method="post">
					<div class="row">
						<div class="col-md-12 form-group">
							<label for="">
									Subject:
							</label>
							<input type="text" class="form-control" placeholder="Subject" name="e-subject" required="" value="'.$subject.'">
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-group">
							<label for="">
									Body:
							</label>
							<textarea name="e-body" id="" cols="30" rows="5" class="form-control" placeholder="Notification goes here" required="">'.$body.'</textarea>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<input type="hidden" value="'.$edit_id.'" name="edit_id" style="float: right;">
						</div>
						<div class="col-md-6">
							<input type="submit" class="btn btn-primary" value="Update" name="edit" style="float: right;">
						</div>
					</div>
				</form>

		';
		echo $output;

	}

?>