<!-- Header -->
<div class="max-w-6xl mx-auto px-4">
  <div class="flex items-center justify-between py-4">
    <h3 class="text-xl font-semibold text-sky-700 tracking-tight flex items-center gap-2">
      <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-sky-100">
        <i class="fa-regular fa-user-graduate text-sky-500"></i>
      </span>
      จัดการนักศึกษา
    </h3>

    <a href="?page=add_idol"
       class="inline-flex items-center gap-2 rounded-xl border border-sky-200 bg-white px-3 py-2 text-sm font-medium text-sky-700 hover:bg-sky-50 hover:border-sky-300 focus:outline-none focus:ring-2 focus:ring-sky-300">
      <i class="fa-regular fa-circle-plus"></i>
      เพิ่มข้อมูลนักศึกษา
    </a>
  </div>
</div>

<!-- List -->
<div class="max-w-6xl mx-auto px-4 pb-6">
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
    <?php
      $get_user = dd_q("SELECT * FROM idol ORDER BY id DESC");
      while ($row = $get_user->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <!-- Card -->
    <div class="group rounded-2xl border border-sky-100 bg-white shadow-sm hover:shadow-md transition-shadow">
      <div class="flex items-start gap-4 p-4">
        <!-- Avatar -->
        <div class="shrink-0">
          <img src="<?php echo $row['img']; ?>"
               alt="ภาพของ <?php echo htmlspecialchars($row['nickname']); ?>"
               class="h-16 w-16 rounded-full object-cover ring-2 ring-sky-100" />
        </div>

        <!-- Info -->
        <div class="min-w-0 flex-1">
          <h4 class="text-base font-semibold text-sky-700 truncate">
            <?php echo htmlspecialchars($row['nickname']); ?>
          </h4>
          <p class="text-sm text-sky-500/80 truncate">
            <?php echo htmlspecialchars($row['name']); ?>
          </p>

          <!-- Actions: ผลงาน / แก้ไข / ลบ -->
          <div class="mt-3 grid grid-cols-3 gap-2">
            <a href="/portfolio&id=<?php echo $row['id']; ?>"
               class="inline-flex items-center justify-center rounded-lg border border-sky-200 bg-white px-3 py-2 text-sm text-sky-700 hover:bg-sky-50 hover:border-sky-300 focus:outline-none focus:ring-2 focus:ring-sky-300"
               aria-label="ดูผลงานของ <?php echo htmlspecialchars($row['nickname']); ?>">
              ผลงาน
            </a>

            <a href="/idol_edit&id=<?php echo $row['id']; ?>"
               class="inline-flex items-center justify-center rounded-lg border border-sky-200 bg-white px-3 py-2 text-sm text-sky-700 hover:bg-sky-50 hover:border-sky-300 focus:outline-none focus:ring-2 focus:ring-sky-300"
               aria-label="แก้ไขประวัติของ <?php echo htmlspecialchars($row['nickname']); ?>">
              แก้ไข
            </a>

            <button type="button"
                    class="inline-flex items-center justify-center rounded-lg border border-sky-200 bg-white px-3 py-2 text-sm text-sky-700 hover:bg-sky-50 hover:border-sky-300 focus:outline-none focus:ring-2 focus:ring-sky-300"
                    onclick="del('<?php echo $row['id']; ?>','<?php echo htmlspecialchars($row['nickname']); ?>')"
                    aria-label="ลบข้อมูลของ <?php echo htmlspecialchars($row['nickname']); ?>">
              ลบ
            </button>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</div>

<script>
  function del(id, username) {
    Swal.fire({
      title: 'ยืนยันที่จะลบ ?',
      text: "คุณจะลบ " + username + " จริงหรือ ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#38bdf8', // sky-400
      cancelButtonColor: '#ef4444',  // red-500
      confirmButtonText: 'ยืนยัน',
      cancelButtonText: 'ยกเลิก',
      customClass: {
        popup: 'rounded-2xl',
        confirmButton: 'rounded-xl',
        cancelButton: 'rounded-xl'
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const formData = new FormData();
        formData.append('id', id);
        $.ajax({
          type: 'POST',
          url: 'system/backend/idol_del.php',
          data: formData,
          contentType: false,
          processData: false,
        }).done(function(res) {
          Swal.fire({
            icon: 'success',
            title: 'สำเร็จ',
            text: res.message,
            confirmButtonColor: '#38bdf8'
          }).then(function() {
            window.location = "?page=<?php echo $_GET['page']; ?>";
          });
        }).fail(function(jqXHR) {
          const res = jqXHR.responseJSON || { message: 'ไม่สามารถลบได้' };
          Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: res.message,
            confirmButtonColor: '#38bdf8'
          });
        });
      }
    });
  }
</script>
