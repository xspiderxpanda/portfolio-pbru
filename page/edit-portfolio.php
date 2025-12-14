<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { die("Invalid idol id"); }
?>


  <!-- Top Bar -->
  <header class="sticky top-0 z-20 bg-white/90 backdrop-blur border-b border-slate-200 mt-4">
    <div class="max-w-6xl mx-auto px-3 py-2 flex items-center justify-between">
      <div class="flex items-center gap-3">
        
        <span class="font-semibold text-slate-700">ค้นหาผลงาน</span>
      </div>
      <div class="flex items-center gap-2">
        <input id="searchBox" placeholder="ค้นหา..." class="px-3 py-1.5 rounded-full border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-300"/>
        <button class="px-3 py-1.5 rounded-full bg-sky-400 text-white">ค้นหา</button>
      </div>
    </div>
  </header>

  <!-- Cover + Avatar -->
  <section class="bg-primary-300">
    <div class="max-w-6xl mx-auto">
      <div id="cover" class="h-48 sm:h-60 bg-gradient-to-r from-primary-300 to-sky-400"></div>
      <div class="px-3 relative">
        <div class="-mt-14 flex items-end gap-4">
          <img id="idolAvatar" src="https://i.pravatar.cc/160" alt="avatar"
               class="w-28 h-28 rounded-full ring-4 ring-white object-cover">
          <div class="mt-2">
            <h1 id="idolName" class="text-2xl font-bold text-white drop-shadow">Idol #<?= $id ?></h1>
            <p class="text-sky/90">สร้างและจัดการผลงาน • Facebook-like profile</p>
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
          <p class="text-sm text-slate-500">เฉพาะ “เจ้าของไอดอล” ที่ role 1 หรือ 2</p>
        </div>
        <form id="createForm" class="p-4 space-y-3">
          <div>
            <label class="block text-sm mb-1">หัวเรื่อง *</label>
            <input name="title" required class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-300">
          </div>
          <div>
            <label class="block text-sm mb-1">รายละเอียด *</label>
            <textarea name="detail" rows="4" required class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-300"></textarea>
          </div>
          <div class="grid grid-cols-1 gap-3">
             <div>
    <label class="block text-sm mb-1">รูปหลัก (อัปโหลดไฟล์)</label>
    <input type="file" id="fileMain" accept="image/*" class="w-full rounded-xl border border-slate-200 px-3 py-2">
    <input type="hidden" name="img" id="imgMainUrl">
    <div id="fileMainMsg" class="text-xs text-slate-500 mt-1">ยังไม่ได้อัปโหลด</div>
    <img id="fileMainPreview" class="mt-2 w-full max-h-48 object-cover rounded-xl hidden">
  </div>
            <div>
              <label class="block text-sm mb-1">ลิงก์ผลงาน</label>
              <input name="url" placeholder="https://..." class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-300">
            </div>
            <div>
              <label class="block text-sm mb-1">GitHub</label>
              <input name="github" placeholder="username/repo หรือข้อความสั้น" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-300">
            </div>
            <div>
              <label class="block text-sm mb-1">Facebook (URL)</label>
              <input name="facebook" placeholder="https://facebook.com/..." class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-300">
            </div>
            <div>
              <label class="block text-sm mb-1">ไฟล์ PDF (URL)</label>
              <input name="pdf" placeholder="https://..." class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-300">
            </div>
          </div>

          <button class="w-full rounded-xl bg-sky-400 text-white px-4 py-2 hover:opacity-90">บันทึกผลงาน</button>
          <p id="createMsg" class="text-sm"></p>
        </form>
      </div>

    
      <div id="noPermBox" class="hidden mt-6 bg-white shadow rounded-2xl border border-slate-200 p-4">
        <p class="text-sm text-slate-600">คุณกำลังดูโปรไฟล์ของไอดอลคนอื่น หรือสิทธิ์ไม่เพียงพอ จึงไม่สามารถเพิ่ม/แก้ไขผลงานได้</p>
      </div>
    </aside>

    <section class="lg:col-span-2">
      <div id="portfolioList" class="space-y-4"></div>
    </section>
  </main>

<script>


const $ = (sel, ctx=document) => ctx.querySelector(sel);
const idolId = <?= $id ?>;
const API = 'system/api_portfolio.php?id=' + idolId;

async function callAPI(payload) {
  const res = await fetch(API, {
    method: 'POST',
    headers: {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'},
    body: new URLSearchParams(payload)
  });
  const json = await res.json();
  if (!res.ok) throw new Error(json?.msg || 'Error');
  return json;
}

function cardHTML(item){
  const cover = item.img ? `<img src="${item.img}" class="w-full h-48 object-cover rounded-t-2xl">` : '';
  const linkBadge = (href, label) => href ? `<a href="${href}" target="_blank" class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-sky-100 text-sky-700 border border-sky-200">${label}</a>` : '';
  const github = item.github ? `<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-slate-100 text-slate-700 border">${item.github}</span>` : '';
  const images = (item.images||[]).map(img =>
    `<div class="relative group">
      <img src="${img.img}" class="w-full h-28 object-cover rounded-xl">
      <button data-img="${img.id}" class="del-img hidden group-hover:block absolute top-1 right-1 text-xs bg-white/90 border px-2 py-0.5 rounded">ลบ</button>
    </div>`
  ).join('');

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
        <button data-del="${item.id}" class="text-sm px-3 py-1 rounded-xl border hover:bg-slate-50">ลบ</button>
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

    if (idol?.name) $('#idolName').textContent = `${idol.name} (${idol.nickname || ''})`.trim();
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
  } catch (e) {
    console.error(e);
  }
}

async function refreshList() {
  try {
    const { data } = await callAPI({act:'list'});
    $('#portfolioList').innerHTML = data.map(cardHTML).join('');
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
    ev.target.reset();
    await refreshList();
  } catch (e) { $('#createMsg').textContent = e.message; }
});




(async function init(){
  await loadMeta();
  await refreshList();
})();
</script>
