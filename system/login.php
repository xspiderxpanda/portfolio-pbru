<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'a_func.php';

function dd_return($status, $message)
{
    $json = ['status' => $status ? 'success' : 'fail', 'message' => $message];
    http_response_code(200);
    exit(json_encode($json));
}

header('Content-Type: application/json; charset=utf-8;');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['id'])) {
        $user_login = $_POST['usernamelogin'];
        $pwd_login = $_POST['passwordlogin'];
        $ip = $_SERVER['REMOTE_ADDR'];
        
        if (!empty($user_login) && !empty($pwd_login)) {
            $q = dd_q("SELECT * FROM users WHERE username = ?", [$user_login]);

            if ($q->rowCount() === 1) {
                $dt = $q->fetch(PDO::FETCH_ASSOC);

                if ($dt['failed_attempts'] >= 3) {
                    dd_return(false, "บัญชีของคุณถูกล็อกชั่วคราวเนื่องจากพยายามล็อกอินเข้ามา กรุณาติดต่อแอดมิน");
                }

                if (password_verify($pwd_login, $dt['password'])) {
                    $_SESSION['id'] = $dt['id'];
                    dd_q("UPDATE users SET ip = ?, statusonline = 1, failed_attempts = 0 WHERE id = ?", [$ip, $_SESSION['id']]);
                    dd_return(true, "เข้าสู่ระบบสำเร็จ ยินดีต้อนรับคุณ " . $dt['nickname']);
                } else {
                    $failed_attempts = $dt['failed_attempts'] + 1;
                    dd_q("UPDATE users SET failed_attempts = ? WHERE id = ?", [$failed_attempts, $dt['id']]);

                    if ($failed_attempts >= 3) {
                        dd_return(false, "บัญชีของคุณถูกล็อกชั่วคราวเนื่องจากพยายามล็อกอินผิดเกิน 3 ครั้ง");
                    } else {
                        dd_return(false, "ไม่พบผู้ใช้หรือรหัสผ่าน ไม่ถูกต้อง");
                    }
                }
            } else {
                dd_return(false, "ไม่พบผู้ใช้หรือรหัสผ่าน ไม่ถูกต้อง");
            }
        } else {
            dd_return(false, "กรุณากรอกข้อมูลให้ครบ");
        }
    } else {
        dd_return(false, "ออกจากระบบก่อน");
    }
}
dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
?>
