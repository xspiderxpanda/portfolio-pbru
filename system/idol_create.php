<?php

error_reporting(E_ALL);
ini_set('display_errors', 0);
require_once 'a_func.php';


function dd_return($status, $message) {
    $json = ['msg' => $message];
    if ($status) {
        http_response_code(200);
        die(json_encode($json, JSON_UNESCAPED_UNICODE));
    } else {
        http_response_code(400);
        die(json_encode($json, JSON_UNESCAPED_UNICODE));
    }
}

header('Content-Type: application/json; charset=utf-8;');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    dd_return(false, 'Method not allowed');
}

if (!isset($_SESSION['id'])) {
    dd_return(false, 'กรุณาเข้าสู่ระบบก่อน');
}

// โหลดโปรไฟล์ผู้ใช้ปัจจุบัน
$q_1 = dd_q('SELECT * FROM users WHERE id = ?', [$_SESSION['id']]);
if ($q_1->rowCount() < 1) {
    dd_return(false, 'ไม่พบผู้ใช้ในระบบ');
}
$plr = $q_1->fetch(PDO::FETCH_ASSOC);

// ตรวจสิทธิ์ role
if (!isset($plr['role']) || ($plr['role'] !== "1" && $plr['role'] !== "2")) {
    dd_return(false, 'คุณไม่มีสิทธิ์สร้างโปรไฟล์ไอดอล');
}

// รับ JSON body
$raw = file_get_contents('php://input');
$body = json_decode($raw, true);
if (!is_array($body)) {
    dd_return(false, 'รูปแบบข้อมูลไม่ถูกต้อง');
}

// ดึงฟิลด์ที่ต้องใช้
$name        = trim($body['name'] ?? '');
$nickname    = trim($body['nickname'] ?? '');
$img         = trim($body['img'] ?? '');
$banner      = trim($body['banner'] ?? '');
$info        = trim($body['info'] ?? '');
$major_id    = (int)($body['major_id'] ?? 0);
$dateofbirth = trim($body['dateofbirth'] ?? '');
$contact     = trim($body['contact'] ?? '');



// ตรวจความถูกต้องแบบเบื้องต้น
if ($name === '' || $nickname === '') {
    dd_return(false, 'กรุณากรอกชื่อจริงและชื่อเล่น');
}

if ($dateofbirth !== '') {
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateofbirth)) {
        dd_return(false, 'รูปแบบวันเกิดไม่ถูกต้อง (YYYY-MM-DD)');
    } else {
        // ตรวจสอบว่าเป็น พ.ศ. หรือ ค.ศ.
        [$year, $month, $day] = explode('-', $dateofbirth);
        $year = (int)$year;
        if ($year > 2400) { 
            // ถ้าเป็น พ.ศ. ให้แปลงเป็น ค.ศ.
            $year -= 543;
            $dateofbirth = sprintf('%04d-%02d-%02d', $year, $month, $day);
        }
    }
}


// เตรียมค่าเริ่มต้นตาม schema
$u_admin   = (int)$_SESSION['id'];
$position  = '0';
$view      = '0';
$love      = '0';
$dateupdate = date('Y-m-d H:i:s');

// INSERT ด้วย dd_q (PDO prepared ภายในฟังก์ชันของคุณ)
$sql = "INSERT INTO idol
        (name, nickname, img, banner, info, major_id, dateofbirth, u_admin, position, view, love, contact, dateupdate)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$params = [
    $name, $nickname, $img, $banner, $info, $major_id, $dateofbirth ?: date('Y-m-d'),
    $u_admin, $position, $view, $love, $contact, $dateupdate
];

try {
    $q = dd_q($sql, $params);
    if ($q->rowCount() >= 1) {
        dd_return(true, 'สร้างโปรไฟล์สำเร็จ');
    } else {
        dd_return(false, 'ไม่สามารถบันทึกข้อมูลได้');
    }
} catch (Throwable $e) {
    // ซ่อนรายละเอียดภายใน แต่บันทึก log ได้ถ้าคุณมีระบบ log
    dd_return(false, 'เกิดข้อผิดพลาดในการบันทึกข้อมูล');
}
