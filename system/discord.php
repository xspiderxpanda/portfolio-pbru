<?php
 session_start();
 error_reporting(0);
 require_once 'a_func.php';


$clientID = $discord['client'];
$clientSecret = $discord['secrets'];

$redirectURI = 'https://'.$_SERVER['SERVER_NAME'].'/system/discord.php';


$ip = $_SERVER['REMOTE_ADDR'];

if (!isset($_SESSION['id'])) {
    if ($line['of'] == 1) {

if (isset($_GET['code'])) {
    $token = getToken($_GET['code'], $clientID, $clientSecret, $redirectURI);

    $user = getUser($token);
    $avatarURL = getAvatarURL($user->id, $user->avatar);

    // echo("-------<br/>");
    // echo("DIS ID: ". $user->id . "<br/>");
    // echo("-------<br/>");
    // echo("DIS Username: ". $user->username . "<br/>");
    // echo("-------<br/>");
    // echo("DIS Global Name: ". $user->global_name . "<br/>");
    // echo("-------<br/>");
    // echo("DIS IMG: ". "<img src=".$avatarURL." /><br/>");
    // echo("-------<br/>");

    $q = dd_q("SELECT * FROM users WHERE social_id = ? ", [$user->id]);
    $random = substr(md5(uniqid(rand(), true)), 0, 5);
    $hashedPassword = password_hash($user->id, PASSWORD_DEFAULT);


    if ($q->rowCount() == 1) {
        $dt = $q->fetch(PDO::FETCH_ASSOC);
        $_SESSION['id'] = $dt['id'];
        dd_q("UPDATE users SET ip = ? , statusonline = 1 WHERE id = ?", [$ip, $_SESSION['id']]);
        header('Location: /?page=home&true=discord#login');
        exit();
    } else {
      
        $in = dd_q("INSERT INTO users (nickname,username, password, 
            ip, img, social_id, u_type , statusonline , created_at, email , failed_attempts)
             VALUES (?,?, ?, ?, ?, ?,'discord',? , NOW() , 'NULL' , '0')", [
                "mu".$random,
                $user->id,
                $hashedPassword,
                $ip,
                $avatarURL,
                $user->id,
                1
            ]);
       
        if ($in == true) {
            $q = dd_q("SELECT * FROM users WHERE social_id = ? ", [
                $user->id
            ]);
            $dt = $q->fetch(PDO::FETCH_ASSOC);
            $_SESSION['id'] = $dt['id'];
            dd_q("UPDATE users SET ip = ? , statusonline = 1 WHERE id = ?", [$ip, $_SESSION['id']]);
            header('Location: /?page=home&true=discord#reg');
            exit();
        } else {
            header('Location: /?page=home&error=discord#reg');
            exit();
        }
    }
} else {
    header('Location: https://discord.com/api/oauth2/authorize?client_id=' . $clientID . '&redirect_uri=' . urlencode($redirectURI) . '&response_type=code&scope=identify');
    exit();
}
} else {
    dd_return(false, "Sorry, Admin isn't allowed Line Login System For Website");
    header('Location: /?page=home&true=line#reg');
}
} else {
    dd_return(false, "กรุณาออกจากระบบก่อน");
}




function getToken($code, $clientID, $clientSecret, $redirectURI) {
    $data = array(
        'client_id' => $clientID,
        'client_secret' => $clientSecret,
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => $redirectURI,
        'scope' => 'identify'
    );

    $ch = curl_init('https://discord.com/api/oauth2/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);
    curl_close($ch);

    $token = json_decode($response)->access_token;
    return $token;
}

function getUser($token) {
    $ch = curl_init('https://discord.com/api/users/@me');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $token
    ));
    $response = curl_exec($ch);
    curl_close($ch);

    $user = json_decode($response);
    return $user;
}

function getAvatarURL($userID, $avatarHash, $size = 128) {
    $avatarSize = $size != null ? '?size=' . $size : '';
    return 'https://cdn.discordapp.com/avatars/' . $userID . '/' . $avatarHash . '.png' . $avatarSize;
}


?>
