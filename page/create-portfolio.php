<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { die("Invalid idol id"); }
?>

<div class="bg-slate-50 text-slate-800 min-h-screen">
  <!-- Toast -->
  <div id="toast" class="fixed top-3 left-1/2 -translate-x-1/2 z-[100] hidden">
    <div class="px-4 py-2 rounded-xl shadow bg-slate-900/90 text-white text-sm" id="toastMsg">Saved</div>
  </div>

  <!-- Cover + Avatar -->
  <section class="bg-slate-100">
    <div class="max-w-6xl mx-auto">
      <div id="cover" class="h-48 sm:h-60 bg-gradient-to-r from-sky-300 to-sky-400"></div>
      <div class="px-3 relative">
        <div class="-mt-14 flex items-end gap-4">
          <img id="idolAvatar" src="https://i.pravatar.cc/160" alt="avatar"
               class="w-28 h-28 rounded-full ring-4 ring-white object-cover">
          <div class="pb-2">
            <h1 id="idolName" class="text-2xl font-bold text-white drop-shadow">Idol #<?= $id ?></h1>
            <p class="text-white/90">สร้างและจัดการผลงาน • Facebook-like profile</p>
          </div>
        </div>
        <div class="mt-4 border-b border-slate-200">
          <nav class="flex gap-4">
            <button class="tab-btn active text-sky-400 border-b-2 border-sky-400 -mb-px px-2 py-2">ผลงาน</button>
            <button class="tab-btn text-slate-500 hover:text-slate-700 px-2 py-2">เกี่ยวกับ</button>
          </nav>
        </div>
      </div>
    </div>
  </section>

  <!-- Content -->
  <main class="max-w-6xl mx-auto px-3 py-6 grid lg:grid-cols-3 gap-6">
    <!-- Left: Create forms -->
    <aside class="lg:col-span-1">
      <div id="createBox" class="bg-white shadow rounded-2xl border border-slate-200">
        <div class="p-4 border-b border-slate-100">
          <h2 class="font-semibold text-slate-700">เพิ่มผลงานใหม่</h2>
        </div>
        <form id="createForm" class="p-4 space-y-3">
          <div>
            <label class="block text-sm mb-1">หัวเรื่อง *</label>
            <input name="title" required class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-300">
          </div>
          <div>
            <label class="block text-sm mb-1">รายละเอียด *</label>
            <textarea name="detail" rows="4" required class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-300"></textarea>
          </div>
          <div class="grid grid-cols-1 gap-3">
            <div>
              <label class="block text-sm mb-1">รูปหลัก (URL)</label>
              <input name="img" placeholder="https://..." class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-300">
            </div>
            <div>
              <label class="block text-sm mb-1">ลิงก์ผลงาน</label>
              <input name="url" placeholder="https://..." class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-300">
            </div>
            <div>
              <label class="block text-sm mb-1">GitHub</label>
              <input name="github" placeholder="username/repo หรือข้อความสั้น" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-300">
            </div>
            <div>
              <label class="block text-sm mb-1">Facebook (URL)</label>
              <input name="facebook" placeholder="https://facebook.com/..." class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-300">
            </div>
            <div>
              <label class="block text-sm mb-1">ไฟล์ PDF (URL)</label>
              <input name="pdf" placeholder="https://..." class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-300">
            </div>
          </div>

          <button class="w-full rounded-xl bg-sky-400 text-white px-4 py-2 hover:opacity-90">บันทึกผลงาน</button>
          <p id="createMsg" class="text-sm"></p>
        </form>
      </div>

      <div id="addImgBox" class="mt-6 bg-white shadow rounded-2xl border border-slate-200">
        <div class="p-4 border-b border-slate-100">
          <h2 class="font-semibold text-slate-700">เพิ่มรูปในผลงาน</h2>
        </div>
        <form id="addImageForm" class="p-4 space-y-3">
          <div>
            <label class="block text-sm mb-1">เลือกผลงาน</label>
            <select name="port_id" id="portSelect" class="w-full rounded-xl border border-slate-200 px-3 py-2"></select>
          </div>
          <div>
            <label class="block text-sm mb-1">รูป (URL) *</label>
            <input name="img" required placeholder="https://..." class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-300">
          </div>
          <button class="w-full rounded-xl bg-sky-400 text-white px-4 py-2 hover:opacity-90">เพิ่มรูป</button>
          <p id="addImgMsg" class="text-sm"></p>
        </form>
      </div>

      <div id="noPermBox" class="hidden mt-6 bg-white shadow rounded-2xl border border-slate-200 p-4">
        <p class="text-sm text-slate-600">คุณกำลังดูโปรไฟล์ของไอดอลคนอื่น หรือสิทธิ์ไม่เพียงพอ จึงไม่สามารถเพิ่ม/แก้ไขผลงานได้</p>
      </div>
    </aside>

    <!-- Right: Portfolio list -->
    <section class="lg:col-span-2">
      <div id="portfolioList" class="space-y-4"></div>
    </section>
  </main>

 
  <!-- Edit Modal -->
  <div id="editModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/40" data-close="modal"></div>
    <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-[95vw] max-w-2xl">
      <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
        <div class="p-4 border-b flex items-center justify-between">
          <h3 class="font-semibold text-slate-800">แก้ไขผลงาน <span id="editTitleSuffix" class="text-slate-400"></span></h3>
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

<script>
const $ = (sel, ctx=document) => ctx.querySelector(sel);
const idolId = <?= $id ?>;
const API = '/system/api_portfolio.php?id=' + idolId;
let portfolioCache = [];

async function callAPI(payload) {
  const res = await fetch(API, {
    method: 'POST',
    headers: {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'},
    body: new URLSearchParams(payload)
  });
  const json = await res.json();
  if (!res.ok || json?.ok === false) throw new Error(json?.msg || 'Error');
  return json;
}

function toast(msg){
  const t = $('#toast');
  $('#toastMsg').textContent = msg;
  t.classList.remove('hidden');
  clearTimeout(toast.__timer);
  toast.__timer = setTimeout(()=>t.classList.add('hidden'), 1800);
}

function cardHTML(item, canEditGlobal){
  const cover = item.img ? `<img src="${item.img}" class="w-full h-48 object-cover rounded-t-2xl">` : '';
  const linkBadge = (href, label) => href ? `<a href="${href}" target="_blank" class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-sky-100 text-sky-700 border border-sky-200">${label}</a>` : '';
  const github = item.github ? `<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-slate-100 text-slate-700 border">${item.github}</span>` : '';
  const images = (item.images||[]).map(img =>
    `<div class="relative group">
      <img src="${img.img}" class="w-full h-28 object-cover rounded-xl">
      ${canEditGlobal ? `<button data-img="${img.id}" class="del-img hidden group-hover:block absolute top-1 right-1 text-xs bg-white/90 border px-2 py-0.5 rounded">ลบ</button>` : ''}
    </div>`
  ).join('');
  const actions = canEditGlobal ? `
    <div class="flex items-center gap-2">
      <button data-edit="${item.id}" class="text-sm px-3 py-1 rounded-xl border hover:bg-slate-50">แก้ไข</button>
      <button data-del="${item.id}" class="text-sm px-3 py-1 rounded-xl border hover:bg-rose-50">ลบ</button>
    </div>` : '';

  return `
  <article class="bg-white shadow rounded-2xl border border-slate-200 overflow-hidden">
    ${cover}
    <div class="p-4">
      <div class="flex items-start justify-between gap-3">
        <div>
          <h3 class="text-lg font-semibold text-slate-800">${item.title}</h3>
          <div class="mt-1 flex flex-wrap gap-2">
            ${linkBadge(item.url, 'ลิงก์')}
            ${linkBadge(item.facebook, 'Facebook')}
            ${linkBadge(item.pdf, 'PDF')}
            ${github}
          </div>
        </div>
        ${actions}
      </div>
      <p class="mt-3 text-slate-700 whitespace-pre-line">${item.detail}</p>
      ${(item.images && item.images.length)
        ? `<div class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-2">${images}</div>`
        : `<div class="mt-4 text-sm text-slate-400">ยังไม่มีรูปเพิ่มเติม</div>`}
    </div>
  </article>`;
}

async function loadMeta() {
  try {
    const { idol, canEdit } = await callAPI({act:'meta'});

    // ตั้งชื่อ/ภาพ
    if (idol?.name) $('#idolName').textContent = `${idol.name} ${(idol.nickname? '('+idol.nickname+')':'')}`.trim();
    if (idol?.img)  $('#idolAvatar').src = idol.img;
    if (idol?.banner) {
      const cover = document.getElementById('cover');
      cover.style.backgroundImage = `url('${idol.banner}')`;
      cover.style.backgroundSize = 'cover';
      cover.style.backgroundPosition = 'center';
    }

    // ควบคุมสิทธิ์
    if (canEdit) {
      $('#createBox').classList.remove('hidden');
      $('#addImgBox').classList.remove('hidden');
      $('#noPermBox').classList.add('hidden');
    } else {
      $('#createBox').classList.add('hidden');
      $('#addImgBox').classList.add('hidden');
      $('#noPermBox').classList.remove('hidden');
    }

    // เก็บสถานะสิทธิ์ไว้ใน DOM dataset เพื่อใช้ตอนเรนเดอร์การ์ด
    document.body.dataset.canEdit = !!canEdit;
  } catch (e) {
    console.error(e);
  }
}

async function refreshList() {
  try {
    const { data } = await callAPI({act:'list'});
    portfolioCache = data || [];
    $('#portSelect').innerHTML = portfolioCache.map(d => `<option value="${d.id}">#${d.id} • ${d.title}</option>`).join('');
    const canEditGlobal = document.body.dataset.canEdit === 'true' || document.body.dataset.canEdit === '1';
    $('#portfolioList').innerHTML = portfolioCache.map(d => cardHTML(d, canEditGlobal)).join('');
  } catch (e) {
    $('#portfolioList').innerHTML = `<div class="p-4 bg-white rounded-2xl border">โหลดรายการไม่สำเร็จ: ${e.message}</div>`;
  }
}

$('#createForm').addEventListener('submit', async (ev)=>{
  ev.preventDefault();
  const fd = new FormData(ev.target);
  const payload = Object.fromEntries(fd.entries());
  payload.act = 'create';
  $('#createMsg').textContent = 'กำลังบันทึก...';
  try {
    const r = await callAPI(payload);
    $('#createMsg').textContent = r.msg || 'สำเร็จ';
    toast('เพิ่มผลงานแล้ว');
    ev.target.reset();
    await refreshList();
  } catch (e) { $('#createMsg').textContent = e.message; }
});

$('#addImageForm').addEventListener('submit', async (ev)=>{
  ev.preventDefault();
  const fd = new FormData(ev.target);
  const payload = Object.fromEntries(fd.entries());
  payload.act = 'add_image';
  $('#addImgMsg').textContent = 'กำลังเพิ่มรูป...';
  try {
    const r = await callAPI(payload);
    $('#addImgMsg').textContent = r.msg || 'สำเร็จ';
    toast('เพิ่มรูปแล้ว');
    ev.target.reset();
    await refreshList();
  } catch (e) { $('#addImgMsg').textContent = e.message; }
});

// ---------- Edit helpers ----------
function openEditModal(item){
  if(!item) return;
  $('#editId').value = item.id;
  $('#editTitleSuffix').textContent = `#${item.id}`;
  $('#editTitle').value = item.title || '';
  $('#editDetail').value = item.detail || '';
  $('#editImg').value = item.img || '';
  $('#editUrl').value = item.url || '';
  $('#editGithub').value = item.github || '';
  $('#editFacebook').value = item.facebook || '';
  $('#editPdf').value = item.pdf || '';
  $('#editMsg').textContent = '';
  $('#editModal').classList.remove('hidden');
}

function closeEditModal(){ $('#editModal').classList.add('hidden'); }

$('#editForm').addEventListener('submit', async (ev)=>{
  ev.preventDefault();
  const fd = new FormData(ev.target);
  const payload = Object.fromEntries(fd.entries());
  payload.act = 'update'; // ต้องรองรับที่ API ฝั่ง server
  $('#editMsg').textContent = 'กำลังบันทึกการแก้ไข...';
  try {
    const r = await callAPI(payload);
    $('#editMsg').textContent = r.msg || 'บันทึกแล้ว';
    toast('บันทึกการแก้ไขแล้ว');
    closeEditModal();
    await refreshList();
  } catch (e) { $('#editMsg').textContent = e.message; }
});

// ---------- Global click handlers ----------
document.addEventListener('click', async (ev)=>{
  const delPort = ev.target.closest('[data-del]');
  const delImg = ev.target.closest('.del-img');
  const editBtn = ev.target.closest('[data-edit]');
  const closeModal = ev.target.matches('[data-close="modal"]');

  if (delPort) {
    const id = delPort.getAttribute('data-del');
    if (confirm('ลบผลงาน #' + id + ' ?')) {
      try { await callAPI({act:'delete', port_id:id}); toast('ลบแล้ว'); await refreshList(); }
      catch(e){ alert(e.message); }
    }
  }

  if (delImg) {
    const imgId = delImg.getAttribute('data-img');
    if (confirm('ลบรูป #' + imgId + ' ?')) {
      try { await callAPI({act:'delete_image', img_id: imgId}); toast('ลบรูปแล้ว'); await refreshList(); }
      catch(e){ alert(e.message); }
    }
  }

  if (editBtn) {
    const id = editBtn.getAttribute('data-edit');
    const item = portfolioCache.find(x => String(x.id) === String(id));
    openEditModal(item);
  }

  if (closeModal) { closeEditModal(); }
});

(async function init(){
  await loadMeta();
  await refreshList();
})();
</script>

</div>
