<?php
// system/backend/portfolio_save.php
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once '../a_func.php';

header('Content-Type: application/json; charset=utf-8');

function respond($ok, $message, $extra = [], $http_ok = 200, $http_err = 400) {
  http_response_code($ok ? $http_ok : $http_err);
  echo json_encode(array_merge(['ok' => $ok, 'message' => $message, 'msg' => $message], $extra), JSON_UNESCAPED_UNICODE);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  respond(false, 'Method not allowed', [], 200, 405);
}
if (!isset($_SESSION['id'])) {
  respond(false, 'กรุณาเข้าสู่ระบบก่อน');
}

$q_1 = dd_q('SELECT * FROM users WHERE id = ? AND role = 2 ', [$_SESSION['id']]);
    if ($q_1->rowCount() < 1) {
    respond(false, 'เซสชั่นผิดพลาด โปรดล็อกอินใหม่');
    session_destroy();
}

$mode    = $_POST['mode'] ?? 'create';
$port_id = (int)($_POST['id'] ?? 0);
$idol_id = (int)($_POST['idol_id'] ?? 0);

$title   = trim($_POST['title'] ?? '');
$detail  = trim($_POST['detail'] ?? '');
$img     = trim($_POST['img'] ?? '');
$url     = trim($_POST['url'] ?? '#');
$github  = trim($_POST['github'] ?? '');
$facebook= trim($_POST['facebook'] ?? '');
$pdf     = trim($_POST['pdf'] ?? '');

// ตรวจความถูกต้องพื้นฐาน
if ($idol_id < 1) respond(false, 'idol_id ไม่ถูกต้อง');
if ($title === '') respond(false, 'กรอกชื่อผลงานด้วยนะ');
if ($mode === 'edit' && $port_id < 1) respond(false, 'รหัสผลงานไม่ถูกต้อง');

// (ออปชัน) ตรวจสิทธิ์: ผู้ใช้มีสิทธิ์แก้ไข idol_id นี้หรือไม่

try {
  if ($mode === 'edit') {
    // แก้ไข
    $q = dd_q("UPDATE idol_portfolio 
               SET title=?, detail=?, img=?, url=?, github=?, facebook=?, pdf=?
               WHERE id=? AND idol_id=?",
      [$title, $detail, $img, $url, $github, $facebook, $pdf, $port_id, $idol_id]
    );
    if ($q->rowCount() >= 0) {
      respond(true, 'แก้ไขผลงานเรียบร้อย', ['id' => $port_id]);
    } else {
      respond(false, 'ไม่สามารถแก้ไขได้');
    }
  } else {
    // สร้างใหม่
    $q = dd_q("INSERT INTO idol_portfolio (title, detail, img, url, github, facebook, pdf, idol_id)
               VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
      [$title, $detail, $img, $url, $github, $facebook, $pdf, $idol_id]
    );
    $new_id = $GLOBALS['pdo']->lastInsertId(); // หรือ dd_last_id() ถ้ามี
    respond(true, 'บันทึกผลงานเรียบร้อย', ['id' => (int)$new_id]);
  }
} catch (Exception $e) {
  respond(false, 'เกิดข้อผิดพลาด: '.$e->getMessage());
}
