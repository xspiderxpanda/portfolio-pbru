<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once '../a_func.php';

    function dd_return($roleing, $message) {
        $json = ['message' => $message];
        if ($roleing) {
            http_response_code(200);
            die(json_encode($json));
        }else{
            http_response_code(400);
            die(json_encode($json));
        }
    }

    //////////////////////////////////////////////////////////////////////////

    header('Content-Type: application/json; charset=utf-8;');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        dd_return(true, "บันทึกสำเร็จ");
        
        // if (isset($_SESSION['id'])) {

        //     if ($_POST['id'] != "" AND $_POST['role'] != "") {
        //         $q_1 = dd_q('SELECT * FROM users WHERE id = ? AND role = 2 ', [$_SESSION['id']]);
        //         $plr = $q_1->fetch(PDO::FETCH_ASSOC);

        //         if ($q_1->rowCount() >= 1) {
        //             if($_POST['password'] != ""){
        //                 $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        //                 $insert = dd_q("UPDATE users SET password = ? WHERE id = ?", [
        //                     $hashed_password,
        //                     $_POST['id'],
        //                 ]);
        //             }
        //             if($_POST['role'] != ""){
        //                 $insert = dd_q("UPDATE users SET role = ? WHERE id = ?", [
        //                     $_POST['role'],
        //                     $_POST['id'],
        //                 ]);
        //             }

        //             $roleing = $_POST['role'];
        //             switch ($roleing) {
        //                 case '0':
        //                     $roleing = "User \n";
        //                     break;
        //                 case '1':
        //                     $roleing= "Manager \n";
        //                     break;
        //                 case '2':
        //                     $roleing= "Admin \n";
        //                     break;
        //                 default:
        //                     $roleing = "ไม่พบการแก้ไข \n";
        //             }

        //             $insert = dd_q("UPDATE users SET nickname = ?, email = ? WHERE id = ?", [
        //                 $_POST['nickname'],
        //                 $_POST['email'],
        //                 $_POST['id'],
        //             ]);
        //             if($insert){
        //                 $select = dd_q("SELECT username FROM users WHERE id = ?", [$_POST['id']]);
        //                 $row = $select->fetch(PDO::FETCH_ASSOC);
                        
        //                 dd_return(true, "บันทึกสำเร็จ");
        //             }else{
        //                 dd_return(false, "SQL ผิดพลาด");
        //             }
        //         }else{
        //             dd_return(false, "เซสชั่นผิดพลาด โปรดล็อกอินใหม่");
        //             session_destroy();
        //         }
        //     }else{
        //         dd_return(false, "กรุณากรอกข้อมูลให้ครบ");
        //     }
        // }else{
        //     dd_return(false, "เข้าสู่ระบบก่อน");
        // }
    }else{
        dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
    }
?>
