<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../a_func.php';

function dd_return($status, $message) {
    $json = ['message' => $message];
    http_response_code($status ? 200 : 400);
    die(json_encode($json));
}

header('Content-Type: application/json; charset=utf-8;');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['id'])) {
        $q_1 = dd_q('SELECT * FROM users WHERE id = ? AND role = 2', [$_SESSION['id']]);
        if ($q_1->rowCount() >= 1) {

        if ((!empty($_FILES['img_file']['name']))) {
            
    $date1 = date("Ymd_His");
    $numrand = mt_rand();
    $upload = $_FILES['img_file']['name'];
    $typefile = strrchr($upload, ".");
    $path = "../../upload/";
    $newname = $numrand . $date1 . $typefile;
    $path_copy = $path . $newname;


        if (in_array($typefile, ['.jpg', '.jpeg', '.png'])) {
       
            $file_tmp = $_FILES['img_file']['tmp_name'];
            $file_content = file_get_contents($file_tmp);
            $base64_image = 'data:' . mime_content_type($file_tmp) . ';base64,' . base64_encode($file_content);

            // ส่งกลับภาพที่แปลงแล้ว
            // dd_return(true, "รูปแบบไฟล์ถูกต้องแล้ว", ['img_preview' => $base64_image]);

            
             if (move_uploaded_file($_FILES['img_file']['tmp_name'], $path_copy)) {
        
                $img_name = pathinfo($newname, PATHINFO_FILENAME);
                $insert = dd_q("INSERT INTO tbl_uploads (img_name, img_file) VALUES (?, ?)", [$img_name, $newname]);

                if ($insert) {
                dd_return(true, "บันทึกรูปภาพสำเร็จ");
                } else {
                dd_return(false, "SQL ผิดพลาด");
                }

                } else {
                    dd_return(false, "การอัปโหลดไฟล์ล้มเหลว");
                }
            } else {
                dd_return(false, "รูปแบบไฟล์ไม่ถูกต้อง");
            }

        } else {
            dd_return(false, "กรุณาแนบไฟล์รูปภาพ");
        }

    } else {
        dd_return(false, "เซสชั่นผิดพลาด โปรดล็อกอินใหม่");
        session_destroy();
    }
        
    } else {
        dd_return(false, "เข้าสู่ระบบก่อน");
    }
  
} else {
    dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
}
?>
