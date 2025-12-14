<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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


header('Content-Type: application/json; charset=utf-8;');



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['id'])) {
        $img = filter_input(INPUT_POST, 'img', FILTER_VALIDATE_URL);

        if ($img !== false) {
            $user = dd_q("SELECT * FROM users WHERE id = ?", [$_SESSION['id']])->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                    $q = dd_q("UPDATE users SET img = ? WHERE id = ?", [$img, $_SESSION['id']]);
                    
                    if ($q) {
                        echo json_encode([
                            'status' => "success",
                            'msg' => "เปลี่ยนรูปภาพสำเร็จ"                        
                        ]);
                    } else {
                        echo json_encode([
                            'status' => "error",
                            'msg' => "เกิดข้อผิดพลาดกรุณาแจ้งแอดมิน"                        
                        ]);
                    }
               
            } else {
                echo json_encode([
                    'status' => "error",
                    'msg' => "กรุณาเข้าสู่ระบบก่อนดำเนินการ"                        
                ]);
            }
        } else {
            echo json_encode([
                'status' => "error",
                'msg' => "รูปแบบรูปภาพไม่ถูกต้อง"                        
            ]);
        }
    }

    dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
}
?>