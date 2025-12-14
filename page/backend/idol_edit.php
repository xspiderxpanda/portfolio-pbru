<?php

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
  http_response_code(400);
  die('Bad request');
}
$idol_id = (int)$_GET['id'];

$q_user = dd_q('SELECT * FROM users WHERE id = ?', [$_SESSION['id']]);
$plr = $q_user->fetch(PDO::FETCH_ASSOC);
if (!isset($plr['role']) || ($plr['role'] !== "1" && $plr['role'] !== "2")) {
  die('คุณไม่มีสิทธิ์แก้ไขโปรไฟล์ไอดอล');
}

$id1 = dd_q("SELECT * FROM idol WHERE id = ?", [$idol_id]);
$id = $id1->fetch(PDO::FETCH_ASSOC);
if (!$id) {
  die('ไม่พบข้อมูล หรือคุณไม่มีสิทธิ์แก้ไขรายการนี้');
}

// ฟังก์ชันช่วยสำหรับ escape
function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

$majorsStmt = dd_q('SELECT id, name FROM major ORDER BY name ASC');
$majors = $majorsStmt ? $majorsStmt->fetchAll(PDO::FETCH_KEY_PAIR) : [];

$currentMajorId   = (string)($row['major_id'] ?? '');
$currentMajorText = $majors[$currentMajorId] ?? '—';
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
          วันเกิด: <span id="previewDob"><?php echo h($id['dateofbirth'] ?: 'YYYY-MM-DD'); ?></span>
          <br>สาขา/หมวด: <span id="previewMajor"><?php echo h($currentMajorText); ?></span>
        </div>
        <div class="mt-2 text-xs text-gray-500">
          ช่องทางติดต่อ: <a id="previewContact" href="<?php echo h($id['contact'] ?: '#'); ?>" class="text-sky-600 hover:underline"><?php echo h($id['contact'] ?: '—'); ?></a>
        </div>
      </div>
    </div>
  </section>

<section>
<?php
// เตรียมข้อมูลผู้ใช้ และ u_admin ปัจจุบัน
$usersStmt = dd_q("SELECT id, username, nickname FROM users ORDER BY id ASC");
$users = $usersStmt->fetchAll(PDO::FETCH_ASSOC);

$rawAdmins = array_map('trim', explode(',', (string)($id['u_admin'] ?? '')));
$currentAdmins = array_values(array_filter(array_map(function($x){
  return ctype_digit($x) ? (int)$x : null;
}, $rawAdmins), fn($v)=>!is_null($v) && $v > 0));
sort($currentAdmins);

$labels = [];
foreach ($users as $u) {
  $labels[(int)$u['id']] = $u['username'] . ($u['nickname'] ? " ({$u['nickname']})" : "");
}
?>

<!-- ผู้ดูแลโปรไฟล์ -->
<div class="border rounded-2xl p-4 space-y-3">
  <h2 class="text-lg font-semibold">ผู้ดูแลโปรไฟล์ (เลือกได้หลายคน)</h2>

  <div class="flex gap-2">
    <select id="adminSelect" class="w-full border rounded-xl px-3 py-2">
      <option value="">— เลือกผู้ใช้ —</option>
      <?php foreach ($users as $u): ?>
        <option value="<?php echo (int)$u['id']; ?>">
          <?php echo htmlspecialchars($u['username'] . ($u['nickname'] ? " ({$u['nickname']})" : ""), ENT_QUOTES, 'UTF-8'); ?>
        </option>
      <?php endforeach; ?>
    </select>
    <button type="button" id="addAdminBtn"
      class="shrink-0 rounded-xl border border-sky-200 bg-white px-3 py-2 text-sm text-sky-700 hover:bg-sky-50">
      เพิ่ม
    </button>
  </div>

  <div id="adminsPills" class="mt-1 flex flex-wrap gap-2"></div>
  <p id="adminsResp" class="text-xs text-gray-500"></p>
  <p class="text-xs text-gray-500">ระบบจะแสดงเฉพาะชื่อผู้ใช้ (username) และชื่อเล่น (nickname) แต่จะส่ง <em>id</em> ไปเก็บในฐานข้อมูล</p>
</div>

<script>
(() => {
  // ===== ค่าคงที่จาก PHP (ไม่พึ่ง DOM) =====
  const idolId       = <?php echo (int)$idol_id; ?>;          // << สำคัญ: ฝังจาก PHP
  const initialAdmins = <?php echo json_encode($currentAdmins, JSON_UNESCAPED_UNICODE); ?>;
  const userMap       = new Map(Object.entries(<?php echo json_encode($labels, JSON_UNESCAPED_UNICODE); ?>).map(([k,v])=>[parseInt(k,10), v]));

  if (!idolId) {
    console.error('idolId ไม่ถูกต้อง'); // กันพลาด
  }

  // State & elements
  const adminsSet   = new Set(initialAdmins);
  const adminSelect = document.getElementById('adminSelect');
  const addAdminBtn = document.getElementById('addAdminBtn');
  const adminsPills = document.getElementById('adminsPills');
  const adminsResp  = document.getElementById('adminsResp');

  function setBusy(el, busy) {
    if (!el) return;
    el.disabled = !!busy;
    el.classList.toggle('opacity-50', !!busy);
    el.classList.toggle('cursor-not-allowed', !!busy);
  }

  function msg(text, ok=true) {
    if (!adminsResp) return;
    adminsResp.className = 'text-xs ' + (ok ? 'text-green-600' : 'text-red-600');
    adminsResp.textContent = text;
  }

  function renderPills() {
    adminsPills.innerHTML = '';
    [...adminsSet].sort((a,b)=>a-b).forEach(uid => {
      const pill = document.createElement('span');
      pill.className = 'inline-flex items-center gap-2 rounded-full bg-sky-50 border border-sky-200 px-3 py-1 text-xs text-sky-700';
      pill.dataset.uid = uid;
      pill.innerHTML = `
        ${userMap.get(uid) ?? ('User #'+uid)}
        <button type="button" class="removeAdmin text-sky-500 hover:text-sky-700" title="ลบ">×</button>
      `;
      adminsPills.appendChild(pill);
    });
  }

  // ---- ยิงไปหลังบ้านทันที ----
  async function pushAdmins(mode, ids) {
    try {
      setBusy(addAdminBtn, true);
      msg('กำลังบันทึก…', true);

      const r = await fetch('system/backend/idol_addadmin.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        credentials: 'include',
        body: JSON.stringify({ id: idolId, mode, admins: ids })
      });
      const j = await r.json();
      if (!r.ok) throw new Error(j.message || 'บันทึกล้มเหลว');

      // sync state จากผลลัพธ์จริง
      const latest = Array.isArray(j.admins) ? j.admins.map(n => parseInt(n,10)).filter(Boolean) : [];
      adminsSet.clear();
      latest.forEach(x => adminsSet.add(x));
      initialAdmins.splice(0, initialAdmins.length, ...latest);

      renderPills();
      msg(j.message || 'สำเร็จ', true);
      return true;
    } catch (e) {
      msg(e.message, false);
      return false;
    } finally {
      setBusy(addAdminBtn, false);
    }
  }

  // กด "เพิ่ม" → add ทันที
  addAdminBtn?.addEventListener('click', async () => {
    const v = parseInt(adminSelect.value, 10);
    if (!v || Number.isNaN(v)) { msg('กรุณาเลือกผู้ใช้', false); return; }

    if (adminsSet.has(v)) {
      msg('ผู้ใช้นี้ถูกเพิ่มไว้แล้ว', true);
      adminSelect.value = '';
      return;
    }

    const ok = await pushAdmins('add', [v]);
    if (ok) adminSelect.value = '';
  });

  // คลิกลบที่ pill → remove ทันที
  adminsPills?.addEventListener('click', async (e) => {
    if (!e.target.classList.contains('removeAdmin')) return;
    const uid = parseInt(e.target.parentElement.dataset.uid, 10);
    if (!uid) return;

    if (!confirm('ยืนยันลบผู้ดูแลคนนี้?')) return;
    await pushAdmins('remove', [uid]);
  });

  const form = document.getElementById('idolForm');
  if (form) {
    form.addEventListener('submit', () => {
      const full = [...adminsSet].sort((a,b)=>a-b);
      fetch('system/backend/idol_addadmin.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        credentials: 'include',
        body: JSON.stringify({ id: idolId, mode: 'set', admins: full })
      }).catch(()=>{});
    }, { passive: true });
  }

  renderPills();
})();
</script>
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
      <!-- Portfolio Card (แก้ไข) -->
      <div
        class="group cursor-pointer transform transition-all duration-300 hover:scale-105"
        onclick="openPortfolioModal('edit', <?php echo (int)$row['id'];?>)"
      >
        <div class="text-center">
          <div class="relative w-28 h-28 mx-auto rounded-2xl overflow-hidden mb-3 shadow-lg border-3 border-white group-hover:border-sky-300 group-hover:shadow-xl transition-all duration-300">
            <img src="<?php echo $row['img'];?>" class="w-full h-full object-cover transition-transform duration-300" alt="<?php echo $row['title'];?>">
            <div class="absolute inset-0 bg-sky-400 bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center pointer-events-none">
              <i class="fas fa-edit text-white opacity-0 group-hover:opacity-100 text-xl transition-opacity duration-300"></i>
            </div>
          </div>
          <h3 class="text-sm font-medium text-gray-700 group-hover:text-sky-400 transition-colors duration-300 px-2 leading-tight"
              style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;word-break:break-word;line-height:1.3;max-height:2.6em;"
              title="<?php echo htmlspecialchars($row['title']); ?>">
            <?php echo $row['title'];?>
          </h3>
        </div>
      </div>
      <?php } ?>

      <!-- Add New Portfolio (สร้างใหม่) -->
      <div
        class="group cursor-pointer transform transition-all duration-300 hover:scale-105"
        onclick="openPortfolioModal('create')"
      >
        <div class="text-center">
          <div class="w-28 h-28 mx-auto rounded-2xl bg-sky-50 border-2 border-dashed border-sky-300 group-hover:border-sky-500 mb-3 transition-all duration-300 group-hover:bg-sky-100 flex items-center justify-center">
            <div class="text-center">
              <i class="fas fa-plus text-2xl text-sky-400 group-hover:text-sky-500 mb-1 transition-colors duration-300"></i>
              <div class="text-xs text-sky-500 group-hover:text-sky-600 transition-colors duration-300">เพิ่มผลงาน</div>
            </div>
          </div>
          <h3 class="text-base font-medium text-sky-500 group-hover:text-sky-600 transition-colors duration-300">
            สร้างผลงานใหม่
          </h3>
        </div>
      </div>
    </div>
  </div>
</section>

<div id="portfolioModalBackdrop"
     class="fixed inset-0 bg-black/40 z-[9998] hidden"
     onclick="closePortfolioModal()"></div>

<!-- Modal -->
<div id="portfolioModal"
     class="fixed inset-0 z-[9999] hidden items-center justify-center p-4">
  <div class="bg-white w-full max-w-2xl rounded-2xl shadow-xl overflow-hidden"
       onclick="event.stopPropagation()">

    <div class="px-6 py-4 border-b">
      <h3 id="portfolioModalTitle" class="text-lg font-semibold">สร้างผลงานใหม่</h3>
    </div>

    <form id="portfolioForm" class="px-6 py-5 space-y-4">
      <!-- hidden -->
      <input type="hidden" name="mode" id="mode" value="create">
      <input type="hidden" name="id" id="port_id" value="">
      <input type="hidden" name="idol_id" id="idol_id" value="<?php echo (int)$_GET['id'];?>">

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <label class="block">
          <span class="text-sm">ชื่อผลงาน (title)</span>
          <input type="text" name="title" id="title" class="mt-1 w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400" required>
        </label>

        <label class="block">
          <span class="text-sm">ลิงก์ภาพปก (img)</span>
          <input type="url" name="img" id="img" class="mt-1 w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400" placeholder="https://...">
        </label>
      </div>

      <label class="block">
        <span class="text-sm">รายละเอียด (detail)</span>
        <textarea name="detail" id="detail" rows="5" class="mt-1 w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400"></textarea>
      </label>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <label class="block">
          <span class="text-sm">ลิงก์ผลงาน (url)</span>
          <input type="url" name="url" id="url" class="mt-1 w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400" placeholder="#">
        </label>

        <label class="block">
          <span class="text-sm">GitHub (github)</span>
          <input type="text" name="github" id="github" class="mt-1 w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400" placeholder="-">
        </label>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <label class="block">
          <span class="text-sm">Facebook (facebook)</span>
          <input type="url" name="facebook" id="facebook" class="mt-1 w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400">
        </label>

        <label class="block">
          <span class="text-sm">ไฟล์เอกสาร (pdf)</span>
          <input type="url" name="pdf" id="pdf" class="mt-1 w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400" placeholder="ลิงก์ไฟล์ PDF">
        </label>
      </div>

      <!-- (ถ้าต้องการอัปโหลดหลายรูปไปที่ idol_portfolio_img ให้เพิ่มส่วนนี้ภายหลัง) -->

      <div class="flex items-center justify-end gap-3 pt-2">
        <button type="button" class="px-4 py-2 rounded-xl border hover:bg-gray-50" onclick="closePortfolioModal()">ยกเลิก</button>
        <button type="submit" class="px-5 py-2 rounded-xl bg-sky-500 text-white hover:bg-sky-600">บันทึก</button>
      </div>
    </form>

  </div>
</div>


<script>
  const modal = document.getElementById('portfolioModal');
  const backdrop = document.getElementById('portfolioModalBackdrop');
  const form = document.getElementById('portfolioForm');
  const titleEl = document.getElementById('portfolioModalTitle');

  function openPortfolioModal(mode = 'create', id = null) {
    document.getElementById('mode').value = mode;
    document.getElementById('port_id').value = id || '';
    titleEl.textContent = (mode === 'edit') ? 'แก้ไขผลงาน' : 'สร้างผลงานใหม่';

    form.reset();
    if (mode === 'edit' && id) {
      fetch(`/system/backend/call/portfolio_get.php?id=${encodeURIComponent(id)}`, {
        credentials: 'include'
      })
      .then(r => r.json())
      .then(res => {
        if (!res.ok) throw new Error(res.message || 'โหลดข้อมูลไม่สำเร็จ');
        const d = res.data || {};
        document.getElementById('title').value = d.title || '';
        document.getElementById('img').value = d.img || '';
        document.getElementById('detail').value = d.detail || '';
        document.getElementById('url').value = d.url || '';
        document.getElementById('github').value = d.github || '';
        document.getElementById('facebook').value = d.facebook || '';
        document.getElementById('pdf').value = d.pdf || '';
      })
      .catch(err => alert(err.message));
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    backdrop.classList.remove('hidden');
  }

  function closePortfolioModal() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    backdrop.classList.add('hidden');
  }

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const fd = new FormData(form);
    fetch('/system/backend/portfolio_save.php', {
      method: 'POST',
      body: fd,
      credentials: 'include'
    })
    .then(r => r.json())
    .then(res => {
      if (!res.ok) throw new Error(res.message || 'บันทึกไม่สำเร็จ');
      // สำเร็จ: ปิด modal และรีเฟรชหน้า (หรือจะอัปเดต DOM จุดนั้นเลยก็ได้)
      closePortfolioModal();
      location.reload();
    })
    .catch(err => alert(err.message));
  });
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
      const res = await fetch('system/backend/idol_update.php', {
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
