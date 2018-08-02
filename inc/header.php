<?php
	session_start();
?>

<html>
<head>
	<title>Student Attendance Tracker</title>
	<!-- Jquery -->
	<link href="/attendance/inc/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet">
	<script src="/attendance/inc/jquery-ui-1.12.1/external/jquery/jquery.js"></script>
	<script src="/attendance/inc/jquery-ui-1.12.1/jquery-ui.js"></script>
	
	<!-- Bootstrap -->
	<script type="text/javascript" src="/attendance/inc/bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="/attendance/inc/bootstrap-3.3.7/dist/css/bootstrap.min.css" />

	<!-- ClientJs -->
	<script type="text/javascript" src="/attendance/clientjs/dist/client.min.js"></script>
</head>
<body>
	<div class="container">
	<?php if (isset($_SESSION['user_id'])): ?>
		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="/attendance/index.php">Student Attendance Tracker</a>
		    </div>
		    
		    <ul class="nav navbar-nav navbar-right">
		      <li><a href="/attendance/date_view.php"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> View Attendance</a></li>
		      <li>
					<a href="/attendance/logout.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
					 Logout <?="(".$_SESSION['username'].")"?>
					</a>
					</li>
		    </ul>

		    <?php if($_SESSION['user_id']=='admin' || $_SESSION['logintype']==1){ ?>
		    <ul class="nav navbar-nav navbar-right">
		      <li><a href="/attendance/gen_report.php"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Generate Report</a></li>
		    </ul>
		    <?php } ?>

		    <?php if($_SESSION['user_id']=='admin'){ ?>
		    <ul class="nav navbar-nav navbar-right">
		      <li><a href="/attendance/admin/add_class.php"><span class="glyphicon glyphicon-bookmark" aria-hidden="true"></span> Class</a></li>
		    </ul>

		    <ul class="nav navbar-nav navbar-right">
		      <li><a href="/attendance/admin/add_course.php"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Course</a></li>
		    </ul>
		    
		    <ul class="nav navbar-nav navbar-right">
		      <li><a href="/attendance/admin/show_student.php"><span class="glyphicon glyphicon-education" aria-hidden="true"></span> Student</a></li>
		    </ul>
		    
		    <ul class="nav navbar-nav navbar-right">
		      <li><a href="/attendance/admin/show_teacher.php"><span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span> Teacher</a></li>
		    </ul>
		    <?php } ?>

		  </div>
		</nav>
	<?php else: ?>
	 	<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="/attendance/index.php">Student Attendance Tracker</a>
		    </div>
		    <ul class="nav navbar-nav navbar-right">
		      <li><a href="/attendance/register.php"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Sign Up</a></li>
		      <li><a href="/attendance/login.php"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Login</a></li>
		    </ul>
		  </div>
		</nav>
	<?php endif; ?>
