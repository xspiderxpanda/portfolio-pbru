<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once 'a_func.php';

function dd_return($status, $message) {
    $json = ['msg' => $message];
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
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $isValid = true;
    $p = dd_q("SELECT * FROM users WHERE id = ? ", [$_SESSION['id']]);
        $plr = $p->fetch(PDO::FETCH_ASSOC);
        if (isset($_SESSION['id'])) {

            $q_1 = dd_q('SELECT * FROM users WHERE id = ?', [$_SESSION['id']]);
                if ($q_1->rowCount() >= 1) {
                    $row_1 = $q_1->fetch(PDO::FETCH_ASSOC);
                    $p = dd_q("SELECT * FROM box_product WHERE id = ? ", [$_POST['product_id']]);
                    $pd = $p->fetch(PDO::FETCH_ASSOC);
                    $cateagory = dd_q("SELECT * FROM category WHERE id = ? ", [$pd['c_type']]);
                    $cate = $cateagory->fetch(PDO::FETCH_ASSOC);
                    $point = (int) $row_1['point'];

                        if ($row_1['rank'] == 1 || $row_1['rank'] == 2) {
                            $price = (int) $pd['pricevip'];
                        } else {
                            $price = (int) $pd['price'];
                        }
                        

                        $all_price = $price;
                        if ($point >= $all_price) {
                            $find_stock = dd_q("SELECT * FROM box_stock WHERE p_id = ? LIMIT 1", [$pd['id']]);
                                if($pd['of'] == 1){

                            if ($find_stock->rowCount() == 1) {
                                $stock = $find_stock->fetch(PDO::FETCH_ASSOC);

                                $del = dd_q("DELETE FROM box_stock WHERE id = ? ", [$stock['id']]);
                                $upt = dd_q("UPDATE users SET point = point - ?  WHERE id = ? ", [$price, $_SESSION['id']]);



                                $insert = dd_q("INSERT INTO boxlog (date , username , img , category , price , prize_name , p_id ,uid,status )
                                VALUES ( NOW() , ? , ? , ? , ? , ? , ? , ? , 1 ) 
                            ", [
                                $row_1["username"],
                                $pd["img"],
                                $cate['name'] . " " . $pd["name"],
                                $pd["price"],
                                $stock["username"],
                                $pd["id"],
                                $_SESSION['id']
                            ]);

                        if ($insert and $del and $upt) {
                        echo json_encode([
                            'status' => "success",
                            'msg' => "คุณได้สั่งซื้อ {$cate['name']} {$pd['name']} เรียบร้อยแล้ว"                        
                        ]);
                    } else {
                        echo json_encode([
                            'status' => "error",
                            'msg' => "เกิดข้อผิดพลาดกรุณาแจ้งแอดมิน !"                        
                        ]);
                    }

                    } else {
                        echo json_encode([
                            'status' => "error",
                            'msg' => "ขออภัยสินค้าหมดจากสต๊อก"
                        ]);
                    }
                    } else {
                        echo json_encode([
                            'status' => "error",
                            'msg' => "ขออภัยสินค้าไม่พร้อมให้บริการขณะนี้"
                        ]);
                    }
                } else {
                    echo json_encode([
                        'status' => "error",
                        'msg' => "ยอดเงินของท่านไม่เพียงพอ"
                    ]);
                }

                } else {
                    echo json_encode([
                        'status' => "success",
                        'msg' => "ไม่พบชื่อผู้ใช้งาน"
                    ]);
                }
    } else {
        echo json_encode([
            'status' => "error",
            'msg' => "กรุณาเข้าสู่ระบบก่อนทำรายการ"
        ]);

    }
} else {
    echo json_encode([
        'status' => "error",
        'msg' => "กรุณาเลือกสินค้าก่อน"
    ]);
}
} else {
    echo json_encode([
        'status' => "error",
        'msg' => "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!"
    ]);
}
