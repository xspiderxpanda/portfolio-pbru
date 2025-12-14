<!-- Header Section with Sky Theme -->
<div class="bg-gradient-to-r from-sky-50 to-sky-100 p-6 rounded-2xl shadow-lg border border-sky-200 mb-8">
  <div class="flex items-center justify-between">
    <div class="flex items-center space-x-4">
      <div class="bg-gradient-to-r from-sky-400 to-sky-600 p-3 rounded-xl shadow-lg">
        <i class="fas fa-bullhorn text-white text-xl"></i>
      </div>
      <div>
        <h4 class="text-2xl font-bold text-sky-800">
          ระบบจัดการประกาศข่าวสาร
        </h4>
        <p class="text-sky-600 text-sm mt-1">จัดการและแก้ไขประกาศข่าวสารทั้งหมด</p>
      </div>
    </div>
    <button 
      onclick="toggleModal('product_insert', true)" 
      class="group flex items-center gap-3 bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200"
    >
      <i class="fas fa-plus w-5 h-5 group-hover:rotate-90 transition-transform duration-200"></i>
      <span>เพิ่มประกาศใหม่</span>
    </button>
  </div>
</div>

<!-- Table Container with Sky Theme -->
<div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-sky-200 overflow-hidden">
  <!-- Table Header -->
  <div class="bg-gradient-to-r from-sky-400 to-sky-500 px-6 py-4">
    <h2 class="text-lg font-semibold text-white flex items-center gap-2">
      <i class="fas fa-list"></i>
      รายการประกาศข่าวสารทั้งหมด
    </h2>
  </div>

  <!-- Table Content -->
  <div class="p-6">
    <div class="w-full overflow-hidden rounded-xl border border-sky-100 p-2">
      <div class="w-full overflow-x-auto">
        <table id="log-table" class="w-full whitespace-nowrap p-2">
          <thead class="p-2">
            <tr class="bg-gradient-to-r from-sky-50 to-sky-100 border-b-2 border-sky-200">
              <th class="px-6 py-4 text-left text-sky-700 font-bold text-sm uppercase tracking-wider">
                <i class="fas fa-image mr-2 text-sky-500"></i>#
              </th>
              <th class="px-6 py-4 text-left text-sky-700 font-bold text-sm uppercase tracking-wider">
                <i class="fas fa-user mr-2 text-sky-500"></i>ผู้ประกาศ
              </th>
              <th class="px-6 py-4 text-left text-sky-700 font-bold text-sm uppercase tracking-wider">
                <i class="fas fa-calendar mr-2 text-sky-500"></i>วันที่
              </th>
              <th class="px-6 py-4 text-center text-sky-700 font-bold text-sm uppercase tracking-wider">
                <i class="fas fa-cogs mr-2 text-sky-500"></i>จัดการ
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-sky-100">

<?php 
$get_user = dd_q("SELECT * FROM ann ORDER BY id DESC");
while ($row = $get_user->fetch(PDO::FETCH_ASSOC)) {
?>

            <tr class="text-sky-800 hover:bg-sky-50/50 transition-all duration-200">
              <td class="px-6 py-4">
                <div class="flex items-center text-sm">
                  <!-- Avatar with Sky Theme -->
                  <div class="relative hidden w-12 h-12 mr-4 rounded-full md:block ring-2 ring-sky-200 shadow-md overflow-hidden">
                    <img
                      class="object-cover w-full h-full rounded-full"
                      src="<?php echo $row['img']; ?>"
                      alt="ประกาศข่าวสาร"
                      loading="lazy"
                    />
                    <div class="absolute inset-0 rounded-full shadow-inner bg-gradient-to-t from-black/10 to-transparent" aria-hidden="true"></div>
                  </div>
                  <div>
                    <p class="font-semibold text-sky-800 leading-relaxed line-clamp-3" width="50px;"><?php echo $row['name']; ?></p>
                    <p class="text-xs text-sky-500 mt-1">ประกาศข่าวสาร</p>
                  </div>
                </div>
              </td>


              <td class="px-6 py-4">
                <div class="inline-flex items-center">
                  <span class="bg-sky-100 text-sky-700 px-3 py-1 rounded-full text-sm font-medium">
                    <i class="fas fa-user-tie mr-1"></i>
                    <?php echo $row['admin']; ?>
                  </span>
                </div>
              </td>

              <td class="px-6 py-4">
                <div class="flex flex-col">
                  <span class="text-sky-800 font-medium text-sm">
                    <?php echo $row['date'];?>
                  </span>
                  <span class="text-sky-500 text-xs mt-1">
                    <i class="far fa-clock mr-1"></i>เผยแพร่แล้ว
                  </span>
                </div>
              </td>

              <td class="px-6 py-4">
                <div class="flex items-center justify-center space-x-2">
                  <!-- Edit Button -->
                  <button
                    class="group flex items-center justify-center w-10 h-10 text-sm font-medium leading-5 text-white transition-all duration-200 bg-gradient-to-r from-sky-400 to-sky-500 border border-transparent rounded-full hover:from-sky-500 hover:to-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-300 shadow-lg hover:shadow-xl transform hover:scale-110"
                    title="แก้ไขประกาศ"
                    onclick="get_detail(<?php echo $row['id']; ?>)"
                  >
                    <i class="fas fa-edit w-4 h-4 group-hover:rotate-12 transition-transform duration-200"></i>
                  </button>

                  <!-- Delete Button -->
                  <button
                    class="group flex items-center justify-center w-10 h-10 text-sm font-medium leading-5 text-white transition-all duration-200 bg-gradient-to-r from-red-400 to-red-500 border border-transparent rounded-full hover:from-red-500 hover:to-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 shadow-lg hover:shadow-xl transform hover:scale-110"
                    title="ลบประกาศ"
                    onclick="del('<?php echo $row['id']; ?>','<?php echo htmlspecialchars($row['username']); ?>')"
                  >
                    <i class="fas fa-trash w-4 h-4 group-hover:shake transition-transform duration-200"></i>
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
</div>

<!-- MODAL: เพิ่มประกาศใหม่ -->
<div id="product_insert" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden justify-center items-center z-50">
  <div class="bg-white rounded-2xl w-full max-w-lg mx-4 shadow-2xl transform scale-95 transition-all duration-300">
    <!-- Modal Header -->
    <div class="bg-gradient-to-r from-sky-500 to-sky-600 px-6 py-4 rounded-t-2xl">
      <div class="flex justify-between items-center">
        <div class="flex items-center gap-3">
          <div class="bg-white/20 p-2 rounded-lg">
            <i class="fas fa-plus text-white"></i>
          </div>
          <h3 class="text-lg font-semibold text-white">เพิ่มประกาศข่าวสารใหม่</h3>
        </div>
        <button 
          onclick="toggleModal('product_insert', false)" 
          class="text-white/80 hover:text-white hover:bg-white/20 rounded-full p-2 transition-all duration-200"
        >
          <i class="fas fa-times text-lg"></i>
        </button>
      </div>
    </div>

    <!-- Modal Body -->
    <div class="p-6 text-left space-y-5">
      <div class="space-y-2">
        <label class="text-sm font-semibold text-sky-700 flex items-center gap-2">
          <i class="fas fa-heading text-sky-500"></i>
          หัวข้อประกาศ
        </label>
        <input 
          type="text" 
          id="p_name" 
          class="w-full px-4 py-3 border-2 border-sky-200 rounded-xl focus:ring-2 focus:ring-sky-400 focus:border-sky-400 transition-all duration-200 bg-sky-50/30 placeholder-sky-400"
          placeholder="ระบุหัวข้อประกาศ..."
        >
      </div>

      <div class="space-y-2">
        <label class="text-sm font-semibold text-sky-700 flex items-center gap-2">
          <i class="fas fa-align-left text-sky-500"></i>
          เนื้อหาประกาศ
        </label>
        <textarea 
          id="p_detail" 
          rows="5" 
          class="w-full px-4 py-3 border-2 border-sky-200 rounded-xl focus:ring-2 focus:ring-sky-400 focus:border-sky-400 transition-all duration-200 bg-sky-50/30 placeholder-sky-400 resize-none"
          placeholder="ระบุรายละเอียดประกาศ..."
        ></textarea>
      </div>

      <div class="space-y-2">
        <label class="text-sm font-semibold text-sky-700 flex items-center gap-2">
          <i class="fas fa-user-tie text-sky-500"></i>
          ผู้ประกาศ
        </label>
        <input 
          type="text" 
          id="p_admin" 
          class="w-full px-4 py-3 border-2 border-sky-200 rounded-xl focus:ring-2 focus:ring-sky-400 focus:border-sky-400 transition-all duration-200 bg-sky-50/30 placeholder-sky-400"
          placeholder="ชื่อผู้ประกาศ..."
        >
      </div>

      <div class="space-y-2">
        <label class="text-sm font-semibold text-sky-700 flex items-center gap-2">
          <i class="fas fa-image text-sky-500"></i>
          ลิ้งค์รูปภาพข่าวสาร
        </label>
        <input 
          type="url" 
          id="p_img" 
          class="w-full px-4 py-3 border-2 border-sky-200 rounded-xl focus:ring-2 focus:ring-sky-400 focus:border-sky-400 transition-all duration-200 bg-sky-50/30 placeholder-sky-400"
          placeholder="https://example.com/image.jpg"
        >
      </div>
    </div>

    <!-- Modal Footer -->
    <div class="flex justify-end p-6 space-x-3 border-t border-sky-100 bg-sky-50/30 rounded-b-2xl">
      <button 
        onclick="toggleModal('product_insert', false)" 
        class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-semibold transition-all duration-200 hover:shadow-md"
      >
        <i class="fas fa-times mr-2"></i>ยกเลิก
      </button>
      <button 
        id="insert_btn" 
        class="px-8 py-2.5 bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200"
      >
        <i class="fas fa-save mr-2"></i>บันทึกประกาศ
      </button>
    </div>
  </div>
</div>

<!-- MODAL: แก้ไขประกาศ -->
<div id="product_detailuser" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden justify-center items-center z-50">
  <div class="bg-white rounded-2xl w-full max-w-lg mx-4 shadow-2xl transform scale-95 transition-all duration-300">
    <!-- Modal Header -->
    <div class="bg-gradient-to-r from-sky-500 to-sky-600 px-6 py-4 rounded-t-2xl">
      <div class="flex justify-between items-center">
        <div class="flex items-center gap-3">
          <div class="bg-white/20 p-2 rounded-lg">
            <i class="fas fa-edit text-white"></i>
          </div>
          <h3 class="text-lg font-semibold text-white">แก้ไขประกาศข่าวสาร</h3>
        </div>
        <button 
          onclick="toggleModal('product_detailuser', false)" 
          class="text-white/80 hover:text-white hover:bg-white/20 rounded-full p-2 transition-all duration-200"
        >
          <i class="fas fa-times text-lg"></i>
        </button>
      </div>
    </div>

    <!-- Modal Body -->
    <div class="p-6 text-left space-y-5">
      <div class="space-y-2">
        <label class="text-sm font-semibold text-sky-700 flex items-center gap-2">
          <i class="fas fa-heading text-sky-500"></i>
          หัวข้อประกาศ
        </label>
        <input 
          type="text" 
          id="name" 
          class="w-full px-4 py-3 border-2 border-sky-200 rounded-xl focus:ring-2 focus:ring-sky-400 focus:border-sky-400 transition-all duration-200 bg-sky-50/30"
        >
      </div>

      <div class="space-y-2">
        <label class="text-sm font-semibold text-sky-700 flex items-center gap-2">
          <i class="fas fa-align-left text-sky-500"></i>
          เนื้อหาประกาศ
        </label>
        <textarea 
          id="detail" 
          rows="5" 
          class="w-full px-4 py-3 border-2 border-sky-200 rounded-xl focus:ring-2 focus:ring-sky-400 focus:border-sky-400 transition-all duration-200 bg-sky-50/30 resize-none"
        ></textarea>
      </div>

      <div class="space-y-2">
        <label class="text-sm font-semibold text-sky-700 flex items-center gap-2">
          <i class="fas fa-user-tie text-sky-500"></i>
          ผู้ประกาศ
        </label>
        <input 
          type="text" 
          id="admin" 
          class="w-full px-4 py-3 border-2 border-sky-200 rounded-xl focus:ring-2 focus:ring-sky-400 focus:border-sky-400 transition-all duration-200 bg-sky-50/30"
        >
      </div>

      <div class="space-y-2">
        <label class="text-sm font-semibold text-sky-700 flex items-center gap-2">
          <i class="fas fa-image text-sky-500"></i>
          ลิ้งค์รูปภาพข่าวสาร
        </label>
        <input 
          type="url" 
          id="img" 
          class="w-full px-4 py-3 border-2 border-sky-200 rounded-xl focus:ring-2 focus:ring-sky-400 focus:border-sky-400 transition-all duration-200 bg-sky-50/30"
        >
      </div>

      <div class="space-y-2">
        <label class="text-sm font-semibold text-sky-700 flex items-center gap-2">
          <i class="fas fa-calendar-alt text-sky-500"></i>
          วันที่อัพเดต
        </label>
        <input 
          type="text" 
          id="date" 
          class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-100 text-gray-600 cursor-not-allowed" 
          disabled
        >
      </div>
    </div>

    <!-- Modal Footer -->
    <div class="flex justify-end p-6 space-x-3 border-t border-sky-100 bg-sky-50/30 rounded-b-2xl">
      <button 
        onclick="toggleModal('product_detailuser', false)" 
        class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-semibold transition-all duration-200 hover:shadow-md"
      >
        <i class="fas fa-times mr-2"></i>ยกเลิก
      </button>
      <button 
        id="save_btn" 
        class="px-8 py-2.5 bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200"
      >
        <i class="fas fa-save mr-2"></i>บันทึกการแก้ไข
      </button>
    </div>
  </div>
</div>

                        <script>
 $(document).ready(function() {
    // Initialize DataTable
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

// ฟังก์ชัน toggleModal สำหรับ Tailwind CSS
function toggleModal(modalId, show) {
    const modal = document.getElementById(modalId);
    const modalContent = modal.querySelector('.modal-content, .bg-white');
    
    if (show) {
        // แสดง modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        // เพิ่ม animation
        setTimeout(() => {
            modalContent.style.transform = 'scale(1)';
        }, 10);
        // ป้องกันการ scroll ของ body
        document.body.style.overflow = 'hidden';
    } else {
        // ซ่อน modal
        modalContent.style.transform = 'scale(0.95)';
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }, 300);
    }
}

// ปิด modal เมื่อคลิกพื้นหลัง
$(document).on('click', '.fixed.inset-0', function(e) {
    if (e.target === this) {
        const modalId = $(this).attr('id');
        toggleModal(modalId, false);
    }
});

// ปิด modal ด้วยปุ่ม ESC
$(document).keydown(function(e) {
    if (e.key === "Escape") {
        $('.fixed.inset-0').each(function() {
            if (!$(this).hasClass('hidden')) {
                const modalId = $(this).attr('id');
                toggleModal(modalId, false);
            }
        });
    }
});

// ปุ่มบันทึกการแก้ไข
$("#save_btn").click(function(){
    var formData = new FormData();
    formData.append('id', $("#save_btn").attr("data-id"));
    formData.append('name', $("#name").val());
    formData.append('detail', $("#detail").val());
    formData.append('img', $("#img").val());
    formData.append('admin', $("#admin").val());
    
    $.ajax({
        type: 'POST',
        url: 'system/backend/ann_update.php',
        data: formData,
        contentType: false,
        processData: false,   
    }).done(function(res){
        result = res;
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ',
            text: result.message
        }).then(function() {
            window.location = "<?php echo $_GET['page'];?>";
        });
    }).fail(function(jqXHR){
        console.log(jqXHR);
        res = jqXHR.responseJSON;
        Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: res.message
        })
    });
});

// ปุ่มเพิ่มประกาศใหม่
$("#insert_btn").click(function(){
    var formData = new FormData();
    formData.append('name', $("#p_name").val());
    formData.append('detail', $("#p_detail").val());
    formData.append('img', $("#p_img").val());                
    formData.append('admin', $("#p_admin").val());

    $.ajax({
        type: 'POST',
        url: 'system/backend/ann_insert.php',
        data: formData,
        contentType: false,
        processData: false,   
    }).done(function(res){
        result = res;
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ',
            text: result.message
        }).then(function() {
            window.location = "<?php echo $_GET['page'];?>";
        });
    }).fail(function(jqXHR){
        console.log(jqXHR);
        res = jqXHR.responseJSON;
        Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: res.message
        })
    });
});

// ฟังก์ชันดึงรายละเอียดสำหรับแก้ไข
function get_detail(id){
    var formData = new FormData();
    formData.append('id', id);
    
    $.ajax({
        type: 'POST',
        url: 'system/backend/call/ann_detail.php',
        data: formData,
        contentType: false,
        processData: false,   
    }).done(function(res){
        console.log(res);
        $("#name").val(res.name);
        $("#detail").val(res.detail);
        $("#img").val(res.img);
        $("#admin").val(res.admin);
        $("#date").val(res.date);
        $("#save_btn").attr("data-id", id);
        
        // เปิด modal แก้ไข
        toggleModal('product_detailuser', true);
        
    }).fail(function(jqXHR){
        console.log(jqXHR);
        res = jqXHR.responseJSON;
        Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: res.message
        })
    });
}

// ฟังก์ชันลบข้อมูล
function del(id, username){
    Swal.fire({
        title: 'ยืนยันที่จะลบ?',
        text: "คุณแน่ใจหรอที่จะลบ   " + username,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ลบเลย',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            var formData = new FormData();
            formData.append('id', id);
            
            $.ajax({
                type: 'POST',
                url: 'system/backend/ann_del.php',
                data: formData,
                contentType: false,
                processData: false,   
            }).done(function(res){
                result = res;
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ',
                    text: result.message
                }).then(function() {
                    window.location = "<?php echo $_GET['page'];?>";
                });
            }).fail(function(jqXHR){
                console.log(jqXHR);
                res = jqXHR.responseJSON;
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: res.message
                })
            });
        }
    });
}

                        </script>