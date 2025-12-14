<!-- Back Button -->
<div class="">
    <div class="container mx-auto px-4 py-6 max-w-6xl">
        <div class="flex justify-end mb-6">
            <button onclick="history.back()" 
                    class="flex items-center gap-2 px-4 py-2 bg-white text-sky-600 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:bg-sky-50 border border-sky-100">
                <i class="fa-regular fa-circle-chevron-left"></i>
                <span class="font-medium">ย้อนกลับ</span>
            </button>
        </div>

        <!-- Main Profile Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8" data-aos="fade-up">
            <!-- Profile Header -->
            <div class="bg-gradient-to-r from-sky-300 to-blue-400 p-8 text-center relative">
                <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
                <div class="relative z-10">
                    <div class="mb-4">
                        <img id="profile-image" 
                             src="<?php echo $user['img']; ?>" 
                             class="w-32 h-32 rounded-full mx-auto border-4 border-white shadow-lg object-cover" 
                             data-aos="zoom-in">
                    </div>
                    <h1 class="text-2xl font-bold text-white mb-2">
                        <i class="fa-regular fa-user mr-2"></i>
                        <?php echo $user['nickname']; ?>
                        <button onclick="Changenick()" 
                                class="ml-2 p-2 bg-white/20 rounded-full hover:bg-white/30 transition-all duration-300">
                            <i class='bx bx-message-square-edit text-lg'></i>
                        </button>
                    </h1>
                    <div class="inline-block bg-white/20 backdrop-blur-sm rounded-full px-4 py-2">
                        <p class="text-white font-medium">
                            <i class="fa-regular fa-wallet mr-2"></i>
                            ตำแหน่ง : <?php $RoleCheck = checkrole($user); echo $RoleCheck; ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Change Password Button -->
                    <button onclick="Changpassword()" 
                            class="flex items-center justify-center gap-3 p-4 bg-gradient-to-r from-sky-300 to-blue-400 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                        <div class="bg-white/20 p-2 rounded-full">
                            <i class='bx bx-message-square-edit text-lg'></i>
                        </div>
                        <span class="font-medium">เปลี่ยนรหัสผ่าน</span>
                    </button>

                    <!-- Logout Button -->
                    <a href="/logout" 
                       class="flex items-center justify-center gap-3 p-4 bg-gradient-to-r from-red-400 to-red-500 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                        <div class="bg-white/20 p-2 rounded-full">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </div>
                        <span class="font-medium">ออกจากระบบ</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Favorites Section -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden" data-aos="fade-up" data-aos-delay="200">
            <!-- Section Header -->
            <div class="bg-gradient-to-r from-sky-300 to-blue-400 p-6 text-center">
                <h2 class="text-xl font-bold text-white">
                    <i class="fa-solid fa-heart text-red-300 mr-2"></i>
                    ผู้คนที่คุณถูกใจไว้
                </h2>
            </div>

            <!-- Favorites Grid -->
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php 
                    $find = dd_q("SELECT * FROM logloveidol WHERE u_id = ? AND status_love = 1 ORDER BY id DESC", [$_SESSION['id']]);
                    $check = $find->rowCount(); 

                    if ($check == 0) { 
                        echo '<div class="col-span-full text-center py-12">
                                <div class="text-sky-300 mb-4">
                                    <i class="fa-solid fa-heart-crack text-6xl"></i>
                                </div>
                                <p class="text-gray-500 text-lg">ไม่พบการถูกใจบุคคลที่คุณอาจสนใจ</p>
                              </div>';
                    } else {
                        while ($row = $find->fetch(PDO::FETCH_ASSOC)) {
                            $theidol = dd_q("SELECT * FROM idol WHERE id = ?", [$row['idol_id']]);
                            $idol = $theidol->fetch(PDO::FETCH_ASSOC);
                    ?>
                        <div class="bg-gradient-to-br from-sky-50 to-blue-50 rounded-xl p-4 text-center shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105 cursor-pointer border-2 border-transparent hover:border-sky-300" 
                             data-aos="fade-up"
                             data-aos-delay="<?php echo 100 + ($row['id'] * 50); ?>"
                             data-id="<?php echo $row['id']; ?>"
                             data-name="<?php echo $idol['name']; ?>" 
                             data-nickname="<?php echo $idol['nickname']; ?>" 
                             data-img="<?php echo $idol['img']; ?>" 
                             data-banner="<?php echo $idol['banner']; ?>" 
                             onclick="showDetail(this)">
                             
                            <div class="mb-3">
                                <i class="fa-solid fa-heart text-red-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-sky-600 mb-1"><?php echo $idol['name']; ?></h3>
                            <p class="text-sm text-gray-500"><?php echo $row["date"]; ?></p>
                        </div>
                    <?php 
                        } 
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Detail Modal Container -->
        <div id="showInfo" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <!-- Content will be inserted here by JavaScript -->
        </div>
    </div>
</div>

<script>
let showdetailid = null; 

function showDetail(element) {
    const id = element.getAttribute("data-id");
    const name = element.getAttribute("data-name");
    const nickname = element.getAttribute("data-nickname");
    const img = element.getAttribute("data-img");
    const banner = element.getAttribute("data-banner");
    showdetailid = id;
    
    const detailSection = document.getElementById("showInfo");
    detailSection.innerHTML = `
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto overflow-hidden" data-aos="zoom-in">
            <!-- Close Button -->
            <div class="flex justify-end p-4">
                <button onclick="closeDetail()" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                    <i class="fa-solid fa-times text-gray-500"></i>
                </button>
            </div>
            
            <!-- Profile Content -->
            <div class="px-6 pb-6">
                <!-- Banner and Profile Image -->
                <div class="relative mb-8">
                    <img src="${banner}" class="w-full h-40 object-cover rounded-xl">
                    <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2">
                        <img src="${img}" class="w-16 h-16 border-4 border-white rounded-full shadow-lg">
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="text-center">
                    <div class="mb-2">
                        <i class="fa-solid fa-heart text-red-400"></i>
                        <span class="text-gray-600 ml-1">บุคคลที่ชื่นชอบ</span>
                    </div>
                    <h3 class="text-xl font-bold text-sky-600 mb-1">${name}</h3>
                    <p class="text-lg text-gray-600 mb-6">${nickname}</p>
                    
                    <!-- Action Button -->
                    <a href="/portfolio&id=${id}" 
                       class="inline-block px-6 py-3 bg-gradient-to-r from-sky-300 to-blue-400 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 font-medium">
                       <i class="fa-solid fa-external-link-alt mr-2"></i>
                       รับชมผลงานเพิ่มเติม
                    </a>
                </div>
            </div>
        </div>
    `;
    
    detailSection.classList.remove("hidden");
    document.body.style.overflow = 'hidden';
}

function closeDetail() {
    const detailSection = document.getElementById("showInfo");
    detailSection.classList.add("hidden");
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById("showInfo").addEventListener('click', function(e) {
    if (e.target === this) {
        closeDetail();
    }
});

const userNickname = <?php echo json_encode($user['nickname']); ?>;

function Changenick() {
    Swal.fire({
        title: '<span class="text-sky-600">ตั้งชื่อเล่นของคุณ</span>',
        html: `
            <div class="text-left mb-4">
                <label for="nickname" class="block text-gray-700 text-sm font-medium mb-2">กรุณาตั้งชื่อเล่นของคุณ</label>
                <input id="nickname" type="text" class="w-full px-3 py-2 border border-sky-300 rounded-lg focus:ring-2 focus:ring-sky-300 focus:border-transparent" placeholder="ตั้งชื่อเล่นของคุณที่นี่" value="${userNickname}">
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check mr-2"></i>ยืนยัน',
        cancelButtonText: '<i class="fa-solid fa-times mr-2"></i>ยกเลิก',
        buttonsStyling: false,
        customClass: {
            confirmButton: 'px-4 py-2 bg-sky-300 text-white rounded-lg hover:bg-sky-400 transition-colors mr-2',
            cancelButton: 'px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors'
        },
        focusConfirm: false,
        preConfirm: () => {
            const nickname = document.getElementById('nickname').value;
            if (!nickname) {
                Swal.showValidationMessage('กรุณากรอกข้อมูลชื่อเล่นของคุณก่อน');
                return false;
            }
            return { nickname };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const { nickname } = result.value;
            const formData = new FormData();
            formData.append('nickname', nickname);
            
            $.ajax({
                type: 'POST',
                url: 'system/cnickname.php',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ',
                            text: response.msg,
                            confirmButtonColor: '#7dd3fc'
                        }).then(function() {
                            window.location.href = `profile`;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: response.msg,
                            confirmButtonColor: '#7dd3fc'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'ข้อผิดพลาด',
                        text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้',
                        confirmButtonColor: '#7dd3fc'
                    });
                }
            });
        }
    });
}

function Changpassword() {
    Swal.fire({
        title: '<span class="text-sky-600">เปลี่ยนรหัสผ่าน</span>',
        html: `
            <div class="text-left space-y-4">
                <div>
                    <label for="old-password" class="block text-gray-700 text-sm font-medium mb-2">รหัสผ่านเก่า</label>
                    <input id="old-password" type="password" class="w-full px-3 py-2 border border-sky-300 rounded-lg focus:ring-2 focus:ring-sky-300 focus:border-transparent" placeholder="กรอกรหัสผ่านเก่า">
                </div>
                <div>
                    <label for="new-password1" class="block text-gray-700 text-sm font-medium mb-2">รหัสผ่านใหม่</label>
                    <input id="new-password1" type="password" class="w-full px-3 py-2 border border-sky-300 rounded-lg focus:ring-2 focus:ring-sky-300 focus:border-transparent" placeholder="กรอกรหัสผ่านใหม่">
                </div>
                <div>
                    <label for="new-password2" class="block text-gray-700 text-sm font-medium mb-2">ยืนยันรหัสผ่านใหม่</label>
                    <input id="new-password2" type="password" class="w-full px-3 py-2 border border-sky-300 rounded-lg focus:ring-2 focus:ring-sky-300 focus:border-transparent" placeholder="ยืนยันรหัสผ่านใหม่">
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check mr-2"></i>ยืนยัน',
        cancelButtonText: '<i class="fa-solid fa-times mr-2"></i>ยกเลิก',
        buttonsStyling: false,
        customClass: {
            confirmButton: 'px-4 py-2 bg-sky-300 text-white rounded-lg hover:bg-sky-400 transition-colors mr-2',
            cancelButton: 'px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors'
        },
        focusConfirm: false,
        preConfirm: () => {
            const oldPassword = document.getElementById('old-password').value;
            const newPassword1 = document.getElementById('new-password1').value;
            const newPassword2 = document.getElementById('new-password2').value;

            if (!oldPassword || !newPassword1 || !newPassword2) {
                Swal.showValidationMessage('กรุณากรอกรหัสผ่านให้ครบ');
                return false;
            }

            if (newPassword1 !== newPassword2) {
                Swal.showValidationMessage('รหัสผ่านใหม่ไม่ตรงกัน');
                return false;
            }

            return { oldPassword, newPassword: newPassword1 };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const { oldPassword, newPassword } = result.value;
            const formData = new FormData();
            formData.append('old_password', oldPassword);
            formData.append('new_password', newPassword);

            $.ajax({
                type: 'POST',
                url: 'system/cpassword.php',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ',
                            text: response.msg,
                            confirmButtonColor: '#7dd3fc'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: response.msg,
                            confirmButtonColor: '#7dd3fc'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'ข้อผิดพลาด',
                        text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้',
                        confirmButtonColor: '#7dd3fc'
                    });
                }
            });
        }
    });
}
</script>