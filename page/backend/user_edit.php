 <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">ระบบจัดการสมาชิก</h1>
            <p class="text-gray-600">จัดการข้อมูลสมาชิกและสิทธิ์การใช้งาน</p>
        </div>

        <!-- Table Container -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden p-4">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">รายชื่อสมาชิก</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table id="log-table" class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ข้อมูลส่วนตัว</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">บทบาท</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">วันที่สมัคร</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php 
                        $get_user = dd_q("SELECT * FROM users ORDER BY id DESC");
                        while ($row = $get_user->fetch(PDO::FETCH_ASSOC)) {
                            
                            if($row['role'] == 0){
                                $roleing = '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                    <i class="fas fa-user mr-2 text-green-600"></i>สมาชิกทั่วไป
                                </span>'; 
                            } elseif($row['role'] == 1) {
                                $roleing = '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                    <i class="fas fa-graduation-cap mr-2 text-blue-600"></i>นักศึกษา/ศิษย์เก่า
                                </span>';
                            } elseif($row['role'] == 2){
                                $roleing = '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-50 text-purple-700 border border-purple-200">
                                    <i class="fas fa-crown mr-2 text-purple-600"></i>แอดมิน
                                </span>';
                            } else{
                                $roleing = '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">
                                    <i class="fas fa-ban mr-2 text-red-600"></i>แบน/ระงับใช้งาน
                                </span>';  
                            }
                        ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                <?php echo $row['id'];?>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <img class="h-12 w-12 rounded-full object-cover border-2 border-gray-100" 
                                             src="<?php echo $row['img']; ?>" 
                                             alt="<?php echo $row['username'];?>" loading="lazy">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?php echo $row['nickname']; ?></div>
                                        <div class="text-sm text-gray-500">@<?php echo $row['username'];?></div>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php echo $roleing ;?>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar text-gray-400 mr-2"></i>
                                    <?php echo $row['created_at'] ;?>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center space-x-2">
                                    <button onclick="get_detail(<?php echo $row['id']; ?>)" 
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 hover:text-blue-700 transition-colors">
                                        <i class="fas fa-edit mr-1"></i>
                                        แก้ไข
                                    </button>
                                    <button onclick="del('<?php echo $row['id']; ?>','<?php echo htmlspecialchars($row['username']); ?>')"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 hover:text-red-700 transition-colors">
                                        <i class="fas fa-trash mr-1"></i>
                                        ลบ
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

      <div id="product_detailuser" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white rounded-xl w-full max-w-lg mx-4 shadow-xl">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="bg-blue-50 p-2 rounded-lg mr-3">
                        <i class="fas fa-user-edit text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">แก้ไขข้อมูลสมาชิก</h3>
                </div>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6 space-y-6">
                <!-- Top Section: Profile Picture + Username & Password -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Profile Picture (Left) -->
                    <div class="md:col-span-1 flex flex-col items-center">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-3 text-center">รูปโปรไฟล์</label>
                            <div class="relative">
                                <img id="img" src="https://via.placeholder.com/150" 
                                     alt="Profile Picture" 
                                     class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 shadow-md">
                                <div class="absolute bottom-2 right-2 bg-blue-500 text-white rounded-full p-2 shadow-lg">
                                    <i class="fas fa-camera text-sm"></i>
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 text-center">รูปโปรไฟล์ผู้ใช้</p>
                    </div>

                    <!-- Username & Password (Right) -->
                    <div class="md:col-span-2 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                            <input type="text" id="username" 
                                   class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-500 focus:outline-none" 
                                   disabled>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">รหัสผ่านผู้ใช้งาน</label>
                            <input type="password" id="password" 
                                   class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" 
                                   placeholder="ระบุรหัสผ่านใหม่ เมื่อต้องการเปลี่ยนแปลง">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                        <input type="text" id="nickname" 
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="text" id="email" 
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                        <select id="role" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                        </select>
                    </div>  

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">IP Lastly Login</label>
                        <input type="text" id="ip" 
                                   class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-500 focus:outline-none" 
                                   disabled>
                    </div>                   
                 
                </div>
            </div>
            <div class="flex justify-end p-6 space-x-3 border-t border-gray-200">
                <button onclick="closeModal()" 
                        class="px-6 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    ยกเลิก
                </button>
                <button id="save_btn" 
                        class="px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>บันทึกการเปลี่ยนแปลง
                </button>
            </div>
        </div>
    </div>




                        <script>
 $(document).ready(function() {
    $('#log-table').DataTable({
      "pageLength": 10,
      "language": {
        "search": "ค้นหา:",
        "lengthMenu": "แสดง _MENU_ รายการ",
        "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
        "paginate": {
          "first": "หน้าแรก",
          "last": "หน้าสุดท้าย",
          "next": "ถัดไป",
          "previous": "ก่อนหน้า"
        },
        "zeroRecords": "ไม่พบข้อมูล",
      }
    });
  });


  document.addEventListener("DOMContentLoaded", function() {
        const roleLabels = {
            'ban': "แบน/ระงับ",
            '0': "สมาชิกทั่วไป",
            '1': "นักศึกษา/ศิษย์เก่า",
            '2': "แอดมิน"
        };

        const roleDropdown = document.getElementById('role');

        function populateroleOptions() {
            for (const [roleValue, roleLabel] of Object.entries(roleLabels)) {
                const option = document.createElement('option');
                option.value = roleValue;
                option.text = roleLabel;
                roleDropdown.appendChild(option);
            }
        }
        populateroleOptions();
    });

function del(id, username) {
        Swal.fire({
            title: 'ยืนยันที่จะลบ ?',
            text: "คุณแน่ใจหรอที่จะลบผู้ใช้  " + username,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยันลบเลย',
            customClass: {
                                popup: 'warning-mu',
                                confirmButton: 'Swal-Button',
                                cancelButton: 'Swal-cButton',
                                }
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('id', id);
                $.ajax({
                    type: 'POST',
                    url: 'system/backend/user_del.php',
                    data: formData,
                    contentType: false,
                    processData: false,
                }).done(function(res) {
                    result = res;
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ',
                        text: result.message,
                        customClass: {
                                    popup: 'success-mu',
                                    confirmButton: 'Swal-Button',
                                }
                    }).then(function() {
                        window.location = "<?php echo $_GET['daisy']; ?>";
                    });
                }).fail(function(jqXHR) {
                    console.log(jqXHR);
                    res = jqXHR.responseJSON;
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: res.message,
                        customClass: {
                                popup: 'error-mu',
                                confirmButton: 'Swal-Button',
                                
                                }
                    })
                });
            }
        })


    }


    $("#save_btn").click(function() {
        var formData = new FormData();
        formData.append('id', $("#save_btn").attr("data-id"));
        formData.append('nickname', $("#nickname").val());
        formData.append('password', $("#password").val());
        formData.append('role', $("#role").val());

        $.ajax({
            type: 'POST',
            url: 'system/backend/user_setting.php',
            data: formData,
            contentType: false,
            processData: false,
        }).done(function(res) {
            result = res;
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ',
                text: result.message,
                customClass: {
                                popup: 'success-mu',
                                confirmButton: 'Swal-Button',
                                cancelButton: 'Swal-cButton',
                                }
            }).then(function() {
                location.reload();
            });
        }).fail(function(jqXHR) {
            console.log(jqXHR);
            res = jqXHR.responseJSON;
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: res.message,
                customClass: {
                                popup: 'error-mu',
                                confirmButton: 'Swal-Button',
                                cancelButton: 'Swal-cButton',
                                }
            })
        });
    });


    function openModal() {
    const modal = document.getElementById("product_detailuser");
    modal.classList.remove("hidden");
    modal.classList.add("flex");
  }

  function closeModal() {
    const modal = document.getElementById("product_detailuser");
    modal.classList.remove("flex");
    modal.classList.add("hidden");
  }

  function get_detail(id) {
    var formData = new FormData();
    formData.append('id', id);

    $.ajax({
        type: 'POST',
        url: 'system/backend/call/user_detail.php',
        data: formData,
        contentType: false,
        processData: false,
    }).done(function(res) {
        $("#username").val(res.username);
        $("#nickname").val(res.nickname);
        $("#role").val(res.role);
        $("#ip").val(res.ip);
        $("#email").val(res.email);
        $("#social_id").val(res.social_id);
        $("#created_at").val(res.created_at);
        $("#img").attr('src', res.img || 'https://demo.mucity.online/img/itlogo.png');
        $("#save_btn").attr("data-id", id);
        openModal();
    }).fail(function(jqXHR) {
        res = jqXHR.responseJSON;
        Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: res.message,
            customClass: {
                                popup: 'error-mu',
                                confirmButton: 'Swal-Button',
                                cancelButton: 'Swal-cButton',
                                }
        });
    });
  }

                        </script>