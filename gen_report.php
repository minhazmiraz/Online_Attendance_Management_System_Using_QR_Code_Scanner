<?php
	include 'inc/header.php';
	include 'lib/student.php';
?>

<?php 

if(!isset($_SESSION['user_id']))
	echo "<div class='alert alert-danger'><center><h3>Access Denied</h3></center></div>";
else{
	$stu = new Student();
	$db = new Database();
	if($_SESSION['user_id']=='admin'){
		if(isset($_POST['show_courses'])){
			$query = "SELECT * FROM tbl_courseallocteacher WHERE teacher_id='".$_POST['teacher']."' ORDER BY courseId ASC";
			$get_course = $db->select($query);
		} else{
			$get_course=NULL;
		}
	} else{
		$query = "SELECT * FROM tbl_courseallocteacher WHERE teacher_id='".$_SESSION['user_id']."' ORDER BY courseId ASC";
		$get_course = $db->select($query);
	}
?>


<?php
	if($_SESSION['user_id']=='admin'){
?>

<center>
	<form action="" method="POST">
		<div class="form-inline">
			<div class="form-group">
				<select id="teacher" name="teacher" class="form-control">
					<option value="">Select a Teacher</option>
					<?php
						$stu = new Student();
						$get_teacher = $stu->getTeachers();
						if($get_teacher){
							while($value = $get_teacher->fetch_assoc()){
								echo "<option value='".$value['teacher_id']."'>".$value['teachername']."</option>";
							}
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" name="show_courses" value="Submit">
			</div>
		</div>
	</form>
</center>

<?php
	}
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h2> Course List </h2>
	</div>

	<div class="panel-body">
		<?php
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
					<td><?=$value['classId'];?></td>
					<td>
						<form action="show_pdf.php" method="post" class="form-check">
							<input type="hidden" name="courseId" value="<?=$value['courseId'];?>">
							<input type="hidden" name="classId" value="<?=$value['classId'];?>">
							<td class="form-group">
								<input type="submit" name="gen_rep" value="Generate Report" class="btn btn-primary">
						</form>
					</td>
				</tr>

				<?php } ?>
			</table>
		<?php } else{ ?>
			<div class='alert alert-warning text-center'>No Course Added.</div>
		<?php } ?>
	</div>
</div>


<?php
}
?>

<?php include 'inc/footer.php'; ?>