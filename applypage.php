<!DOCTYPE html>
<html lang="en">
	<?php include('include/top-apply.php'); ?>
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
				<li>
					<input type="text" name="search_apps" id="search_apps" placeholder="Search Application"> <i class="fas fa-search"></i>
				</li>
				<li>
					<a href="login.php?type=<?php echo "user"; ?>"><i class="fas fa-lock-open"></i> SignIn</a>
				</li>
				<li>
					<a href=""><i class="fas fa-lock"></i> SignUp</a>
				</li>
			</ul>
		</div>
		<!--// Navbar -->

		<!-- Searche engine -->
		<div id="searchresult">
			
		</div>
		<!-- Searche engine -->

		<!-- Buttons -->
		<div class="row button-tabs">
			<div class="col-md-6">
				<div class="btn-new1">
					<a href="login.php?type=<?php echo "guest"; ?>">
						<h2>Submit an application</h2>
					</a>
				</div>
			</div>
			<div class="col-md-6">
				<div class="btn-new2">
					<a href="login.php?type=<?php echo "guest_a"; ?>">
						<h2>View all applications</h2>
					</a>
				</div>
			</div>
		</div>
		<!--// Buttons -->
		
		<!-- Image Sliders -->
			
		<div class="row vc">
			<div class="col-md-6">
				<img src="images/uom-vc.jpg" width="100%" height="78%" alt="">
				<h4>Professor Doctor Gulzaman the Voice Chancelar of University of Malakand</h4>
			</div>
			<div class="col-md-6">
				<img src="images/haseeb-sab.jpg" width="100%"  alt="">
				<h4>Dr. Haseeb Ur Rahman (Assistant Professor at UOM) The Coordinator of the project </h4>
			</div>
		</div>

		<div class="row">
			<div class="col-md-3">
				
			</div>
			<div class="col-md-6">
				<div style="width: 100%;">
					<img src="images/ihsan1.jpeg" width="600" alt="">
					<h4 style="text-align: center; padding: 10px;">Engineer. Ihsanullah Siddique (The Student of CS&IT at UOM) Project Developer </h4>
				</div>
			</div>
			<div class="col-md-3"></div>
		</div>

		<!--// Image Sliders -->

		<?php include('include/footer.php'); ?>

	</div>

</body>
</html>