<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once 'a_func.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function send_otp_email($to, $webname, $otp, $ref)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'thsv6.hostatom.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'demo@mucity.online';
        $mail->Password = 'cxnQ3MrNvtUWWraw8MKV';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('demo@mucity.online', $webname);
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = "🔐 รหัส OTP ยืนยันตัวตนจาก $webname";
        
        // HTML Template with CSS styling
        $mail->Body = "
        <!DOCTYPE html>
        <html lang='th'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>OTP Verification</title>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                
                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    background-color: #f5f7fa;
                    color: #333;
                    line-height: 1.6;
                }
                
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #ffffff;
                    border-radius: 12px;
                    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
                    overflow: hidden;
                }
                
                .header {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    padding: 30px;
                    text-align: center;
                    color: white;
                }
                
                .header h1 {
                    font-size: 24px;
                    font-weight: 600;
                    margin-bottom: 8px;
                }
                
                .header p {
                    font-size: 14px;
                    opacity: 0.9;
                }
                
                .content {
                    padding: 40px 30px;
                }
                
                .greeting {
                    font-size: 16px;
                    margin-bottom: 20px;
                    color: #555;
                }
                
                .otp-section {
                    text-align: center;
                    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                    padding: 30px;
                    border-radius: 12px;
                    margin: 25px 0;
                }
                
                .otp-title {
                    color: white;
                    font-size: 18px;
                    font-weight: 500;
                    margin-bottom: 15px;
                }
                
                .otp-code {
                    background: rgba(255, 255, 255, 0.95);
                    display: inline-block;
                    padding: 15px 25px;
                    border-radius: 8px;
                    font-size: 28px;
                    font-weight: bold;
                    color: #333;
                    letter-spacing: 3px;
                    margin: 10px 0;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                }
                
                .ref-section {
                    background-color: #f8f9ff;
                    padding: 20px;
                    border-radius: 8px;
                    margin: 20px 0;
                    border-left: 4px solid #667eea;
                }
                
                .ref-title {
                    color: #667eea;
                    font-weight: 600;
                    font-size: 14px;
                    margin-bottom: 5px;
                }
                
                .ref-code {
                    font-family: 'Courier New', monospace;
                    font-size: 16px;
                    color: #333;
                    font-weight: 500;
                }
                
                .warning {
                    background-color: #fff3cd;
                    border: 1px solid #ffeaa7;
                    padding: 15px;
                    border-radius: 8px;
                    margin: 20px 0;
                    color: #856404;
                }
                
                .warning-icon {
                    display: inline-block;
                    margin-right: 8px;
                    font-size: 16px;
                }
                
                .security-tips {
                    background-color: #e8f4f8;
                    padding: 20px;
                    border-radius: 8px;
                    margin: 20px 0;
                    border-left: 4px solid #17a2b8;
                }
                
                .security-tips h3 {
                    color: #17a2b8;
                    font-size: 16px;
                    margin-bottom: 10px;
                }
                
                .tips-list {
                    list-style: none;
                    padding: 0;
                }
                
                .tips-list li {
                    padding: 5px 0;
                    color: #495057;
                    font-size: 14px;
                }
                
                .tips-list li:before {
                    content: '✓';
                    color: #28a745;
                    margin-right: 8px;
                    font-weight: bold;
                }
                
                .footer {
                    background-color: #f8f9fa;
                    padding: 25px 30px;
                    text-align: center;
                    color: #6c757d;
                    font-size: 14px;
                    border-top: 1px solid #e9ecef;
                }
                
                .footer p {
                    margin: 5px 0;
                }
                
                .company-name {
                    font-weight: 600;
                    color: #495057;
                }
                
                @media (max-width: 600px) {
                    .container {
                        margin: 10px;
                        border-radius: 8px;
                    }
                    
                    .header, .content, .footer {
                        padding: 20px;
                    }
                    
                    .otp-section {
                        padding: 20px;
                    }
                    
                    .otp-code {
                        font-size: 24px;
                        letter-spacing: 2px;
                    }
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>🔐 ยืนยันตัวตน</h1>
                    <p>รหัส OTP สำหรับการเข้าสู่ระบบ</p>
                </div>
                
                <div class='content'>
                    <div class='greeting'>
                        สวัสดีครับ/ค่ะ 👋
                        <br>คุณได้ขอรหัส OTP สำหรับการยืนยันตัวตนจาก <strong>$webname</strong>
                    </div>
                    
                    <div class='otp-section'>
                        <div class='otp-title'>รหัส OTP ของคุณ</div>
                        <div class='otp-code'>$otp</div>
                    </div>
                    
                    <div class='ref-section'>
                        <div class='ref-title'>หมายเลขอ้างอิง (Ref Code)</div>
                        <div class='ref-code'>$ref</div>
                    </div>
                    
                    <div class='warning'>
                        <span class='warning-icon'>⚠️</span>
                        <strong>สำคัญ:</strong> รหัส OTP นี้จะหมดอายุภายใน <strong>3 นาที</strong> 
                        กรุณาใช้งานโดยเร็วที่สุด
                    </div>
                    
                    <div class='security-tips'>
                        <h3>🛡️ ข้อควรระวังด้านความปลอดภัย</h3>
                        <ul class='tips-list'>
                            <li>อย่าแชร์รหัส OTP ให้ผู้อื่น</li>
                            <li>ตรวจสอบให้แน่ใจว่าคุณอยู่ในเว็บไซต์ที่ถูกต้อง</li>
                            <li>หากคุณไม่ได้ขอรหัสนี้ กรุณาติดต่อเราทันที</li>
                            <li>อย่ากรอกรหัส OTP ในลิงก์ที่น่าสงสัย</li>
                        </ul>
                    </div>
                </div>
                
                <div class='footer'>
                    <p class='company-name'>$webname</p>
                    <p>อีเมลนี้ถูกส่งโดยอัตโนมัติ กรุณาอย่าตอบกลับ</p>
                    <p>หากมีปัญหา กรุณาติดต่อทีมสนับสนุน</p>
                    <p style='margin-top: 15px; font-size: 12px; color: #adb5bd;'>
                        © " . date('Y') . " $webname. All rights reserved.
                    </p>
                </div>
            </div>
        </body>
        </html>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function dd_return($status, $message)
{
    $json = ['status' => $status ? 'success' : 'fail', 'message' => $message];
    http_response_code(200);
    die(json_encode($json));
}

header('Content-Type: application/json; charset=utf-8;');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['id'])) {
        $email = trim($_POST['emailforgot']);

        if (isset($_POST['get_otp'])) {

            //dd_return(true, "GET OTP");
            $q = dd_q("SELECT * FROM users WHERE email = ?", [$email]);

            if (empty($email)) {
                dd_return(false, "กรุณากรอกอีเมลก่อนทำรายการ");
            }

            
            if ($q->rowCount() == 1) {
                $user = $q->fetch(PDO::FETCH_ASSOC);

                if (!isset($_SESSION['otp_created_time']) || time() - $_SESSION['otp_created_time'] >= 0) {
                    $otp = mt_rand(100000, 999999);
                    $otp_formatted = substr($otp, 0, 3) . '-' . substr($otp, 3, 3);
                    $ref_otp = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);

                    $_SESSION['otp'] = $otp_formatted;
                    $_SESSION['ref_otp'] = $ref_otp;
                    $_SESSION['otp_created_time'] = time();

                    if (send_otp_email($email, $config['name'], $otp_formatted, $ref_otp)) {
                        $in = dd_q(
                            "INSERT INTO forgot_password (otp, ref_otp, uid, email) VALUES (?, ?, ?, ?)",
                            [$otp_formatted, $ref_otp, $user['id'], $email]
                        );
                        if ($in) {
                            dd_return(true, "OTP ถูกส่งไปยังอีเมลเรียบร้อยแล้ว");
                        } else {
                            dd_return(false, "เกิดข้อผิดพลาดในการบันทึก OTP");
                        }
                    } else {
                        dd_return(false, "ไม่สามารถส่งอีเมลได้ โปรดติดต่อผู้ดูแลระบบ");
                    }
                } else {
                    dd_return(false, "กรุณารอ 3 นาทีก่อนส่ง OTP ใหม่");
                }
            } else {
                dd_return(false, "ไม่พบบัญชีที่ใช้ email นี้");
            }
        } else {
            $pass = $_POST['passforgot'] ?? '';
            $cpass = $_POST['cpassforgot'] ?? '';
            $otp = $_POST['otp'] ?? '';

            if (empty($email) || empty($pass) || empty($cpass) || empty($otp)) {
                dd_return(false, "กรุณากรอกข้อมูลให้ครบถ้วน");
            }

            if (!isset($_SESSION['ref_otp'])) {
                dd_return(false, "ไม่พบ REF CODE กรุณาขอ OTP ใหม่");
            }

            if ($pass !== $cpass) {
                dd_return(false, "รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน");
            }

            $forgot = dd_q("SELECT * FROM forgot_password WHERE otp = ? AND ref_otp = ?", [$otp, $_SESSION['ref_otp']])->fetch(PDO::FETCH_ASSOC);
            if ($forgot) {
                $hashed = password_hash($pass, PASSWORD_DEFAULT);
                $reset = dd_q("UPDATE users SET password = ? WHERE email = ?", [$hashed, $email]);
                if ($reset) {
                    dd_q("DELETE FROM forgot_password WHERE ref_otp = ? AND otp = ?", [$_SESSION['ref_otp'], $otp]);
                    unset($_SESSION['otp'], $_SESSION['ref_otp'], $_SESSION['otp_created_time']);
                    dd_return(true, "เปลี่ยนรหัสผ่านเรียบร้อยแล้ว");
                } else {
                    dd_return(false, "เกิดข้อผิดพลาดในการเปลี่ยนรหัสผ่าน");
                }
            } else {
                dd_return(false, "รหัส OTP ไม่ถูกต้องหรือหมดอายุ");
            }
        }
    } else {
        dd_return(false, "กรุณาออกจากระบบก่อนดำเนินการ");
    }
} else {
    dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' ไม่ได้รับอนุญาต!");
}
?>
