<?php
require('../../system/a_func.php');
if (!isset($idol_id) || !is_int($idol_id)) { $idol_id = 0; }
if (!isset($activeTab)) { $activeTab = 'profile'; }
?>
<header class="sticky top-0 z-20 bg-white/90 backdrop-blur border-b border-slate-200">
  <div class="max-w-6xl mx-auto px-3 py-2 flex items-center justify-between">
    <div class="flex items-center gap-3">
      <div class="w-9 h-9 rounded-full bg-sky-400"></div>
      <span class="font-semibold text-slate-700">PORTFOLIO</span>
    </div>
    <div class="flex items-center gap-2">
      <input placeholder="ค้นหา..." class="px-3 py-1.5 rounded-full border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-300"/>
      <button class="px-3 py-1.5 rounded-full bg-sky-400 text-white">ค้นหา</button>
    </div>
  </div>

  <!-- Tabs -->
  <div class="bg-white border-t border-slate-100">
    <div class="max-w-6xl mx-auto px-3">
      <nav class="flex gap-4">
        <a href="idol_manage.php?id=<?=$idol_id?>"
           class="px-2 py-2 -mb-px <?= $activeTab==='profile' ? 'text-sky-500 border-b-2 border-sky-400' : 'text-slate-500 hover:text-slate-700' ?>">
          โปรไฟล์
        </a>
        <a href="idol_portfolio.php?id=<?=$idol_id?>"
           class="px-2 py-2 -mb-px <?= $activeTab==='portfolio' ? 'text-sky-500 border-b-2 border-sky-400' : 'text-slate-500 hover:text-slate-700' ?>">
          ผลงาน
        </a>
      </nav>
    </div>
  </div>
</header>
