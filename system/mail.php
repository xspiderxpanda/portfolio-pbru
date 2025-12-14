<?php
$jsonData = file_get_contents("php://input");
$data = json_decode($jsonData, true);

if (empty($data['to']) || empty($data['webname']) || empty($data['code']) || empty($data['ref'])) {
    echo "Missing required data.";
    exit;
}

$to = $data['to'];
$subject = "แจ้งมีการขอรหัส OTP เพื่อทำการเปลี่ยนรหัสผ่าน บน {$data['webname']}";
$message = "
<html>
<head>
<title>แจ้งมีการขอรหัส OTP เพื่อทำการเปลี่ยนรหัสผ่าน</title>
</head>
<body style='padding: 20px; background-color: #f2f2f2;'>
<div style='border: 1px solid #ccc; padding: 20px; border-radius: 10px; background-color: #ffffff;'>
<center>
<h2 style='color: red;'>แจ้งมีการขอรหัส OTP เพื่อทำการเปลี่ยนรหัสผ่าน</h2>
<h3>{$data['webname']}</h3>
<p style='font-size: 16px;'>OTP : {$data['code']} (โปรดอย่าส่งรหัสนี้ให้กับผู้อื่น !)<br>Ref: {$data['ref']}</p>
</center>
</div>
</body>
</html>
";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: Forgot Password {$data['webname']} <forgot-password@mucity.online>\r\n";

if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully!";
} else {
    echo "Email sending failed.";
}

?>