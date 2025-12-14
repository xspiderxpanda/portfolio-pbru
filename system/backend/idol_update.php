<?php
// system/backend/idol_update.php

error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once '../a_func.php'; // ต้องมี dd_q(), session_start() (ถ้าจำเป็น) ภายในไฟล์นี้

header('Content-Type: application/json; charset=utf-8');

function dd_return($ok, $msg, $http_ok = 200, $http_err = 400) {
  http_response_code($ok ? $http_ok : $http_err);
  echo json_encode(['msg' => $msg], JSON_UNESCAPED_UNICODE);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  dd_return(false, 'Method not allowed', 200, 405);
}
if (!isset($_SESSION['id'])) {
  dd_return(false, 'กรุณาเข้าสู่ระบบก่อน');
}

// ดึงข้อมูลผู้ใช้ปัจจุบัน
$q_user = dd_q('SELECT id, role FROM users WHERE id = ?', [$_SESSION['id']]);
if ($q_user->rowCount() < 1) {
  dd_return(false, 'ไม่พบผู้ใช้');
}
$plr = $q_user->fetch(PDO::FETCH_ASSOC);
$role = isset($plr['role']) ? (string)$plr['role'] : null;
if ($role !== "1" && $role !== "2") {
  dd_return(false, 'คุณไม่มีสิทธิ์แก้ไขโปรไฟล์ไอดอล');
}

// รับ JSON
$raw  = file_get_contents('php://input');
$body = json_decode($raw, true);
if (!is_array($body)) {
  dd_return(false, 'รูปแบบข้อมูลไม่ถูกต้อง');
}

// ===== รับฟิลด์ =====
$id          = isset($body['id']) && ctype_digit((string)$body['id']) ? (int)$body['id'] : 0;
$name        = trim($body['name']        ?? '');
$nickname    = trim($body['nickname']    ?? '');
$img         = trim($body['img']         ?? '');
$banner      = trim($body['banner']      ?? '');
$info        = trim($body['info']        ?? '');
$major_id    = (int)($body['major_id']   ?? 0);
$dateofbirth = trim($body['dateofbirth'] ?? '');
$contact     = trim($body['contact']     ?? '');


// ===== validate ขั้นต้น =====
if ($id <= 0) {
  dd_return(false, 'ไม่พบไอดีโปรไฟล์');
}
if ($name === '' || $nickname === '') {
  dd_return(false, 'กรุณากรอกชื่อจริงและชื่อเล่น');
}

// ตรวจว่ามีโปรไฟล์นี้
$q_chk = dd_q('SELECT id, u_admin FROM idol WHERE id = ?', [$id]);
if ($q_chk->rowCount() < 1) {
  dd_return(false, 'ไม่พบข้อมูล');
}
$row_chk = $q_chk->fetch(PDO::FETCH_ASSOC);

// ===== สิทธิ์การแก้ไข =====
// แอดมินระบบ (role=2) ผ่านได้
// ผู้ใช้ทั่วไป (role=1) ต้องเป็นหนึ่งใน u_admin เดิม
if ($role !== "2") {
  $oldAdmins = array_filter(array_map('intval', array_map('trim', explode(',', (string)($row_chk['u_admin'] ?? '')))));
  if (!in_array((int)$_SESSION['id'], $oldAdmins, true)) {
    dd_return(false, 'คุณไม่มีสิทธิ์แก้ไขรายการนี้');
  }
}

// ===== validate/normalize dateofbirth =====
if ($dateofbirth !== '') {
  if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateofbirth)) {
    dd_return(false, 'รูปแบบวันเกิดไม่ถูกต้อง (YYYY-MM-DD)');
  } else {
    [$yy, $mm, $dd] = explode('-', $dateofbirth);
    $y = (int)$yy;
    // ถ้าเป็นปี พ.ศ. ให้แปลงเป็น ค.ศ.
    if ($y > 2400) {
      $y -= 543;
      $dateofbirth = sprintf('%04d-%02d-%02d', $y, (int)$mm, (int)$dd);
    }
  }
}

$dateupdate = date('Y-m-d H:i:s');

// ===== อัปเดต =====
$sql = "UPDATE idol
        SET name = ?, nickname = ?, img = ?, banner = ?, info = ?, major_id = ?,
            dateofbirth = ?, contact = ?, dateupdate = ?
        WHERE id = ?";
$params = [
  $name, $nickname, $img, $banner, $info, $major_id,
  ($dateofbirth ?: null), $contact, $dateupdate, $id
];

try {
  $q = dd_q($sql, $params);
  if ($q->rowCount() > 0) {
    dd_return(true, 'อัปเดตโปรไฟล์สำเร็จ');
  } else {
    dd_return(false, 'ไม่มีการเปลี่ยนแปลง');
  }
} catch (Throwable $e) {
  dd_return(false, 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล');
}
