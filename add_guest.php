<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include('include/top-other.php'); ?>
	<style>
		.box{
			width: 100%;
			border: 2px solid #44CF6C;
			border-radius: 10px 10px 0 0;
			margin-top: 30px;
		}
		.box .box-head{
			background: #44CF6C;
			border-radius: 8px 8px 0 0;
			text-align: center;
		}
		.box .box-head h3{
			padding: 10px;
			color: white;
			font-weight: bold;
		}
		.box .box-body .note{
			text-align: center;
			color: blue;
		}
		.box .box-body .note span{
			color: red;
			margin-right: 15px;
		}
		#form{
			padding: 20px;
		}
		#form p{
			padding-top: 10px;
		}
		.foo{
			text-align: center;
			color: #44CF6C;
			margin-top: 30px;
		}
		.error{
			background: #FCD0A1;
		}
	</style>
</head>
<body>

	<?php

		include('include/db_connect.php');

		if(isset($_POST['submit'])){
			$first_name = mysqli_real_escape_string($con, $_POST['first_name']);
			$last_name  = mysqli_real_escape_string($con, $_POST['last_name']);
			$username   = mysqli_real_escape_string($con, $_POST['username']);
			$username_trim = preg_replace("/\s+/", '', $username);
			$email      = mysqli_real_escape_string($con, $_POST['email']);
			$cnic       = mysqli_real_escape_string($con, $_POST['cnic']);
			$password   = mysqli_real_escape_string($con, $_POST['password']);
			$image      = $_FILES['image']['name'];
			$tmp_name   = $_FILES['image']['tmp_name'];
			$address    = mysqli_real_escape_string($con, $_POST['address']);

			$crypt_pass = md5($password);

			$check_query = "SELECT * FROM applicants WHERE username = '$username' || email = '$email' || cnic = '$cnic'";
			$check_query_run = mysqli_query($con, $check_query);
			if(mysqli_num_rows($check_query_run) > 0){
				$error = "User already Exist:";
			}else if($username != $username_trim){
				$error = "Please don't use Spaces/Uppercase letters in Username";
			}else{
				$insert_query = "INSERT INTO `applicants`(`first_name`, `last_name`, `username`, `email`, `cnic`, `password`, `image`, `address`, `type`) VALUES ('$first_name','$last_name','$username','$email','$cnic','$crypt_pass','$image','$address','guest')";
				$insert_query_run = mysqli_query($con, $insert_query);
				if($insert_query_run){
					$msg = "Congratulations! Registeration Successfull:";
					move_uploaded_file($tmp_name, "images/$image");
				}else{
					$error = "Error! Regiteration failed:";
				}
			}

		}
	?>

	<div class="row">
		<div class="col-lg-2"></div>
		<div class="col-lg-8">
			<div class="box">
				<div class="box-head">
					<h3>Registeration From!</h3>
				</div>
				<div class="box-body">
					<p class="note">
						<span>Note!</span>Please make sure that all your credentials are pure and accurate.
					</p>

	<?php
		if(isset($error)){
			echo "<p style='color:red; text-align:center;' class='error'>$error</p>";
		}else if(isset($msg)){
			echo "<p style='color:green; text-align:center;' class='error'>$msg</p>";
		}
	?>

					<form action="" id="form" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-6 form-group">
								<label for="first-name">
									First Name:
								</label>
								<input type="text" placeholder="First Name" class="form-control" name="first_name" required="">
							</div>
							<div class="col-md-6 form-group">
								<label for="last-name">
									Last Name:
								</label>
								<input type="text" placeholder="Last Name" class="form-control" required="" name="last_name">
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 form-group">
								<label for="username">
									Username:
								</label>
								<input type="text" placeholder="Username" class="form-control" name="username" required="">
							</div>
							<div class="col-md-6 form-group">
								<label for="email">
									Email:
								</label>
								<input type="email" placeholder="Email" class="form-control" required="" name="email">
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 form-group">
								<label for="cnic">
									CNIC:
								</label>
								<input type="text" placeholder="CNIC" class="form-control" name="cnic" required="">
							</div>
							<div class="col-md-6 form-group">
								<label for="password">
									Password:
								</label>
								<input type="password" placeholder="Password" class="form-control" required="" name="password">
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 form-group">
								<label for="image">
									Image:
								</label>
								<input type="file" class="form-control" name="image" required="">
							</div>
							<div class="col-md-6 form-group">
								<label for="address">
									Address:
								</label>
								<input type="text" placeholder="Address" class="form-control" required="" name="address">
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<p>Already have an account
									<a href="applypage.php">
										SignIn?
									</a>
								</p>
							</div>
							<div class="col-md-6">
								<input type="submit" class="btn btn-primary" value="Submit" style="float: right; margin-left: 10px;" name="submit">

								<input type="reset" class="btn btn-danger" value="Reset" style="float: right;">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-2"></div>
	</div>

	<!-- Footer -->

	<div class="foo">
		<div class="contents">
			<i class="fas fa-heart"> &nbsp
				<span>&copy 2019</span> &nbsp
			</i> Developed By | Ihsan Ulah Siddique <a href="#">ihsanullahi501@gmail.com</a> 0346-2100165
		</div>
	</div>

	<!-- // Footer -->
	
</body>
</html>