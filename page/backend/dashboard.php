<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set("Asia/Bangkok");

$midnight    = strtotime("today 00:00");
$date_day    = date('Y-m-d H:i:s', $midnight);         // วันนี้ 00:00
$date_month  = date('Y-m-01 00:00:00', $midnight);     // ต้นเดือนนี้ 00:00
$date_7d     = date('Y-m-d H:i:s', strtotime('-7 days', $midnight));
$date_30d    = date('Y-m-d H:i:s', strtotime('-30 days', $midnight));


$usercount   = (int) dd_q("SELECT COUNT(*) FROM users WHERE role = '0'")->fetchColumn();
$idolcount   = (int) dd_q("SELECT COUNT(*) FROM users WHERE role = '1'")->fetchColumn();
$admincount   = (int) dd_q("SELECT COUNT(*) FROM users WHERE role = '2'")->fetchColumn();
$idolport    = (int) dd_q("SELECT COUNT(*) FROM idol_portfolio")->fetchColumn();
$newscount   = (int) dd_q("SELECT COUNT(*) FROM ann")->fetchColumn();
$usercount   = (int) dd_q("SELECT COUNT(*) FROM users")->fetchColumn();

// ผู้เข้าชม (อ้างอิงตาราง idol_views)
$views_today  = (int) dd_q("SELECT COUNT(*) FROM idol_views WHERE last_view >= ?", [$date_day])->fetchColumn();
$views_month  = (int) dd_q("SELECT COUNT(*) FROM idol_views WHERE last_view >= ?", [$date_month])->fetchColumn();
$views_7d     = (int) dd_q("SELECT COUNT(*) FROM idol_views WHERE last_view >= ?", [$date_7d])->fetchColumn();
$views_30d    = (int) dd_q("SELECT COUNT(*) FROM idol_views WHERE last_view >= ?", [$date_30d])->fetchColumn();
$unique_ip_7d = (int) dd_q("SELECT COUNT(DISTINCT ip_address) FROM idol_views WHERE last_view >= ?", [$date_7d])->fetchColumn();

// การมีส่วนร่วม (logloveidol)
$loves_today  = (int) dd_q("SELECT COUNT(*) FROM logloveidol WHERE status_love=1 AND `date` >= ?", [$date_day])->fetchColumn();
$loves_month  = (int) dd_q("SELECT COUNT(*) FROM logloveidol WHERE status_love=1 AND `date` >= ?", [$date_month])->fetchColumn();
$loves_7d     = (int) dd_q("SELECT COUNT(*) FROM logloveidol WHERE status_love=1 AND `date` >= ?", [$date_7d])->fetchColumn();

// ไอดอลที่มีผลงานอย่างน้อย 1 ชิ้น (ใช้ดู conversion)
$idols_with_port = (int) dd_q("SELECT COUNT(DISTINCT idol_id) FROM idol_portfolio")->fetchColumn();
$portfolio_conversion = $idolcount ? round(($idols_with_port / $idolcount) * 100, 2) : 0.0;

// แยกตามคณะ/สาขา (major) และชั้นปี/สถานะ (position)
$by_major = dd_q("
  SELECT m.name AS major_name, COUNT(*) AS c
  FROM idol i
  LEFT JOIN major m ON m.id = i.major_id
  GROUP BY i.major_id
  ORDER BY c DESC, m.name ASC
")->fetchAll(PDO::FETCH_ASSOC);

$by_position = dd_q("
  SELECT position, COUNT(*) AS c
  FROM idol
  GROUP BY position
  ORDER BY position ASC
")->fetchAll(PDO::FETCH_ASSOC);

// Top 5 ไอดอลยอดนิยม (7 วัน) ตามยอดกดถูกใจ
$top_idol_love_7d = dd_q("
  SELECT i.id, i.name, i.nickname, COUNT(*) AS love7
  FROM logloveidol l
  JOIN idol i ON i.id = l.idol_id
  WHERE l.status_love = 1 AND l.`date` >= ?
  GROUP BY l.idol_id
  ORDER BY love7 DESC
  LIMIT 5
", [$date_7d])->fetchAll(PDO::FETCH_ASSOC);

// Top 5 ไอดอลคนดูเยอะ (7 วัน) ตามจำนวนวิว
$top_idol_view_7d = dd_q("
  SELECT i.id, i.name, i.nickname, COUNT(*) AS view7
  FROM idol_views v
  JOIN idol i ON i.id = v.idol_id
  WHERE v.last_view >= ?
  GROUP BY v.idol_id
  ORDER BY view7 DESC
  LIMIT 5
", [$date_7d])->fetchAll(PDO::FETCH_ASSOC);

// ผลงานล่าสุด 10 รายการ
$latest_ports = dd_q("
  SELECT p.id, p.title, p.url, p.github, p.facebook, p.pdf, p.img, p.idol_id, i.nickname
  FROM idol_portfolio p
  LEFT JOIN idol i ON i.id = p.idol_id
  ORDER BY p.id DESC
  LIMIT 10
")->fetchAll(PDO::FETCH_ASSOC);

// ผู้ใช้สมัครล่าสุด 10 คน
$latest_users = dd_q("
  SELECT id, username, nickname, `date`, role
  FROM users
  ORDER BY id DESC
  LIMIT 10
");
$latest_users = $latest_users ? $latest_users->fetchAll(PDO::FETCH_ASSOC) : [];

// กราฟแนวโน้ม (7 และ 30 วัน) — สร้าง series ต่อวันให้ chart.php ใช้งาน
$love_series_7d = dd_q("
  SELECT DATE(`date`) AS d, COUNT(*) AS c
  FROM logloveidol
  WHERE status_love=1 AND `date` >= ?
  GROUP BY DATE(`date`)
  ORDER BY d ASC
", [$date_7d])->fetchAll(PDO::FETCH_ASSOC);

$view_series_7d = dd_q("
  SELECT DATE(last_view) AS d, COUNT(*) AS c
  FROM idol_views
  WHERE last_view >= ?
  GROUP BY DATE(last_view)
  ORDER BY d ASC
", [$date_7d])->fetchAll(PDO::FETCH_ASSOC);

$view_series_30d = dd_q("
  SELECT DATE(last_view) AS d, COUNT(*) AS c
  FROM idol_views
  WHERE last_view >= ?
  GROUP BY DATE(last_view)
  ORDER BY d ASC
", [$date_30d])->fetchAll(PDO::FETCH_ASSOC);

// helper
function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function nf($n){ return number_format((float)$n); } // สำหรับขึ้นการ์ดสวยๆ
?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">


<div class="stat-card rounded-2xl p-6 card-hover border-2">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sky-600 text-sm font-medium">สมาชิกทั้งหมด</p>
        <p class="text-3xl font-bold text-sky-700 mt-2"><?= nf($usercount); ?></p>
      </div>
      <div class="w-12 h-12 bg-gradient-to-r from-sky-400 to-sky-500 rounded-xl flex items-center justify-center">
        <i class="fas fa-user text-white text-xl"></i>
      </div>
    </div>
  </div>

<div class="stat-card rounded-2xl p-6 card-hover">
  <div class="flex items-center justify-between">
      <div>
        <p class="text-sky-600 text-sm font-medium">แอดมินทั้งหมด</p>
        <p class="text-3xl font-bold text-sky-700 mt-2"><?= nf($admincount); ?></p>
      </div>
      <div class="w-12 h-12 bg-gradient-to-r from-sky-400 to-sky-500 rounded-xl flex items-center justify-center">
        <i class="fas fa-user text-white text-xl"></i>
      </div>
    </div>
  </div>


  <div class="stat-card rounded-2xl p-6 card-hover">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sky-600 text-sm font-medium">นักศึกษาทั้งหมด</p>
        <p class="text-3xl font-bold text-sky-700 mt-2"><?= nf($idolcount); ?></p>
      </div>
      <div class="w-12 h-12 bg-gradient-to-r from-sky-400 to-sky-500 rounded-xl flex items-center justify-center">
        <i class="fas fa-user-graduate text-white text-xl"></i>
      </div>
    </div>
  </div>



  <div class="stat-card rounded-2xl p-6 card-hover">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sky-600 text-sm font-medium">ผลงานทั้งหมด</p>
        <p class="text-3xl font-bold text-sky-700 mt-2"><?= nf($idolport); ?></p>
      </div>
      <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-blue-500 rounded-xl flex items-center justify-center">
        <i class="fas fa-folder text-white text-xl"></i>
      </div>
    </div>
  </div>

  <div class="stat-card rounded-2xl p-6 card-hover">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sky-600 text-sm font-medium">ข่าวสาร</p>
        <p class="text-3xl font-bold text-sky-700 mt-2"><?= nf($newscount); ?></p>
      </div>
      <div class="w-12 h-12 bg-gradient-to-r from-cyan-400 to-cyan-500 rounded-xl flex items-center justify-center">
        <i class="fas fa-newspaper text-white text-xl"></i>
      </div>
    </div>
  </div>

  <div class="stat-card rounded-2xl p-6 card-hover">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sky-600 text-sm font-medium">ผู้เข้าชมวันนี้</p>
        <p class="text-3xl font-bold text-sky-700 mt-2"><?= nf($views_today); ?></p>
      </div>
      <div class="w-12 h-12 bg-gradient-to-r from-indigo-400 to-indigo-500 rounded-xl flex items-center justify-center">
        <i class="fas fa-eye text-white text-xl"></i>
      </div>
    </div>
  </div>
</div>

<!-- แถวสรุปเพิ่ม -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
  <div class="stat-card rounded-2xl p-6 card-hover">
    <p class="text-sky-600 text-sm font-medium">วิว (7 วัน)</p>
    <p class="text-3xl font-bold text-sky-700 mt-2"><?= nf($views_7d); ?></p>
    <p class="text-xs text-gray-500 mt-1">Unique IP (7 วัน): <?= nf($unique_ip_7d); ?></p>
  </div>
  <div class="stat-card rounded-2xl p-6 card-hover">
    <p class="text-sky-600 text-sm font-medium">วิว (เดือนนี้)</p>
    <p class="text-3xl font-bold text-sky-700 mt-2"><?= nf($views_month); ?></p>
  </div>
  <div class="stat-card rounded-2xl p-6 card-hover">
    <p class="text-sky-600 text-sm font-medium">ถูกใจ (วันนี้)</p>
    <p class="text-3xl font-bold text-sky-700 mt-2"><?= nf($loves_today); ?></p>
    <p class="text-xs text-gray-500 mt-1">เดือนนี้: <?= nf($loves_month); ?> | 7 วัน: <?= nf($loves_7d); ?></p>
  </div>
  <div class="stat-card rounded-2xl p-6 card-hover">
    <p class="text-sky-600 text-sm font-medium">สัดส่วนมีผลงาน</p>
    <p class="text-3xl font-bold text-sky-700 mt-2"><?= nf($portfolio_conversion); ?>%</p>
    <p class="text-xs text-gray-500 mt-1"><?= nf($idols_with_port); ?> / <?= nf($idolcount); ?> คน</p>
  </div>
</div>

<!-- Top lists -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
  <div class="rounded-2xl p-6 card-hover bg-white">
    <h3 class="text-lg font-semibold mb-3">Top 5 ไอดอล “ถูกใจ” สูงสุด (7 วัน)</h3>
    <table class="w-full">
      <thead>
        <tr class="text-left text-sm text-gray-500">
          <th class="pb-2">ไอดอล</th><th class="pb-2">ถูกใจ 7 วัน</th>
        </tr>
      </thead>
      <tbody class="text-sm">
        <?php foreach($top_idol_love_7d as $r): ?>
        <tr class="border-t">
          <td class="py-2"><?= h($r['name']).' ('.h($r['nickname']).')'; ?></td>
          <td class="py-2"><?= nf($r['love7']); ?></td>
        </tr>
        <?php endforeach; if(!$top_idol_love_7d){ echo '<tr><td class="py-2" colspan="2">—</td></tr>'; } ?>
      </tbody>
    </table>
  </div>

  <div class="rounded-2xl p-6 card-hover bg-white">
    <h3 class="text-lg font-semibold mb-3">Top 5 ไอดอล “ผู้ชม” สูงสุด (7 วัน)</h3>
    <table class="w-full">
      <thead>
        <tr class="text-left text-sm text-gray-500">
          <th class="pb-2">ไอดอล</th><th class="pb-2">วิว 7 วัน</th>
        </tr>
      </thead>
      <tbody class="text-sm">
        <?php foreach($top_idol_view_7d as $r): ?>
        <tr class="border-t">
          <td class="py-2"><?= h($r['name']).' ('.h($r['nickname']).')'; ?></td>
          <td class="py-2"><?= nf($r['view7']); ?></td>
        </tr>
        <?php endforeach; if(!$top_idol_view_7d){ echo '<tr><td class="py-2" colspan="2">—</td></tr>'; } ?>
      </tbody>
    </table>
  </div>
</div>

<!-- ตารางแยกตามสาขา/สถานะ -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
  <div class="rounded-2xl p-6 card-hover bg-white">
    <h3 class="text-lg font-semibold mb-3">จำนวนไอดอลตามสาขา</h3>
    <table class="w-full">
      <thead>
        <tr class="text-left text-sm text-gray-500"><th class="pb-2">สาขา</th><th class="pb-2">จำนวน</th></tr>
      </thead>
      <tbody class="text-sm">
        <?php foreach($by_major as $r): ?>
          <tr class="border-t"><td class="py-2"><?= h($r['major_name'] ?: 'ไม่ระบุ'); ?></td><td class="py-2"><?= nf($r['c']); ?></td></tr>
        <?php endforeach; if(!$by_major){ echo '<tr><td class="py-2" colspan="2">—</td></tr>'; } ?>
      </tbody>
    </table>
  </div>

  <div class="rounded-2xl p-6 card-hover bg-white">
    <h3 class="text-lg font-semibold mb-3">จำนวนไอดอลตามชั้นปี/สถานะ</h3>
    <table class="w-full">
      <thead>
        <tr class="text-left text-sm text-gray-500"><th class="pb-2">ชั้นปี/สถานะ</th><th class="pb-2">จำนวน</th></tr>
      </thead>
      <tbody class="text-sm">
        <?php
        function position_text($v){
          $v = (int)$v;
          if ($v === 99) return 'ศิษย์เก่า';
          if ($v >= 1 && $v <= 4) return "นักศึกษาปี $v";
          return 'ไม่ระบุ';
        }
        foreach($by_position as $r):
        ?>
          <tr class="border-t"><td class="py-2"><?= h(position_text($r['position'])); ?></td><td class="py-2"><?= nf($r['c']); ?></td></tr>
        <?php endforeach; if(!$by_position){ echo '<tr><td class="py-2" colspan="2">—</td></tr>'; } ?>
      </tbody>
    </table>
  </div>
</div>

<!-- กราฟสรุป: ส่งข้อมูลไปให้ chart.php ใช้ -->
<script>
  window.__REPORT__ = {
    love7: <?= json_encode($love_series_7d, JSON_UNESCAPED_UNICODE); ?>,
    view7: <?= json_encode($view_series_7d, JSON_UNESCAPED_UNICODE); ?>,
    view30: <?= json_encode($view_series_30d, JSON_UNESCAPED_UNICODE); ?>
  };
</script>

<!-- รายการล่าสุด -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
  <div class="rounded-2xl p-6 card-hover bg-white">
    <h3 class="text-lg font-semibold mb-3">ผลงานที่เพิ่มล่าสุด</h3>
    <table class="w-full">
      <thead>
        <tr class="text-left text-sm text-gray-500">
          <th class="pb-2">ชื่อเรื่อง</th><th class="pb-2">ไอดอล</th><th class="pb-2">ลิงก์</th>
        </tr>
      </thead>
      <tbody class="text-sm">
        <?php foreach($latest_ports as $p): ?>
        <tr class="border-t">
          <td class="py-2"><?= h($p['title']); ?></td>
          <td class="py-2"><?= h($p['nickname'] ?: ('ID#'.$p['idol_id'])); ?></td>
          <td class="py-2">
            <?php if($p['url']): ?><a class="text-sky-600 hover:underline" href="<?= h($p['url']); ?>" target="_blank">เปิด</a><?php else: ?>—<?php endif; ?>
          </td>
        </tr>
        <?php endforeach; if(!$latest_ports){ echo '<tr><td class="py-2" colspan="3">—</td></tr>'; } ?>
      </tbody>
    </table>
  </div>

  <div class="rounded-2xl p-6 card-hover bg-white">
    <h3 class="text-lg font-semibold mb-3">ผู้ใช้สมัครล่าสุด</h3>
    <table class="w-full">
      <thead>
        <tr class="text-left text-sm text-gray-500">
          <th class="pb-2">ผู้ใช้</th><th class="pb-2">ชื่อเล่น</th><th class="pb-2">สิทธิ์</th><th class="pb-2">สมัครเมื่อ</th>
        </tr>
      </thead>
      <tbody class="text-sm">
        <?php foreach($latest_users as $u): ?>
        <tr class="border-t">
          <td class="py-2"><?= h($u['username']); ?></td>
          <td class="py-2"><?= h($u['nickname']); ?></td>
          <td class="py-2"><?= h($u['role']); ?></td>
          <td class="py-2"><?= h($u['date']); ?></td>
        </tr>
        <?php endforeach; if(!$latest_users){ echo '<tr><td class="py-2" colspan="4">—</td></tr>'; } ?>
      </tbody>
    </table>
  </div>
</div>


