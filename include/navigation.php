
<?php
	
	$role        = $_SESSION['role'];
	$username    = $_SESSION['username'];
    $office      = $_SESSION['office'];

    //echo $session_role." ".$username." ".$office;

    include('db_connect.php');

    /*   Office ID   */

    $office_query = "SELECT * FROM office WHERE office_name = '$office'";
    $office_run = mysqli_query($con, $office_query);
    if(mysqli_num_rows($office_run) > 0){
    	$office_row = mysqli_fetch_array($office_run);

    	$office_id = $office_row['office_id'];

    }

    /*   Office ID ended   */

    /*   User ID   */

    $user_query = "SELECT * FROM applicants WHERE username = '$username'";
    $user_run   = mysqli_query($con, $user_query);
    if(mysqli_num_rows($user_run) > 0){
    	$user_row = mysqli_fetch_array($user_run);

    	$user_id  = $user_row['applicant_id'];

    }

    /*   User ID ended   */
?>

<!DOCTYPE html>
<html lang="en">
<body>
	
	<!-- Header Top Area -->
		<div class="navbar">
			<div class="container">
				<div class="menu-toggle"><i class="fas fa-bars"></i></div>
				<div class="logo-top">
					<a href="index.php">
						<img src="images/ats.png" width="300" height="60" alt="">
					</a>
				</div>
				<div class="notifications">
					<ul>
						<li>
							<form action="index.php" method="post">
								<input type="text" placeholder="Search here" class="form-input" name="search" required="">
								<button type="submit" id="search-button" name="sear"><i class="fas fa-search"></i></button>
							</form>
						</li>
						<li>

		<?php
			$noti_query = "SELECT * FROM notifications WHERE office_id = '$office_id' or office_id = '0' and status = 'new' ORDER BY notification_id DESC LIMIT 10";
			$noti_run = mysqli_query($con, $noti_query);
			$noti_rows = mysqli_num_rows($noti_run);
		?>

							<a href="#" id="notif">
								<i class="fas fa-bell"></i>
							<?php if($noti_rows > 0): ?>
								<span class="num">
									<?php
										if($noti_rows < 10){
											echo "0".$noti_rows;
										}else{
											echo $noti_rows;
										}
									?>
								</span>
							<?php endif ?>
							</a>
						</li>
						<li>

				<?php
					$application_query = "SELECT * FROM applications WHERE office_id = '$office_id'";
					if($role != 'employee'){
						$application_query .= "and status = 'new'";
					}
					if($role == 'employee'){
						$application_query .= "and employee_id = '$user_id' and employee_status = 'new'";
					}
					$application_run = mysqli_query($con, $application_query);
					$application_num_rows = mysqli_num_rows($application_run);

				?>

							<a href="#" id="notif2">
								<i class="fas fa-comment-alt"></i>
								<?php
									if($application_num_rows > 0){
								?>
								<span class="num">
									<?php if($application_num_rows < 10){
										echo '0'.$application_num_rows;
									}else{
										echo $application_num_rows;
									} ?>
								</span>
								<?php } ?>
							</a>
						</li>
						<li>
							<a href="#" id="sett">
								<i class="fas fa-cog"></i>
							</a>
						</li>
					</ul>
				</div>
			</div>
			
			<!-- Notifications -->

			<div class="notification">
				<div class="arrow-up1"></div>
					<div class="list-contents1">
						<div class="noti-head">
							<h5>Notifications</h5>
						</div>
						<div class="noti-body">
			<?php
				if($noti_rows > 0){
					while($noti_r = mysqli_fetch_array($noti_run)){
						$notification_id = $noti_r['notification_id'];
						$not_subject = substr($noti_r['subject'], 0, 25);
						$not_date    = $noti_r['date'];
			?>
							<div class="details">
								<a href="#" class="noti-view" id="<?php echo $notification_id; ?>">
									<img src="images/1.jpg" width="50" alt="">
									<p>
										<?php echo $not_subject; ?>
									</p>
									<span class="date">
										<?php echo $not_date; ?>
									</span>
								</a>
							</div>
			<?php }}else{ ?>
							<div class="details">
								<center>
									<h3>No new notification</h3>
								</center>
							</div>
			<?php } ?>
						</div>
						<div class="noti-footer">
							<a href="notification.php">View all</a>
						</div>
					</div>
			</div>

			<!--// Notifications -->

			<!-- Chat Area -->
		<div class="arrow-up2"></div>
			<div class="list-contents2">
				<div class="chat-head">
					<h5>New Applications</h5>
				</div>
				
				<div class="chat-body">

		<?php
			if($application_num_rows > 0){
				while($application_row = mysqli_fetch_array($application_run)){
					$application_id = $application_row['application_id'];
					$subject = substr($application_row['subject'], 0, 28);
					$ap_date = $application_row['received_date'];

		?>
				
				
					<div class="detials view_data" id="<?php echo $application_id; ?>">
						<a href="#">
							<img src="images/user-male-icon.png" width="40" alt="">
							<span class="name">
								<?php echo $subject."..."; ?>
							</span><br>
							<span class="date">
								<?php echo $ap_date; ?>
							</span>
						</a>
					</div>
		<?php }}else{ ?>
			<center>
				<h3>No Applications</h3>
			</center>
		<?php } ?>
				</div>
				<div class="chat-footer">
					<a href="index.php">View all</a>
				</div>
			</div>
			<!--// Chat Area -->

		</div>
	<!-- Header Top Area -->

	<!-- Settings Area -->

		<div class="setting-arrow"></div>
		<div class="setting-panel">
			<div style="border-bottom: 2px solid gray;">
				<i class="fas fa-file"></i>
				<a href="profile.php">Your Profile</a>
			</div>
			<?php if($role == 'admin'){ ?>
				<div style="border-bottom: 2px solid gray;">
					<i class="fas fa-cog"></i>
					<a href="profile.php">Settings</a>
				</div>
			<?php }else if($role == 'office_head'){ ?>
				<div style="border-bottom: 2px solid gray;">
					<i class="fas fa-cog"></i>
					<a href="profile.php">Settings</a>
				</div>
			<?php } ?>
			<div>
				<i class="fas fa-lock"></i>
				<a href="logout.php">Logout</a>
			</div>
		</div>

	<!--// Settings Area -->

</body>
</html>