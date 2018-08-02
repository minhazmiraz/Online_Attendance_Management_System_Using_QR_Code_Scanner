<?php
	session_start();
	include 'lib/student.php';
	
	$stu = new Student();
	$db = new Database();
	
	if(isset($_POST["curDate"]) && isset($_POST["courseId"]) &&
		 isset($_POST["classId"]) && isset($_POST["stu_id"])){
		$cur_date = $_POST["curDate"];
		$courseId = $_POST["courseId"];
		$classId = $_POST["classId"];
		$stu_id = $_POST["stu_id"];
		$get_attn = $stu->getAttendance($cur_date, $courseId, $classId, $stu_id);
		$output="";
		if($get_attn){
			$output.="<table class='table table-striped'>";
			$output.='<tr>
					<th width="25%">Serial</th>
					<th width="25%">Student Roll</th>
					<th width="25%">Attendance</th>
					</tr>';
			$i = 0;
			while($value = $get_attn->fetch_assoc()){
				$i++;
				$output.='<tr>
						<td>'. $i .'</td>
						<td>'. $value['roll'] .'</td>
						<td>';
				if($value['attend']==1)
					$output.='<i class="glyphicon glyphicon-ok"></i>';
				else
					$output.='<i class="glyphicon glyphicon-remove"></i>';
				$output.='</td></tr>';

			}
			$output.='</table>';
		} else{
			$output.="<div class='alert alert-warning text-center'>Attendance Not Taken.</div>";
		}
	} else if(isset($_POST['semester']) && isset($_POST['courseId'])){
		$semester = $_POST['semester'];
		$courseId = $_POST['courseId'];
		if($_SESSION['logintype']==0){
			$data = $stu->getClass($semester);
		} else if($_SESSION['logintype']==1){
			//for Teacher
			$data = $db->select("SELECT * FROM tbl_courseallocteacher 
								WHERE courseId='".$courseId."' AND teacher_id=".$_SESSION['user_id']);
		} else{
			$data = $db->select("SELECT * FROM tbl_courseallocstu 
								WHERE courseId='".$courseId."' AND stu_id=".$_SESSION['user_id']);
		}
		
		$output = '<option value="0">Select Class</option>';
		while($value = $data->fetch_assoc()){
			$output.="<option value=".$value['classId'].">".$value['classId']."</option>";
		}
	} else{
		$output = "<div class='alert alert-danger text-center'>Credential Missing</div>";
	}
	echo $output;
?>