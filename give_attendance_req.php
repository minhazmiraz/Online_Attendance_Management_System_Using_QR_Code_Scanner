<?php
include 'lib/Database.php';
$db = new Database();
if(isset($_POST['result'])){
    if($_POST['result']===$_POST['qrcode']){
        $tempstuattendanceId = $_POST['stu_id'].$_POST['courseId'].$_POST['classId'].$_POST['cur_date']."";
        $feed = $db->insert("INSERT INTO tbl_tempstuattendance(tempstuattendanceId, stu_id, courseId, classId, attend_date) 
                Values('".$tempstuattendanceId."', ".$_POST['stu_id'].", '".$_POST['courseId']."', '".$_POST['classId']."', '".$_POST['cur_date']."')");
        if($feed){
            $_SESSION['feed'] = "<div class='alert alert-success'>Attendance Given Successfully</div>";
        } else{
            $_SESSION['feed'] = "<div class='alert alert-danger'>Attendance Not added</div>";
        }
        $tmp="1";
    } else{
        $tmp="0";
    }
    echo $tmp;
}
?>