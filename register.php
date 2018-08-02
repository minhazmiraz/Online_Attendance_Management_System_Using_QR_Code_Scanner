<?php 	
	include 'inc/header.php';
	include 'lib/Database.php';
?>

<?php
	if (isset($_SESSION['user_id'])) {
		header('Location: index.php');
		exit();
	}

	function get_client_ip() {
	    $ipaddress = '';
	    if (isset($_SERVER['HTTP_CLIENT_IP']))
	        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED'];
	    else if(isset($_SERVER['REMOTE_ADDR']))
	        $ipaddress = $_SERVER['REMOTE_ADDR'];
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}

	if ($_SERVER['REQUEST_METHOD']=='POST') {

		$db = new Database();

		if (isset($_POST['register'])) {
			$regtype = $_POST['regtype'];
			$newUser = $_POST['newUser'];
			$userid = $_POST['userid'];
			$email = $_POST['email'];
			$phn_number = $_POST['phn_number'];
			$newPass = $_POST['newPassword'];
			$conPass = $_POST['conPassword'];
			$userAgent = $_POST['userAgent'];
			$fingerprint = $_POST['fingerprint'];
			$os = $_POST['os'];
			$osVersion = $_POST['osVersion'];
			$colorDepth = $_POST['colorDepth'];
			$availableResolution = $_POST['availableResolution'];
			$user_ip = get_client_ip();
			
			if($regtype && !empty($newUser) && !empty($newPass) && !empty($conPass)){
				if($regtype==1){
					$query = "SELECT * FROM tbl_teacher WHERE teacher_id = $userid OR email = '$email' OR phone = '$phn_number' LIMIT 1";
				} else if($regtype==2){
					$query = "SELECT * FROM tbl_student WHERE roll = $userid OR email = '$email' OR phone = '$phn_number' LIMIT 1";
				}

				$result = $db->select($query);
				if($result->num_rows>=1){
					$_SESSION['feed'] = "<div class='alert alert-danger'>Given Information Already Exist</div>";
					header('Location: register.php');
					exit();
				}

				if ($newPass==$conPass) {
					$pass = md5($newPass);
					if($regtype==1){
						$query = "INSERT INTO tbl_teacher(teacher_id, teachername, email, phone, password) VALUES($userid, '$newUser', '$email', '$phn_number', '$pass')";
					} else if($regtype==2){
						$query = "INSERT INTO tbl_student(roll, name, email, phone, password, user_agent, os, os_version, ip, fingerprint, color_depth, resolution) VALUES($userid, '$newUser', '$email', '$phn_number', '$pass', '$userAgent', '$os', '$osVersion', '$user_ip', '$fingerprint', '$colorDepth', '$availableResolution')";
					}

					$feed = $db->insert($query);

					if($feed){
						$_SESSION['feed'] = "<div class='alert alert-success'>Successfully Registered. Now you can login with new username and password</div>";
						header('Location: login.php');
						exit();
					} else {
						$_SESSION['feed'] = "<div class='alert alert-danger'>Registration Unsuccessful</div>";
						header('Location: register.php');
						exit();
					}
				} else {
					$_SESSION['feed'] = "<div class='alert alert-danger'>Passwords didn\'t match</div>";
					header('Location: register.php');
					exit();
				}
			} else {
				$_SESSION['feed'] = "<div class='alert alert-danger'>Missing Information</div>";
				//echo "Hello ".$regtype;
				header('Location: register.php');
				exit();
			}
		}
	}

?>


<?php
	if(isset($_SESSION['feed'])){
		echo $_SESSION['feed'];
		unset($_SESSION['feed']);
	}
?>

<div class="container">
	<div class="col-lg-4"></div>
	<div class="col-lg-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2>
					<a class="btn btn-success" href="login.php">Log In</a>
					<a class="btn btn-info pull-right" href="index.php">Back</a>
				</h2>
			</div>

			<div class="panel-body">
				<form action="register.php" method="post">
					<div class="form-group">
						<input type="hidden" name="regtype" id="regtype" value="0"></label>
						<label for="name">I Am: </label>
						<label class="radio-inline"><input type="radio" name="regtype" id="regtype" value="1"> Teacher</label>
						<label class="radio-inline"><input type="radio" name="regtype" id="regtype" value="2"> Student</label>
					</div>

					<div class="form-group">
						<label for="name">Username</label>
						<input type="text" class="form-control" id="newUser" name="newUser" placeholder="Enter Username">
					</div>
					
					<div class="form-group">
						<label for="name">ID: </label>
						<input type="text" class="form-control" id="userid" name="userid" placeholder="Enter ID">
					</div>

					<div class="form-group">
						<label for="name">Email: </label>
						<input type="text" class="form-control" id="email" name="email" placeholder="Enter Email">
					</div>

					<div class="form-group">
						<label for="name">Phone Number (Ex: 8801XXXXXXXXX): </label>
						<input type="text" class="form-control" id="phn_number" name="phn_number" placeholder="Enter Phone Number">
					</div>

					<div class="form-group">
						<label for="name">Password</label>
						<input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter password">
					</div>

					<div class="form-group">
						<label for="name">Confirm Password</label>
						<input type="password" class="form-control" id="conPassword" name="conPassword" placeholder="Confirm password">
					</div>
					<input type="hidden" name="userAgent" id="userAgent" value="">
					<input type="hidden" name="os" id="os" value="">
					<input type="hidden" name="osVersion" id="osVersion" value="">
					<input type="hidden" name="fingerprint" id="fingerprint" value="">
					<input type="hidden" name="colorDepth" id="colorDepth" value="">
					<input type="hidden" name="availableResolution" id="availableResolution" value="">
					<div class="form-group">
						<input type="submit" class="btn btn-primary form-control" name="register" value="Sign Up">
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-lg-4"></div>
</div>
<?php include 'inc/footer.php'; ?>


<script>
	var client = new ClientJS(); // Create A New Client Object	
	document.getElementById('userAgent').value = client.getUserAgent();
	document.getElementById('fingerprint').value = client.getFingerprint();
	document.getElementById('os').value = client.getOS();
	document.getElementById('osVersion').value = client.getOSVersion();
	document.getElementById('availableResolution').value = client.getAvailableResolution();
	document.getElementById('colorDepth').value = client.getColorDepth();
</script>
