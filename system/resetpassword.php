<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once 'a_func.php';

function dd_return($status, $message)
{
    if ($status) {
        $json = ['status' => 'success', 'message' => $message];
        http_response_code(200);
        die(json_encode($json));
    } else {
        $json = ['status' => 'fail', 'message' => $message];
        http_response_code(200);
        die(json_encode($json));
    }
}

header('Content-Type: application/json; charset=utf-8;');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['id'])) {
        $email = $_POST['emailforgot'];

        if (isset($_POST['get_otp'])) {
            if (!$email) {
                dd_return(false, "กรุณากรอกอีเมลก่อนทำรายการ");
            }

            $q = dd_q("SELECT * FROM users WHERE email = ?", [$email]);
            $row_count = $q->rowCount();
            if ($row_count == 1) {
                $dt = $q->fetch(PDO::FETCH_ASSOC);
                if ($dt !== false) {
                    if (!isset($_SESSION['otp_created_time']) || (time() - $_SESSION['otp_created_time']) >= 180) {
                        $otp = mt_rand(100000, 999999);
                        $otp_formatted = substr($otp, 0, 3) . '-' . substr($otp, 3, 3);

                        $ref_otp = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);

                        $_SESSION['otp'] = $otp_formatted;
                        $_SESSION['ref_otp'] = $ref_otp;
                        $_SESSION['otp_created_time'] = time();

                        $url = 'https://{$_SERVER["SERVER_NAME"]}/system/mail.php';
                        $data = json_encode(array(
                            'to' => $email,
                            'webname' => $config['name'],
                            'code' => $otp_formatted,
                            'ref' => $ref_otp
                        ));

                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => $data,
                            CURLOPT_HTTPHEADER => array(
                                'Content-Type: application/json'
                            ),
                        ));

                        $mail_response = curl_exec($curl);
                        curl_close($curl);

                        if ($mail_response) {
                            $in = dd_q("INSERT INTO forgot_password (otp, ref_otp, uid) VALUES (?, ?, ?)", [$otp_formatted, $ref_otp, $dt['id']]);
                            if ($in) {
                                $json = ['status' => 'success', 'message' => "OTP ถูกส่งไปยังอีเมลของคุณเรียบร้อยแล้ว", 'ref_otp' =>  $ref_otp];
                                http_response_code(200);
                                die(json_encode($json));
                            } else {
                                dd_return(false, "เกิดข้อผิดพลาดในการบันทึกข้อมูล OTP และ REF OTP");
                            }
                        } else {
                            dd_return(false, "เกิดข้อผิดพลาดในการส่งอีเมล");
                        }
                    } else {
                        dd_return(false, "กรุณารอ 3 นาทีก่อนทำการส่ง OTP อีกครั้ง");
                    }
                } else {
                    dd_return(false, "ไม่พบข้อมูลผู้ใช้");
                }
            } else {
                dd_return(false, "ไม่พบอีเมล์ที่ท่านแจ้งในระบบ");
            }
        } else {

            dd_return(false, "ไม่พบ REF CODE");
            // $pass = $_POST['passforgot'];
            // $cpass = $_POST['cpassforgot'];
            // $otp = $_POST['otp'];

            // if (!$email) {
            //     dd_return(false, "กรุณากรอกอีเมลก่อนทำรายการ");
            // }

            // if (!$_SESSION['ref_otp']) {
            //     dd_return(false, "ไม่พบ REF CODE");
            // }

            // if (!$pass) {
            //     dd_return(false, "กรุณากรอกรหัสผ่านก่อนทำรายการ");
            // }

            // if (!$cpass) {
            //     dd_return(false, "กรุณากรอกยืนยันรหัสผ่านก่อนทำรายการ");
            // }

            // if (!$otp) {
            //     dd_return(false, "กรุณากรอก OTP ก่อนทำรายการ");
            // }

            $forgot_password = dd_q("SELECT * FROM forgot_password WHERE otp = ? AND ref_otp = ? ", [$otp, $_SESSION['ref_otp']])->fetch(PDO::FETCH_ASSOC);
            // if ($forgot_password) {
            //     $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
            //     $reset_password = dd_q("UPDATE users SET password = ? WHERE email = ?", [$hashedPassword, $email]);

            //     if ($reset_password == true) {
            //         $delete_otp = dd_q("DELETE FROM forgot_password WHERE ref_otp = ? AND otp = ?", [$_SESSION['ref_otp'], $otp]);

            //         if ($delete_otp == true) {
            //             unset($_SESSION['otp']);
            //             unset($_SESSION['ref_otp']);
            //             unset($_SESSION['otp_created_time']);

            //             dd_return(true, "เปลี่ยนรหัสผ่านสำเร็จ!");
            //         } else {
            //             dd_return(false, "เกิดข้อผิดพลาดในการลบข้อมูล OTP และ REF OTP");
            //         }
            //     } else {
            //         dd_return(false, "เกิดข้อผิดพลาดในการเปลี่ยนรหัสผ่าน");
            //     }
            // } else {
            //     dd_return(false, "ไม่พบ OTP นี้ หรือหมดอายุแล้ว");
            // }
        }
    } else {
        dd_return(false, "กรุณาออกจากระบบก่อนดำเนินการ");
    }
} else {
    dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' ไม่ได้รับอนุญาต!");
}
?>
