<?php
	ob_start();
	session_start();
	if(!isset($_SESSION['username'])){
    header('Location: applypage.php');

}

	$username    = $_SESSION['username'];
    $office      = $_SESSION['office'];
    $role        = $_SESSION['role'];

    include('include/db_connect.php');

   function office_name($office_id){
   		include('include/db_connect.php');

		$select_query = "SELECT * FROM office WHERE office_id = '$office_id'";
		$run = mysqli_query($con, $select_query);
		$row = mysqli_fetch_array($run);

		$office_name = ucfirst($row['office_name']);
		return $office_name;
	}

?>

<!DOCTYPE html>
<html lang="en">
	<?php include('include/top-other.php'); ?>
<body>

	<?php include('include/navigation.php'); ?>

	<?php include('include/chat.php'); ?>

	
	<div class="container set-page">
	<!--
		<div class="caption">
			<h2>
				<marquee behavior="move" direction="left">
						Application's all Details and Remarks
				</marquee>
			</h2>
		</div>
		-->

		<?php

			if(isset($_GET['application_no'])){
				$application_no = $_GET['application_no'];

				$query = "SELECT * FROM applications WHERE application_no = '$application_no'";
				$run = mysqli_query($con, $query);
				$num_rows = mysqli_num_rows($run);
				if($num_rows > 0){
					$row = mysqli_fetch_array($run);

					$application_id = $row['application_id'];
					$to_office = $row['to_office'];
					$subject   = $row['subject'];
					$body      = $row['body'];
					$applicant_id = $row['applicant_id'];
					$received_date = $row['received_date'];
					$application_type = $row['application_type'];

					$applicant_query = "SELECT * FROM applicants WHERE applicant_id = '$applicant_id'";
					$applicant_run = mysqli_query($con, $applicant_query);
					$applicant_row = mysqli_fetch_array($applicant_run);

					$applicant_first_name = $applicant_row['first_name'];
					$applicant_last_name  = $applicant_row['last_name'];

				}
			}

		?>


		<div id="application-page">
			<div class="row">
				<div class="col-md-2 app-logo">
					<img src="images/uomlogo.png" width="120" alt="">
				</div>
				<div class="col-md-6">
					<h3 class="ap-title">
						The University of Malakan
					</h3>
				</div>
				<div class="col-md-4"></div>
			</div>

			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4"></div>
				<div class="col-md-4">
					Respected Sir <br>
					Department of <?php echo $to_office; ?> <br>
				</div>
			</div> <br>

			<?php if($application_type == 'written'){ ?>
				<div class="row">
					<div class="col-md-12 subject">
						<b>
							Subject
						</b> <br><br>
						<p>
							<?php echo $subject; ?>
						</p>
					</div>
				</div>

				<div class="row body-caption">
					<div class="col-md-12">
						<span>
							<b>
								sir,
							</b>
						</span>
						
						<p>
							<?php echo $body; ?>
						</p>
					</div>
				</div>
			<?php }else if ($application_type == 'file') { ?>
				<div class="row body-caption">
					<img src="application_files/<?php echo $row['file']; ?>" alt="File" width="100%" height="100%">
				</div>
			<?php } ?>

			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4"></div>
				<div class="col-md-4">
					Name: <?php echo $applicant_first_name." ".$applicant_last_name; ?> <br>
					Date: <?php echo $received_date; ?>
				</div>
			</div>

		</div>

	<?php
		$receiving_query = "SELECT * FROM receiving WHERE application_no = '$application_no' ORDER BY id ASC";
		$receiving_run   = mysqli_query($con, $receiving_query);
		if(mysqli_num_rows($receiving_run) > 0){
			while($receiving_row = mysqli_fetch_array($receiving_run)){
				
				$received_in = $receiving_row['received_date'];
				$r_date = $receiving_row['received_date'];

				$r_number = $receiving_row['r_number'];
				$received_office_id = $receiving_row['office_id'];
				$office_name = office_name($received_office_id);

				$forward_query = "SELECT * FROM forwarding WHERE application_no = '$application_no' and forward_from = '$received_office_id' and r_number = '$r_number'";
				$forward_run = mysqli_query($con, $forward_query);
				$forward_row = mysqli_fetch_array($forward_run);

				$status = $forward_row['status'];
				$f_date = $forward_row['forwarding_date'];

				$f_number = $forward_row['r_number'];
				$forward_to_office_id = $forward_row['forward_to'];
				$f_office_name = office_name($forward_to_office_id);


	?>

		<div class="detail-section">
			<div class="row">
				<div class="col-md-12">
					<label for="office-name">
						Office Name: &nbsp;&nbsp;&nbsp;&nbsp;
						<?php echo $office_name; ?>
					</label>
				</div>
			</div>
				
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<label for="time" class="clickable-1">
							<b>Time Elapsed:</b>
						</label>
					</div>

					<div class="row time-contents">
						<div class="col-md-12">
							<table class="table table-bordered table-responsive table-striped">
								<thead>
									<tr>
										<th>Received Date</th>
										<td>
											<?php echo $r_date; ?>
										</td>
										<td>
											Received By: <?php echo $office_name; ?>
										</td>
									</tr>
									<tr>
										<th>Forwarded Date</th>
										<td>
											<?php 
												if($forward_to_office_id == '0'){
													echo "The application is now present in this office...!";
												}else{
													echo $f_date;
												}
											?>
										</td>
										<td>
											Forwarded To: <?php 
												if($forward_to_office_id == '0'){
													echo "Not forwarded yet...!";
												}else{
													echo $f_office_name;
												}
											?>
										</td>
									</tr>
									<tr>
										<th>Total Time</th>
										<td>
											<?php 
											if($forward_to_office_id == '0'){
												echo $r_date." --to-- "."________";
											}else{
												echo $r_date." --to-- ".$f_date;
											}
											?>
										</td>

			<?php
				$holidays=array();
				$working_days = getWorkingDays($r_date,$f_date,$holidays);
			?>

										<td>
						<?php
							if($forward_to_office_id == 0){
								echo "<b>Processing Yet...!</b>";
							}else if($working_days == 1){
								echo "<span style='font-size: 23px;'>$working_days</span>"." "."Working Day";
							}else if($working_days < 9){
								echo "<b style='font-size: 23px;'>$working_days</b>"." "."Working Days";
							}
						?>
										</td>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<label for="remarks" class="clickable-2">
							<b>Remarks:</b>
						</label>
					</div>
				</div>
			</div>
		
		<?php
			$remarks_query = "SELECT * FROM remarks WHERE application_id = '$application_id' and office_id = '$received_office_id'";
			$remarks_query_run = mysqli_query($con, $remarks_query);
			if(mysqli_num_rows($remarks_query_run) > 0){
				while($remarks_row = mysqli_fetch_array($remarks_query_run)){
					$subject = $remarks_row['remarks_subject'];
					$body    = $remarks_row['remarks_body'];
				
		?>

				<div class="row remarks-contents">
					<div class="col-md-12">
						<label for="">
							<b>Subject:</b>
						</label><br>
						<p>
							<?php echo $subject; ?>
						</p><br>
						<label for="">
							<b>Body:</b>
						</label><br>
						<p>
							<?php echo $body; ?>
						</p>
					</div>
					<label for="" class="remarks-by">
						Remarks By: ihsan ullah
					</label>
					<hr>			
				</div>
			<?php }} ?>
		</div>

		<?php
		// first while and if
			}}else{
				?>
				<div class="detail-section">
					<center>
						<h1 style="padding-top: 20px;">
							The application has not precessed yet...!
						</h1>
					</center>
				</div>

		<?php
			}
		?>
		
	</div>
	
	
	<?php

//The function returns the no. of business days between two dates and it skips the holidays
function getWorkingDays($startDate,$endDate,$holidays){
    // do strtotime calculations just once
    $endDate = strtotime($endDate);
    $startDate = strtotime($startDate);


    //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
    //We add one to inlude both dates in the interval.
    $days = ($endDate - $startDate) / 86400 + 1;

    $no_full_weeks = floor($days / 7);
    $no_remaining_days = fmod($days, 7);

    //It will return 1 if it's Monday,.. ,7 for Sunday
    $the_first_day_of_week = date("N", $startDate);
    $the_last_day_of_week = date("N", $endDate);

    //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
    //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
    if ($the_first_day_of_week <= $the_last_day_of_week) {
        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
    }
    else {
        // (edit by Tokes to fix an edge case where the start day was a Sunday
        // and the end day was NOT a Saturday)

        // the day of the week for start is later than the day of the week for end
        if ($the_first_day_of_week == 7) {
            // if the start date is a Sunday, then we definitely subtract 1 day
            $no_remaining_days--;

            if ($the_last_day_of_week == 6) {
                // if the end date is a Saturday, then we subtract another day
                $no_remaining_days--;
            }
        }
        else {
            // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
            // so we skip an entire weekend and subtract 2 days
            $no_remaining_days -= 2;
        }
    }

    //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
   $workingDays = $no_full_weeks * 5;
    if ($no_remaining_days > 0 )
    {
      $workingDays += $no_remaining_days;
    }

    //We subtract the holidays
    foreach($holidays as $holiday){
        $time_stamp=strtotime($holiday);
        //If the holiday doesn't fall in weekend
        if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
            $workingDays--;
    }

    return $workingDays;
}

?>

		<!-- Footer -->

	<?php include('include/footer.php'); ?>

		<!--// Footer -->
</body>
</html>