

<?php     
include('SMTP.php');
include("PHPMailer.php"); 
use PHPMailer\PHPMailer\PHPMailer;
function sendMail($to){
	$nFrom = "no-reply";    //mail duoc gui tu dau, thuong de ten cong ty ban
	$mFrom = 'manhtoan159@gmail.com';  //dia chi email cua ban 
	$mPass = 'Anhtoan1997';       //mat khau email cua ban

	$mail = new PHPMailer();
	$body = 'Bạn đã đặt hàng thành công!';   // Noi dung email
	$title = "Thông báo đặt hàng thành công";   //Tieu de gui mail
	$mail->IsSMTP();             
	$mail->CharSet  = "utf-8";
	$mail->SMTPDebug  = 0;   // enables SMTP debug information (for testing)
	$mail->SMTPAuth   = true;    // enable SMTP authentication
	$mail->SMTPSecure = "ssl";   // sets the prefix to the servier
	$mail->Host       = "smtp.gmail.com";    // sever gui mail.
	$mail->Port       = 465;         // cong gui mail de nguyen
	// xong phan cau hinh bat dau phan gui mail
	$mail->Username   = $mFrom;  // khai bao dia chi email
	$mail->Password   = $mPass;              // khai bao mat khau
	$mail->SetFrom($mFrom, $nFrom);
	$mail->AddReplyTo('manhtoan159@gmail.com', 'Toantm'); //khi nguoi dung phan hoi se duoc gui den email nay
	$mail->Subject    = $title;// tieu de email 
	$mail->MsgHTML($body);// noi dung chinh cua mail se nam o day.
	$mail->AddAddress($to, $to);
	// thuc thi lenh gui mail 
	if(!$mail->Send()) {
			return 1;
	} else {
			return 0;
	}
}
?>


