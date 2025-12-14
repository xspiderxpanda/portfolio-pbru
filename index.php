<?php
require_once("system/a_func.php");
if (isset($_SESSION['id'])) {
    $q1 = dd_q("SELECT * FROM users WHERE id = ?", [$_SESSION['id']]);
    if ($q1->rowCount() == 1) {
        $user = $q1->fetch(PDO::FETCH_ASSOC);
    } else {
        session_destroy();
        $_GET['page'] = "auth";
    }
}
date_default_timezone_set('Asia/Bangkok');
$current_server_time = date("Y")."-".date("m")."-".date("d").
" ".date("H:i:s");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta property="og:title" content="<?php echo $config['name']; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://<?php echo $_SERVER['SERVER_NAME']; ?>">
    <meta property="og:image" content="<?php echo $config['logo']; ?>">
    <meta property="og:description" content="<?php echo $config['des']; ?>">
    <title><?php echo $config['name']; ?></title>
    <link rel="shortcut icon" href="<?php echo $config['logo']; ?>" type="image/png" sizes="16x16">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://kit-pro.fontawesome.com/releases/v6.2.0/css/pro.min.css" rel="stylesheet">
    <script src="https://fastly.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" type="13d076e0dcff5eb0c0a31e99-text/javascript"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js" type="13d076e0dcff5eb0c0a31e99-text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.2/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="css/mucity.css">
        <link rel="stylesheet" href="https://maketline.github.io/goodday/font/stylesheet.css" type="text/css" charset="utf-8" />

</head>
<style>
:root {
    font-family: 'line_seed_sans_th';
    --main: <?php echo $config["main_color"]; ?>;
    --sub: <?php echo $config["sec_color"]; ?>;
    --sub-opa-50: <?php echo $config["main_color"]; ?>80;
    --sub-opa-25: <?php echo $config["main_color"]; ?>;
    --primary-blue: #3B82F6;
    --secondary-cyan: #06B6D4;
    --accent-indigo: #6366F1;
    --glass-bg: rgba(255, 255, 255, 0.1);
    --glass-border: rgba(255, 255, 255, 0.2);
    --backdrop-blur: blur(20px);
}
.btnslide {
    padding: 5px 15px;
    width: 100%;
    border-radius: 16px;
    color: black;
    position: relative;
    overflow: hidden;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0);
    transition: box-shadow 0.1s ease-in;
    user-select: none;
  }
  .btnslide:active {
    box-shadow: 0px 0px 15px rgba(0, 119, 255, 0.5);
  }
  
  .btnslide:hover::before {
    animation: slidebar2 0.4s 1;
  }
  
  .btnslide::before {
    content: 'เลือกชมเลย';
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    background: var(--main);
    background: linear-gradient(315deg, var(--main), var(--sub));
    width: 100%;
    height: 100%;
    border-radius: 16px;
    top: 0;
    left: 0;
    transform: translateX(-99%);
    animation: slidebar 10s infinite;
  }
  
  .btnslide:hover::before {
    transform: translateX(0%);
  }
  
  @keyframes slidebar {
    0% {
      transform: translateX(-99%);
    }
  
    25% {
      transform: translateX(-90%);
    }
  
    50% {
      transform: translateX(-80%);
    }
  
    75% {
      transform: translateX(-95%);
    }
  
    100% {
      transform: translateX(-99%);
    }
  }
  
  @keyframes slidebar2 {
    to {
      transform: translateX(-1%);
    }
  
    from {
      transform: translateX(-99%);
    }
  }  
</style>
<body>
<?php
$navbar = [
    [
        'name' => 'HOME',
        'href' => '/home',
        'icon' => 'fa-regular fa-house-chimney',
        'show' => true
    ],
    [
        'name' => 'PORTFOLIO',
        'href' => '/portfolio',
        'icon' => 'fa-regular fa-address-book',
        'show' => true
    ],
    [
        'name' => 'NEWS',
        'href' => '/news',
        'icon' => 'fa-regular fa-bell',
        'show' => true
    ],
    [
        'name' => 'CONTACT',
        'href' => '/contact',
        'icon' => 'fa-regular fa-headset',
        'blank' => true,
        'show' => true
    ]
];
?>
<nav class="hidden lg:block fixed top-0 left-1/2 transform -translate-x-1/2 w-full max-w-screen-lg text-gray-800 border border-gray-200 shadow-md z-50 bg-white"
     style="border-radius: 0 0 1rem 1rem;"><div class="flex justify-between items-center p-2">
     
    <div class="font-bold text-lg pl-2">
      <img src="<?php echo $config['logo']; ?>" class="max-w-12">
    </div>
    
    <div class="flex space-x-4 text-sm text-gray-800">
      <?php
$username = $user['username'];
if (mb_strlen($username, 'UTF-8') > 10) {
    $shortUsername = mb_substr($username, 0, 8, 'UTF-8') . '...';
} else {
    $shortUsername = $username;
}

$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$currentPath = rtrim($currentPath, '/'); 

      foreach ($navbar as $key => $value) {
    if ($value['show']) {
        $itemHrefPath = rtrim(parse_url($value['href'], PHP_URL_PATH), '/');
        $isActive = ($currentPath === $itemHrefPath)
            ? "bg-{$config['bgcolor']} {$config['textcolor']} p-2 rounded-xl"
            : "hover:bg-gray-100 hover:rounded-xl hover:p-2 hover:text-gray-700 text-gray-800";

        $isBlank = !empty($value['blank']) ? 'target="_blank" rel="noopener"' : '';

        echo '<a href="' . htmlspecialchars($value['href']) . '" style="text-decoration:none;" class="flex flex-col justify-center items-center w-1/4 ' . $isActive . '" ' . $isBlank . '>';
        echo '<i class="' . htmlspecialchars($value['icon']) . '"></i>';
        echo '<span class="text-xs mt-1">' . htmlspecialchars($value['name']) . '</span>';
        echo '</a>';
    }
}

if ($user['role'] === "1" || $user['role'] === "2") {
    $setupPath = '/setup-portfolio';
    $isActiveProfile = ($currentPath === rtrim($setupPath, '/'))
        ? "bg-{$config['bgcolor']} {$config['textcolor']} p-2 rounded-xl"
        : "hover:bg-gray-100 hover:rounded-xl hover:p-2 hover:text-gray-700 text-gray-800";

    echo '<a href="' . $setupPath . '" style="text-decoration:none;" class="flex flex-col justify-center items-center w-1/4 ' . $isActiveProfile . '">';
    echo '<i class="fa-solid fa-user-secret"></i>';
    echo '<span class="text-xs mt-1">PROFILE</span>';
    echo '</a>';
}

      if (isset($_SESSION['id'])) {
        echo '<div class="relative group rounded-xl flex flex-col p-2 justify-center items-center w-1/4 text-white bg-' . $config['bgcolor'] . '">';
        echo '<span class="">' . htmlspecialchars($shortUsername) . '</span>';
        
        echo '<div class="absolute hidden group-hover:block top-1 bg-white shadow-lg rounded-lg hover:rounded-lg mt-8 w-32 text-sm text-gray-500">';
        echo '<a href="/profile" class="block px-4 py-2 hover:bg-gray-100" style="text-decoration:none;"><i class="fa-regular fa-user"></i>&nbsp;PROFILE</a>';
        if (admin($user)) {
        echo '<a href="/backend" class="block px-4 py-2 hover:bg-gray-100" style="text-decoration:none;">&nbspSETTING</a>';
        }
        echo '<a href="/logout" class="block px-4 py-2 hover:bg-gray-100 text-red-500" style="text-decoration:none;">&nbsp;SIGN OUT</a>';
        echo '</div>';
        
        echo '</div>';
      } else {
        echo '<a href="/auth" class="flex flex-col justify-center p-2 rounded-lg items-center w-1/4 ' . $config['textcolor'] . ' bg-' . $config['bgcolor'] . '">';
        echo '<i class="fa-regular fa-sign-in"></i>';
        echo '<span class="text-xs mt-1">LOGIN</span>';
        echo '</a>&nbsp;';
      }
      ?>
    </div>
  </div>
</nav>
   
<?php 
if(isset($_GET['true']) && $_GET['true'] === "line") {
    ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'เข้าสู่ระบบสำเร็จ',
            text: "ยินดีต้อนรับคุณ <?php echo $user['nickname']; ?>"
        }).then(function() {
            window.location = "home";
        });
    </script>
<?php 
} elseif(isset($_GET['error']) && $_GET['error'] === "line") { 
?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: "เข้าสู่ระบบไม่สำเร็จ"
        }).then(function() {
            window.location = "home";
        });
    </script>
<?php 
}?>
<?php 
if(isset($_GET['true']) && $_GET['true'] === "discord") {
    ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'เข้าสู่ระบบสำเร็จ',
            text: "ยินดีต้อนรับคุณ <?php echo $user['nickname']; ?>"
        }).then(function() {
            window.location = "home";
        });
    </script>
<?php 
} elseif(isset($_GET['error']) && $_GET['error'] === "discord") { 
?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: "เข้าสู่ระบบไม่สำเร็จ"
        }).then(function() {
            window.location = "home";
        });
    </script>
<?php 
}?>
<div class="min-h-screen bg-cover bg-center py-1">
<br>
<?php
    
    if (isset($_GET['page']) && $_GET['page'] == "menu") {
        require_once('page/simple.php');
    } elseif (isset($_GET['page']) && $_GET['page'] == "auth" && !isset($_SESSION['id'])) {
    require_once('page/auth.php');
    } elseif (isset($_GET['page']) && $_GET['page'] == "logout" && isset($_SESSION['id'])) {
        session_destroy();
        dd_q("UPDATE users SET statusonline = 0 WHERE id = ?", [$_SESSION['id']]);;
        echo "<script>window.location.href = '';</script>";
    } elseif (isset($_GET['page']) && $_GET['page'] == "profile" && isset($_SESSION['id'])) {
        require_once('page/profile.php');
    } elseif (isset($_GET['page']) && $_GET['page'] == "news") {
    require_once('page/news.php');
    } elseif (isset($_GET['page']) && $_GET['page'] == "contact") {
    require_once('page/contact.php');
    } elseif (isset($_GET['page']) && $_GET['page'] == "payment") {
    require_once('page/payment.php');
    } elseif (isset($_GET['page']) && $_GET['page'] == "portfolio") {
    require_once('page/portfolio.php');
    } elseif (isset($_GET['page']) && $_GET['page'] == "portidol") {
    require_once('page/portidol.php');
    } elseif (student($user) && isset($_GET['page']) && $_GET['page'] == "setup-portfolio" || admin($user) && isset($_GET['page']) && $_GET['page'] == "setup-portfolio") {
        require_once('page/setup-port.php');
    } elseif (student($user) && isset($_GET['page']) && $_GET['page'] == "create-profile" || admin($user) && isset($_GET['page']) && $_GET['page'] == "create-profile") {
        require_once('page/create-profile.php');
    } elseif (student($user) && isset($_GET['page']) && $_GET['page'] == "create-portfolio" && isset($_GET['id']) || admin($user) && isset($_GET['page']) && $_GET['page'] == "create-portfolio" && isset($_GET['id'])) {
        require_once('page/create-portfolio.php');
    } elseif (student($user) && isset($_GET['page']) && $_GET['page'] == "edit-portfolio" && isset($_GET['id']) || admin($user) && isset($_GET['page']) && $_GET['page'] == "edit-portfolio" && isset($_GET['id'])) {
        require_once('page/edit-portfolio.php');
    } elseif (student($user) && isset($_GET['page']) && $_GET['page'] == "idol_portfolio" && isset($_GET['id']) || admin($user) && isset($_GET['page']) && $_GET['page'] == "idol_portfolio" && isset($_GET['id'])) {
        require_once('page/idol_portfolio.php');
    } elseif (student($user) && isset($_GET['page']) && $_GET['page'] == "idol-report" && isset($_GET['id']) || admin($user) && isset($_GET['page']) && $_GET['page'] == "idol-report" && isset($_GET['id'])) {
        require_once('page/idol_report.php');
    } elseif (student($user) && isset($_GET['page']) && $_GET['page'] == "edit-profile" && isset($_GET['id']) || admin($user) && isset($_GET['page']) && $_GET['page'] == "edit-profile" && isset($_GET['id'])) {
        require_once('page/edit-profile.php');
    } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "backend") {
        require_once('page/backend/index.php');
    } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "upload") {
        require_once('page/backend/index.php');
    } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "add_idol") {
        require_once('page/backend/index.php');
    } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "news_manage") {
        require_once('page/backend/index.php');
    } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "idol") {
        require_once('page/backend/index.php');
    } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "idol_edit" && isset($_GET['id'])) {
        require_once('page/backend/index.php');   
    } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "idol_port") {
        require_once('page/backend/index.php');    
    } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "idol_portedit" && isset($_GET['id'])) {
        require_once('page/backend/index.php');   
    } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "user_edit") {
        require_once('page/backend/index.php');
    } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "website") {
        require_once('page/backend/index.php');
    }else {
            require_once('page/home.php');
    }
    ?>
  </div>
</body>
        
       
    <script>
            // function openCity(evt, cityName) {
            // var i, tabcontent, tablinks;
            // tabcontent = document.getElementsByClassName("tabcontent");
            // for (i = 0; i < tabcontent.length; i++) {
            //     tabcontent[i].style.display = "none";
            // }
            // tablinks = document.getElementsByClassName("tablinks");
            // for (i = 0; i < tablinks.length; i++) {
            //     tablinks[i].className = tablinks[i].className.replace(" active", "");
            // }
            // document.getElementById(cityName).style.display = "block";
            // evt.currentTarget.className += " active";
            // }
            // document.getElementById("defaultOpen").click();
            AOS.init();
            </script>
<?php
$footer = [
    [
        'name' => 'HOME',
        'href' => '/home',
        'icon' => 'fa-regular fa-house-chimney',
        'show' => true
    ],
    [
        'name' => 'PORTFOLIO',
        'href' => '/portfolio',
        'icon' => 'fa-regular fa-address-book',
        'show' => true
    ],
    [
        'name' => 'NEWS',
        'href' => '/news',
        'icon' => 'fa-regular fa-bell',
        'show' => true
    ],
    [
        'name' => 'PROFILE',
        'href' => '/profile',
        'icon' => 'fa-regular fa-bell',
        'show' => false
    ],
    [
        'name' => 'CONTACT',
        'href' => '/contact',
        'icon' => 'fa-regular fa-headset',
        'show' => true
    ]
];
?>
<footer class="lg:hidden fixed bottom-2 left-1/2 transform -translate-x-1/2 w-11/12 max-w-md">
    <!-- โลโก้ตรงกลาง -->
    <div class="absolute left-1/2 transform -translate-x-1/2 -top-11 bg-white p-2 rounded-full shadow-md">
        <a><img src="<?php echo $config['logo'];?>" alt="Logo" class="w-12 h-12"></a>
    </div>
    
    <div class="bg-white p-2 rounded-xl shadow-lg ">
    <?php if (isset($_SESSION['id'])) { ?>
    <div class="flex justify-between items-center text-xs text-gray-500 mb-2">
        <span class="bg-gray-100 px-2 py-2 text-sm rounded-full w-1/2"><?php echo $user['nickname'];?></span>
        <span class="bg-gray-300 px-2 py-2 text-sm rounded-full w-1/2 text-end" style="text-decoration:none;">
            <?php $RoleCheck = checkrole($user);
            echo $RoleCheck;?>
        </span>
    </div>
    <?php } ?>
        <div class="flex items-center justify-between">
            <?php
            foreach ($footer as $key => $value) {
                if ($value['show']) {
                    $isBlank = (isset($value['blank'])) ? 'target="_blank"' : '';
                    $isActive = ($_SERVER['REQUEST_URI'] == $value['href']) 
                    ? "bg-{$config['bgcolor']} {$config['textcolor']} p-2 rounded-xl items-center" 
                    : 'hover:bg-gray-100 hover:p-2 rounded-xl hover:text-gray-700';
                    echo '<a href="' . $value['href'] . '" style="text-decoration:none;" class="flex flex-col justify-center items-center w-1/5 ' . $isActive . '" ' . $isBlank . '>';
                    echo '<i class="' . $value['icon'] . ' text-xl"></i>';
                    echo '<span class="text-xs mt-1">' . $value['name'] . '</span>';
                    echo '</a>';
                }
            }
            ?>
            <div class="flex flex-col justify-center items-center w-1/5 bg-<?php echo $config['bgcolor'];?> <?php echo $config['textcolor'];?> hover:bg-gray-100 p-2 rounded-xl hover:text-gray-700 items-center">
                <?php if (!isset($_SESSION['id'])) { ?>
                 
                    <a href="/auth" class="flex flex-col items-center text-center hover:text-gray-800" style="text-decoration:none;">
                        <i class="fa-regular fa-sign-in text-xl"></i>
                        <span class="text-sm mt-1">LOGIN</span>
                </a>
                <?php } else { ?>
                    <a href="/profile" class="  flex flex-col items-center text-center hover:text-gray-700" style="text-decoration:none;">
                        <i class="fa-regular fa-user text-xl"></i>
                        <span class="text-sm mt-1"><?php echo $user['nickname'];?></span>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
</footer>

<?php include('page/footer.php');?>

</div>
</div>
</html>