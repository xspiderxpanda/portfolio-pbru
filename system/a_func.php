
<?php

            session_start();
            $host = "localhost";
            $db_user = "mucity_demo";
            $db_pass = "vAKKpbSGBVEuHrHUgsbN";
            $db =  "mucity_demo";
        
            $conn = new PDO("mysql:host=$host;dbname=$db",$db_user,$db_pass);
            $conn->exec("set names utf8mb4");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            
            function dd_q($str, $arr = []) {
                global $conn;
                try {
                    $exec = $conn->prepare($str);
                    $exec->execute($arr);
                } catch (PDOException $e) {
                    return false;
                    //  return $e;
                }
                return $exec;
            }

            function check_login(){
                if(!isset($_SESSION['id'])){
                    return false;
                }else{
                    return true;
                    
                }
            }
            
            function checknull($var = []){
                foreach ($var as $key => $value) {
                    if($value == "" || empty($value) || !isset($value)){
                        return false;
                    }
                }
                return true;
            }
            function base_url(){
                return "";
            }
            
            function admin($user)
            {
                if (isset($_SESSION['id']) && $user["role"] == "2") {
                    return true;
                } else {
                    return false;
                }
            }
            function student($user)
            {
                if (isset($_SESSION['id']) && $user["role"] == "1") {
                    return true;
                } else {
                    return false;
                }
            }


            function checkrole($user) {
                global $conn;
                $rolech = dd_q("SELECT role FROM users WHERE id = ? AND role = ?", [$_SESSION['id'],$user['role']]);
                if ($row = $rolech->fetch(PDO::FETCH_ASSOC)) {
                    if ($row['role'] == '2') {
                        return "ADMIN";
                    } elseif ($row['role'] == '1') {
                        return "SPECIAL PERSON";
                    } else {
                        return "USER";
                    }
                }
                return "ROLE NOT FOUND";
            }


            function convertDateToThai($date) {
                $timestamp = strtotime($date);
                if (!$timestamp) {
                    return "วันที่ไม่ถูกต้อง";
                }
            
                $thaiMonths = [
                    1 => "มกราคม", 2 => "กุมภาพันธ์", 3 => "มีนาคม", 4 => "เมษายน",
                    5 => "พฤษภาคม", 6 => "มิถุนายน", 7 => "กรกฎาคม", 8 => "สิงหาคม",
                    9 => "กันยายน", 10 => "ตุลาคม", 11 => "พฤศจิกายน", 12 => "ธันวาคม"
                ];
            
                $day = date("j", $timestamp);
                $month = date("n", $timestamp);
                $year = date("Y", $timestamp) + 543;
            
                return "{$day} {$thaiMonths[$month]} {$year}";
            }
            

            $get_setting = dd_q("SELECT * FROM setting");
            $config = $get_setting->fetch(PDO::FETCH_ASSOC);

            $get_line = dd_q("SELECT * FROM line");
            $line = $get_line->fetch(PDO::FETCH_ASSOC);



try {
    $dbh = new PDO("mysql:host=$host;dbname=$db",$db_user,$db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql_lastviews = "DELETE FROM idol_views WHERE last_view < DATE_SUB(NOW(), INTERVAL 1 HOUR)";
    $deleted = $dbh->exec($sql_lastviews);
} catch (PDOException $e) {
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}