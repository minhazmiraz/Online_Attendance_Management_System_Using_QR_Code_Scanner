<?php
    if($_SERVER["HTTPS"] != "on")
    {
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }
    $qrcode="OG4ELthJOb";
?>
<html>
  <head>
    <title>QR Code Scanner</title>
	<link rel="stylesheet" href="/attendance/inc/bootstrap-3.3.7/dist/css/bootstrap.min.css" />    
	<script src="/attendance/inc/jquery-ui-1.12.1/external/jquery/jquery.js"></script>
    <script src="/attendance/qrcode/jsqrcode-combined.js"></script>
    <script src="/attendance/qrcode/html5-qrcode.js"></script>

    <style>
        .hidden {
            display: none;
        }
    </style>
  </head>
  <body>
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
			</div>
		</div>
	</div>


  </body>
</html>


<script>
    
$(document).ready(function() {
	$("#scan").on('click', function() {
        $("code").html('scanning');
		$('#qr').html5_qrcode(function(data){
            // do something when code is read
                $("#result").html('code scanned as: ' +data);
                if(data === '<?=$qrcode?>'){
                    $("#result").addClass('alert alert-info');
                }

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