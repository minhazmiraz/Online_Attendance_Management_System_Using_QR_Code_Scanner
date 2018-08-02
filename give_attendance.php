<?php
	include 'inc/header.php';
	include 'lib/student.php';
    
    
    if($_SERVER["HTTPS"] != "on"){
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }

    if(isset($_SESSION['user_id'])){
        $stu = new Student();
        $db = new Database();
        $cur_date = date('Y-m-d');
        $stu_id = $_SESSION['user_id'];
        
        if(isset($_GET['courseId'])){
            $courseId = $_GET['courseId'];
        }
        
        if(isset($_GET['classId'])){
            $classId = $_GET['classId'];
        }

        if(isset($_GET['qrcode'])){
            $qrcode = $_GET['qrcode'];
        }

        if(isset($_POST['result'])){
            if(strcmp($_POST['result'],$_POST['qrcode'])){
                $tempstuattendanceId = $_POST['stu_id'].$_POST['courseId'].$_POST['classId'].$_POST['cur_date']."";
                $feed = $db->insert("INSERT INTO tbl_tempstuattendance(tempstuattendanceId, stu_id, courseId, classId, attend_date) 
                        Values('".$tempstuattendanceId."', ".$_POST['stu_id'].", '".$_POST['courseId']."', '".$_POST['classId']."', '".$_POST['cur_date']."')");
                if($feed){
                    $_SESSION['feed'] = "<div class='alert alert-success'>Attendance Given Successfully</div>";
                } else{
                    $_SESSION['feed'] = "<div class='alert alert-danger'>Attendance Not added</div>";
                }
                header("Location: index.php");
                exit();
            }
        }
?>


<html>
    <head>
        <title>QR Code Scanner</title>
        <script src="/attendance/qrcode/jsqrcode-combined.js"></script>
        <script src="/attendance/qrcode/html5-qrcode.js"></script>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
        <style>
            .hidden {
                display: none;
            }
        </style>
    </head>
    <body>
        <p id="cur_date" class="hidden"><?=$cur_date?></p>
        <p id="classId" class="hidden"><?=$classId?></p>
        <p id="courseId" class="hidden"><?=$courseId?></p>
        <p id="stu_id" class="hidden"><?=$stu_id?></p>
        <p id="qrcode" class="hidden"><?=$qrcode?></p>
    
        <div class="container" style="text-align: center">
            <h1> QR Code scanner Example </h1>
            <br><br>

            <div id="qr" style="display: inline-block; width: 500px; height: 500px; border: 1px solid silver"></div>
            <br><br>

            <div class="row">
                <button id="scan" class="btn btn-success btn-sm">start scaning</button>
                <button id="stop" class="btn btn-warning btn-sm hidden">stop scanning</button>
            </div>
            <br><br>
            <div class="row">
                <div class="col-md-12">
                    <code>Start Scanning</code> <p id="result"></p> <span class="feedback"></span>
                    <div id="submit" class="hidden">
                        <form action="" method="POST">
                            <input type="submit" class="btn btn-primary" name="give_attendance" value="Submit Attendance">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>


<script>
function redirect(flag){
    
}

function postIt(classId, courseId, stu_id, cur_date, qrcode, result) {
    $.post("give_attendance_req.php", 
    {
        cur_date: cur_date,
        stu_id: stu_id,
        courseId: courseId,
        classId: classId,
        qrcode: qrcode,
        result: result 
    }, function(data){
        var flag = $.trim(data);
        if(flag==="1"){
            window.location.replace("index.php");
        } else{
            alert(flag);
        }
    });
}

$(document).ready(function() {
	$("#scan").on('click', function() {
        $("code").html('scanning');
		$('#qr').html5_qrcode(function(result){
            // do something when code is read
                $("#result").html('code scanned as: ' +result);
                $("#result").addClass('alert alert-info');
                var cur_date = $('#cur_date').text();
                var stu_id = $('#stu_id').text();
                var courseId = $('#courseId').text();
                var classId = $('#classId').text();
                var qrcode = $('#qrcode').text();
                postIt(classId, courseId, stu_id, cur_date, qrcode, result);
            },
            function(error){
                //show read errors 
                $(".feedback").html('Unable to scan the code! Error: ' +error)
            }, function(videoError){
                //the video stream could be opened
                $(".feedback").html('Video error');
            }
        );
        
        $("#scan").addClass('hidden');
        $("#stop").removeClass('hidden');
	});
    
	$("#stop").on('click', function() {
        $("#qr").html5_qrcode_stop();
		$("code").html('Start Scanning');
        
		$("#scan").removeClass('hidden');
		$("#stop").addClass('hidden');
	});
});
</script>

<?php
    } else{
        echo '<div class="alert alert-danger"><center>Access Denied!!</center></div>';
    }
	include 'inc/footer.php';
?>
