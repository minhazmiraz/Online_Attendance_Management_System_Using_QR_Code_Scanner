<?php include_once 'Database.php'; ?>

 
<?php

class student{
	private $db;	
	public function __construct(){
		$this->db = new Database();
	}

	public function getStudents(){
		$query = 'SELECT * FROM tbl_student ORDER BY roll ASC';
		$result = $this->db->select($query); 
		return $result;
	}

	public function getTeachers(){
		$query = 'SELECT * FROM tbl_teacher ORDER BY teacher_id ASC';
		$result = $this->db->select($query); 
		return $result;
	}

	public function getAttendance($cur_date, $courseId, $classId, $stu_id){
		if($stu_id==''){
			$query = "SELECT * FROM tbl_attendance 
					WHERE courseId='".$courseId."' AND classId='".$classId."' 
					AND att_time='".$cur_date."' ORDER BY att_time ASC";
		} else if($cur_date==''){
			$query = "SELECT * FROM tbl_attendance 
					WHERE courseId='".$courseId."' AND classId='".$classId."' 
					AND roll='".$stu_id."' ORDER BY roll ASC";
		} else{
			$query = "SELECT * FROM tbl_attendance 
					WHERE courseId='".$courseId."' AND classId='".$classId."' 
					AND roll='".$stu_id."' AND att_time='".$cur_date."' 
					ORDER BY att_time ASC";			
		}
		$result = $this->db->select($query);
		return $result;
	}

	public function getClass($semester){
		if($semester) $query = "SELECT * FROM tbl_class WHERE semester=$semester ORDER BY classId ASC";
		else $query = "SELECT * FROM tbl_class ORDER BY classId ASC";
		$result = $this->db->select($query);
		return $result;
	}

	public function getCourse(){
		$query = "SELECT * FROM tbl_course ORDER BY courseId ASC";
		$result = $this->db->select($query);
		return $result;
	}

	public function getCourseForAlloc($alloc_type, $alloc_id, $courseId, $semester){
		if($alloc_type==0){
			$query = "SELECT T1.classId, T2.classId AS classId2 FROM (
						SELECT tbl_class.classId FROM tbl_class WHERE tbl_class.semester='$semester'
					) T1 LEFT JOIN (
						SELECT tbl_courseallocstu.classId FROM tbl_courseallocstu WHERE tbl_courseallocstu.courseId='$courseId' AND tbl_courseallocstu.stu_id='$alloc_id'
					) T2 ON T1.classId = T2.classId WHERE T2.classId IS NOT NULL";
			$result = $this->db->select($query);
			if($result) return 0;
			
			$query = "SELECT T1.classId, T2.classId AS classId2 FROM (
						SELECT tbl_class.classId FROM tbl_class WHERE tbl_class.semester='$semester'
					) T1 LEFT JOIN (
						SELECT tbl_courseallocstu.classId FROM tbl_courseallocstu WHERE tbl_courseallocstu.courseId='$courseId' AND tbl_courseallocstu.stu_id='$alloc_id'
					) T2 ON T1.classId = T2.classId ORDER BY T1.classId ASC";

/* 			$query = "SELECT T1.courseId, T1.courseTitle, T1.semester, T2.courseId as courseId2 FROM (
						tbl_course T1 LEFT JOIN (
							SELECT tbl_courseallocstu.courseId FROM `tbl_courseallocstu` WHERE tbl_courseallocstu.stu_id='$alloc_id'
               			) T2 ON T1.courseId=T2.courseID
					)WHERE T2.courseId IS NULL 
						ORDER BY T1.courseId ASC"; */
			
		} else{
			$query = "SELECT T1.classId, T2.classId AS classId2 FROM (
						SELECT tbl_class.classId FROM tbl_class WHERE tbl_class.semester='$semester'
					) T1 LEFT JOIN (
						SELECT tbl_courseallocteacher.classId FROM tbl_courseallocteacher WHERE tbl_courseallocteacher.courseId='$courseId' AND tbl_courseallocteacher.teacher_id='$alloc_id'
					) T2 ON T1.classId = T2.classId WHERE T2.classId IS NULL ORDER BY T1.classId ASC";
		}
		$result = $this->db->select($query);
		return $result;
	}

	public function getAllocCourse($alloc_type, $alloc_id){
		if($alloc_type==1)
			$query = "SELECT * FROM tbl_courseallocteacher INNER JOIN tbl_course 
						ON tbl_courseallocteacher.courseId = tbl_course.courseId 
						WHERE teacher_id=$alloc_id ORDER BY tbl_courseallocteacher.courseId ASC";
		else
			$query = "SELECT * FROM tbl_courseallocstu  INNER JOIN tbl_course 
						ON tbl_courseallocstu.courseId = tbl_course.courseId 
						WHERE stu_id=$alloc_id ORDER BY tbl_courseallocstu.courseId ASC";
		$result = $this->db->select($query);
		return $result;
	}

	public function insertClass($name, $semester, $section) {
		$name = mysqli_escape_string($this->db->link, $name);
		$section = mysqli_escape_string($this->db->link, $section);
		if(empty($name) || empty($section) || !$semester) {
			$msg = "<div class='alert alert-danger'><strong>Error ! </strong> Field Must Not Be Empty !</div>";
			return $msg;
		} else {
			$query = "SELECT * FROM tbl_class WHERE classId='$name'";
			$result = $this->db->select($query);

			if($result && $result->num_rows===1){
				$msg = "<div class='alert alert-danger'>Given Information Already Exist!</div>";
				return $msg;
			}


			$query = "INSERT INTO tbl_class(classId, semester, section) VALUES('$name',$semester,'$section')";
			$insert = $this->db->insert($query);

			if($insert){
				$msg = "<div class='alert alert-success'><strong>Success ! </strong> Class Data Inserted Successfully.</div>";
				return $msg;
			} else{
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong> Class Data Not Inserted.</div>";
				return $msg;
			}
		}
	}


	public function insertCourse($courseId, $courseTitle, $semester) {
		$courseId = mysqli_escape_string($this->db->link, $courseId);
		$courseTitle = mysqli_escape_string($this->db->link, $courseTitle);
		if(empty($courseId) || empty($courseTitle) || !$semester) {
			$msg = "<div class='alert alert-danger'><strong>Error ! </strong> Field Must Not Be Empty !</div>";
			return $msg;
		} else {
			$query = "SELECT * FROM tbl_course WHERE courseId='$courseId'";
			$result = $this->db->select($query);

			if($result && $result->num_rows===1){
				$msg = "<div class='alert alert-danger'>Given Information Already Exist!</div>";
				return $msg;
			}


			$query = "INSERT INTO tbl_course(courseId, courseTitle, semester) VALUES('$courseId','$courseTitle',$semester)";
			$insert = $this->db->insert($query);

			if($insert){
				$msg = "<div class='alert alert-success'><strong>Success ! </strong> Course Data Inserted Successfully.</div>";
				return $msg;
			} else{
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong> course Data Not Inserted.</div>";
				return $msg;
			}
		}
	}



	public function insertAttendance($cur_date, $courseId, $classId, $attend){
		$query = "SELECT * FROM tbl_attendance where att_time = '$cur_date' AND courseId='$courseId' AND classId='$classId'";
		$get_data = $this->db->select($query);
		//echo is_bool($get_data);
		$data_insert=NULL;
		if(!is_bool($get_data)){
			$msg = "<div class='alert alert-danger'><strong>Error ! </strong> Attendance Already Taken Today!</div>";
			return $msg;
		} else {
			$get_tempattendance = $this->db->select("SELECT * FROM tbl_tempstuattendance WHERE courseId='$courseId' AND classId='$classId' AND attend_date='$cur_date'");
			if($get_tempattendance){
				while($value = $get_tempattendance->fetch_assoc()){
					$stu_id=$value['stu_id'];
					$stu_query = "INSERT INTO tbl_attendance(roll, attend, att_time, classId, courseId) VALUES('$stu_id', '1', '$cur_date', '$classId', '$courseId')";
					$data_insert = $this->db->insert($stu_query);
				}
			}
			$this->db->delete("DELETE FROM tbl_tempstuattendance WHERE courseId='$courseId' AND classId='$classId' AND attend_date='$cur_date'");
			
			foreach ($attend as $atn_key => $atn_value) {
				$tempres=$this->db->select("SELECT * FROM tbl_attendance WHERE att_time = '$cur_date' AND roll='$atn_key' AND courseId='$courseId' AND classId='$classId'");
				$stu_query = "INSERT INTO tbl_attendance(roll, attend, att_time, classId, courseId) VALUES('$atn_key', '$atn_value', '$cur_date', '$classId', '$courseId')";
				if(!$tempres)
					$data_insert = $this->db->insert($stu_query);
			}

			if($data_insert){
				$msg = "<div class='alert alert-success'><strong>Success ! </strong> Attendance Data Inserted Successfully.</div>";
				return $msg;
			}
		}
	}


	public function insertAllocCourse($alloc_type, $alloc_id, $selectclass){		
		foreach ($selectclass as $selectclass_key => $selectclass_value) {
			$courseallocId = "".$alloc_id.$selectclass_value.$selectclass_key."";
			if($selectclass_value==0) continue;

			$data_insert=NULL;
			if($alloc_type)
				$res = $this->db->select("SELECT * FROM tbl_courseallocteacher WHERE teacher_id=$alloc_id AND courseId='".$selectclass_key."' AND classId='".$selectclass_value."'");
			else
				$res = $this->db->select("SELECT * FROM tbl_courseallocstu WHERE stu_id=$alloc_id AND courseId='".$selectclass_key."' AND classId='".$selectclass_value."'");
			if($res && $res->num_rows>=1){
				continue;
			}

			if($alloc_type)
				$query = "INSERT INTO tbl_courseallocteacher(courseallocteacher_id, teacher_id, classId, courseId)
							VALUES('$courseallocId', '$alloc_id', '$selectclass_value', '$selectclass_key')";
			else
				$query = "INSERT INTO tbl_courseallocstu(courseallocstu_id, stu_id, classId, courseId)
							VALUES('$courseallocId','$alloc_id', '$selectclass_value', '$selectclass_key')";
			$data_insert = $this->db->insert($query);
		}

		if($data_insert){
			$msg = "<div class='alert alert-success'><strong>Success ! </strong> Course Allocated Successfully.</div>";
			return $msg;
		} else{
			$msg = "<div class='alert alert-info'>Course already allocated!!</div>";
			return $msg;
		}
	}

	public function updateCourse($courseId, $courseTitle, $semester, $pcourseId){
		if($courseId!='' && $courseTitle!='' && $semester!=''){
			$query = "UPDATE tbl_course SET courseId='$courseId', courseTitle='$courseTitle', semester=$semester WHERE courseId='$pcourseId'";
			$data_insert = $this->db->update($query);
			if($data_insert){
				$msg = "<div class='alert alert-success'><strong>Success ! </strong> Course Edited Successfully.</div>";
			} else{
				$msg = "<div class='alert alert-info'><div class='alert alert-danger'>Course Not Edited</div></div>";
			}
		} else{
			$msg = "<div class='alert alert-danger'>Fill Up All The Input</div>";
		}
	}

	public function updateClass($classId, $section, $semester, $pclassId){
		if($classId!='' && $section!='' && $semester!=''){
			$query = "UPDATE tbl_class SET classId='$classId', section='$section', semester=$semester WHERE classId='$pclassId'";
			$data_insert = $this->db->update($query);
			if($data_insert){
				$msg = "<div class='alert alert-success'><strong>Success ! </strong> Class Edited Successfully.</div>";
			} else{
				$msg = "<div class='alert alert-info'><div class='alert alert-danger'>Class Not Edited</div></div>";
			}
		} else{
			$msg = "<div class='alert alert-danger'>Fill Up All The Input</div>";
		}
	}

}
?>