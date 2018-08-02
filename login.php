<?php 
	include 'inc/header.php';
	include 'lib/Database.php';
?>

<?php
	
	$db = new Database();

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

	if(isset($_POST['submit'])) { 
		// Check if submit button is clicked
		$userid = $_POST['userid']; 
		$username = $_POST['username']; 
		$password = $_POST['password'];
		$logintype = $_POST['logintype'];
		$userAgent = $_POST['userAgent'];
		$fingerprint = $_POST['fingerprint'];
		$os = $_POST['os'];
		$osVersion = $_POST['osVersion'];
		$colorDepth = $_POST['colorDepth'];
		$availableResolution = $_POST['availableResolution'];
		$user_ip = get_client_ip();

		if (empty($userid) || empty($username) || empty($password)) {
			// check if the username & password are provided
			echo "<div class='alert alert-danger'>Provide all information</div>";
		} else {
			$username = strip_tags($username);
			$username = mysqli_escape_string($db->link, $username);
			$password = strip_tags($password);
			$password = mysqli_escape_string($db->link, $password);
			$password = md5($password);
			$query = "SELECT * FROM tbl_admin WHERE name = '$username' AND id = $userid LIMIT 1";
			if($logintype==1){
				$query = "SELECT * FROM tbl_teacher WHERE teachername = '$username' AND teacher_id = $userid LIMIT 1";
			} else if($logintype==2){
				$query = "SELECT * FROM tbl_student WHERE name = '$username' AND roll = $userid LIMIT 1";
			}

			$result = $db->select($query);

			if($result && $result->num_rows===1){				// Check if any row has returned 
				//$result = $result->fetch_object();
				# Another style
				while ($row = $result->fetch_object()) {
					$hash = $row->password;
					//if($logintype==1 || $logintype==0 || $logintype==2){
						if ($password===$hash) {
						 //if any row has returned, then set session variable
							if($logintype==1){
								$_SESSION['user_id'] =  $row->teacher_id;
								$_SESSION['username'] =  $row->$teachername;
							} else if($logintype==2){
								$_SESSION['user_id'] =  $row->roll;
								$_SESSION['username'] =  $row->name;
							} else{
								$_SESSION['user_id'] =  "admin";
								$_SESSION['username'] =  $row->name;
							}
							
							$_SESSION['logintype'] =  $logintype;
							
							// redirect to index.php and exit
							header('Location: index.php');
							exit();
						} else {
							echo "<div class='alert alert-danger'>Invalid Password</div>";
						}
					//} else{
					//	echo "<div class='alert alert-danger'>Invalid Device</div>";
					//}
				}
			} else {
				echo "<div class='alert alert-danger'>Invalid Username or Password Or Login Type</div>";
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
				<a class="btn btn-success" href="register.php">Sign Up</a>
				<a class="btn btn-info pull-right" href="index.php">Back</a>
			</h2>
		</div>
		<div class="panel-body">
			<form action="login.php" method="post">
				<div class="form-group">
					<select class="form-control" id="logintype" name="logintype">
						<option value="0">Select Your ID type</option>
						<option value="1">Teacher</option>
						<option value="2">Student</option>
					</select>
				</div>

				<div class="form-group">
					<label for="name">ID</label>
					<input type="text" class="form-control" id="userid" name="userid" placeholder="Enter ID">
				</div>

				<div class="form-group">
					<label for="name">Username</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
				</div>

				<div class="form-group">
					<label for="name">Password</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="password">
				</div>

				<input type="hidden" name="userAgent" id="userAgent" value="">
				<input type="hidden" name="os" id="os" value="">
				<input type="hidden" name="osVersion" id="osVersion" value="">
				<input type="hidden" name="fingerprint" id="fingerprint" value="">
				<input type="hidden" name="colorDepth" id="colorDepth" value="">
				<input type="hidden" name="availableResolution" id="availableResolution" value="">

				<div class="form-group">
					<input type="submit" class="btn btn-primary form-control" name="submit" value="Log In">
				</div>
			</form>
		</div>
	</div>
	<div class="col-lg-4"></div>
	</div>
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
