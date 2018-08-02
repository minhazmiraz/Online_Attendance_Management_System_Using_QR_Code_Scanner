<?php
	include 'lib/student.php';
	require('fpdf/fpdf.php');
?>

<?php 
	$stu = new Student();
	$db = new Database();

	
	if(isset($_POST['gen_rep'])){
		$courseId=$_POST['courseId'];
		$classId=$_POST['classId'];
		
		$getstudent=$db->select("SELECT * FROM tbl_courseallocstu WHERE courseId='$courseId' AND classId='$classId' ORDER BY stu_id ASC");
		
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(40,10,'Attendance List');
		$pdf->Ln();
		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(40,10,'Course - ID: '.$courseId.'  Class: '.$classId);
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetFont('Arial','B',12);


		if($getstudent){
			$i=1;
			while($value = $getstudent->fetch_assoc()){
				$getattend = $db->select("SELECT * FROM tbl_attendance WHERE courseId='".$courseId."' AND classId='".$classId."' AND roll=".$value['stu_id']." AND attend='1'");
				if($getattend)
					$pdf->Cell(40,10,$i.'   '.$value['stu_id'].'         Attend: '.mysqli_num_rows($getattend));
				else
					$pdf->Cell(40,10,$i.'   '.$value['stu_id'].'         Attend: 0');
				$pdf->Ln();
				$i++;
			}
		} else{
			$pdf->Cell(40,10,'NO STUDENT');
			$pdf->Ln();
		}
	}

	$pdf->Output();
?>