<?php
    include 'lib/student.php';
    include 'inc/header.php';
?>

<?php
	$stu = new Student();    
    if(isset($_POST['editClass'])){
		$classId = $_POST['classId'];
		$pclassId = $_POST['pclassId'];
		$section = $_POST['section'];
		$semester = $_POST['semester'];
		$_SESSION['feed'] = $stu->updateClass($classId, $section, $semester, $pclassId);		
        header("Location: admin/add_class.php");
        die();
    }

    if(isset($_POST['editCourse'])){
		$courseId = $_POST['courseId'];
		$pcourseId = $_POST['pcourseId'];
		$courseTitle = $_POST['courseTitle'];
		$semester = $_POST['semester'];
		$_SESSION['feed'] = $stu->updateCourse($courseId, $courseTitle, $semester, $pcourseId);		
        header("Location: admin/add_course.php");
        die();
    }

    if(isset($_GET['edit_Class'])){
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h2> Edit Class </h2>
    </div>

    <div class="panel-body">
        <form action="" method="post">
            <div class="form-group">
                <label for="semester">Semester</label>
                <input type="number" class="form-control" name="semester" id="semester" value="<?=$_GET['semester']?>" required="">
            </div>

            <div class="form-group">
                <label for="section">Section</label>
                <input type="text" class="form-control" name="section" id="section" value="<?=$_GET['section']?>" required="">
            </div>

            <div class="form-group">
                <label for="classId">Class Name</label>
                <input type="text" class="form-control" name="classId" id="classId" value="<?=$_GET['classId']?>" required="">
                <input type="hidden" class="form-control" name="pclassId" id="pclassId" value="<?=$_GET['classId']?>" required="">
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="editClass" value="Edit Class">
            </div>
        </form>
    </div>
</div>
<?php 
    } 


    if(isset($_GET['edit_Course'])){
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h2> Edit Course </h2>
    </div>

    <div class="panel-body">
        <form action="" method="post">
            <div class="form-group">
                <label for="courseId">Course Code (EX: cse-xxxx)</label>
                <input type="text" class="form-control" name="courseId" id="courseId" value="<?=$_GET['courseId']?>" required="">
                <input type="hidden" class="form-control" name="pcourseId" id="pcourseId" value="<?=$_GET['courseId']?>" required="">
            </div>

            <div class="form-group">
                <label for="courseTitle">Course Title</label>
                <input type="text" class="form-control" name="courseTitle" id="courseTitle" value="<?=$_GET['courseTitle']?>" required="">
            </div>

            <div class="form-group">
                <label for="Semester">Semester</label>
                <input type="hidden" name="semester" id="semester" value="0">
                <input type="text" class="form-control" name="semester" id="semester" value="<?=$_GET['semester']?>" required="">
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="editCourse" value="Edit Course">
            </div>
        </form>
    </div>			
</div>

<?php
    }
?>