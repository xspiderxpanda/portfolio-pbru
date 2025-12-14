<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'a_func.php'; 

header('Content-Type: application/json; charset=utf-8;');

function dd_return($ok, $msg, $extra = []) {
  $json = ['ok' => $ok ? true : false, 'msg' => $msg] + $extra;
  http_response_code($ok ? 200 : 400);
  die(json_encode($json));
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  dd_return(false, 'Invalid method');
}

$idolId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($idolId <= 0) dd_return(false, 'Invalid idol id');

$qIdol = dd_q('SELECT * FROM idol WHERE id = ?', [$idolId]);
if ($qIdol->rowCount() < 1) dd_return(false, 'Idol not found');

if (!isset($_SESSION['id'])) dd_return(false, 'Please login');

// ผู้ใช้ปัจจุบัน
$q_1 = dd_q('SELECT * FROM users WHERE id = ?', [$_SESSION['id']]);
if ($q_1->rowCount() < 1) dd_return(false, 'User not found');
$plr = $q_1->fetch(PDO::FETCH_ASSOC);

/**
 * แปลงค่า u_admin ให้เป็นอาร์เรย์ของ int รองรับ:
 * - JSON array: "[1,2,3]"
 * - CSV string: "1,2,3"
 * - ค่าจำนวนเต็มเดี่ยว: "5" หรือ 5
 * - ค่า null/ว่าง -> []
 */
function parse_admin_ids($raw) {
  if ($raw === null) return [];
  if (is_array($raw)) {
    return array_values(array_unique(array_map('intval', $raw)));
  }
  $s = trim((string)$raw);

  if ($s === '') return [];

  // JSON array
  if ($s[0] === '[') {
    $arr = json_decode($s, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($arr)) {
      return array_values(array_unique(array_map('intval', $arr)));
    }
  }

  // CSV
  if (strpos($s, ',') !== false) {
    $parts = array_map('trim', explode(',', $s));
    return array_values(array_unique(array_map('intval', $parts)));
  }

  // เลขเดี่ยว
  if (ctype_digit($s)) return [intval($s)];

  // กรณีอื่น ๆ ที่ไม่รู้จัก -> ว่าง
  return [];
}

$idol = $qIdol->fetch(PDO::FETCH_ASSOC);
$adminIds = parse_admin_ids($idol['u_admin'] ?? null);

// เงื่อนไขสิทธิ์: role เป็น 1 หรือ 2 และเป็นหนึ่งในผู้ดูแลของไอดอลนี้
$userId = (int)$_SESSION['id'];
$isOwner = in_array($userId, $adminIds, true);
$roleOk  = in_array((string)$plr['role'], ['1','2'], true) || in_array((int)$plr['role'], [1,2], true);
$canEdit = ($roleOk && $isOwner);

$act = $_POST['act'] ?? 'meta';

try {

  if ($act === 'meta') {
    dd_return(true, 'ok', [
      'idol' => [
        'id'       => (int)$idol['id'],
        'name'     => $idol['name'] ?? null,
        'nickname' => $idol['nickname'] ?? null,
        'img'      => $idol['img'] ?? null,
        'banner'   => $idol['banner'] ?? null,
      ],
      'isOwner' => $isOwner,
      'canEdit' => $canEdit,
      'role'    => (string)$plr['role'],
      'me'      => $userId,
      'u_admin' => $adminIds, // ส่งกลับไปให้ดีบั๊กได้ด้วย
    ]);
  }

 if ($act === 'list') {
  // 1) ดึงรายการหลัก
  $stmt = dd_q(
    'SELECT * FROM idol_portfolio WHERE idol_id = ? ORDER BY id DESC',
    [$idolId]
  );

  if (!($stmt instanceof PDOStatement)) {
    dd_return(false, 'DB error: list query failed');
  }

  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // 2) เติม images แบบปลอดภัย: ข้ามได้ถ้าตารางไม่มี/คิวรีล้มเหลว
  if (!empty($rows)) {
    $ids = array_map(fn($r) => (int)$r['id'], $rows);
    $ids = array_values(array_filter($ids, fn($v) => $v > 0));
    if (count($ids) > 0) {
      $placeholders = implode(',', array_fill(0, count($ids), '?'));
      // ลองคิวรี ถ้าล้มเหลวไม่ต้องหยุดทั้ง endpoint แค่ไม่เติม images
      $imgStmt = dd_q(
        "SELECT id, port_id, img
           FROM idol_portfolio_img
          WHERE port_id IN ($placeholders)
          ORDER BY id ASC",
        $ids
      );

      $grouped = [];
      if ($imgStmt instanceof PDOStatement) {
        $imgRows = $imgStmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($imgRows as $im) {
          $pid = (int)$im['port_id'];
          $grouped[$pid][] = ['id' => (int)$im['id'], 'img' => $im['img']];
        }
      }

      foreach ($rows as &$r) {
        $pid = (int)$r['id'];
        $r['images'] = $grouped[$pid] ?? [];
      }
      unset($r);
    }
  }

  dd_return(true, 'ok', ['data' => $rows]);
}
  if ($act === 'create') {
    if (!$canEdit) dd_return(false, 'Permission denied');

    $title  = trim($_POST['title'] ?? '');
    $detail = trim($_POST['detail'] ?? '');
    if ($title === '' || $detail === '') dd_return(false, 'กรอกหัวเรื่องและรายละเอียด');

    $img      = trim($_POST['img'] ?? '');
    $url      = trim($_POST['url'] ?? '');
    $github   = trim($_POST['github'] ?? '');
    $facebook = trim($_POST['facebook'] ?? '');
    $pdf      = trim($_POST['pdf'] ?? '');

    dd_q(
      'INSERT INTO idol_portfolio (title, detail, img, url, github, facebook, pdf, idol_id)
       VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
      [$title, $detail, $img, $url, $github, $facebook, $pdf, $idolId]
    );

    $newId = dd_q('SELECT LAST_INSERT_ID() AS id')->fetch(PDO::FETCH_ASSOC)['id'] ?? null;
    dd_return(true, 'เพิ่มผลงานสำเร็จ', ['id' => (int)$newId]);
  }

  if ($act === 'update') {
    if (!$canEdit) dd_return(false, 'Permission denied');

    $portId = (int)($_POST['port_id'] ?? 0);
    if ($portId <= 0) dd_return(false, 'ข้อมูลไม่ครบ');

    // ต้องเป็นผลงานของไอดอลนี้
    $own = dd_q('SELECT id FROM idol_portfolio WHERE id = ? AND idol_id = ?', [$portId, $idolId]);
    if ($own->rowCount() < 1) dd_return(false, 'ไม่พบผลงานนี้ หรือไม่ใช่ของไอดอลคนนี้');

    $title    = trim($_POST['title'] ?? '');
    $detail   = trim($_POST['detail'] ?? '');
    $img      = trim($_POST['img'] ?? '');
    $url      = trim($_POST['url'] ?? '');
    $github   = trim($_POST['github'] ?? '');
    $facebook = trim($_POST['facebook'] ?? '');
    $pdf      = trim($_POST['pdf'] ?? '');

    if ($title === '' || $detail === '') dd_return(false, 'กรอกหัวเรื่องและรายละเอียด');

    dd_q(
      'UPDATE idol_portfolio
         SET title = ?, detail = ?, img = ?, url = ?, github = ?, facebook = ?, pdf = ?
       WHERE id = ?',
      [$title, $detail, $img, $url, $github, $facebook, $pdf, $portId]
    );

    dd_return(true, 'อัปเดตผลงานสำเร็จ', ['id' => $portId]);
  }

  if ($act === 'add_image') {
    if (!$canEdit) dd_return(false, 'Permission denied');

    $portId = (int)($_POST['port_id'] ?? 0);
    $imgUrl = trim($_POST['img'] ?? '');
    if ($portId <= 0 || $imgUrl === '') dd_return(false, 'ข้อมูลไม่ครบ');

    $own = dd_q('SELECT id FROM idol_portfolio WHERE id = ? AND idol_id = ?', [$portId, $idolId]);
    if ($own->rowCount() < 1) dd_return(false, 'ไม่พบผลงานนี้ หรือไม่ใช่ของไอดอลคนนี้');

    // ปรับชื่อตารางให้ตรงสคีมาของคุณ
    dd_q('INSERT INTO idol_portfolio_img (port_id, img) VALUES (?, ?)', [$portId, $imgUrl]);

    dd_return(true, 'เพิ่มรูปสำเร็จ');
  }

  if ($act === 'delete') {
    if (!$canEdit) dd_return(false, 'Permission denied');

    $portId = (int)($_POST['port_id'] ?? 0);
    if ($portId <= 0) dd_return(false, 'ข้อมูลไม่ครบ');

    $own = dd_q('SELECT id FROM idol_portfolio WHERE id = ? AND idol_id = ?', [$portId, $idolId]);
    if ($own->rowCount() < 1) dd_return(false, 'ไม่พบผลงานนี้ หรือไม่ใช่ของไอดอลคนนี้');

    // ลบรูปที่เกี่ยวข้องก่อน (ถ้ามีตาราง)
    dd_q('DELETE FROM idol_portfolio_img WHERE port_id = ?', [$portId]);
    dd_q('DELETE FROM idol_portfolio WHERE id = ?', [$portId]);

    dd_return(true, 'ลบผลงานสำเร็จ');
  }

  dd_return(false, 'Unknown action');
} catch (Throwable $e) {
  dd_return(false, 'Server error: '.$e->getMessage());
}
?>