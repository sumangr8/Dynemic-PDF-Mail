<?php 
include("db.php"); 
function show($con)
{
	$qry=mysqli_query($con,"select * from login where id=2");
	$output='
		<table class="table">
			<tr>
				<td>Name</td>
				<td>Email</td>
				<td>Password</td>
			</tr>
	';
	while($row=mysqli_fetch_array($qry))
	{
		extract($row);
		$output.='
			<tr>
				<td>'.$name.'</td>
				<td>'.$email.'</td>
				<td>'.$password.'</td>
			</tr>
		';
	}
	$output.='</table>';
	return $output;
}
$message='';
if(isset($_POST["action"]))
{
	include('pdf.php');
	$file_name=md5(rand()).'.pdf';
	$html_code='<link rel="stylesheet" type="text/css" href="bootstrap.min.css">';
	$html_code.=show($con);
	$pdf=new pdf();
	$pdf->load_html($html_code);
	$pdf->render();
	$file=$pdf->output();
	file_put_contents('img/'.$file_name, $file); //kis folder ke under file ko rakhna hai
	require 'class/class.phpmailer.php';
	$mail=new PHPMailer;
	$mail->IsSMTP();
	$mail->Host='ssl://smtp.gmail.com';
	$mail->Port='465';
	$mail->SMTPAuth=true;
	$mail->Username='suman.krgr8@gmail.com';
	$mail->Password='cmmmjqdegkilgkpv';
	$mail->SMTPSecure='smtp';
	$mail->From='suman.krgr8@gmail.com';
	$mail->FromName='Suman';
	$mail->AddAddress('theequicomgr8@gmail.com', 'Name');
	$mail->WordWrap=50;
	$mail->IsHTML(true);
	$mail->AddAttachment('img/'.$file_name);
	$mail->Subject='Rst';
	$mail->Body='Body Part';
	if($mail->Send())
	{
		echo "Success";
	}
	else
	{
		echo "False";
	}

}
;?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<script type="text/javascript" src="bootstrap.min.js"></script>
	<script type="text/javascript" src="jquery.min.js"></script>
	<script type="text/javascript" src="popper.min.js"></script>
</head>
<body>
	<form method="post">
		<input type="submit" name="action" value="Send pdf" class="btn btn-info">
	</form><br><br>
<?php echo show($con); ?>
</body>
</html>