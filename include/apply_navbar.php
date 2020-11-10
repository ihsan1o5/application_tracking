<!DOCTYPE html>
<html lang="en">

<body>

	<div class="navbar">
			<div class="logo">
				<h2>Application Tracking System</h2>
			</div>
			<ul>

		<?php
			if(isset($_SESSION['username'])){
		?>

				<li>
					<a href="logout.php?type=<?php echo "user"; ?>"><i class="fas fa-lock"></i> SignOut</a>
				</li>
		<?php }else{ ?>
				<li>
					<a href="login.php?type=<?php echo "user"; ?>"><i class="fas fa-lock-open"></i> SignIn</a>
				</li>
			<?php } ?>
				<li>
					<a href="add_guest.php"><i class="fas fa-lock"></i> SignUp</a>
				</li>
			</ul>
		</div>
	
</body>
</html>