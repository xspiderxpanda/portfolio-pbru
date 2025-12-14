<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
header('Content-Type: application/json; charset=utf-8;');

require_once 'a_func.php'; 

function jret($ok, $msg, $extra = []) {
  http_response_code($ok ? 200 : 400);
  die(json_encode(['msg' => $msg] + $extra));
}


$idolId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($idolId <= 0) jret(false, 'Invalid idol id');


if (!isset($_SESSION['id'])) jret(false, 'กรุณาเข้าสู่ระบบ');
$q_user = dd_q('SELECT * FROM users WHERE id = ?', [$_SESSION['id']]);
if ($q_user->rowCount() < 1) jret(false, 'ไม่พบผู้ใช้');
$plr = $q_user->fetch(PDO::FETCH_ASSOC);
if (!isset($plr['role']) || ($plr['role'] !== "1" && $plr['role'] !== "2")) {
  jret(false, 'คุณไม่มีสิทธิ์อัปโหลดรูป');
}

// ตรวจว่าเป็นเจ้าของ idol
$q_idol = dd_q('SELECT * FROM idol WHERE id = ? AND u_admin = ?', [$idolId, $_SESSION['id']]);
if ($q_idol->rowCount() < 1) jret(false, 'ไม่พบไอดอล หรือคุณไม่ใช่เจ้าของ');

// ต้องเป็น POST + multipart/form-data
if ($_SERVER['REQUEST_METHOD'] !== 'POST') jret(false, 'Invalid method');
if (!isset($_FILES['file'])) jret(false, 'ไม่พบไฟล์อัปโหลด');

// ตัวเลือก scope: portfolio_cover | portfolio_gallery | idol_avatar | idol_banner
$scope = $_POST['scope'] ?? 'portfolio_cover';
$allowScopes = ['portfolio_cover','portfolio_gallery','idol_avatar','idol_banner'];
if (!in_array($scope, $allowScopes, true)) $scope = 'portfolio_cover';

$f = $_FILES['file'];
if ($f['error'] !== UPLOAD_ERR_OK) jret(false, 'อัปโหลดล้มเหลว (err='.$f['error'].')');

// จำกัดนามสกุล/ชนิด/ขนาด
$allowed = [
  'image/jpeg' => '.jpg',
  'image/png'  => '.png',
  'image/webp' => '.webp',
];
$sizeMax = 5 * 1024 * 1024; // 5MB

$mime = mime_content_type($f['tmp_name']);
$ext = $allowed[$mime] ?? null;
if (!$ext) jret(false, 'ชนิดไฟล์ไม่รองรับ (อนุญาต: jpg, png, webp)');
if ($f['size'] > $sizeMax) jret(false, 'ไฟล์ใหญ่เกินกำหนด (สูงสุด 5MB)');

// เตรียมโฟลเดอร์ปลายทาง
$baseDir = dirname(__DIR__) . '/uploads/idol/' . $idolId . '/' . $scope;
if (!is_dir($baseDir)) {
  if (!@mkdir($baseDir, 0775, true)) jret(false, 'สร้างโฟลเดอร์ไม่สำเร็จ');
}

// สร้างชื่อไฟล์ใหม่
$fname = bin2hex(random_bytes(8)) . $ext;
$destPath = $baseDir . '/' . $fname;

// ย้ายไฟล์
if (!move_uploaded_file($f['tmp_name'], $destPath)) {
  jret(false, 'บันทึกไฟล์ไม่สำเร็จ');
}

// สร้าง URL แบบ relative (ปรับตามโครงโปรเจกต์คุณ)
$publicUrl = '/uploads/idol/' . $idolId . '/' . $scope . '/' . $fname;

// สำเร็จ
jret(true, 'อัปโหลดสำเร็จ', ['url' => $publicUrl]);
