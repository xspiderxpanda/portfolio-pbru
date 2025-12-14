
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../a_func.php';

function dd_return($status, $message)
{
    $json = ['message' => $message];
    if ($status) {
        http_response_code(200);
        die(json_encode($json));
    } else {
        http_response_code(400);
        die(json_encode($json));
    }
}

//////////////////////////////////////////////////////////////////////////

header('Content-Type: application/json; charset=utf-8;');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['id'])) {

        if (
            $_POST['id'] != "" and $_POST['detail'] != "" and $_POST['name'] != ""
        ) {
            $q_1 = dd_q('SELECT * FROM users WHERE id = ? AND role = 2  ', [$_SESSION['id']]);
            $plr = $q_1->fetch(PDO::FETCH_ASSOC);
            if ($q_1->rowCount() >= 1) {
                $insert = dd_q("UPDATE ann SET name = ? , detail = ? , img = ? , link = ? ,date = NOW() , admin = ?  WHERE id = ? ", [
                    $_POST['name'],
                    $_POST['detail'],
                    $_POST['img'],
                    $_POST['link'],
                    $plr['username'],
                    $_POST['id'],
                ]);
                if ($insert) {
                    log_admin_action($_SESSION['id'], "UPDATE", "แก้ไขเนื้อหาประกาศ");


                    dd_return(true, "บันทึกสำเร็จ");
                } else {
                    dd_return(false, "SQL ผิดพลาด");
                }
            } else {
                dd_return(false, "เซสชั่นผิดพลาด โปรดล็อกอินใหม่");
                session_destroy();
            }
        } else {
            dd_return(false, "กรุณากรอกข้อมูลให้ครบ");
        }
    } else {
        dd_return(false, "เข้าสู่ระบบก่อน");
    }
} else {
    dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
}
?>
