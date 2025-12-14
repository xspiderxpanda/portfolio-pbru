<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
require_once 'a_func.php';

function dd_return($ok, $msg, $extra = []) {
    $json = array_merge(['status' => $ok ? 'success' : 'fail', 'message' => $msg], $extra);
    http_response_code(200);
    die(json_encode($json));
}

header('Content-Type: application/json; charset=utf-8;');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
}

if (!isset($_SESSION['id'])) {
    dd_return(false, "กรุณาเข้าสู่ระบบก่อน");
}

if (!isset($_POST['id'])) {
    dd_return(false, "กรุณาเลือกบุคคลที่ท่านถูกใจก่อน");
}

$userId = (int)$_SESSION['id'];
$idolId = (int)$_POST['id'];

dd_q("START TRANSACTION");

$idStmt = dd_q("SELECT id, love FROM idol WHERE id = ? FOR UPDATE", [$idolId]);
$idol = $idStmt->fetch(PDO::FETCH_ASSOC);
if (!$idol) {
    dd_q("ROLLBACK");
    dd_return(false, "ไม่พบบุคคลนี้");
}

$logStmt = dd_q(
    "SELECT status_love FROM logloveidol WHERE idol_id = ? AND u_id = ? FOR UPDATE",
    [$idolId, $userId]
);
$log = $logStmt->fetch(PDO::FETCH_ASSOC);

if ($log) {
    if ((int)$log['status_love'] === 1) {
        dd_q("UPDATE logloveidol SET status_love = 0, date = NOW() WHERE idol_id = ? AND u_id = ?", [$idolId, $userId]);
        dd_q("UPDATE idol SET love = GREATEST(love - 1, 0) WHERE id = ?", [$idolId]);

        dd_q("COMMIT");
        dd_return(true, "ยกเลิกการกดถูกใจสำเร็จ", ['liked' => false]);
    } else {
        dd_q("UPDATE logloveidol SET status_love = 1, date = NOW() WHERE idol_id = ? AND u_id = ?", [$idolId, $userId]);
        dd_q("UPDATE idol SET love = love + 1 WHERE id = ?", [$idolId]);

        dd_q("COMMIT");
        dd_return(true, "กดถูกใจสำเร็จ", ['liked' => true]);
    }
} else {
    try {
        dd_q(
            "INSERT INTO logloveidol (date, idol_id, u_id, status_love) VALUES (NOW(), ?, ?, 1)",
            [$idolId, $userId]
        );
        dd_q("UPDATE idol SET love = love + 1 WHERE id = ?", [$idolId]);

        dd_q("COMMIT");
        dd_return(true, "กดถูกใจสำเร็จ", ['liked' => true]);
    } catch (Exception $e) {
        dd_q("ROLLBACK");
        dd_return(false, "เกิดข้อขัดแย้งของข้อมูล กรุณาลองอีกครั้ง");
    }
}
