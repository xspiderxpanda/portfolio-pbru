<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once 'a_func.php';

function dd_return($status, $message) {
    $json = ['msg' => $message];
    if ($status) {
        http_response_code(200);
        die(json_encode($json));
    } else {
        http_response_code(400);
        die(json_encode($json));
    }
}

#######################################

header('Content-Type: application/json; charset=utf-8;');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['id'])) {
        $p = dd_q("SELECT * FROM users WHERE id = ?", [$_SESSION['id']]);
        if ($p->rowCount() >= 1) {
            $plr = $p->fetch(PDO::FETCH_ASSOC);

            $nick = isset($_POST['nickname']) ? trim($_POST['nickname']) : '';
    $isValid = true;

    if ($nick === '') {
        echo json_encode([
            'status' => "error",
            'msg' => "ชื่อเล่นไม่สามารถเว้นว่างไว้ได้หากคุณต้องการแก้ไข"
        ]);
        exit;
    }

    if (!preg_match('/^[ก-ฮa-zA-Z0-9 _-]+$/u', $nick)) {
        echo json_encode([
            'status' => "error",
            'msg' => "ชื่อเล่นห้ามมีอักษรพิเศษ เช่น < > { } ( ) \" ' ; :"
        ]);
        exit;
    }

    if (mb_strlen($nick, 'UTF-8') > 30) {
        echo json_encode([
            'status' => "error",
            'msg' => "ชื่อเล่นต้องไม่เกิน 30 ตัวอักษร"
        ]);
        exit;
    }

            $cnickname = dd_q("UPDATE users SET nickname = ? WHERE id = ?", [$nick, $_SESSION['id']]);

            if ($cnickname) {
                echo json_encode([
                    'status' => "success",
                    'msg' => "คุณได้เปลี่ยนชื่อเล่นเป็น " . htmlspecialchars($nick, ENT_QUOTES, 'UTF-8') . " เรียบร้อยแล้ว"
                ]);
            } else {
                echo json_encode([
                    'status' => "error",
                    'msg' => "เกิดข้อผิดพลาดกรุณาแจ้งแอดมิน !"
                ]);
            }
        } else {
            echo json_encode([
                'status' => "error",
                'msg' => "ไม่พบชื่อผู้ใช้งาน"
            ]);
        }
    } else {
        echo json_encode([
            'status' => "error",
            'msg' => "กรุณาเข้าสู่ระบบก่อนทำรายการ"
        ]);
    }
} else {
    echo json_encode([
        'status' => "error",
        'msg' => "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!"
    ]);
}
