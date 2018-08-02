<?php
	include 'inc/header.php';
	include 'lib/student.php';
?>

<?php 

	function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
	
	$stu = new Student();
	$db = new Database();
	if(isset($_POST['take_attendance'])){
		$cur_date=date('Y-m-d');
		$courseId = $_POST['courseId'];
		$_SESSION['courseId'] = $courseId;
		$classId = $_POST['classId'];
		$_SESSION['classId'] = $classId;
		$activeattendanceId = $courseId.$classId."";
		$_SESSION['activeattendanceId'] = $activeattendanceId;
		
		$query = "SELECT * FROM tbl_attendance 
					where att_time = '$cur_date' AND courseId='$courseId' AND classId='$classId'";
		$is_already_taken = $db->select($query);
		if($is_already_taken){
			$_SESSION['feed'] = "<div class='alert alert-danger'><strong>Error ! </strong> Attendance Already Taken Today!</div>";
			header("Location: index.php");
			exit();
		} else {
			$tempres = $db->select("SELECT * FROM tbl_activeattendance WHERE activeattendanceId='".$activeattendanceId."'");
			if($tempres)
			$insertattend = "<div class='alert alert-warning'>Attendance is Already open for student.</div>";
			else{
				$_SESSION['qrcode'] = generateRandomString();
				$feed = $db->insert("INSERT INTO tbl_activeattendance(activeattendanceId, courseId, classId, qrcode) 
						Values('".$activeattendanceId."', '".$courseId."', '".$classId."', '".$_SESSION['qrcode']."')");
				if($feed){
					$insertattend = "<div class='alert alert-info'>Attendance is open for student.</div>";
				} else{
					$insertattend = "<div class='alert alert-danger'>Attendance is not available yet for student.</div>";
				}
			}
		}
	}
	
	
	$cur_date=date('Y-m-d');
	if(isset($_POST['store_attendance'])){
		$attend = $_POST['attend'];
		$insertattend = $stu->insertAttendance($cur_date, $_SESSION['courseId'], $_SESSION['classId'], $attend);
		$db->delete("DELETE FROM tbl_activeattendance WHERE activeattendanceId='".$_SESSION['activeattendanceId']."'");
	}
?>

<?php
	if(isset($insertattend)) {
		echo $insertattend;
	}
?>



<?php if (isset($_SESSION['user_id'])){ ?>
	<center>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Scan This Code For Giving Attendance</h4>
			</div>
			<div class="panel-body">
				<img src="phpqrcode/qrcode.php" alt="QR Code"/>
			</div>		
		</div>
	</center>

	<div class="panel panel-default">
		<div class="panel-body">
			<div class="well text-center" style="font-size: 20px;">
				<strong>Date: </strong><?php echo $cur_date; ?>
			</div>
			<?php
				$get_student = $db->select("SELECT * FROM tbl_courseallocstu T1 INNER JOIN tbl_student T2 
											ON T1.stu_id = T2.roll 
											WHERE T1.courseId='".$_SESSION['courseId']."' 
											AND T1.classId='".$_SESSION['classId']."' 
											ORDER BY T1.stu_id ASC");
				if($get_student){
			?>
			<form action="" method="post" class="form-check">
				<table class="table table-striped">
					<tr>
						<th width="25%">Serial</th>
						<th width="25%">Student Roll</th>
						<th width="25%">Student Name</th>
						<th width="25%">Attendance</th>
					</tr>
			<?php
				$i = 0;
				while($value = $get_student->fetch_assoc()){
					$i++;
			?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $value['roll']; ?></td>
						<td><?php echo $value['name']; ?></td>
						<td>
						<input type="hidden" name="attend[<?php echo $value['roll']; ?>]" value="0">
						<input class="checkbox-inline" type="checkbox" id="attend[<?=$value['roll'];?>]" name="attend[<?=$value['roll'];?>]" class="form-check-input" value="1">
						</td>
					</tr>
			<?php } ?>
					<tr>
						<td colspan="4">
							<input type="submit" class="btn btn-primary" name="store_attendance" value="Submit">
						</td>
					</tr>
				</table>
			</form>
			<?php } else { ?>			
				<div class='alert alert-warning text-center'>No Student Added.</div>
			<?php } ?>
		</div>
	</div>
<?php } ?>
<?php include 'inc/footer.php'; ?>