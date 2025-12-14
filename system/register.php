<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

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
        $email_login = $_POST['emailreg'];
        $user_login = $_POST['usernamereg'];
        $nname = $_POST['nickname'];
        $pwd_login = $_POST['passwordreg'];
        $pwd2_login = $_POST['passwordreg1'];
        $ip = $_SERVER['REMOTE_ADDR'];

        $email_exist = dd_q("SELECT * FROM users WHERE email = ?", [$email_login]);
        $user_exist = dd_q("SELECT * FROM users WHERE username = ?", [$user_login]);
        $ip_exist = dd_q("SELECT * FROM users WHERE ip = ?", [$ip]);

        if (!empty($user_login) && !empty($pwd_login) && !empty($email_login) && !empty($pwd2_login)) {
            if (preg_match('/^[a-zA-Z0-9\_]*$/', $user_login)) {
                if ($email_exist->rowCount() == 0) {
                    if ($ip_exist->rowCount() == 0) {
                        if ($user_exist->rowCount() == 0) {
                            if ($pwd_login === $pwd2_login) {
                                $hashedPassword = password_hash($pwd_login, PASSWORD_DEFAULT);
                                $avata = $config['logo'];

                                $in = dd_q("INSERT INTO users (nickname,username, password, 
                                ip, img, social_id, u_type , statusonline , created_at , email , failed_attempts)
                                VALUES (?,?, ?, ?, ?,'website', 'website' , ? , NOW(), ? , '0')", [
                                    $nname,
                                    $user_login,
                                    $hashedPassword,
                                    $ip,
                                    $config['logo'],
                                    0,
                                    $email_login
                                ]);

                                if ($in) {
                                    $q = dd_q("SELECT * FROM users WHERE username = ?", [$user_login]);
                                    $dt = $q->fetch(PDO::FETCH_ASSOC);
                                    $_SESSION['id'] = $dt['id'];
                                    dd_q("UPDATE users SET ip = ?, statusonline = 1 WHERE id = ?", [$ip, $_SESSION['id']]);
                                    dd_return(true, "สมัครสมาชิกสำเร็จ");
                                } else {
                                    dd_return(false, "สมัครสมาชิกผิดพลาด โปรดแจ้งแอดมิน");
                                }
                            } else {
                                dd_return(false, "กรุณาป้อนรหัสผ่านทั้งสองให้ตรงกัน");
                            }
                        } else {
                            dd_return(false, "ชื่อผู้ใช้นี้มีผู้ใช้งานแล้ว");
                        }
                    } else {
                        dd_return(false, "มีการสมัครสมาชิกด้วย IP นี้แล้ว");
                    }
                } else {
                    dd_return(false, "อีเมล์นี้เคยสมัครใช้งานเว็บไซต์แล้ว");
                }
            } else {
                dd_return(false, "ชื่อผู้ใช้ต้องมีความยาว 8 ตัวอักษรขึ้นไป และประกอบด้วยเฉพาะอักษรภาษาอังกฤษและตัวเลข");
            }
        } else {
            dd_return(false, "กรุณากรอกข้อมูลให้ครบ");
        }
    } else {
        dd_return(false, "ออกจากระบบก่อน");
    }
} else {
    dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
}
?>