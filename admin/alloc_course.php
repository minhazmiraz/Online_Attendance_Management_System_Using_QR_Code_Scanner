<?php
	define('ROOT_FOLDER',$_SERVER['DOCUMENT_ROOT'].'/attendance/');
	include ROOT_FOLDER.'inc/header.php';
	include ROOT_FOLDER.'lib/student.php';
?>

<?php 
	$stu = new Student();
	$db = new Database();
	if(isset($_GET['alloc_type'])){
		$alloc_type=$_GET['alloc_type'];
		$alloc_id=$_GET['id'];
		if(isset($_POST['submit'])){
			$selectclass = $_POST['selectclass'];
			$insertalloccourse = $stu->insertAllocCourse($alloc_type, $alloc_id, $selectclass);
		}
	} else{
		$insertalloccourse = '<div class="alert alert-warning">No Course Allocation User Found</div>';
	}
?>

<?php
	if(isset($insertalloccourse)) {
		echo $insertalloccourse;
	}

	if(!isset($_SESSION['user_id']) || $_SESSION['user_id']!='admin'){
		echo "<div class='alert alert-danger'><center><h3>Access Denied</h3></center></div>";
	} else{
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h2> Allocated Courses To <?=$alloc_id;?></h2>
	</div>

	<div class="panel-body">
		<?php
			$get_alloccourse = $stu->getAllocCourse($alloc_type, $alloc_id);
			if($get_alloccourse){
		?>
		<table class="table table-striped">
			<tr>
				<th width="10%">Serial</th>
				<th width="30%">Course Code</th>
				<th width="40%">Course Title</th>
				<th width="20%">Class</th>
			</tr>

			<?php
				$i = 0;
				while($value = $get_alloccourse->fetch_assoc()){
					$i++;
			?>

			<tr>
				<td><?=$i;?></td>
				<td><?=$value['courseId'];?></td>
				<td><?=$value['courseTitle'];?></td>
				<td><?=$value['classId']?></td>
			</tr>

			<?php } ?>
		</table>
	<?php } else{ ?>
		<div class='alert alert-warning text-center'>No Course Allocated</div>
	<?php } ?>
	</div>
</div>


<div class="panel panel-default">
	<div class="panel-heading">
		<h2> Courses List </h2>
	</div>

	<div class="panel-body">
			<?php
				$get_course = $stu->getCourse();
				if($get_course){
			?>
			<form action="" method="post" class="form-check">
			<table class="table table-striped">
				<tr>
					<th width="10%">Serial</th>
					<th width="30%">Course Code</th>
					<th width="40%">Course Title</th>
					<th width="20%">Action</th>
				</tr>

				<?php
					$i = 0;
					while($value = $get_course->fetch_assoc()){
						$i++;
						$get_class = $stu->getCourseForAlloc($alloc_type, $alloc_id, $value['courseId'], $value['semester']);
						if($get_class){
				?>
				<tr>
					<td><?=$i;?></td>
					<td><?=$value['courseId'];?></td>
					<td><?=$value['courseTitle'];?></td>
					<td>
						<div class="form-group">
							<select class="form-control" id="selectclass[<?=$value['courseId'];?>]" name="selectclass[<?=$value['courseId'];?>]">
								<option value="0">Select Class</option>
								<?php
									while($res = $get_class->fetch_assoc()){
								?>
								<option value="<?=$res['classId'];?>"><?=$res['classId'];?></option>
								<?php } ?>
							</select>
						</div>
					</td>
				</tr>
				<?php } } ?>

				<tr>
					<td colspan="4">
						<input type="submit" class="btn btn-primary" name="submit" value="Submit">
					</td>
				</tr>
			</table>
			</form>
		<?php } else{ ?>
			<div class='alert alert-warning text-center'>No Course Added.</div>
		<?php } ?>
	</div>
</div>

<?php } ?>
<?php include ROOT_FOLDER.'inc/footer.php'; ?>
