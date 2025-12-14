<!-- Tailwind-styled Student Form with multi-admin selection -->
<div class="min-h-screen bg-stone-950 text-stone-100 py-8">
  <div class="mx-auto max-w-3xl px-4">
    <div class="flex items-center justify-center mb-6">
      <h3 class="text-lg sm:text-xl font-semibold tracking-tight inline-flex items-center gap-3">
        <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-stone-800">
          <i class="fa-regular fa-user-graduate text-green-300"></i>
        </span>
        เพิ่มข้อมูลนักศึกษา
      </h3>
    </div>

    <div class="rounded-2xl border border-stone-800 bg-stone-900/60 shadow-lg backdrop-blur">
      <div class="p-5 sm:p-6">
        <div class="space-y-5">
          <!-- รูปภาพ -->
          <div>
            <label for="img" class="block text-sm text-stone-300 mb-1">รูปภาพ <span class="text-red-400">*</span></label>
            <input type="text" id="img" placeholder="กรอก URL รูปภาพนักศึกษา" class="w-full rounded-xl border border-stone-700 bg-stone-950 px-3 py-2 text-sm placeholder-stone-500 focus:border-green-400 focus:outline-none focus:ring-2 focus:ring-green-400/40" />
          </div>

          <!-- รูปพื้นหลังโปรไฟล์ -->
          <div>
            <label for="banner" class="block text-sm text-stone-300 mb-1">รูปพื้นหลังโปรไฟล์ <span class="text-red-400">*</span></label>
            <input type="text" id="banner" placeholder="กรอก URL รูปภาพภาพพื้นหลังโปรไฟล์นักศึกษา" class="w-full rounded-xl border border-stone-700 bg-stone-950 px-3 py-2 text-sm placeholder-stone-500 focus:border-green-400 focus:outline-none focus:ring-2 focus:ring-green-400/40" />
          </div>

          <!-- ชื่อ-นามสกุล -->
          <div>
            <label for="name" class="block text-sm text-stone-300 mb-1">ชื่อ-นามสกุล <span class="text-red-400">*</span></label>
            <input type="text" id="name" placeholder="ชื่อและนามสกุล" class="w-full rounded-xl border border-stone-700 bg-stone-950 px-3 py-2 text-sm placeholder-stone-500 focus:border-green-400 focus:outline-none focus:ring-2 focus:ring-green-400/40" />
          </div>

          <!-- ชื่อเล่น -->
          <div>
            <label for="nickname" class="block text-sm text-stone-300 mb-1">ชื่อเล่น <span class="text-red-400">*</span></label>
            <input type="text" id="nickname" placeholder="ชื่อเล่น" class="w-full rounded-xl border border-stone-700 bg-stone-950 px-3 py-2 text-sm placeholder-stone-500 focus:border-green-400 focus:outline-none focus:ring-2 focus:ring-green-400/40" />
          </div>

          <!-- วันเดือนปีเกิด -->
          <div>
            <label for="dateofbirth" class="block text-sm text-stone-300 mb-1">วันเดือนปีเกิด <span class="text-red-400">*</span></label>
            <input type="date" id="dateofbirth" class="w-full rounded-xl border border-stone-700 bg-stone-950 px-3 py-2 text-sm placeholder-stone-500 focus:border-green-400 focus:outline-none focus:ring-2 focus:ring-green-400/40" />
          </div>

          <!-- รายละเอียด -->
          <div>
            <label for="info" class="block text-sm text-stone-300 mb-1">รายละเอียด <span class="text-red-400">*</span></label>
            <textarea id="info" rows="6" class="w-full rounded-xl border border-stone-700 bg-stone-950 px-3 py-2 text-sm placeholder-stone-500 focus:border-green-400 focus:outline-none focus:ring-2 focus:ring-green-400/40" placeholder="กรอกรายละเอียดแนะนำนักศึกษา"></textarea>
          </div>

          <!-- ตำแหน่งสถานะ -->
          <div>
            <label for="position" class="block text-sm text-stone-300 mb-1">ตำแหน่งสถานะ <span class="text-red-400">*</span></label>
            <select id="position" class="w-full rounded-full border border-stone-700 bg-stone-950 px-3 py-2 text-sm focus:border-green-400 focus:outline-none focus:ring-2 focus:ring-green-400/40">
              <option value="0">ศิษย์เก่า</option>
              <option value="1">นักศึกษาชั้นปีที่ 1</option>
              <option value="2">นักศึกษาชั้นปีที่ 2</option>
              <option value="3">นักศึกษาชั้นปีที่ 3</option>
              <option value="4">นักศึกษาชั้นปีที่ 4</option>
              <option value="5">นักศึกษาชั้นปีที่ 5</option>
            </select>
          </div>

          <!-- ช่องทางการติดต่อ -->
          <div>
            <label for="contact" class="block text-sm text-stone-300 mb-1">ช่องทางการติดต่อ <span class="text-red-400">*</span></label>
            <input type="text" id="contact" placeholder="ลิ้งค์ Facebook หรือ Line เป็นต้น" class="w-full rounded-xl border border-stone-700 bg-stone-950 px-3 py-2 text-sm placeholder-stone-500 focus:border-green-400 focus:outline-none focus:ring-2 focus:ring-green-400/40" />
          </div>

          <!-- ผู้ดูแล (เลือกได้หลายคน) -->
          <div>
            <div class="flex items-center justify-between mb-1">
              <label for="u_admin" class="block text-sm text-stone-300">ผู้ดูแล <span class="text-red-400">*</span></label>
              <span class="text-[11px] text-stone-400">เลือกได้หลายคน (กด Ctrl/Command หรือลากเมาส์)</span>
            </div>
            <select id="u_admin" multiple size="6" class="w-full rounded-xl border border-stone-700 bg-stone-950 px-3 py-2 text-sm focus:border-green-400 focus:outline-none focus:ring-2 focus:ring-green-400/40">
              <option value="">ยังไม่ระบุ</option>
              <?php 
                $find = dd_q("SELECT * FROM users ORDER BY id ASC");
                while ($row = $find->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo $row['id']; ?>"><?php echo $row['username']; ?></option>
              <?php } ?>
            </select>
            <p class="mt-1 text-xs text-stone-400">ถ้าต้องการเพิ่มผู้ดูแลหลายคน ให้กดปุ่มบวกด้านล่างหรือเลือกหลายรายการด้านบน</p>

            <!-- ปุ่มเพิ่มชื่อผู้ดูแลแบบรวดเร็ว (ใส่ไอดี) -->
            <div class="mt-3 flex gap-2">
              <input type="number" id="u_admin_quick" placeholder="พิมพ์ ID ผู้ใช้ แล้วกดเพิ่ม" class="flex-1 rounded-xl border border-stone-700 bg-stone-950 px-3 py-2 text-sm placeholder-stone-500 focus:border-green-400 focus:outline-none focus:ring-2 focus:ring-green-400/40" />
              <button type="button" id="add_admin_btn" class="rounded-xl bg-green-500/90 px-3 py-2 text-sm font-medium text-stone-900 hover:bg-green-400 active:scale-[.98]">เพิ่ม</button>
            </div>
          </div>

          <input type="hidden" id="id" value="<?php echo $id['id']; ?>" />

          <div class="pt-2">
            <button class="w-full rounded-xl bg-green-400 px-4 py-2.5 text-stone-900 font-semibold shadow hover:bg-green-300 active:scale-[.99] disabled:opacity-60" id="btn_regis">
              บันทึกข้อมูล
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // ปุ่มเพิ่มผู้ดูแลจากช่องกรอก ID อย่างรวดเร็ว
  $(document).on('click', '#add_admin_btn', function () {
    const quickId = $('#u_admin_quick').val().trim();
    if (!quickId) return;

    // ถ้ายังไม่มี option นี้ ให้สร้างใหม่
    const exists = $('#u_admin option[value="' + quickId + '"]').length > 0;
    if (!exists) {
      $('#u_admin').append('<option value="' + quickId + '">User #' + quickId + '</option>');
    }

    // เลือก option นี้ (เพิ่มเข้ากลุ่มที่เลือก)
    $('#u_admin option[value="' + quickId + '"]').prop('selected', true);
    $('#u_admin_quick').val('');
  });

  // บันทึกข้อมูล
  $(document).on('click', '#btn_regis', function (e) {
    e.preventDefault();

    const formData = new FormData();
    formData.append('name', $('#name').val());
    formData.append('nickname', $('#nickname').val());
    formData.append('img', $('#img').val());
    formData.append('banner', $('#banner').val());
    formData.append('info', $('#info').val());
    formData.append('contact', $('#contact').val());
    formData.append('dateofbirth', $('#dateofbirth').val());
    formData.append('position', $('#position').val());
    formData.append('id', $('#id').val());

    // ดึงค่าผู้ดูแลหลายคน (array)
    const admins = $('#u_admin').val() || []; // จะได้เป็น array เมื่อใช้ multiple
    // ส่งเป็น u_admin[] เพื่อให้ PHP รับเป็น array ใน $_POST['u_admin']
    admins.forEach(function (id) {
      formData.append('u_admin[]', id);
    });

    $('#btn_regis').attr('disabled', 'disabled');

    $.ajax({
      type: 'POST',
      url: 'system/backend/add_idol.php',
      data: formData,
      contentType: false,
      processData: false,
    })
      .done(function (res) {
        console.log(res);
        Swal.fire({
          position: 'bottom',
          title:
            `<div class="flex items-center"><i class="fa-solid fa-check-circle text-green-500 mr-2"></i> สำเร็จ  &nbsp;<span class="text-gray-500">  ${res.message} </span></div>`,
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
            popup: 'animate__animated animate__rubberBand animate__faster',
          },
          hideClass: {
            popup: 'animate__animated animate__fadeOutRight animate__faster',
          },
        }).then(function () {
          window.location = '?page=idol';
        });
      })
      .fail(function (jqXHR) {
        console.log(jqXHR);
        const res = jqXHR.responseJSON || { message: 'ไม่สามารถบันทึกข้อมูลได้' };
        Swal.fire({
          icon: 'error',
          title: 'เกิดข้อผิดพลาด',
          text: res.message,
        });
        $('#btn_regis').removeAttr('disabled');
      });
  });
</script>

<!-- หมายเหตุฝั่ง PHP (add_idol.php)

คาดหวังให้รับผู้ดูแลเป็น array:

  $u_admins = $_POST['u_admin'] ?? []; // จะได้ array ของ user_id
  // validate: เปลี่ยนเป็น int และกรองค่าซ้ำ
  $u_admins = array_values(array_unique(array_map('intval', $u_admins)));

จากนั้นบันทึกความสัมพันธ์ (เช่น ตาราง pivot idol_admins: idol_id, user_id)
หรือหากต้องการเก็บในฟิลด์เดียว อาจบันทึกเป็น JSON:

  $u_admin_json = json_encode($u_admins, JSON_UNESCAPED_UNICODE);

และอย่าลืมอัปเดตฝั่ง SELECT ตอนอ่านข้อมูล เพื่อแสดงผลคนที่ถูกเลือกอยู่แล้ว
-->
