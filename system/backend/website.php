<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../a_func.php';

function dd_return($status, $message) {
    $json = ['message' => $message];
    if ($status) {
        http_response_code(200);
        die(json_encode($json));
    }else{
        http_response_code(400);
        die(json_encode($json));
    }
}

#######################################

header('Content-Type: application/json; charset=utf-8;');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['id'])) {

        $q_1 = dd_q('SELECT * FROM users WHERE id = ? AND role = 2 ', [$_SESSION['id']]);
        if ($q_1->rowCount() >= 1) {
                
            
            $insert = dd_q("UPDATE setting SET name = ? , logo = ? , main_color = ? , sec_color = ? ,
            contact = ? , facebook = ? , ann = ? , linetoken = ? , bgcolor = ? , des = ?", [
                $_POST['name'],
                $_POST['logo'],
                $_POST['main_color'],
                $_POST['sec_color'],
                $_POST['contact'],
                $_POST['facebook'],
                $_POST['ann'],
                $_POST['linetoken'],
                $_POST['bgcolor'],
                $_POST['des'],
            ]);
            if($insert){
                dd_return(true, "บันทึกสำเร็จ");
            }else{
                dd_return(false, "SQL ผิดพลาด");
            }

        } else {
            dd_return(false, "เซสชั่นผิดพลาด โปรดล็อกอินใหม่");
            session_destroy();
        }

    } else {
        dd_return(false, "กรุณาเข้าสู่ระบบก่อน");
    }
                    } else {
                        dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
                    }

