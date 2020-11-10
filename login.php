
<?php
	ob_start();
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include('include/top-other.php'); ?>
	<style>
		.box{
			width: 30%;
			border: 2px solid #44CF6C;
			vertical-align: bottom;
			border-radius: 5px 5px 0px 0px;
			margin: auto;
			margin-top: 150px;
		}
		.box .heading{
			height: 50px;
			background: #44CF6C;
		}
		.box .heading h5{
			text-align: center;
			font-weight: bolder;
			color: white;
			padding: 10px;
		}
		.box-body form{
			padding: 20px;
		}
		.box-body form .btn{
			float: right;
		}
		.sign-up{
			float: right;
			padding: 5px;
			margin-right: 10px;
		}
		.foo{
			margin-top: 80px;
		}
		.foo .contents{
			text-align: center;
			color: #44CF6C;
		}
		.box .box-body .error{
			width: 80%;
			background: #FCD0A1;
		}
		.box .box-body .error p{
			color: white;
		}
	</style>
</head>
<body>

	<?php

		include('include/db_connect.php');


		$errors = array();

		if(isset($_POST['submit'])){
			$l_username = mysqli_real_escape_string($con, $_POST['username']);
			$password = mysqli_real_escape_string($con, $_POST['password']);

			$crypt_pass = md5($password);

			$select_user = "SELECT * FROM applicants WHERE username = '$l_username'";
			$select_user_run = mysqli_query($con, $select_user);
			if(mysqli_num_rows($select_user_run) > 0){

				$row = mysqli_fetch_array($select_user_run);

				$db_user_id  = $row['applicant_id'];
				$db_username = $row['username'];
				$db_password = $row['password'];
				$role        = $row['role'];
				$office_name = $row['office'];
				$type        = $row['type'];

				if($l_username == $db_username and $crypt_pass == $db_password){

					if($_GET['type'] == 'user'){
						$_SESSION['username'] = $l_username;
						$_SESSION['role']     = $role;
						$_SESSION['office']   = $office_name;
						$_SESSION['type']     = $type;

						if($_SESSION['type'] == 'user'){
							header('Location: index.php');
						}else{
							header('Location: all_guest_appli.php');
						}

					}else if($_GET['type'] == 'guest'){

						$_SESSION['username'] = $l_username;
						$_SESSION['type']     = $type;

						header('Location: add_application.php');

					}else if($_GET['type'] == 'guest_a'){

						$_SESSION['username'] = $l_username;
						$_SESSION['role']     = $role;
						$_SESSION['office']   = $office_name;
						$_SESSION['id']       = $db_user_id;
						$_SESSION['username'] = $l_username;
						$_SESSION['type']     = $type;

						header('Location: all_guest_appli.php');
					}

				}else{
					array_push($errors, "Rong Username or Password");
				}
			}else{
				array_push($errors, "Rong Username or Password");
			}
		}
	?>

	<div class="box">
		<div class="heading">
			<h5>Login Form</h5>
		</div>
		<div class="box-body">
			<?php if(count($errors) > 0): ?>
				<div class="error">
					<?php foreach($errors as $error): ?>
						<p><?php echo $error; ?></p>
					<?php endforeach ?>
				</div>
			<?php endif ?>
			<form action="" method="post">
				<div class="row">
					<div class="col-md-12 form-group">
						<label for="username">Username:</label>
						<input type="text" class="form-control" placeholder="Username" name="username" required="">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 form-group">
						<label for="password">Password:</label>
						<input type="password" class="form-control" placeholder="Password" name="password" required="">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<input type="submit" class="btn btn-success btn" name="submit" value="Login">
						<a href="add_guest.php" class="sign-up">Sign Up?</a>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="foo">
		<div class="contents">
			<i class="fas fa-heart"> &nbsp
				<span>&copy 2019</span> &nbsp
			</i> Developed By | Ihsan Ulah Siddique <a href="#">ihsanullahi501@gmail.com</a> 0346-2100165
		</div>
	</div>
</body>
</html>