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


header('Content-Type: application/json; charset=utf-8;');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $img_id = $_POST['id'];

    if (isset($_SESSION['id'])) {
       
    if ($_POST['id'] != "") {
   

    $q_1 = dd_q('SELECT * FROM users WHERE id = ? AND role = 2', [$_SESSION['id']]);
    if ($q_1->rowCount() >= 1) {
        


    $q_img = dd_q("SELECT img_file FROM tbl_uploads WHERE no = ?", [$img_id]);
    if ($q_img->rowCount() >= 1) {
        

    $img_data = $q_img->fetch(PDO::FETCH_ASSOC);
    $img_file = $img_data['img_file'];

    // ลบไฟล์จากโฟลเดอร์
    $path = "../../upload/" . $img_file;
    if (file_exists($path)) {
        if (!unlink($path)) {
            dd_return(false, "ไม่สามารถลบไฟล์ได้");
        }
    } else {
        dd_return(false, "ไฟล์ไม่พบในโฟลเดอร์");
    }

    $delete = dd_q("DELETE FROM tbl_uploads WHERE no = ?", [$img_id]);
    if ($delete && $q_img) {
        dd_return(true, "ลบรูปภาพสำเร็จ");
    } else {
        dd_return(false, "SQL ผิดพลาด");
    }

    } else {
        dd_return(false, "ไม่พบรูปภาพที่ต้องการลบ");
    }


    }else{
                dd_return(false, "เซสชั่นผิดพลาด โปรดล็อกอินใหม่");
                session_destroy();
            }



 } else {
        dd_return(false, "กรุณาเลือกภาพที่จะลบ");
    }


 }else{
        dd_return(false, "เข้าสู่ระบบก่อน");
        }

} else {
    dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
}
?>
