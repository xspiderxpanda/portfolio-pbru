<?php
error_reporting(E_ALL); ini_set('display_errors', 0);
require_once 'a_func.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) { http_response_code(400); die('Bad request'); }
if (!isset($_GET['port']) || !ctype_digit($_GET['port'])) { http_response_code(400); die('Bad request'); }
$idol_id  = (int)$_GET['id'];
$port_id  = (int)$_GET['port'];
?>
<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <title>แก้ไขผลงาน #<?= $port_id ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800">
  <header class="sticky top-0 z-20 bg-white/90 backdrop-blur border-b border-slate-200">
    <div class="max-w-6xl mx-auto px-3 py-2 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <a href="idol_portfolio.php?id=<?=$idol_id?>" class="text-sky-600 hover:underline">← กลับไปหน้าผลงานทั้งหมด</a>
        <span class="font-semibold text-slate-700">แก้ไขผลงาน #<?= $port_id ?></span>
      </div>
    </div>
  </header>

  <main class="max-w-6xl mx-auto px-3 py-6 grid lg:grid-cols-3 gap-6">
    <!-- ฟอร์มแก้ไขผลงาน -->
    <section class="lg:col-span-2">
      <div class="bg-white shadow rounded-2xl border border-slate-200">
        <div class="p-4 border-b border-slate-100">
          <h2 class="font-semibold text-slate-700">รายละเอียดผลงาน</h2>
        </div>
        <form id="editForm" class="p-4 space-y-3">
          <input type="hidden" name="port_id" value="<?=$port_id?>">
          <div>
            <label class="block text-sm mb-1">หัวเรื่อง *</label>
            <input name="title" required class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:ring-2 focus:ring-sky-300">
          </div>
          <div>
            <label class="block text-sm mb-1">รายละเอียด *</label>
            <textarea name="detail" rows="5" required class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:ring-2 focus:ring-sky-300"></textarea>
          </div>

          <!-- รูปหลัก -->
          <div>
            <label class="block text-sm mb-1">รูปหลัก</label>
            <div class="flex items-center gap-3">
              <img id="coverPreview" class="w-32 h-20 object-cover rounded-xl border hidden">
              <input type="hidden" name="img" id="coverUrl">
              <input type="file" id="coverFile" accept="image/*" class="rounded-xl border border-slate-200 px-3 py-2">
            </div>
            <div id="coverMsg" class="text-xs text-slate-500 mt-1">ยังไม่ได้อัปโหลด</div>
          </div>

          <div class="grid grid-cols-1 gap-3">
            <label class="text-sm">ลิงก์ผลงาน
              <input name="url" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2" placeholder="https://...">
            </label>
            <label class="text-sm">GitHub
              <input name="github" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2" placeholder="username/repo หรือข้อความสั้น">
            </label>
            <label class="text-sm">Facebook (URL)
              <input name="facebook" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2" placeholder="https://facebook.com/...">
            </label>
            <label class="text-sm">ไฟล์ PDF (URL)
              <input name="pdf" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2" placeholder="https://...">
            </label>
          </div>

          <button class="w-full rounded-xl bg-sky-400 text-white px-4 py-2 hover:brightness-110">บันทึกการเปลี่ยนแปลง</button>
          <p id="editMsg" class="text-sm"></p>
        </form>
      </div>
    </section>

    <!-- จัดการแกลเลอรีของผลงานนี้ -->
    <aside class="lg:col-span-1">
      <div class="bg-white shadow rounded-2xl border border-slate-200">
        <div class="p-4 border-b border-slate-100">
          <h3 class="font-semibold text-slate-700">รูปในผลงานนี้</h3>
        </div>
        <div class="p-4 space-y-3">
          <form id="addImageForm" class="space-y-2">
            <input type="hidden" name="port_id" value="<?=$port_id?>">
            <div>
              <label class="block text-sm mb-1">อัปโหลดรูป (แกลเลอรี)</label>
              <input type="file" id="galleryFile" accept="image/*" class="w-full rounded-xl border border-slate-200 px-3 py-2">
              <input type="hidden" name="img" id="galleryUrl">
              <div id="galleryMsg" class="text-xs text-slate-500 mt-1">ยังไม่ได้อัปโหลด</div>
              <img id="galleryPreview" class="mt-2 w-full max-h-40 object-cover rounded-xl hidden">
            </div>
            <button class="w-full rounded-xl bg-sky-400 text-white px-4 py-2 hover:brightness-110">เพิ่มรูป</button>
            <p id="addImgMsg" class="text-sm"></p>
          </form>

          <div id="imageList" class="grid grid-cols-2 gap-2"></div>
        </div>
      </div>
    </aside>
  </main>

<script>
const idolId    = <?=$idol_id?>;
const portId    = <?=$port_id?>;
const API       = 'system/api_portfolio.php?id=' + idolId;
const uploadUrl = 'system/upload_image.php?id=' + idolId;

const $ = (s, c=document)=>c.querySelector(s);

// ---------- helpers ----------
async function callAPI(payload){
  const res = await fetch(API, {
    method: 'POST',
    headers: {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'},
    body: new URLSearchParams(payload),
    credentials:'include'
  });
  const j = await res.json();
  if(!res.ok) throw new Error(j?.msg || 'Error');
  return j;
}
async function uploadImage(file, scope){
  const fd = new FormData();
  fd.append('file', file);
  fd.append('scope', scope);
  const res = await fetch(uploadUrl, { method:'POST', body:fd, credentials:'include' });
  const j = await res.json();
  if(!res.ok) throw new Error(j?.msg || 'อัปโหลดล้มเหลว');
  return j.url;
}

// ---------- load existing data ----------
async function loadPortfolio(){
  const { data } = await callAPI({act:'get', port_id: portId});
  // set form fields
  const f = $('#editForm');
  f.title.value    = data.title || '';
  f.detail.value   = data.detail || '';
  f.url.value      = data.url || '';
  f.github.value   = data.github || '';
  f.facebook.value = data.facebook || '';
  f.pdf.value      = data.pdf || '';
  if (data.img) {
    $('#coverUrl').value = data.img;
    const pv = $('#coverPreview'); pv.src = data.img; pv.classList.remove('hidden');
    $('#coverMsg').textContent = 'มีรูปหลักแล้ว';
  }
  renderImages(data.images || []);
}

function renderImages(arr){
  const wrap = $('#imageList');
  if (!arr.length) { wrap.innerHTML = '<div class="text-xs text-slate-500">ยังไม่มีรูปในแกลเลอรี</div>'; return; }
  wrap.innerHTML = arr.map(x=>`
    <div class="relative group border rounded-xl overflow-hidden">
      <img src="${x.img}" class="w-full h-28 object-cover">
      <button data-delimg="${x.id}" class="hidden group-hover:block absolute top-1 right-1 text-xs bg-white/90 border rounded px-2 py-0.5">ลบ</button>
    </div>
  `).join('');
}

// ---------- events ----------
// อัปโหลดรูปหลัก (cover)
$('#coverFile').addEventListener('change', async e=>{
  const f = e.target.files?.[0]; if(!f) return;
  const msg = $('#coverMsg'); msg.textContent = 'กำลังอัปโหลด...';
  try{
    const url = await uploadImage(f, 'portfolio_cover');
    $('#coverUrl').value = url;
    const pv = $('#coverPreview'); pv.src = url; pv.classList.remove('hidden');
    msg.textContent = 'อัปโหลดสำเร็จ';
  }catch(err){ msg.textContent = '❌ '+ err.message; }
});

// บันทึกแก้ไข
$('#editForm').addEventListener('submit', async ev=>{
  ev.preventDefault();
  $('#editMsg').textContent = 'กำลังบันทึก...';
  const payload = Object.fromEntries(new FormData(ev.target).entries());
  payload.act = 'update';
  try{
    await callAPI(payload);
    $('#editMsg').textContent = 'บันทึกสำเร็จ';
  }catch(err){ $('#editMsg').textContent = '❌ ' + err.message; }
});

// อัปโหลดรูปแกลเลอรี
$('#galleryFile').addEventListener('change', async e=>{
  const f = e.target.files?.[0]; if(!f) return;
  const msg = $('#galleryMsg'); const prev = $('#galleryPreview');
  msg.textContent = 'กำลังอัปโหลด...';
  try{
    const url = await uploadImage(f, 'portfolio_gallery');
    $('#galleryUrl').value = url;
    prev.src = url; prev.classList.remove('hidden');
    msg.textContent = 'อัปโหลดสำเร็จ';
  }catch(err){ msg.textContent = '❌ ' + err.message; }
});

// กดเพิ่มรูปเข้าแกลเลอรี (ผูก port_id)
$('#addImageForm').addEventListener('submit', async ev=>{
  ev.preventDefault();
  $('#addImgMsg').textContent = 'กำลังเพิ่มรูป...';
  const payload = Object.fromEntries(new FormData(ev.target).entries());
  payload.act = 'add_image';
  try{
    await callAPI(payload);
    $('#addImgMsg').textContent = 'เพิ่มรูปสำเร็จ';
    ev.target.reset();
    $('#galleryPreview').classList.add('hidden');
    await loadPortfolio();
  }catch(err){ $('#addImgMsg').textContent = '❌ ' + err.message; }
});

// ลบรูปแกลเลอรี
document.addEventListener('click', async ev=>{
  const btn = ev.target.closest('[data-delimg]');
  if (!btn) return;
  const imgId = btn.getAttribute('data-delimg');
  if (!confirm('ลบรูป #' + imgId + ' ?')) return;
  try{
    await callAPI({act:'delete_image', img_id: imgId});
    await loadPortfolio();
  }catch(err){ alert(err.message); }
});

// init
(async function init(){
  await loadPortfolio();
})();
</script>
</body>
</html>
