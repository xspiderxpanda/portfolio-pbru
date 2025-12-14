<?php
session_start();
// error_reporting(E_ALL);
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
        http_response_code(400);
        die(json_encode($json));
    }
}

// //////////////////////////////////////////////////////////////////////////

header('Content-Type: application/json; charset=utf-8;');


if (!isset($_SESSION['id'])) {
    if ($line['of'] == 1) {
if (isset($_GET['code'])) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $code = $_GET['code'];
    $data = [
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => "https://{$_SERVER['SERVER_NAME']}/system/line.php",
        'client_id' => $line['clientid'],
        'client_secret' => $line["secretid"]
    ];

    $token_url = 'https://api.line.me/oauth2/v2.1/token';

    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query($data)
        ]
    ]);

    $response = file_get_contents($token_url, false, $context);
    $token_data = json_decode($response, true);

    if (isset($token_data['access_token'])) {
        $access_token = $token_data['access_token'];

        $profile_url = 'https://api.line.me/v2/profile';
        $profile_response = file_get_contents($profile_url, false, stream_context_create([
            'http' => [
                'header' => "Authorization: Bearer $access_token"
            ]
        ]));
        
        $profile_data = json_decode($profile_response, true);

        $q = dd_q("SELECT * FROM users WHERE social_id = ?", [$profile_data['userId']]);
        if ($q->rowCount() == 1) {
            $dt = $q->fetch(PDO::FETCH_ASSOC);
            $_SESSION['id'] = $dt['id'];
            dd_q("UPDATE users SET img = ? , ip = ? , statusonline = 1 WHERE id = ?", [$profile_data['pictureUrl'],$ip, $_SESSION['id']]);
            header('Location: /?page=home&true=line#login');
            exit();
        } else {
            $random = substr(md5(uniqid(rand(), true)), 0, 5);
            $hashedPassword = password_hash($profile_data['userId'], PASSWORD_DEFAULT);
            $in = dd_q("INSERT INTO users (nickname,username, password, 
            ip, img, social_id, u_type , statusonline , created_at , email , failed_attempts)
             VALUES (?,?, ?, ?, ?, ?,'line',? , NOW() , 'NULL' , '0')", [
                "mu".$random,
                $profile_data['userId'],
                $hashedPassword,
                $ip,
                $profile_data['pictureUrl'],
                $profile_data['userId'],
                1
            ]);
            if ($in) {
                $q = dd_q("SELECT * FROM users WHERE social_id = ?", [$profile_data['userId']]);
                $dt = $q->fetch(PDO::FETCH_ASSOC);
                $_SESSION['id'] = $dt['id'];
                dd_q("UPDATE users SET ip = ? , statusonline = 1 WHERE id = ?", [$ip, $_SESSION['id']]);
                header('Location: /?page=home&true=line#reg');
                exit();
            } else {
                dd_return(false, "Error occurred while registering user.");
                header('Location: /?page=home&true=line#reg');
                exit();
            }
        }
    } else {
        dd_return(false, "Failed to obtain access token.");
        header('Location: /?page=home&true=line#reg');
        exit();
    }
}

    } else {
        dd_return(false, "Sorry, Admin isn't allowed Line Login System For Website");
        header('Location: /?page=home&true=line#reg');
    }
 } else {
        dd_return(false, "กรุณาออกจากระบบก่อน");
    }
?>
