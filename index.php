<?php
	include 'inc/header.php';
	include 'lib/student.php';

	$stu = new Student();
	$db = new Database();
	$cur_date = date('Y-m-d');

	if(isset($_SESSION['feed'])){
		echo $_SESSION['feed'];
		unset($_SESSION['feed']);
	}
?>


<?php if (isset($_SESSION['user_id'])){ ?>
	<?php if($_SESSION['user_id']!='admin'){ ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2>My Courses</h2>
			</div>

			<div class="panel-body">
				<?php
					$get_alloccourse = $stu->getAllocCourse($_SESSION['logintype'], $_SESSION['user_id']);
					if($get_alloccourse){
				?>
						<table class="table table-striped">
							<tr>
								<th width="10%">Serial</th>
								<th width="25%">Course Code</th>
								<th width="30%">Course Title</th>
								<th width="15%">Class</th>
								<th width="20%">Attendance</th>
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
									<?php if($_SESSION['logintype']==1){ ?>
										<form action="take_attendance.php" method="post" class="form-check">
											<input type="hidden" name="courseId" value="<?=$value['courseId'];?>">
											<input type="hidden" name="classId" value="<?=$value['classId'];?>">
											<td class="form-group">
												<input type="submit" name="take_attendance" value="Take Attendance" class="btn btn-primary">
											</td>
										</form>
									<?php } else{ ?>
											<td>
												<?php
													$courseId=$value['courseId'];
													$classId=$value['classId'];
													$activeattendanceId=$courseId.$classId."";
													$query = "SELECT * FROM tbl_activeattendance WHERE activeattendanceId='".$activeattendanceId."' AND courseId='".$courseId."' AND classId='".$classId."' Limit 1";
													$avail = $db->select($query);
													$tempstu = $_SESSION['user_id'].$courseId.$classId.$cur_date."";
													$is_attend_given = $db->select("SELECT * FROM tbl_tempstuattendance WHERE tempstuattendanceId='".$tempstu."'");
													if($avail && !$is_attend_given){ 
														$available = $avail->fetch_assoc();
												?>
													<a href="give_attendance.php?courseId=<?=$courseId?>&classId=<?=$value['classId']?>&qrcode=<?=$available['qrcode']?>" class="btn btn-primary">Give attendance</a>
												<?php } else{
													echo "Not Available";
												} ?>
											</td>
										</form>
									<?php } ?>
								</tr>
							<?php } ?>
						</table>
				<?php } else{ ?>
					<div class='alert alert-warning text-center'>No Course Allocated</div>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
<?php } else{ ?>
	<img src="Picture1.png" class="img-fluid img-thumbnail rounded" alt="Online Attendance System">	
<?php } ?>
<?php include 'inc/footer.php'; ?>
