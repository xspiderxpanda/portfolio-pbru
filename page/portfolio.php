<?php 
$id1 = dd_q("SELECT * FROM idol WHERE id = ? LIMIT 1", [$_GET['id']]);
$id = $id1->fetch(PDO::FETCH_ASSOC);
if ($id['id'] == ($_GET['id'])) {

$status = "";
if($id['position'] == 0) {
    $status = "ศิษย์เก่า";
} elseif ($id['position'] == 1) {
    $status = "นักศึกษาชั้นปีที่ 1";
} elseif ($id['position'] == 2) {
    $status = "นักศึกษาชั้นปีที่ 2";
} elseif ($id['position'] == 3) {
    $status = "นักศึกษาชั้นปีที่ 3";
} elseif ($id['position'] == 4) {
    $status = "นักศึกษาชั้นปีที่ 4";
} elseif ($id['position'] == 5) {
    $status = "นักศึกษาชั้นปีที่ 5";
}

if (!isset($_GET['id'])) : 
?>

<div class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-sky-100">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-sky-400 to-sky-500 px-8 py-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">ผลงานนักศึกษา</h1>
                        <p class="text-sky-100 text-lg">Student Portfolio Collection</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-2">
                        <p class="text-white font-medium">รับชมด้านล่าง</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6">
            <?php $find = dd_q("SELECT * FROM idol ORDER BY id ASC ");
                while ($row = $find->fetch(PDO::FETCH_ASSOC)) {
            ?>  
            <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-sky-300 hover:-translate-y-2">
                <div class="relative overflow-hidden">
                    <img src="<?php echo $row["img"];?>" 
                         class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-110" 
                         alt="<?php echo $row["nickname"];?>">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3 text-center">
                        <?php echo $row["name"];?>
                    </h3>
                    
                    <div class="space-y-3">
                        <a href="/portfolio&id=<?php echo $row["id"];?>" 
                           class="block w-full">
                            <button class="w-full bg-gradient-to-r from-sky-400 to-sky-500 hover:from-sky-500 hover:to-sky-600 text-white font-medium py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg">
                                <i class="fas fa-eye mr-2"></i>
                                ชมผลงาน
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php else : ?>
    <div class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-sky-100">
     
        <?php
$idol_id = $id['id'];
$user_ip = $_SERVER['REMOTE_ADDR'];
$time_limit = 3600;
$now = date('Y-m-d H:i:s');
$stmt = dd_q("SELECT last_view FROM idol_views WHERE idol_id = ? AND ip_address = ?", [$idol_id, $user_ip]);
$last_view = $stmt->fetch(PDO::FETCH_ASSOC);
$add_view = false;
if ($last_view) {
    $last_time = strtotime($last_view['last_view']);
    if ((time() - $last_time) > $time_limit) {
        $add_view = true;
    }
} else {
    $add_view = true;
}
if ($add_view) {
    dd_q("UPDATE idol SET view = view + 1 WHERE id = ?", [$idol_id]);

    dd_q("
        INSERT INTO idol_views (idol_id, ip_address, last_view) 
        VALUES (?, ?, ?) 
        ON DUPLICATE KEY UPDATE last_view = VALUES(last_view)
    ", [$idol_id, $user_ip, $now]);
}
?>

        <div class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-10">
            <div class="container mx-auto px-4 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="bg-sky-100 text-sky-800 px-4 py-2 rounded-xl font-medium">
                            <img src="<?php echo $id['img'];?>" 
                                         class="inline-block w-6 h-6 rounded-full border-2 border-white shadow-xl object-cover mr-3" 
                                         alt="Profile">
                            <?php echo ($id['name']); ?>
                        </div>
                    </div>
                    <button onclick="history.back()" 
                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors duration-300 font-medium">
                        <i class="fas fa-arrow-left mr-2"></i>
                        ย้อนกลับ
                    </button>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
                <div class="xl:col-span-3">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
                        <div class="relative h-64 md:h-80">
                            <img src="<?php echo $id['banner'];?>" 
                                 class="w-full h-full object-cover" 
                                 alt="Cover Image">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                            
                            <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2">
                                <div class="relative">
                                    <img src="<?php echo $id['img'];?>" 
                                         class="w-32 h-32 rounded-full border-4 border-white shadow-xl object-cover" 
                                         alt="Profile">
                                    <div class="absolute -top-2 -right-2">
                                        <?php 
                                        $idollog = dd_q("SELECT * FROM logloveidol WHERE idol_id = ? and u_id = ?", [$id['id'],$user['id']]);
                                        $log = $idollog->fetch(PDO::FETCH_ASSOC);

                                        if ($log && $log['status_love'] == 1) { ?>
                                            <button class="bg-red-500 hover:bg-gray-400 text-white p-2 rounded-full shadow-lg transition-colors duration-300">
                                                <i class="fas fa-heart loveprofile" data-id="<?php echo $id['id'];?>" data-status="0"></i>
                                            </button>
                                        <?php } elseif ($log && $log['status_love'] == 0) { ?>
                                            <button class="bg-gray-400 hover:bg-red-500 text-white p-2 rounded-full shadow-lg transition-colors duration-300">
                                                <i class="fas fa-heart loveprofile" data-id="<?= $id['id'] ?>" data-status="1"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button class="bg-gray-400 hover:bg-red-500 text-white p-2 rounded-full shadow-lg transition-colors duration-300">
                                                <i class="fas fa-heart loveprofile" data-id="<?= $id['id'] ?>"></i>
                                            </button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Profile Info -->
                        <div class="pt-20 pb-8 px-8">
                            <div class="text-center mb-6">
                                <h1 class="text-3xl font-bold text-gray-800 mb-2"><?php echo ($id['name']); ?></h1>
                                <h2 class="text-xl text-sky-500 font-semibold mb-3"><?php echo ($id['nickname']); ?></h2>
                                <div class="inline-block bg-sky-100 text-sky-800 px-4 py-2 rounded-full text-sm font-medium">
                                    <?php echo ($status); ?>
                                </div>
                            </div>
                            
                            <!-- Profile Details -->
                            <div class="bg-gray-50 rounded-xl p-6 mb-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">ข้อมูลส่วนตัว</h3>
                                <div class="space-y-3 text-gray-700">
                                    <p class="leading-relaxed"><?php echo nl2br($id['info']); ?></p>
                                    <div class="flex items-center">
                                        <i class="fas fa-birthday-cake text-sky-500 mr-3"></i>
                                        <span>วันเกิด : <?php echo convertDateToThai($id['dateofbirth']); ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Statistics -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                <div class="bg-sky-50 rounded-xl p-4 text-center">
                                    <div class="text-2xl font-bold text-sky-500"><?php echo ($id['view']); ?></div>
                                    <div class="text-sm text-gray-600">ยอดรับชม</div>
                                </div>
                                <div class="bg-red-50 rounded-xl p-4 text-center">
                                    <div class="text-2xl font-bold text-red-600"><?php echo ($id['love']); ?></div>
                                    <div class="text-sm text-gray-600">ยอดถูกใจ</div>
                                </div>
                                <div class="bg-green-50 rounded-xl p-4 text-center">
                                    
                                    <div class="text-base font-medium text-green-600"><?php echo ($id['dateupdate']); ?></div>
                                    <div class="text-xs text-gray-600 ">อัปเดตล่าสุด</div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex flex-wrap gap-3 justify-center">
                                <a href="<?php echo ($id['contact']); ?>" 
                                   class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-medium transition-colors duration-300 flex items-center">
                                    <i class="fas fa-phone mr-2"></i>
                                    ติดต่อ
                                </a>
                                <button onclick="shareOnFacebook()" 
                                        class="bg-sky-400 hover:bg-sky-500 text-white px-6 py-3 rounded-xl font-medium transition-colors duration-300 flex items-center">
                                    <i class="fab fa-facebook-f mr-2"></i>
                                    แชร์
                                </button>
                                <button onclick="copyToClipboard()" 
                                        class="bg-sky-300 hover:bg-sky-400 text-white px-6 py-3 rounded-xl font-medium transition-colors duration-300 flex items-center">
                                    <i class="fas fa-link mr-2"></i>
                                    คัดลอกลิ้งค์
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Portfolio Gallery Sidebar -->
                <div class="xl:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-images mr-3 text-sky-400"></i>
                            ผลงาน
                        </h3>
                        
                        <div class="space-y-4">
                            <?php 
                            $find = dd_q("SELECT * FROM idol_portfolio WHERE idol_id = ? ORDER BY id ASC", [$_GET['id']]);
                            while ($row = $find->fetch(PDO::FETCH_ASSOC)) {
                            ?> 
                            <div class="group bg-gray-50 hover:bg-sky-50 rounded-xl p-4 transition-all duration-300 border border-gray-100 hover:border-sky-300">
                                <div class="relative overflow-hidden rounded-lg mb-3">
                                    <img src="<?php echo $row['img'];?>" 
                                         class="w-full h-32 object-cover transition-transform duration-300 group-hover:scale-105" 
                                         alt="Portfolio">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-300"></div>
                                </div>
                                
                                <p class="text-sm text-gray-700 mb-3 line-clamp-2"><?php echo $row['title']; ?></p>
                                
                                <a href="/?page=portidol&id=<?php echo $row['id'];?>" 
                                   target="_blank"
                                   class="block w-full bg-gradient-to-r from-sky-400 to-sky-500 hover:from-sky-500 hover:to-sky-600 text-white text-center py-2 rounded-lg font-medium transition-all duration-300 text-sm">
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    ดูผลงาน
                                </a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v20.0&appId=371430855207236" nonce="FPUb5Dqq"></script>

<script>
   $(".loveprofile").click(function(e) {
       e.preventDefault();
       var button = $(this);
       var formData = new FormData();
       formData.append('id', button.attr("data-id"));
       formData.append('status_love', button.attr("data-status"));
       button.attr('disabled', 'disabled');

       $.ajax({
           type: 'POST',
           url: 'system/lovestatus.php',
           data: formData,
           contentType: false,
           processData: false,
       }).done(function(res) {
           if (res.status === 'success') {
               Swal.fire({
                   position: "bottom",
                   title: `<div class="flex items-center"><i class="fa-solid fa-check-circle text-green-500 mr-2"></i> สำเร็จ  &nbsp;<span class="text-gray-500">  ${res.message} </span></div>`,
                   showConfirmButton: false,
                   timer: 1500,
                   toast: true,
                   timerProgressBar: true,
                   customClass: {
                       popup: 'bg-white shadow-md rounded-md border border-gray-300 text-center',
                       title: 'text-sm font-semibold text-gray-800',
                       htmlContainer: 'text-xs text-gray-600',
                   },
                   showClass: {
                       popup: 'animate__animated animate__rubberBand animate__faster'
                   },
                   hideClass: {
                       popup: 'animate__animated animate__fadeOutRight animate__faster'
                   }
               }).then(function() {
                   window.location = "/<?php echo $_GET['page']; ?>&id=<?=$id['id'];?>";
               });
           } else {
               Swal.fire({
                   position: "bottom",
                   title: `<div class="flex items-center"><i class="fa-solid fa-exclamation-circle text-red-500 mr-2"></i> เกิดข้อผิดพลาด&nbsp;<span class="text-gray-500">  ${res.message} </span></div>`,
                   showConfirmButton: false,
                   timer: 3000,
                   timerProgressBar: true,
                   customClass: {
                       popup: 'bg-white shadow-md rounded-md border border-red-300',
                       title: 'text-sm font-semibold text-red-700',
                       htmlContainer: 'text-xs text-gray-600',
                   },
                   showClass: {
                       popup: 'animate__animated animate__rubberBand animate__faster'
                   },
                   hideClass: {
                       popup: 'animate__animated animate__fadeOutRight animate__faster'
                   }
               });
               button.removeAttr('disabled');
           }
       }).fail(function(jqXHR) {
           var res = jqXHR.responseJSON;
           Swal.fire({
               position: "bottom",
               title: '<div class="flex items-center"><i class="fa-solid fa-exclamation-circle text-red-500 mr-2"></i> เกิดข้อผิดพลาด</div>',
               text: res ? res.message : 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้',
               showConfirmButton: false,
               timer: 3000,
               customClass: {
                   popup: 'bg-white shadow-md rounded-md border border-red-300 p-2 w-72',
                   title: 'text-sm font-semibold text-red-700',
                   htmlContainer: 'text-xs text-gray-600',
               },
               showClass: {
                   popup: 'animate__animated animate__fadeInUp animate__faster'
               },
               hideClass: {
                   popup: 'animate__animated animate__fadeOutDown animate__faster'
               }
           });
           button.removeAttr('disabled');
       });
   });

    function shareOnFacebook() {
        const url = "https://<?php echo $_SERVER['SERVER_NAME']; ?>//portfolio&id=<?= htmlspecialchars($id['id']); ?>";
        const fbShareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
        window.open(fbShareUrl, 'facebook-share-dialog', 'width=800,height=600');
    }

    function copyToClipboard() {
        var tempInput = document.createElement("input");
        tempInput.value = window.location.href;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);

        Swal.fire({
            position: "bottom-end",
            title: '<div class="flex items-center"><i class="fa-solid fa-check-circle text-green-500 mr-2"></i> คัดลอกลิ้งค์เพื่อแชร์สำเร็จแล้ว</div>',
            showConfirmButton: false,
            timer: 1000,
            toast: true,
            timerProgressBar: true,
            customClass: {
                popup: 'bg-white shadow-md rounded-md border border-gray-300 text-center',
                title: 'text-sm font-semibold text-gray-800',
                htmlContainer: 'text-xs text-gray-600',
            },
            showClass: {
                popup: 'animate__animated animate__fadeInUp animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutDown animate__faster'
            }
        });
    }
</script>


<?php endif ?>
<?php } else { echo "<script>window.location.href = '/home';</script>"; ?>
<?php } ?>

<div class="h-20"></div>