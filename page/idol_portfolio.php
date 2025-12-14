<?php


if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) { http_response_code(400); die('Bad request'); }
$idol_id = (int)$_GET['id'];
?>

<body class="bg-slate-50 text-slate-800">
<?php $activeTab='portfolio'; include '/partials/topbar.php'; ?>

<section class="bg-sky-300">
  <div class="max-w-6xl mx-auto">
    <div id="cover" class="h-48 sm:h-60" style="background:linear-gradient(90deg,#7dd3fc,#38bdf8)"></div>
  </div>
</section>

<main class="max-w-6xl mx-auto px-3 py-6 grid lg:grid-cols-3 gap-6">
  <!-- ด้านซ้าย: ฟอร์ม (ซ่อนถ้าไม่มีสิทธิ์) -->
  <aside class="lg:col-span-1">
    <div id="createBox" class="bg-white shadow rounded-2xl border border-slate-200">
      <div class="p-4 border-b border-slate-100">
        <h2 class="font-semibold text-slate-700">เพิ่มผลงานใหม่</h2>
        <p class="text-sm text-slate-500">เฉพาะเจ้าของไอดอล (role 1/2)</p>
      </div>
      <form id="createForm" class="p-4 space-y-3">
        <div>
          <label class="block text-sm mb-1">หัวเรื่อง *</label>
          <input name="title" required class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:ring-2 focus:ring-sky-300">
        </div>
        <div>
          <label class="block text-sm mb-1">รายละเอียด *</label>
          <textarea name="detail" rows="4" required class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:ring-2 focus:ring-sky-300"></textarea>
        </div>
        <div class="grid grid-cols-1 gap-3">
          <label class="text-sm">รูปหลัก (URL)
            <input name="img" placeholder="https://..." class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2">
          </label>
          <label class="text-sm">ลิงก์ผลงาน
            <input name="url" placeholder="https://..." class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2">
          </label>
          <label class="text-sm">GitHub
            <input name="github" placeholder="username/repo หรือข้อความสั้น" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2">
          </label>
          <label class="text-sm">Facebook (URL)
            <input name="facebook" placeholder="https://facebook.com/..." class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2">
          </label>
          <label class="text-sm">ไฟล์ PDF (URL)
            <input name="pdf" placeholder="https://..." class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2">
          </label>
        </div>
        <button class="w-full rounded-xl bg-sky-400 text-white px-4 py-2 hover:brightness-110">บันทึกผลงาน</button>
        <p id="createMsg" class="text-sm"></p>
      </form>
    </div>

    <div id="addImgBox" class="mt-6 bg-white shadow rounded-2xl border border-slate-200">
      <div class="p-4 border-b border-slate-100">
        <h2 class="font-semibold text-slate-700">เพิ่มรูปในผลงาน</h2>
      </div>
      <form id="addImageForm" class="p-4 space-y-3">
        <label class="text-sm">เลือกผลงาน
          <select name="port_id" id="portSelect" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2"></select>
        </label>
        <label class="text-sm">รูป (URL) *
          <input name="img" required placeholder="https://..." class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2">
        </label>
        <button class="w-full rounded-xl bg-sky-400 text-white px-4 py-2 hover:brightness-110">เพิ่มรูป</button>
        <p id="addImgMsg" class="text-sm"></p>
      </form>
    </div>

    <div id="noPermBox" class="hidden mt-6 bg-white shadow rounded-2xl border border-slate-200 p-4">
      <p class="text-sm text-slate-600">กำลังดูโปรไฟล์ของไอดอลคนอื่น หรือสิทธิ์ไม่พอ—แก้ไขไม่ได้</p>
    </div>
  </aside>

  <!-- ด้านขวา: รายการผลงาน -->
  <section class="lg:col-span-2">
    <div id="heroTitle" class="mb-2 text-xl font-semibold text-slate-700"></div>
    <div id="portfolioList" class="space-y-4"></div>
  </section>
</main>

<script>
const idolId = <?=$idol_id?>;
const API = 'api_portfolio.php?id=' + idolId;

const $ = (s, c=document)=>c.querySelector(s);
function linkBadge(href,label){return href?`<a href="${href}" target="_blank" class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-sky-100 text-sky-700 border border-sky-200">${label}</a>`:''}

function cardHTML(item){
  const cover = item.img ? `<img src="${item.img}" class="w-full h-48 object-cover rounded-t-2xl">` : '';
  const github = item.github ? `<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-slate-100 text-slate-700 border">${item.github}</span>` : '';
  const images = (item.images||[]).map(img =>
    `<div class="relative group">
      <img src="${img.img}" class="w-full h-28 object-cover rounded-xl">
      <button data-img="${img.id}" class="del-img hidden group-hover:block absolute top-1 right-1 text-xs bg-white/90 border px-2 py-0.5 rounded">ลบ</button>
    </div>`
  ).join('');
  return `
  <article id="port-${item.id}" class="bg-white shadow rounded-2xl border border-slate-200 overflow-hidden">
    ${cover}
    <div class="p-4">
      <div class="flex items-start justify-between gap-3">
        <div>
          <h3 class="text-lg font-semibold text-slate-800">${item.title}</h3>
          <div class="mt-1 flex flex-wrap gap-2">
            ${linkBadge(item.url,'ลิงก์')}${linkBadge(item.facebook,'Facebook')}${linkBadge(item.pdf,'PDF')}${github}
          </div>
        </div>
        <button data-del="${item.id}" class="text-sm px-3 py-1 rounded-xl border hover:bg-slate-50">ลบ</button>
      </div>
      <p class="mt-3 text-slate-700 whitespace-pre-line">${item.detail}</p>
      ${(item.images && item.images.length)?`<div class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-2">${images}</div>`:`<div class="mt-4 text-sm text-slate-400">ยังไม่มีรูปเพิ่มเติม</div>`}
    </div>
  </article>`;
}

async function callAPI(payload){
  const res = await fetch(API, {
    method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'},
    body:new URLSearchParams(payload)
  });
  const j = await res.json();
  if(!res.ok) throw new Error(j?.msg || 'Error');
  return j;
}

async function loadMeta(){
  try{
    const { idol, canEdit } = await callAPI({act:'meta'});
    if(idol?.name){ $('#heroTitle').textContent = `ผลงานของ ${idol.name}${idol.nickname?` (${idol.nickname})`:''}` }
    if(idol?.banner){ const c = $('#cover'); c.style.backgroundImage = `url('${idol.banner}')`; c.style.backgroundSize='cover'; c.style.backgroundPosition='center'; }
    if(canEdit){ $('#createBox').classList.remove('hidden'); $('#addImgBox').classList.remove('hidden'); $('#noPermBox').classList.add('hidden'); }
    else { $('#createBox').classList.add('hidden'); $('#addImgBox').classList.add('hidden'); $('#noPermBox').classList.remove('hidden'); }
  }catch(e){ console.error(e); }
}

async function refreshList(){
  try{
    const { data } = await callAPI({act:'list'});
    $('#portSelect').innerHTML = data.map(d=>`<option value="${d.id}">#${d.id} • ${d.title}</option>`).join('');
    $('#portfolioList').innerHTML = data.map(cardHTML).join('');
  }catch(e){ $('#portfolioList').innerHTML = `<div class="p-4 bg-white rounded-2xl border">โหลดรายการไม่สำเร็จ: ${e.message}</div>`; }
}

$('#createForm').addEventListener('submit', async ev=>{
  ev.preventDefault(); $('#createMsg').textContent='กำลังบันทึก...';
  try{ await callAPI(Object.assign({act:'create'}, Object.fromEntries(new FormData(ev.target).entries()))); $('#createMsg').textContent='สำเร็จ'; ev.target.reset(); await refreshList(); }
  catch(e){ $('#createMsg').textContent = e.message; }
});
$('#addImageForm').addEventListener('submit', async ev=>{
  ev.preventDefault(); $('#addImgMsg').textContent='กำลังเพิ่มรูป...';
  try{ await callAPI(Object.assign({act:'add_image'}, Object.fromEntries(new FormData(ev.target).entries()))); $('#addImgMsg').textContent='สำเร็จ'; ev.target.reset(); await refreshList(); }
  catch(e){ $('#addImgMsg').textContent = e.message; }
});

document.addEventListener('click', async ev=>{
  const delPort = ev.target.closest('[data-del]');
  const delImg = ev.target.closest('.del-img');
  if(delPort){ const id = delPort.getAttribute('data-del'); if(confirm('ลบผลงาน #'+id+' ?')){ try{ await callAPI({act:'delete', port_id:id}); await refreshList(); }catch(e){ alert(e.message); } } }
  if(delImg){ const imgId = delImg.getAttribute('data-img'); if(confirm('ลบรูป #'+imgId+' ?')){ try{ await callAPI({act:'delete_image', img_id:imgId}); await refreshList(); }catch(e){ alert(e.message); } } }
});

(async()=>{ await loadMeta(); await refreshList(); })();
</script>
</body>

