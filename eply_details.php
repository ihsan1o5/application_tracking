
<?php
	ob_start();
	session_start();
	if(!isset($_SESSION['username'])){
    header('Location: applypage.php');

}else if($_SESSION['role'] == 'employee'){
	header('Location: index.php');
}

	$username     = $_SESSION['username'];
    $role         = $_SESSION['role'];
    $get_employee = $_GET['get_eply'];

    include('include/db_connect.php');

    /*===========================================*/
    		// user id
    /*==========================================*/

    $user_id = "SELECT * FROM applicants WHERE username = '$username'";
    $user_id_run = mysqli_query($con, $user_id);
    $user_id_row = mysqli_fetch_array($user_id_run);

    $emp_id = $user_id_row['applicant_id'];
    $office = $user_id_row['office'];

    /*===========================================*/
    		// user id end
    /*==========================================*/


    if($role == 'office_head'){
    	$office_i       = $_SESSION['office'];
    }else if($role == 'admin'){
    	$select_off_from_eply = "SELECT * FROM applicants WHERE applicant_id = '$get_employee'";
    	$select_off_from_eply_run  = mysqli_query($con, $select_off_from_eply);
    	$row = mysqli_fetch_array($select_off_from_eply_run);
    	$office_name = $row['office'];

    	$select_office = "SELECT * FROM office WHERE office_name = '$office_name'";
    	$select_office_run = mysqli_query($con, $select_office);
    	$row = mysqli_fetch_array($select_office_run);
    	$office_i = $row['office_id']; 
    }

    $head_id = "SELECT * FROM applicants WHERE username = '$username'";
    $head_id_run = mysqli_query($con, $head_id);
    $head_id_row = mysqli_fetch_array($head_id_run);
    $office_head_id = $head_id_row['applicant_id'];

?>

<!DOCTYPE html>
<html lang="en">
	<?php include('include/top-other.php'); ?>
	<?php include('include/slider-top.php'); ?>
<body>

	<?php include('include/navigation.php'); ?>


	<!-- Navigation Area -->
		<div class="container">
			<div class="main body animated flipInX">
				<div class="swiper-container">
					<h3>Office Name:</h3>
				    <div class="swiper-wrapper">
				<?php
					if($role == 'admin'){
						$office_query = "SELECT * FROM office WHERE office_id = '$office_i'";
					}else if($role == 'employee' or $role == 'office_head'){
						$office_query = "SELECT * FROM office WHERE office_name = '$office_i'";
					}

					$office_query_run = mysqli_query($con, $office_query);
					if(mysqli_num_rows($office_query_run) > 0){
						while ($row = mysqli_fetch_array($office_query_run)) {
							$office_id   = $row['office_id'];
							$office_name = ucfirst($row['office_name']);
				?>
					      <div class="swiper-slide">
					      	<a href="office_details.php?office_get=<?php echo $office_id; ?>">
					      		<h5><?php echo $office_name; ?></h5>
					      	</a>
					      </div>
				<?php }} ?>
				    </div>
			    <!-- Add Pagination -->
			    <div class="swiper-pagination"></div>
			  </div>
			</div>
		</div>
	<!--// Navigation Area -->
	
	<!-- Panel Content -->
		<div class="container">
			<div class="panel content animated flipInX" id="pan">
			<div class="swiper-container">
				<h3>Employee Name:</h3>
				   <div class="swiper-wrapper">

			<?php
				$employee_query = "SELECT * FROM applicants WHERE applicant_id = '$get_employee'";
				$employee_query_run = mysqli_query($con, $employee_query);
				if(mysqli_num_rows($employee_query_run) > 0){
					while($row = mysqli_fetch_array($employee_query_run)){
						$employee_id = $row['applicant_id'];
						$first_name  = ucfirst($row['first_name']);
						$last_name   = ucfirst($row['last_name']);
			?>

					    <div class="swiper-slide">
					      	<h5>
					      		<?php echo $first_name." ".$last_name; ?>
					      	</h5>
					    </div>

			<?php }}else{ ?>
						<div class="swiper-slide">
					      	<a href="">
					      		<h5>
					      			No Employees Exist
					      		</h5>
					      	</a>
					      </div>
			<?php	} ?>
				    </div>
			    <!-- Add Pagination -->
			    <div class="swiper-pagination"></div>
			  </div>
			</div>
		</div>
	<!--// Panel Content -->

	
	<!-- Quick Access Area-->

		<div class="container">

			<?php
			
			/*=========================================
				Now to fetch the applications data
			===========================================*/


			// All Applications
			$select_all_app = "SELECT * FROM applications WHERE office_id = '$office_id' and employee_id = '$get_employee'";
			$select_all_app_run = mysqli_query($con, $select_all_app);
			$number_of_all_app = mysqli_num_rows($select_all_app_run);

			// All Applications code ended


			// New Applications 
			$select_new_app = "SELECT * FROM applications WHERE office_id = '$office_id' and status = 'new' and employee_id = '$get_employee'";
			$select_new_app_run = mysqli_query($con, $select_new_app);
			$number_of_new_app = mysqli_num_rows($select_new_app_run);

			// New Applications code ended


			// Pending Applications
			$select_pending_app = "SELECT * FROM status WHERE office_id = '$office_id' and status = 'pending' and employee_id = '$get_employee'";
			$select_pending_app_run = mysqli_query($con, $select_pending_app);
			$number_of_pending_app = mysqli_num_rows($select_pending_app_run);

			// Pending Applications code ended


			// Completed Applications
			$select_comp_app = "SELECT * FROM completed WHERE office_id = '$office_id' and employee_id = '$get_employee'";
			$select_comp_app_run = mysqli_query($con, $select_comp_app);
			$number_of_comp_app = mysqli_num_rows($select_comp_app_run);

			// Completed Applications code ended

			/*=========================================
				// Now to fetch the applications data
			===========================================*/
		?>

			<div class="row">
				<div class="col-md-6 col-lg-3">
					<div class="quick-access-blue">
						<div class="row">
							<div class="col-sm-4">
								<i class="fas fa-folder-open"></i>
								<span class="bars">
									<hr>
									<hr>
								</span>
							</div>
							<div class="col-sm-8">
								<span class="num">
							<?php echo $number_of_new_app; ?>
								</span>
								<h5>New Applications</h5>
							</div>
						</div>
						<div class="row access-footer">
							<div class="col-lg-12">
								<a href="index.php">View All Applications</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-3">
					<div class="quick-access-yellow">
						<div class="row">
							<div class="col-sm-4">
								<i class="fas fa-folder-open"></i>
								<span class="bars">
									<hr>
									<hr>
								</span>
							</div>
							<div class="col-sm-8">
								<span class="num">
							<?php echo $number_of_all_app; ?>
								</span>
								<h5>All Applications</h5>
							</div>
						</div>
						<div class="row access-footer">
							<div class="col-lg-12">
								<a href="index.php">View All Applications</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-3">
					<div class="quick-access-red">
						<div class="row">
							<div class="col-sm-4">
								<i class="fas fa-folder-open"></i>
								<span class="bars">
									<hr>
									<hr>
								</span>
							</div>
							<div class="col-sm-8">
								<span class="num">
							<?php echo $number_of_comp_app; ?>
								</span>
								<h5>Completed Tasks</h5>
							</div>
						</div>
						<div class="row access-footer">
							<div class="col-lg-12">
								<a href="completed_tasks.php">View All Applications</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-3">
					<div class="quick-access-green">
						<div class="row">
							<div class="col-sm-4">
								<i class="fas fa-folder-open"></i>
								<span class="bars">
									<hr>
									<hr>
								</span>
							</div>
							<div class="col-sm-8">
								<span class="num">
							<?php echo $number_of_pending_app; ?>
								</span>
								<h5>Pending Tasks</h5>
							</div>
						</div>
						<div class="row access-footer">
							<div class="col-lg-12">
								<a href="pending_tasks.php">View All Applications</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	<!--// Quick Access Area-->

	<?php

		if(isset($_POST['checkboxes'])){
			foreach ($_POST['checkboxes'] as $apppp_id) {

				$appli_number_query = "SELECT * FROM applications WHERE application_id = '$apppp_id'";
				$appli_number_query_run = mysqli_query($con, $appli_number_query);
				$application_num_row = mysqli_fetch_array($appli_number_query_run);
				$app_number = $application_num_row['application_no'];

				$bulk_option = $_POST['bulk-options'];
				
				if($bulk_option == 'details'){
					
					header('Location: all_details.php?application_no='.$app_number);
				}else if($bulk_option == 'completed'){

					$emp_search = "SELECT * FROM applications WHERE application_id = '$apppp_id'";
					$emp_search_run = mysqli_query($con, $emp_search);
					$emp_row = mysqli_fetch_array($emp_search_run);

					$assign_to_id = $emp_row['employee_id'];

					if($emp_id == $assign_to_id){
						$search_query = "SELECT * FROM status WHERE application_id = '$apppp_id' and office_id = '$office_id'";
						$search_run = mysqli_query($con, $search_query);
						$num_rows = mysqli_num_rows($search_run);

						if($num_rows > 0){
							$up_date = date('d-m-Y');
							$update_query = "UPDATE `status` SET `employee_id`='$emp_id', `date`='$up_date',`status`='completed' WHERE application_id = '$apppp_id' and office_id = '$office_id'";
							mysqli_query($con, $update_query);

							completed($apppp_id, $emp_id, $office_i);

						}else{
							$up_date = date('d-m-Y');
							$update_status = "INSERT INTO `status`(`application_id`, `office_id`, `employee_id`, `date`, `status`) VALUES ('$apppp_id','$office_id','$emp_id','$up_date','completed')";
							mysqli_query($con, $update_status);
							completed($apppp_id, $emp_id, $office_i);
							
						}
					}else{
						echo "<script>alert('You cannot apply this functionality to this application. Because this is not assigned to you!')</script>";
					}

				}else if($bulk_option == 'pending'){

					$emp_search = "SELECT * FROM applications WHERE application_id = '$apppp_id'";
					$emp_search_run = mysqli_query($con, $emp_search);
					$emp_row = mysqli_fetch_array($emp_search_run);

					$assign_to_id = $emp_row['employee_id'];

					if($emp_id == $assign_to_id){
						$search_query = "SELECT * FROM status WHERE application_id = '$apppp_id' and office_id = '$office_id'";
						$search_run = mysqli_query($con, $search_query);
						$num_rows = mysqli_num_rows($search_run);

						if($num_rows > 0){
							$up_date = date('d-m-Y');
							$update_query = "UPDATE `status` SET `employee_id`='$emp_id', `date`='$up_date',`status`='pending' WHERE application_id = '$apppp_id' and office_id = '$office_id'";
							mysqli_query($con, $update_query);
						}else{
							$up_date = date('d-m-Y');
							$update_status = "INSERT INTO `status`(`application_id`, `office_id`, `employee_id`, `date`, `status`) VALUES ('$apppp_id','$office_id','$emp_id','$up_date','pending')";
							mysqli_query($con, $update_status);
						}
					}else{
						echo "<script>alert('You cannot apply this functionality to this application. Because this is not assigned to you!')</script>";
					}

					
				}else if($bulk_option == 'cancel'){

					$emp_search = "SELECT * FROM applications WHERE application_id = '$apppp_id'";
					$emp_search_run = mysqli_query($con, $emp_search);
					$emp_row = mysqli_fetch_array($emp_search_run);

					$assign_to_id = $emp_row['employee_id'];

					if($emp_id == $assign_to_id){
						$search_query = "SELECT * FROM status WHERE application_id = '$apppp_id' and office_id = '$office_id'";
						$search_run = mysqli_query($con, $search_query);
						$num_rows = mysqli_num_rows($search_run);

						if($num_rows > 0){
							$up_date = date('d-m-Y');
							$update_query = "UPDATE `status` SET `employee_id`='$emp_id', `date`='$up_date',`status`='canceled' WHERE application_id = '$apppp_id' and office_id = '$office_id'";
							mysqli_query($con, $update_query);
						}else{
							$up_date = date('d-m-Y');
							$update_status = "INSERT INTO `status`(`application_id`, `office_id`, `employee_id`, `date`, `status`) VALUES ('$apppp_id','$office_id','$emp_id','$up_date','canceled')";
							mysqli_query($con, $update_status);
						}
					}else{
						echo "<script>alert('You cannot apply this functionality to this application. Because this is not assigned to you!')</script>";
					}
				}
			}
		}

	?>

	<div class="container">
		<div class="application-pannel">
			<h1>New Applications</h1>

		<!--
			/*=======================================*/
					//Bulck Options 
			/*=======================================*/
														-->

			<form action="" method="post">
				<div class="row">
					<div class="col-sm-8">
						<div class="row">
							<div class="col-xs-6 form-group">
								<select name="bulk-options" id="" class="form-control">
									<option value="">
										Choose one option...
									</option>
									<option value="details">
										Check all Details
									</option>
									<option value="completed">
										Change Status to Complete
									</option>
									<option value="pending">
										Change Status to Pending
									</option>
									<option value="cancel">
										Change Status to Cancel
									</option>
								</select>
							</div>
							<div class="col-xs-6">
								&nbsp&nbsp&nbsp
								<input type="submit" class="btn btn-primary" value="Apply">
								<input type="reset" class="btn btn-danger" value="Cancele">
							</div>
						</div>
					</div>
					<div class="col-sm-4"></div>
				</div>

		<!--
			/*=======================================*/
					//Bulck Options Ended
			/*=======================================*/
														-->

			<div class="new-app-table">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th><input type="checkbox" id="selectallboxes"></th>
							<th>Sr No:</th>
							<th>Subject</th>
							<th>Applicant</th>
							<th>Recived Date</th>
							<th>Details</th>
							<th>View</th>
						</tr>
					</thead>
					<tbody>

			<?php
				$new_apple = "SELECT * FROM applications WHERE office_id = '$office_id' and employee_id = '$employee_id'";
				
				$new_apple_run = mysqli_query($con, $new_apple);
				if(mysqli_num_rows($new_apple_run) > 0){
					while($row = mysqli_fetch_array($new_apple_run)){
						$application_id = $row['application_id'];
						$application_subject = substr($row['subject'],0,50);
						$applicant_id = $row['applicant_id'];
						$application_no = $row['application_no'];
						$date          = $row['received_date'];
						$employee_id = $row['employee_id'];

						$select_applicant = "SELECT * FROM applicants WHERE applicant_id = '$applicant_id'";
						$select_applicant_run = mysqli_query($con, $select_applicant);
						if(mysqli_num_rows($select_applicant_run) > 0){
							while($row = mysqli_fetch_array($select_applicant_run)){
								$first_name = ucfirst($row['first_name']);
								$last_name  = ucfirst($row['last_name']);
							}
						}
					
			?>

						<tr>
							<td>
								<input type="checkbox" class="checkboxes" name="checkboxes[]" value="<?php echo $application_id; ?>">
							</td>
							<td>
								<?php echo $application_id; ?>
							</td>
							<td>
								<?php 
									if($application_subject == ''){
										echo "File Attached";
									}else{
										echo $application_subject."....";
									}
								?>
							</td>
							<td>
								<?php echo $first_name." ".$last_name; ?>
							</td>
							<td>
								<?php echo $date; ?>
							</td>
							<td>
								<a href="all_details.php?application_no=<?php echo $application_no; ?>" class="btn btn-success">Details</a>
							</td>
							<td>
								<input type="button" name="view" value="View" id="<?php echo $application_id; ?>" class="btn btn-primary view_data">
							</td>
						</tr>

					<?php }
				}else{  ?>
					<tr>
						<td colspan="8">
							<?php echo "<h3 style='text-align:center;'>No Applications  are Available</h3>"; ?>
						</td>
					</tr>
				<?php }?>
					</tbody>
				</table>
			</form>
			</div>

		</div>
	</div>

	<?php
		function completed($application_id, $emp_id, $office_id){

			include('include/db_connect.php');
			
			$select = "SELECT * FROM applications WHERE application_id = '$application_id'";
			$select_run     = mysqli_query($con, $select);
			$select_row     = mysqli_fetch_array($select_run);
			$ap_id          = $select_row['application_id'];
			$applicant_id   = $select_row['applicant_id'];
			$subject        = $select_row['subject'];
			$body           = $select_row['body'];
			$completed_date = date('d-m-Y');

			$insert_complete = "INSERT INTO `completed`(`application_id`, `applicant_id`, `subject`, `body`, `completed_date`, `office_id`, `employee_id`) VALUES ('$ap_id','$applicant_id','$subject','$body','$completed_date','$office_id','$emp_id')";
			mysqli_query($con, $insert_complete);
		}
	?>

	<!-- Bootstrap Modals -->
	<?php include('modals.php'); ?>
	<!-- Bootstrap Modals ended -->

	<!-- Footer -->
		<?php include('include/footer.php'); ?>
	<!--// Footer -->


	<!-- Slider jquery -->

		<script type="text/javascript" src="js/swiper.min.js"></script>
	
	 <script>
    var swiper = new Swiper('.swiper-container', {
      effect: 'coverflow',
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: 'auto',
      coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows : true,
      },
      pagination: {
        el: '.swiper-pagination',
      },
    });
  </script>

  <!--// Slider jquery -->

</body>
</html>