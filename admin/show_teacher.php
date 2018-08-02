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
		<h2> Teacher List </h2>
	</div>

	<div class="panel-body">
			<?php
				$stu = new Student();
				$get_teacher = $stu->getTeachers();
				if($get_teacher){
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
					while($value = $get_teacher->fetch_assoc()){
						$i++;
				?>

				<tr>
					<td><?=$i;?></td>
					<td><?=$value['teacher_id'];?></td>
					<td><?=$value['teachername'];?></td>
					<td><?='<a href="/attendance/admin/alloc_course.php?alloc_type=1&id='.$value['teacher_id'].'" class="btn btn-primary">Allocate Course</a>';?></td>
				</tr>

				<?php } ?>
			</table>
		<?php } else{ ?>
			<div class='alert alert-warning text-center'>No Teacher Added.</div>
		<?php } ?>
	</div>
</div>

<?php } ?>
<?php include ROOT_FOLDER.'inc/footer.php'; ?>
