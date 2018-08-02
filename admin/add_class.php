<?php
	define('ROOT_FOLDER',$_SERVER['DOCUMENT_ROOT'].'/attendance/');
	include ROOT_FOLDER.'inc/header.php';
	include ROOT_FOLDER.'lib/student.php';
?>

<?php
	$stu = new Student();
	$db = new Database();
	if(isset($_POST['addClass'])) {
		$name = $_POST['name'];
		$semester = $_POST['semester'];
		$section = $_POST['section'];
		$_SESSION['feed'] = $stu->insertClass($name, $semester, $section);
	}

	if(isset($_GET['delete_Class'])){
		$classId = $_GET['classId'];
		$insertdata = $db->delete("DELETE FROM tbl_class WHERE classId='$classId'");
		if($insertdata){
			$_SESSION['feed'] = "<div class='alert alert-success'>Success! Class Deleted Successfully</div>";
		} else{
			$_SESSION['feed'] = "<div class='alert alert-danger'>Success! Class Deletion Unsuccessful</div>";
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
				<h2> Add Class </h2>
			</div>

			<div class="panel-body">
				<form action="" method="post">
					<div class="form-group">
						<label for="semester">Semester</label>
						<input type="hidden" name="semester" id="semester" value="0">
						<input type="number" class="form-control" name="semester" id="semester" required="">
					</div>

					<div class="form-group">
						<label for="section">Section</label>
						<input type="text" class="form-control" name="section" id="section" required="">
					</div>

					<div class="form-group">
						<label for="name">Class Name</label>
						<input type="text" class="form-control" name="name" id="name" required="">
					</div>

					<div class="form-group">
						<input type="submit" class="btn btn-primary" name="addClass" value="Add Class">
					</div>
				</form>
			</div>
			
		</div>
	</div>
	<div class="col col-lg-9">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2> Class List </h2>
			</div>

			<div class="panel-body">
					<?php
						$get_class = $stu->getClass(0);
						if($get_class){
					?>
					<table class="table table-striped">
						<tr>
							<th width="20%">Serial</th>
							<th width="20%">Class Id</th>
							<th width="20%">Semester</th>
							<th width="20%">Section</th>
							<th width="20%">Action</th>
						</tr>

						<?php
							$i = 0;
							while($value = $get_class->fetch_assoc()){
								$i++;
						?>

						<tr>
							<td><?=$i;?></td>
							<td><?=$value['classId'];?></td>
							<td><?=$value['semester'];?></td>
							<td><?=$value['section'];?></td>
							<td class="md-2">
								<a id="edit" class="btn btn-success" href="/attendance/edit.php?classId=<?=$value['classId'];?>&section=<?=$value['section'];?>&semester=<?=$value['semester'];?>&edit_Class=1"><i class="glyphicon glyphicon-edit"></i></a>
								<a id="delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this entry?')" href="/attendance/admin/add_class.php?classId=<?=$value['classId'];?>&delete_Class=1"><i class="glyphicon glyphicon-minus-sign"></i></a>
							</td>
						</tr>

						<?php } ?>
					</table>
				<?php } else{ ?>
					<div class='alert alert-warning text-center'>No Class Added.</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<?php } ?>
<?php include ROOT_FOLDER.'inc/footer.php'; ?>

