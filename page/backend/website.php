<div class="max-w mx-auto px-4">
        <div class="text-center mb-8">
            <div class="inline-flex items-center bg-white px-4 py-2 rounded-full shadow-lg border">
                <span class="bg-gray-800 p-2 px-3 rounded-full mr-3">
                    <i class="fa-duotone fa-browser text-blue-400 text-lg"></i>
                </span>
                <h3 class="text-xl font-semibold text-gray-800 m-0">ตั้งค่าเว็บไซต์</h3>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg border p-8">
            <div class="mb-8">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">การตั้งค่าสี</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            สีหลักของเว็บไซต์ <span class="text-red-500">*</span>
                        </label>
                        <input type="color" class="w-full h-12 rounded-lg border border-gray-300 cursor-pointer" id="site_main_color" value="#3b82f6">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            สีรองของเว็บไซต์ <span class="text-red-500">*</span>
                        </label>
                        <input type="color" class="w-full h-12 rounded-lg border border-gray-300 cursor-pointer" id="site_sec_color" value="#64748b">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        เลือกธีมสี <span class="text-red-500">*</span>
                    </label>
                    <select id="site_bgcolor" class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-800 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="<?php echo $config['bgcolor'];?>">โทนสีปัจจุบัน</option>
                        <option value="sky-300">โทนสีฟ้า</option>
                        <option value="red-300">โทนสีแดงชมพู</option>
                        <option value="purple-300">โทนสีม่วง</option>
                        <option value="orange-300">โทนสีส้ม</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <label class="block text-xs font-medium text-gray-600 mb-2">โทนสีฟ้า</label>
                        <input type="color" class="w-full h-10 rounded-lg border border-gray-300 cursor-pointer" value="#7dd3fc" readonly>
                    </div>
                    <div class="text-center">
                        <label class="block text-xs font-medium text-gray-600 mb-2">โทนสีแดงชมพู</label>
                        <input type="color" class="w-full h-10 rounded-lg border border-gray-300 cursor-pointer" value="#fca5a5" readonly>
                    </div>
                    <div class="text-center">
                        <label class="block text-xs font-medium text-gray-600 mb-2">โทนสีม่วง</label>
                        <input type="color" class="w-full h-10 rounded-lg border border-gray-300 cursor-pointer" value="#d8b4fe" readonly>
                    </div>
                    <div class="text-center">
                        <label class="block text-xs font-medium text-gray-600 mb-2">โทนสีส้ม</label>
                        <input type="color" class="w-full h-10 rounded-lg border border-gray-300 cursor-pointer" value="#fdba74" readonly>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">ข้อมูลพื้นฐาน</h4>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            ชื่อเว็บไซต์ <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="site_name" class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="กรอกชื่อเว็บไซต์" value="<?php echo $config['name'];?>">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            ภาพ Logo (ลิงค์) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="site_logo" class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="<?php echo $config['logo'];?>">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Discord Token <span class="text-red-500">* แจ้งเตือนผ่านโปรแกรมดิสคอร์ด</span>
                        </label>
                        <input type="text" id="linetoken" class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="กรอก Discord Token">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Banner หน้าปกแนะนำผลงาน
                        </label>
                        <input type="text" id="site_bannerbank" class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="https://example.com/banner.jpg">
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="mb-8">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">ช่องทางการติดต่อ</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Facebook <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="site_contact" class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Facebook Page URL">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            LINE@ (ลิงค์) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="site_contact_facebook" class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="LINE@ URL">
                    </div>
                </div>
            </div>

            <!-- Content Settings -->
            <div class="mb-8">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">เนื้อหา</h4>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            ข้อความประกาศ <span class="text-red-500">(หน้าเว็บไซต์)</span>
                        </label>
                        <input type="text" id="ann" class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="กรอกข้อความประกาศ">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            คำอธิบายเว็บไซต์ <span class="text-red-500">*</span>
                        </label>
                        <textarea id="site_des" rows="6" class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none" placeholder="กรอกคำอธิบายเว็บไซต์"><?php echo $config['des'];?></textarea>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center pt-4 border-t border-gray-200">
                <button class="w-full md:w-auto px-8 py-3 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors duration-200 focus:ring-4 focus:ring-green-200" id="btn_regis">
                    <i class="fas fa-save mr-2"></i>บันทึกข้อมูล
                </button>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $("#btn_regis").click(function(e) {
            e.preventDefault();
            
            var formData = new FormData();
            formData.append('name', $("#site_name").val());
            formData.append('main_color', $("#site_main_color").val());
            formData.append('bgcolor', $("#site_bgcolor").val());
            formData.append('logo', $("#site_logo").val());
            formData.append('sec_color', $("#site_sec_color").val());
            formData.append('contact', $("#site_contact").val());
            formData.append('facebook', $("#site_contact_facebook").val());
            formData.append('des', $("#site_des").val());
            formData.append('ann', $("#ann").val());
            formData.append('linetoken', $("#linetoken").val());
            formData.append('bannerbank', $("#site_bannerbank").val());

            $('#btn_regis').attr('disabled', 'disabled').html('<i class="fas fa-spinner fa-spin mr-2"></i>กำลังบันทึก...');
            
            $.ajax({
                type: 'POST',
                url: 'system/backend/website.php',
                data: formData,
                contentType: false,
                processData: false,
            }).done(function(res) {
                result = res;
                console.log(result);
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "บันทึกข้อมูลสำเร็จ",
                    text: res.message,
                    showConfirmButton: false,
                    timer: 2000,
                    toast: true,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'bg-white shadow-lg rounded-lg border border-gray-200',
                        title: 'text-sm font-semibold text-gray-800',
                        content: 'text-xs text-gray-600',
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
                        popup: 'bg-white shadow-lg rounded-lg border border-gray-200',
                        title: 'text-sm font-semibold text-gray-800',
                        content: 'text-xs text-gray-600',
                    }
                })
                $('#btn_regis').removeAttr('disabled').html('<i class="fas fa-save mr-2"></i>บันทึกข้อมูล');
            });
          
        });
    </script>