<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'a_func.php';

function dd_return($status, $message, $extra = [])
{
    $json = array_merge(
        ['status' => $status ? "success" : "error", 'message' => $message],
        $extra
    );
    http_response_code($status ? 200 : 400);
    die(json_encode($json, JSON_UNESCAPED_UNICODE));
}

header('Content-Type: application/json; charset=utf-8;');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
}

if (isset($_SESSION['id'])) {
    dd_return(false, "กรุณาออกจากระบบก่อนทำการรีเซ็ตรหัสผ่าน");
}

$pass  = $_POST['passforgot'] ?? '';
$cpass = $_POST['cpassforgot'] ?? '';
$otp   = $_POST['otp'] ?? '';
$email = trim($_POST['email'] ?? '');

dd_return(true, "ECHO TEST PASSED " .$email );

// $pass  = $_POST['passforgot'] ?? '';
// $cpass = $_POST['cpassforgot'] ?? '';
// $otp   = $_POST['otp'] ?? '';
// $email = trim($_POST['email'] ?? '');

// if (empty($email) || empty($pass) || empty($cpass) || empty($otp)) {
//     dd_return(false, "กรุณากรอกข้อมูลให้ครบถ้วน", $_POST);
// }

// if (!isset($_SESSION['ref_otp'])) {
//     dd_return(false, "ไม่พบ REF CODE กรุณาขอ OTP ใหม่");
// }

// if ($pass !== $cpass) {
//     dd_return(false, "รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน");
// }

// $forgot = dd_q(
//     "SELECT * FROM forgot_password WHERE otp = ? AND email = ? ORDER BY id DESC LIMIT 1",
//     [$otp, $email]
// )->fetch(PDO::FETCH_ASSOC);

// if ($forgot) {
//     // เปลี่ยนรหัสผ่านใหม่
//     $hashed = password_hash($pass, PASSWORD_DEFAULT);
//     $reset = dd_q("UPDATE users SET password = ? WHERE email = ?", [$hashed, $email]);

//     if ($reset) {
//         dd_q("DELETE FROM forgot_password WHERE ref_otp = ? AND otp = ?", [$_SESSION['ref_otp'], $otp]);

//         unset($_SESSION['otp'], $_SESSION['ref_otp'], $_SESSION['otp_created_time']);

//         dd_return(true, "เปลี่ยนรหัสผ่านเรียบร้อยแล้ว");
//     } else {
//         dd_return(false, "เกิดข้อผิดพลาดในการเปลี่ยนรหัสผ่าน");
//     }
// } else {
//     dd_return(false, "รหัส OTP ไม่ถูกต้องหรือหมดอายุ", $_POST);
// }
