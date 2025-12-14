<?php

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
  http_response_code(400);
  die('Bad request');
}
$idol_id = (int)$_GET['id'];


if (!isset($_SESSION['id'])) {
  die('กรุณาเข้าสู่ระบบ');
}
$q_user = dd_q('SELECT * FROM users WHERE id = ?', [$_SESSION['id']]);
if ($q_user->rowCount() < 1) {
  die('ไม่พบผู้ใช้');
}
$plr = $q_user->fetch(PDO::FETCH_ASSOC);
if (!isset($plr['role']) || ($plr['role'] !== "1" && $plr['role'] !== "2")) {
  die('คุณไม่มีสิทธิ์แก้ไขโปรไฟล์ไอดอล');
}

$id1 = dd_q("SELECT * FROM idol WHERE id = ? AND FIND_IN_SET(?, u_admin)", [$idol_id, $_SESSION['id']]);
$id = $id1->fetch(PDO::FETCH_ASSOC);
if (!$id) {
  die('ไม่พบข้อมูล หรือคุณไม่มีสิทธิ์แก้ไขรายการนี้');
}

// ฟังก์ชันช่วยสำหรับ escape
function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

$majorsStmt = dd_q('SELECT id, name FROM major ORDER BY name ASC');
$majors = $majorsStmt ? $majorsStmt->fetchAll(PDO::FETCH_KEY_PAIR) : [];

$currentMajorId   = (string)($id['major_id'] ?? '');
$currentMajorText = $majors[$currentMajorId] ?? '—';

function position_text($v){
  $v = (int)$v;
  if ($v === 99) return 'ศิษย์เก่า';
  if ($v >= 1 && $v <= 4) return "นักศึกษาปี $v";
  return '—';
}
?>


<main class="max-w-6xl mx-auto px-4 mt-6 space-y-6">
  <section>
    <div class="bg-white rounded-2xl shadow overflow-hidden">
      <div class="relative">
        <img id="previewBanner" src="<?php echo h($id['banner'] ?: 'https://placehold.co/1200x400?text=Banner'); ?>" class="w-full h-52 object-cover" alt="">
        <img id="previewImg" src="<?php echo h($id['img'] ?: 'https://placehold.co/200x200?text=Avatar'); ?>"
             class="w-36 h-36 object-cover rounded-full ring-4 ring-white absolute left-6 -bottom-14" alt="">
      </div>
      
      <div class="pt-16 px-6 pb-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
          <div>
            <h1 id="previewName" class="text-2xl font-bold leading-tight"><?php echo h($id['name'] ?: 'ชื่อจริง'); ?></h1>
            <p id="previewNick" class="text-gray-500 -mt-0.5"><?php echo $id['nickname'] ? '('.h($id['nickname']).')' : '(@nickname)'; ?></p>
          </div>
        </div>


        <div id="previewInfo" class="mt-4 text-sm text-gray-700 whitespace-pre-wrap">
          <?php echo h($id['info'] ?: 'เขียนแนะนำตัวไว้ตรงนี้แล้วจะพรีวิว…'); ?>
        </div>
        <div class="mt-4 text-xs text-gray-500">
          วันเกิด: <span id="previewDob"><?php echo h($id['dateofbirth'] ?: 'YYYY-MM-DD'); ?>
          <br>สาขา/หมวด: <span id="previewMajor"><?php echo h($currentMajorText); ?></span>
        </div>
        <div class="mt-2 text-xs text-gray-500">
          ช่องทางติดต่อ: <a id="previewContact" href="<?php echo h($id['contact'] ?: '#'); ?>" class="text-sky-600 hover:underline"><?php echo h($id['contact'] ?: '—'); ?></a>
        </div>
      </div>

    <div class="w-full text-center items-center mt-2 mb-2">
  <a href="/idol-report?id=<?php echo (int)$idol_id; ?>"
     class="inline-flex items-center px-4 py-2 w-full text-center rounded-xl bg-emerald-500 text-white hover:brightness-110"
     rel="noopener">
    ทำรายงาน / ดูหน้า Report
  </a>
</div>
    </div>

 

  </section>

  
<section>
  <div class="bg-white rounded-2xl shadow p-5 space-y-4 mb-3">
    <h2 class="text-lg font-semibold">
      โปรไฟล์ผลงาน <?php echo $id['nickname'] ? '('.h($id['nickname']).')' : '(@nickname)'; ?>
    </h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 mb-12 max-w-5xl mx-auto">
      <?php 
        $find = dd_q("SELECT * FROM idol_portfolio WHERE idol_id = ?", [$_GET['id']]);
        while ($row = $find->fetch(PDO::FETCH_ASSOC)) { 
      ?>  
      <!-- Portfolio Card -->
      <div
        class="group cursor-pointer transform transition-all duration-300 hover:scale-105"
        onclick="openEditModalFromEl(this)"
        data-id="<?php echo (int)$row['id'];?>"
        data-title="<?php echo h($row['title']);?>"
        data-detail="<?php echo h($row['detail']);?>"
        data-img="<?php echo h($row['img']);?>"
        data-url="<?php echo h($row['url']);?>"
        data-github="<?php echo h($row['github']);?>"
        data-facebook="<?php echo h($row['facebook']);?>"
        data-pdf="<?php echo h($row['pdf']);?>"
      >
        <div class="text-center">
          <!-- Portfolio Image -->
          <div class="relative w-28 h-28 mx-auto rounded-2xl overflow-hidden mb-3 shadow-lg border-3 border-white group-hover:border-sky-300 group-hover:shadow-xl transition-all duration-300">
            <img src="<?php echo h($row['img']);?>" 
                 class="w-full h-full object-cover transition-transform duration-300" 
                 alt="<?php echo h($row['title']);?>">
            <!-- Hover overlay -->
            <div class="absolute inset-0 bg-sky-400 bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center pointer-events-none">
              <i class="fas fa-edit text-white opacity-0 group-hover:opacity-100 text-xl transition-opacity duration-300"></i>
            </div>
          </div>
          <!-- Portfolio Title -->
          <h3 class="text-sm font-medium text-gray-700 group-hover:text-sky-400 transition-colors duration-300 px-2 leading-tight" 
              style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; word-break: break-word; line-height: 1.3; max-height: 2.6em;"
              title="<?php echo h($row['title']); ?>">
            <?php echo h($row['title']);?>
          </h3>
        </div>
      </div>
      <?php } ?>

      <!-- Add New Portfolio (คงเดิม) -->
      <div class="group cursor-pointer transform transition-all duration-300 hover:scale-105">
        <a href="/create-portfolio&id=<?php echo (int)($_GET['id']); ?>">
          <div class="text-center">
            <div class="w-28 h-28 mx-auto rounded-2xl bg-sky-50 border-2 border-dashed border-sky-300 group-hover:border-sky-500 mb-3 transition-all duration-300 group-hover:bg-sky-100 flex items-center justify-center">
              <div class="text-center">
                <i class="fas fa-plus text-2xl text-sky-400 group-hover:text-sky-500 mb-1 transition-colors duration-300"></i>
                <div class="text-xs text-sky-500 group-hover:text-sky-600 transition-colors duration-300">จัดการผลงาน</div>
              </div>
            </div>
            <h3 class="text-base font-medium text-sky-500 group-hover:text-sky-600 transition-colors duration-300">
              สร้างหรือจัดการผลงานทั้งหมด
            </h3>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Edit Portfolio Modal -->
<div id="editModal" class="fixed inset-0 z-50 hidden">
  <div class="absolute inset-0 bg-slate-900/40" data-close="modal"></div>
  <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-[95vw] max-w-2xl">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
      <div class="p-4 border-b flex items-center justify-between">
        <h3 class="font-semibold text-slate-800">
          แก้ไขผลงาน <span id="editTitleSuffix" class="text-slate-400"></span>
        </h3>
        <button class="px-2 py-1 text-slate-500 hover:text-slate-800" data-close="modal">ปิด</button>
      </div>

      <form id="editForm" class="p-4 grid gap-3">
        <input type="hidden" name="port_id" id="editId">
        <div>
          <label class="block text-sm mb-1">หัวเรื่อง *</label>
          <input name="title" id="editTitle" required class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-300">
        </div>
        <div>
          <label class="block text-sm mb-1">รายละเอียด *</label>
          <textarea name="detail" id="editDetail" rows="4" required class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-300"></textarea>
        </div>
        <div class="grid sm:grid-cols-2 gap-3">
          <div>
            <label class="block text-sm mb-1">รูปหลัก (URL)</label>
            <input name="img" id="editImg" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-300">
          </div>
          <div>
            <label class="block text-sm mb-1">ลิงก์ผลงาน</label>
            <input name="url" id="editUrl" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-300">
          </div>
          <div>
            <label class="block text-sm mb-1">GitHub</label>
            <input name="github" id="editGithub" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-300">
          </div>
          <div>
            <label class="block text-sm mb-1">Facebook (URL)</label>
            <input name="facebook" id="editFacebook" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-300">
          </div>
          <div class="sm:col-span-2">
            <label class="block text-sm mb-1">ไฟล์ PDF (URL)</label>
            <input name="pdf" id="editPdf" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-300">
          </div>
        </div>

        <div class="flex items-center justify-end gap-2 pt-2">
          <button type="button" class="px-4 py-2 rounded-xl border hover:bg-slate-50" data-close="modal">ยกเลิก</button>
          <button class="px-4 py-2 rounded-xl bg-sky-400 text-white hover:opacity-90">บันทึกการแก้ไข</button>
        </div>
        <p id="editMsg" class="text-sm"></p>
      </form>
    </div>
  </div>
</div>

<!-- Toast (optional) -->
<div id="toast" class="fixed top-3 left-1/2 -translate-x-1/2 z-[100] hidden">
  <div class="px-4 py-2 rounded-xl shadow bg-slate-900/90 text-white text-sm" id="toastMsg">Saved</div>
</div>

<script>
(function(){
  const API_EDIT = '/system/api_portfolio.php?id=<?php echo (int)($_GET['id']); ?>';

  const $ = (sel, ctx=document) => ctx.querySelector(sel);
  function toast(msg){
    const t = $('#toast'); if(!t) return;
    $('#toastMsg').textContent = msg;
    t.classList.remove('hidden');
    clearTimeout(toast.__timer);
    toast.__timer = setTimeout(()=>t.classList.add('hidden'), 1600);
  }

  window.openEditModalFromEl = function(el){
    const d = el.dataset;
    $('#editId').value = d.id || '';
    $('#editTitleSuffix').textContent = d.id ? ('#' + d.id) : '';
    $('#editTitle').value = d.title || '';
    $('#editDetail').value = d.detail || '';
    $('#editImg').value = d.img || '';
    $('#editUrl').value = d.url || '';
    $('#editGithub').value = d.github || '';
    $('#editFacebook').value = d.facebook || '';
    $('#editPdf').value = d.pdf || '';
    $('#editMsg').textContent = '';
    $('#editModal').classList.remove('hidden');
  };

  function closeEditModal(){ $('#editModal').classList.add('hidden'); }

  document.addEventListener('click', function(e){
    if (e.target.matches('[data-close="modal"]')) closeEditModal();
  });

  $('#editForm')?.addEventListener('submit', async (ev)=>{
    ev.preventDefault();
    const fd = new FormData(ev.target);
    const payload = new URLSearchParams();
    payload.set('act', 'update');
    for (const [k,v] of fd.entries()) payload.set(k, v);

    $('#editMsg').textContent = 'กำลังบันทึกการแก้ไข...';
    try {
      const res = await fetch(API_EDIT, {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'},
        body: payload
      });
      const json = await res.json();
      if (!res.ok || json?.ok === false) throw new Error(json?.msg || 'บันทึกไม่สำเร็จ');
      $('#editMsg').textContent = json.msg || 'บันทึกแล้ว';
      toast('บันทึกการแก้ไขแล้ว');

      // ปิด modal แล้วรีเฟรชหน้า (หรือจะอัปเดตการ์ดเฉพาะก็ได้)
      closeEditModal();
      location.reload(); // ถ้าต้องการแบบไม่รีเฟรช ให้ไปอัปเดต DOM จากฟอร์มแทน
    } catch(err){
      $('#editMsg').textContent = err.message || 'เกิดข้อผิดพลาด';
    }
  });
})();
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const portfolioCards = document.querySelectorAll('.group[onclick]');
    portfolioCards.forEach(card => {
        card.addEventListener('click', function(e) {
            e.stopPropagation();
            const onclickAttr = this.getAttribute('onclick');
            const urlMatch = onclickAttr.match(/window\.location\.href='([^']+)'/);
            if (urlMatch) {
                window.location.href = urlMatch[1];
            }
        });
        
        card.addEventListener('dblclick', function(e) {
            e.preventDefault();
        });
        
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05) translateY(-2px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1) translateY(0)';
        });
    });
});
</script>

  <section>
    <form id="idolForm" class="bg-white rounded-2xl shadow p-5 space-y-4 mb-3">
      <h2 class="text-lg font-semibold">แก้ไขโปรไฟล์นักศึกษา</h2>
      <input type="hidden" name="id" value="<?php echo $idol_id; ?>">
      <div class="grid grid-cols-1 gap-3">
        <label class="text-sm">ชื่อจริง - นามสกุล
          <input name="name" value="<?php echo h($id['name']); ?>" required class="mt-1 w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-sky-500"/>
        </label>
        <label class="text-sm">ชื่อเล่น
          <input name="nickname" value="<?php echo h($id['nickname']); ?>" required class="mt-1 w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-sky-500"/>
        </label>
        <label class="text-sm">ลิงก์รูปโปรไฟล์
          <input name="img" value="<?php echo h($id['img']); ?>" placeholder="https://…" class="mt-1 w-full border rounded-xl px-3 py-2"/>
        </label>
        <label class="text-sm">ลิงก์แบนเนอร์
          <input name="banner" value="<?php echo h($id['banner']); ?>" placeholder="https://…" class="mt-1 w-full border rounded-xl px-3 py-2"/>
        </label>
        <label class="text-sm">ข้อมูลแนะนำตัว
          <textarea name="info" rows="10" class="mt-1 w-full border rounded-xl px-3 py-2"><?php echo h($id['info']); ?></textarea>
        </label>

        <!-- เลือกสาขา -->
        <label class="text-sm">เลือกสาขา
          <select name="major_id" class="mt-1 w-full border rounded-xl px-3 py-2">
            <?php foreach ($majors as $val => $text): ?>
              <option value="<?php echo $val; ?>" <?php echo ((string)$id['major_id']===$val)?'selected':''; ?>>
                <?php echo h($text); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </label>


        <label class="text-sm">เลือกสาขา
          <select name="position" class="mt-1 w-full border rounded-xl px-3 py-2">
               <option value="1"  <?= ((int)$id['position']===1)?'selected':''; ?>>นักศึกษาปี 1</option>
<option value="2"  <?= ((int)$id['position']===2)?'selected':''; ?>>นักศึกษาปี 2</option>
<option value="3"  <?= ((int)$id['position']===3)?'selected':''; ?>>นักศึกษาปี 3</option>
<option value="4"  <?= ((int)$id['position']===4)?'selected':''; ?>>นักศึกษาปี 4</option>
<option value="5"  <?= ((int)$id['position']===4)?'selected':''; ?>>นักศึกษาปี 4</option>
<option value="99" <?= ((int)$id['position']===99)?'selected':''; ?>>ศิษย์เก่า</option>
          </select>
        </label>

 
        

        <label class="text-sm">วันเกิด (YYYY-MM-DD)
          <input name="dateofbirth" type="date" value="<?php echo h($id['dateofbirth']); ?>" class="mt-1 w-full border rounded-xl px-3 py-2"/>
        </label>
        <label class="text-sm">ช่องทางติดต่อ (ลิ้งก์ช่องทางการติดต่อ)
          <input name="contact" value="<?php echo h($id['contact']); ?>" class="mt-1 w-full border rounded-xl px-3 py-2"/>
        </label>
      </div>

      <button type="submit"
        class="w-full py-2 rounded-xl bg-sky-400 text-white font-semibold hover:brightness-110">
        บันทึกการเปลี่ยนแปลง
      </button>

      <div id="resp" class="text-sm"></div>
    </form>
  </section>
</main>

<script>
  // พรีวิวแบบเรียลไทม์
  const f = document.getElementById('idolForm');
  const bind = (name, cb) => f.elements[name]?.addEventListener('input', cb);

  bind('name',    e => document.getElementById('previewName').textContent  = e.target.value || 'ชื่อจริง');
  bind('nickname',e => document.getElementById('previewNick').textContent  = e.target.value ? '(@'+e.target.value+')' : '(@nickname)');
  bind('img',     e => document.getElementById('previewImg').src     = e.target.value || 'https://placehold.co/200x200?text=Avatar');
  bind('banner',  e => document.getElementById('previewBanner').src  = e.target.value || 'https://placehold.co/1200x400?text=Banner');
  bind('info',    e => document.getElementById('previewInfo').textContent  = e.target.value || 'เขียนแนะนำตัวไว้ตรงนี้แล้วจะพรีวิว…');
  bind('dateofbirth', e => document.getElementById('previewDob').textContent = e.target.value || 'YYYY-MM-DD');
  bind('major_id', e => {
    const txt = e.target.options[e.target.selectedIndex].text;
    document.getElementById('previewMajor').textContent = txt || '—';
  });
  bind('contact', e => {
    const a = document.getElementById('previewContact');
    a.textContent = e.target.value || '—';
    a.href = e.target.value || '#';
  });

  // ส่ง AJAX ไปหลังบ้าน (อัปเดต)
  f.addEventListener('submit', async (ev) => {
    ev.preventDefault();
    const respEl = document.getElementById('resp');
    respEl.textContent = 'กำลังบันทึก…';
    try {
      const formData = new FormData(f);
      const payload = Object.fromEntries(formData.entries());
      const res = await fetch('system/idol_update.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(payload),
        credentials: 'include'
      });
      const data = await res.json();
      if (res.ok) {
        respEl.className = "text-sm text-green-600 mt-2";
        respEl.textContent = '✅ ' + (data.msg || 'อัปเดตสำเร็จ');
      } else {
        respEl.className = "text-sm text-red-600 mt-2";
        respEl.textContent = '❌ ' + (data.msg || 'อัปเดตล้มเหลว');
      }
    } catch (e) {
      respEl.className = "text-sm text-red-600 mt-2";
      respEl.textContent = '❌ ขัดข้อง: ' + e.message;
    }
  });

  // ให้พรีวิวตรงกับค่าปัจจุบันตั้งแต่โหลดหน้า
  function init() {
    ['name','nickname','img','banner','info','dateofbirth','major_id','contact'].forEach(k => {
      if (f.elements[k]) f.elements[k].dispatchEvent(new Event('input'));
    });
  }
  init();
</script>
