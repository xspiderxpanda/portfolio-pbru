<main class="max-w-6xl mx-auto px-4 mt-6 space-y-6">

    <section>
      <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="relative">
          <img id="previewBanner" src="https://placehold.co/1200x400?text=Banner" class="w-full h-52 object-cover" alt="">
          <img id="previewImg" src="https://placehold.co/200x200?text=Avatar"
               class="w-36 h-36 object-cover rounded-full ring-4 ring-white absolute left-6 -bottom-14" alt="">
        </div>
        <div class="pt-16 px-6 pb-4">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
              <h1 id="previewName" class="text-2xl font-bold leading-tight">ชื่อจริง</h1>
              <p id="previewNick" class="text-gray-500 -mt-0.5">(@nickname)</p>
            </div>
          </div>
          <div id="previewInfo" class="mt-4 text-sm text-gray-700 whitespace-pre-wrap">
            เขียนแนะนำตัวไว้ตรงนี้แล้วจะพรีวิว…
          </div>
          <div class="mt-4 text-xs text-gray-500">
            วันเกิด: <span id="previewDob">YYYY-MM-DD</span> · สาขา/หมวด (major_id): <span id="previewMajor">0</span>
          </div>
          <div class="mt-2 text-xs text-gray-500">
            ช่องทางติดต่อ: <a id="previewContact" href="#" class="text-sky-600 hover:underline">—</a>
          </div>
        </div>
      </div>
    </section>


    <aside >
      <form id="idolForm" class="bg-white rounded-2xl shadow p-5 space-y-4 mb-3">
        <h2 class="text-lg font-semibold">สร้างโปรไฟล์ให้นักศึกษา</h2>
        <div class="grid grid-cols-1 gap-3">
          <label class="text-sm">ชื่อจริง
            <input name="name" required class="mt-1 w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-sky-500"/>
          </label>
          <label class="text-sm">ชื่อเล่น (nickname)
            <input name="nickname" required class="mt-1 w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-sky-500"/>
          </label>
          <label class="text-sm">ลิงก์รูปโปรไฟล์ (img)
            <input name="img" placeholder="https://…" class="mt-1 w-full border rounded-xl px-3 py-2"/>
          </label>
          <label class="text-sm">ลิงก์แบนเนอร์ (banner)
            <input name="banner" placeholder="https://…" class="mt-1 w-full border rounded-xl px-3 py-2"/>
          </label>
          <label class="text-sm">ข้อมูลแนะนำตัว (info)
            <textarea name="info" rows="5" class="mt-1 w-full border rounded-xl px-3 py-2"></textarea>
          </label>
          <label class="text-sm">เลือกสาขา (major_id)
            <select name="major_id" class="mt-1 w-full border rounded-xl px-3 py-2">
                <?php
                                $getrow = dd_q("SELECT * FROM major ORDER BY id DESC");
                                while ($row = $getrow->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                <?php } ?>
            </select>
            </label>
          <label class="text-sm">วันเกิด (YYYY-MM-DD)
            <input name="dateofbirth" type="date" class="mt-1 w-full border rounded-xl px-3 py-2"/>
          </label>
          <label class="text-sm">ช่องทางติดต่อ (URL/ข้อความ)
            <input name="contact" class="mt-1 w-full border rounded-xl px-3 py-2"/>
          </label>
        </div>

        <button type="submit"
          class="w-full py-2 rounded-xl bg-sky-400 text-white font-semibold hover:brightness-110">
          บันทึกโปรไฟล์
        </button>

        <div id="resp" class="text-sm"></div>
      </form>
    </aside>
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
    document.getElementById('previewMajor').textContent = txt;
    });
    bind('contact', e => {
      const a = document.getElementById('previewContact');
      a.textContent = e.target.value || '—';
      a.href = e.target.value || '#';
    });

    // ส่ง AJAX ไปหลังบ้าน
    f.addEventListener('submit', async (ev) => {
      ev.preventDefault();
      const respEl = document.getElementById('resp');
      respEl.textContent = 'กำลังบันทึก…';
      try {
        const formData = new FormData(f);
        const payload = Object.fromEntries(formData.entries());
        const res = await fetch('system/idol_create.php', {
          method: 'POST',
          headers: {'Content-Type': 'application/json'},
          body: JSON.stringify(payload),
          credentials: 'include'
        });
        const data = await res.json();
        if (res.ok) {
          respEl.className = "text-sm text-green-600 mt-2";
          respEl.textContent = '✅ ' + (data.msg || 'บันทึกสำเร็จ');
          f.reset();
        } else {
          respEl.className = "text-sm text-red-600 mt-2";
          respEl.textContent = '❌ ' + (data.msg || 'บันทึกล้มเหลว');
        }
      } catch (e) {
        respEl.className = "text-sm text-red-600 mt-2";
        respEl.textContent = '❌ ขัดข้อง: ' + e.message;
      }
    });
  </script>

