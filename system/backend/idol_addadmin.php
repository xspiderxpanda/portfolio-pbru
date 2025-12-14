<?php
// system/backend/idol_addadmin.php
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once '../a_func.php'; // dd_q(), session_start() ควรอยู่ในไฟล์นี้

header('Content-Type: application/json; charset=utf-8');

function respond($ok, $message, $extra = [], $http_ok = 200, $http_err = 400) {
  http_response_code($ok ? $http_ok : $http_err);
  echo json_encode(array_merge(['message' => $message, 'msg' => $message], $extra), JSON_UNESCAPED_UNICODE);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  respond(false, 'Method not allowed', [], 200, 405);
}
if (!isset($_SESSION['id'])) {
  respond(false, 'กรุณาเข้าสู่ระบบก่อน');
}

// ผู้ใช้ปัจจุบัน
$q_user = dd_q('SELECT id, role FROM users WHERE id = ?', [$_SESSION['id']]);
if ($q_user->rowCount() < 1) respond(false, 'ไม่พบผู้ใช้');
$me   = $q_user->fetch(PDO::FETCH_ASSOC);
$role = (string)($me['role'] ?? '');
if ($role !== "1" && $role !== "2") {
  respond(false, 'คุณไม่มีสิทธิ์แก้ไขรายชื่อผู้ดูแล');
}

// รับ JSON
$raw  = file_get_contents('php://input');
$body = json_decode($raw, true);
if (!is_array($body)) respond(false, 'รูปแบบข้อมูลไม่ถูกต้อง');

$id    = isset($body['id']) && ctype_digit((string)$body['id']) ? (int)$body['id'] : 0;
$mode  = strtolower(trim($body['mode'] ?? 'set')); // set | add | remove
$hasAdminsKey = array_key_exists('admins', $body);
$admins = $body['admins'] ?? [];

if ($id <= 0) respond(false, 'ไม่พบไอดีโปรไฟล์');
if ($mode === 'set' && !$hasAdminsKey) {
  respond(false, 'โหมด set ต้องส่ง admins (array) มาด้วย');
}

// sanitize admins
if (!is_array($admins)) $admins = [];
$admins = array_values(array_unique(array_filter(array_map(function($x){
  return ctype_digit((string)$x) ? (int)$x : null;
}, $admins), fn($v)=>!is_null($v) && $v > 0)));
sort($admins);

// ข้อมูลเดิม
$q = dd_q('SELECT id, u_admin FROM idol WHERE id = ?', [$id]);
if ($q->rowCount() < 1) respond(false, 'ไม่พบข้อมูลโปรไฟล์');
$row = $q->fetch(PDO::FETCH_ASSOC);

$old = array_values(array_filter(array_map('intval', array_map('trim', explode(',', (string)($row['u_admin'] ?? '')))), fn($v)=>$v > 0));
sort($old);

// สิทธิ์
if ($role !== "2" && !in_array((int)$_SESSION['id'], $old, true)) {
  respond(false, 'คุณไม่มีสิทธิ์แก้ไขรายการนี้');
}

// คำนวณชุดใหม่
switch ($mode) {
  case 'add':
    $new = array_values(array_unique(array_merge($old, $admins)));
    sort($new);
    break;
  case 'remove':
    if (empty($admins)) respond(false, 'กรุณาระบุรายการที่จะลบ');
    $removeMap = array_flip($admins);
    $new = array_values(array_filter($old, fn($v) => !isset($removeMap[$v])));
    break;
  default: // set
    $new = $admins;
}

$u_admin_csv = implode(',', $new);

if ($u_admin_csv === (string)$row['u_admin']) {
  respond(false, 'ไม่มีการเปลี่ยนแปลง', ['admins' => $new, 'u_admin' => $u_admin_csv]);
}

// อัปเดต
try {
  $u = dd_q('UPDATE idol SET u_admin = ? WHERE id = ?', [$u_admin_csv, $id]);
  if ($u->rowCount() > 0) {
    respond(true, 'อัปเดตรายชื่อผู้ดูแลสำเร็จ', ['admins' => $new, 'u_admin' => $u_admin_csv]);
  } else {
    respond(false, 'ไม่มีการเปลี่ยนแปลง', ['admins' => $new, 'u_admin' => $u_admin_csv]);
  }
} catch (Throwable $e) {
  // error_log($e->getMessage());
  respond(false, 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล');
}
