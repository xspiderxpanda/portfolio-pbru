<?php
// system/backend/portfolio_get.php
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once '../../a_func.php'; // ต้องมี dd_q(), session_start()

header('Content-Type: application/json; charset=utf-8');

function respond($ok, $message, $extra = [], $http_ok = 200, $http_err = 400) {
  http_response_code($ok ? $http_ok : $http_err);
  echo json_encode(array_merge(['ok' => $ok, 'message' => $message, 'msg' => $message], $extra), JSON_UNESCAPED_UNICODE);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
  respond(false, 'Method not allowed', [], 200, 405);
}
if (!isset($_SESSION['id'])) {
  respond(false, 'กรุณาเข้าสู่ระบบก่อน');
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id < 1) respond(false, 'ไม่พบพารามิเตอร์ id');

$q = dd_q("SELECT id, title, detail, img, url, github, facebook, pdf, idol_id FROM idol_portfolio WHERE id = ?", [$id]);
if ($q->rowCount() < 1) respond(false, 'ไม่พบผลงานที่ต้องการ');

$row = $q->fetch(PDO::FETCH_ASSOC);

// (ออปชัน) ตรวจสิทธิ์เจ้าของผลงาน/แอดมินตามระบบของคุณ
// เช่น ตรวจว่าผู้ใช้มีสิทธิ์แก้ไข idol_id นี้หรือไม่

respond(true, 'success', ['data' => $row]);
