<?php
	include 'inc/header.php';
	include 'lib/student.php';
	//include 'lib/Database.php';
?>


<?php 
	$stu = new Student();
	$db = new Database();
	$cur_date = date('Y-m-d');
?>


<?php if (isset($_SESSION['user_id'])){ ?>
	<div class="panel panel-default">
		<div class="panel-heading text-center">
			<p style="font-size: 20px;">
					<strong>Date: </strong> <?php echo $cur_date; ?>
			</p>
			<div class="form-inline" style="margin-bottom: 10px;">
				<select name="course_select" id="course_select" class="form-control md-2">
					<option value='{"courseId":"0", "semester":"0"}' selected="selected">Select Course</option>
					<?php
						if($_SESSION['logintype']==0){
							$getCourse = $stu->getCourse();
						} else if($_SESSION['logintype']==1){
							$getCourse  = $db->select("SELECT T1.courseId, T2.courseTitle, T2.semester FROM (
												SELECT * FROM tbl_courseallocteacher WHERE teacher_id=".$_SESSION['user_id']."
												) T1 INNER JOIN tbl_course T2 ON T1.courseId = T2.courseId");
						} else{
							$getCourse  = $db->select("SELECT T1.courseId, T2.courseTitle, T2.semester FROM (
												SELECT * FROM tbl_courseallocstu WHERE stu_id=".$_SESSION['user_id']."
												) T1 INNER JOIN tbl_course T2 ON T1.courseId = T2.courseId");
												
						}
						
						if($getCourse){
							while($tmp = $getCourse->fetch_assoc()){
					?>
					<option value='{"courseId":"<?=$tmp['courseId']?>", "semester":"<?=$tmp['semester']?>"}'><?=$tmp['courseTitle']?></option>
					<?php
							}
						}
					?>
				</select>
				<select name="class_select" id="class_select" class="form-control md-2">
						<option value="0" selected="selected">Select Class</option>
				</select>
				<?php
					if($_SESSION['logintype']==2){
				?>
						<input type="hidden" name="student_select" id="student_select" value="<?=$_SESSION['user_id']?>" placeholder="Enter Student Id" class="form-control md-2">
				<?php
					} else{
				?>
						<input type="text" name="student_select" id="student_select" value="" placeholder="Enter Student Id" class="form-control md-2">
				<?php
					}
				?>
				<input type="text" name="date_picker" id="date_picker" placeholder="Select Date" class="form-control md-2">
				<input type="button" name="filter" id="filter" value="filter" class="btn btn-primary md-2">
			</div>
		</div>

		<div class="panel-body">			
			<div id="order_table">
				<div class='alert alert-warning text-center'>Attendance Not Taken.</div>
			</div>
		</div>
		
	</div>
<?php }else{ ?>

	<div class="alert alert-danger" style="font-size: 20px">
		Access Denied
	</div>

<?php } ?>
<?php include 'inc/footer.php'; ?>


<script>
	$(document).ready(function(){
		$.datepicker.setDefaults({
			dateFormat: 'yy-mm-dd'
		});
		$(function(){
			$("#date_picker").datepicker();
		})

		$('#course_select').change(function(){
			var value = $.parseJSON($(this).val());
			//console.log(value['semester']);
			if(value['semester']!='0' && value['courseId']!='0'){
				$.ajax({
					url: 'attn_req.php',
					method: 'post',
					data: (
					{
						semester : value['semester'],
						courseId : value['courseId']
					}),
					dataType: 'text',
					success:function(data){
						$('#class_select').html(data);
					}
				});
			}
		});
		$('#filter').click(function(){
			var val = $.parseJSON($('#course_select').val());
			var courseId = val['courseId'];
			var classId = $('#class_select').val();
			var stu_id = $('#student_select').val();
			var selectDate = $('#date_picker').val();
			if(courseId!="0" && classId!="0"){
				if(stu_id!='' || selectDate!=''){
					$.ajax({
						url: 'attn_req.php',
						method: 'post',
						data: (
						{
							courseId : courseId,
							classId : classId,
							stu_id : stu_id,
							curDate : selectDate
						}),
						dataType: 'text',
						success:function(data){
							$('#order_table').html(data);
						}
					});
				} else{
					alert('Please Enter Student ID or Select Date');
				}
			} else{
					alert('Please Select Course and Class');
			}
		});
	})
</script>


