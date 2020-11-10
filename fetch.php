<?php

	include('include/db_connect.php');
	$output = '';
	$sql = "SELECT * FROM applications WHERE application_no LIKE '%".$_POST['search']."%'";
	$result = mysqli_query($con, $sql);
	if(mysqli_num_rows($result) > 0){
		$output .= '<h4 align="center">Search Result!</h4>';
		$output .= '
			<div class="table table-responsive">
				<table class="table table-bordered">
					<tr>
						<th>Sr No:</th>
						<th>Subject</th>
						<th>Applicant Name</th>
						<th>received_date</th>
						<th>Assigned To</th>
						<th>Show Details</th>
					</tr>';
		while ($row = mysqli_fetch_array($result)) {
			$output .= '
				<tr>
					<td>'.$row["application_id"].'</td>
					<td>'.$row["subject"].'</td>
					<td>'.$row["applicant_id"].'</td>
					<td>'.$row["received_date"].'</td>
					<td>'.$row["employee_id"].'</td>
					<td><a href="all_details.php?application_no='.$row["application_no"].'" class="btn btn-success">Details</a></td>
				</tr>
			';
		}
		$output .= '</table> </div>';
		echo $output;
	}else{
		echo 'Search Not Matched!!';
	}

?>