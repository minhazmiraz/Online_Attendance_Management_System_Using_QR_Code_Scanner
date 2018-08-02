<?php
	define('ROOT_FOLDER',$_SERVER['DOCUMENT_ROOT'].'/attendance/');
	include ROOT_FOLDER.'inc/header.php';
	include ROOT_FOLDER.'lib/student.php';
?>

<?php
	$stu = new Student();
	$db = new Database();
	if(isset($_POST['addCourse'])) {
		$courseTitle = $_POST['courseTitle'];
		$courseId = $_POST['courseId'];
		$semester = $_POST['semester'];
		$_SESSION['feed'] = $stu->insertCourse($courseId, $courseTitle, $semester);
	}

	if(isset($_GET['delete_Course'])){
		$courseId = $_GET['courseId'];
		$insertdata = $db->delete("DELETE FROM tbl_course WHERE courseId='$courseId'");
		if($insertdata){
			$_SESSION['feed'] = "<div class='alert alert-success'>Success! Course Deleted Successfully</div>";
		} else{
			$_SESSION['feed'] = "<div class='alert alert-danger'>Success! Course Deletion Unsuccessful</div>";
		}
	}
?>

<?php
	if(isset($_SESSION['feed'])) {
		echo $_SESSION['feed'];
		unset($_SESSION['feed']);
	}
?>

<?php
	if(!isset($_SESSION['user_id']) || $_SESSION['user_id']!='admin'){
		echo "<div class='alert alert-danger'><center><h3>Access Denied</h3></center></div>";
	} else{
?>

<div class="row">
	<div class="col col-lg-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2> Add Course </h2>
			</div>

			<div class="panel-body">
				<form action="" method="post">
					<div class="form-group">
						<label for="courseId">Course Code (EX: cse-xxxx)</label>
						<input type="text" class="form-control" name="courseId" id="courseId" required="">
					</div>

					<div class="form-group">
						<label for="courseTitle">Course Title</label>
						<input type="text" class="form-control" name="courseTitle" id="courseTitle" required="">
					</div>

					<div class="form-group">
						<label for="Semester">Semester</label>
						<input type="hidden" name="semester" id="semester" value="0">
						<input type="text" class="form-control" name="semester" id="semester" required="">
					</div>

					<div class="form-group">
						<input type="submit" class="btn btn-primary" name="addCourse" value="Add Course">
					</div>
				</form>
			</div>
			
		</div>
	</div>
	<div class="col col-lg-9">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2> Course List </h2>
			</div>

			<div class="panel-body">
					<?php
						$get_course = $stu->getCourse();
						if($get_course){
					?>
					<table class="table table-striped">
						<tr>
							<th width="20%">Serial</th>
							<th width="25%">Course Code</th>
							<th width="30%">Course Title</th>
							<th width="10%">Semester</th>
							<th width="15%">Action</th>
						</tr>

						<?php
							$i = 0;
							while($value = $get_course->fetch_assoc()){
								$i++;
						?>

						<tr>
							<td><?=$i;?></td>
							<td><?=$value['courseId'];?></td>
							<td><?=$value['courseTitle'];?></td>
							<td><?=$value['semester'];?></td>
							<td class="md-2">
								<a id="edit" class="btn btn-success" href="/attendance/edit.php?courseId=<?=$value['courseId'];?>&courseTitle=<?=$value['courseTitle'];?>&semester=<?=$value['semester'];?>&edit_Course=1"><i class="glyphicon glyphicon-edit"></i></a>
								<a id="delete" class="btn btn-danger" href="/attendance/admin/add_course.php?courseId=<?=$value['courseId'];?>&delete_Course=1"><i class="glyphicon glyphicon-minus-sign"></i></a>
							</td>
						</tr>
						<?php } ?>
					</table>
				<?php } else{ ?>
					<div class='alert alert-warning text-center'>No Course Added.</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<?php } ?>
<?php include ROOT_FOLDER.'inc/footer.php'; ?>

