<?php
	define('ROOT_FOLDER',$_SERVER['DOCUMENT_ROOT'].'/attendance/');
	include ROOT_FOLDER.'inc/header.php';
	include ROOT_FOLDER.'lib/student.php';
?>

<?php
	if(!isset($_SESSION['user_id']) || $_SESSION['user_id']!='admin'){
		echo "<div class='alert alert-danger'><center><h3>Access Denied</h3></center></div>";
	} else{
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h2> Student List </h2>
	</div>

	<div class="panel-body">
			<?php
				$stu = new Student();
				$get_student = $stu->getStudents();
				if($get_student){
			?>
			<table class="table table-striped">
				<tr>
					<th width="10%">Serial</th>
					<th width="30%">Id</th>
					<th width="40%">Name</th>
					<th width="20%">Action</th>
				</tr>

				<?php
					$i = 0;
					while($value = $get_student->fetch_assoc()){
						$i++;
				?>

				<tr>
					<td><?=$i;?></td>
					<td><?=$value['roll'];?></td>
					<td><?=$value['name'];?></td>
					<td><?='<a href="/attendance/admin/alloc_course.php?alloc_type=0&id='.$value['roll'].'" class="btn btn-primary">Allocate Course</a>';?></td>
				</tr>

				<?php } ?>
			</table>
		<?php } else{ ?>
			<div class='alert alert-warning text-center'>No Student Added.</div>
		<?php } ?>
	</div>
</div>

<?php } ?>
<?php include ROOT_FOLDER.'inc/footer.php'; ?>
