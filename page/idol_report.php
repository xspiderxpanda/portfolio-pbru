<main class="max-w-6xl mx-auto px-4 mt-6 space-y-6">

<?php


// 1) validate id & session
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) { http_response_code(400); die('Bad request'); }
$idol_id = (int)$_GET['id'];

if (!isset($_SESSION['id'])) { die('กรุณาเข้าสู่ระบบ'); }
$q_user = dd_q('SELECT * FROM users WHERE id = ?', [$_SESSION['id']]);
if ($q_user->rowCount() < 1) { die('ไม่พบผู้ใช้'); }
$plr = $q_user->fetch(PDO::FETCH_ASSOC);
if (!isset($plr['role']) || ($plr['role'] !== "1" && $plr['role'] !== "2")) {
  die('คุณไม่มีสิทธิ์เข้าถึงรายงานนี้');
}

// 2) ตรวจว่าเป็นแอดมินของไอดอลนี้จริง
$id1 = dd_q("SELECT * FROM idol WHERE id = ? AND FIND_IN_SET(?, u_admin)", [$idol_id, $_SESSION['id']]);
$idol = $id1->fetch(PDO::FETCH_ASSOC);
if (!$idol) { die('<div class="text-center py-5"><span class="mt-3 rounded-xl bg-sky-100 border-sky-500 text-sky-600 px-5 py-5">ไม่พบข้อมูล หรือคุณไม่มีสิทธิ์ดูรายงานนี้</span></div>'); }

// 3) ดึงข้อมูลประกอบรายงาน
// 3.1 จำนวนผลงานทั้งหมด
$total_port = (int)dd_q("SELECT COUNT(*) c FROM idol_portfolio WHERE idol_id = ?", [$idol_id])->fetchColumn();

// 3.2 ยอดถูกใจรวม
$total_love = (int)dd_q("SELECT COUNT(*) c FROM logloveidol WHERE idol_id = ? AND status_love = 1", [$idol_id])->fetchColumn();

// 3.3 unique views (จากตาราง idol_views)
$unique_views = (int)dd_q("SELECT COUNT(*) c FROM idol_views WHERE idol_id = ?", [$idol_id])->fetchColumn();

// 3.4 ผู้กดถูกใจล่าสุด 10 รายการ พร้อมชื่อผู้ใช้
$recent_lovers = dd_q(
  "SELECT l.u_id, l.date, u.nickname 
   FROM logloveidol l 
   LEFT JOIN users u ON u.id = l.u_id
   WHERE l.idol_id = ? AND l.status_love = 1
   ORDER BY l.date DESC
   LIMIT 10", [$idol_id]
)->fetchAll(PDO::FETCH_ASSOC);

// 3.5 แนวโน้มถูกใจย้อนหลัง 30 วัน (กลุ่มตามวัน)
$love_by_day = dd_q(
  "SELECT DATE(`date`) d, COUNT(*) c
   FROM logloveidol
   WHERE idol_id = ? AND status_love = 1
     AND `date` >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
   GROUP BY DATE(`date`)
   ORDER BY d ASC", [$idol_id]
)->fetchAll(PDO::FETCH_ASSOC);

// 3.6 รายชื่อผลงานทั้งหมด
$ports = dd_q(
  "SELECT id, title, url, github, facebook, pdf, img 
   FROM idol_portfolio
   WHERE idol_id = ?
   ORDER BY id DESC", [$idol_id]
)->fetchAll(PDO::FETCH_ASSOC);

// 3.7 ผู้เข้าชมล่าสุด 10 รายการ
$recent_viewers = dd_q(
  "SELECT ip_address, last_view
   FROM idol_views
   WHERE idol_id = ?
   ORDER BY last_view DESC
   LIMIT 10", [$idol_id]
)->fetchAll(PDO::FETCH_ASSOC);

// helper
function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
?>

  <style>
    body { font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto; margin: 16px; color:#0f172a;}
    .card { background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:16px; margin-bottom:12px; }
    .grid { display:grid; gap:12px; }
    .grid-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .muted{ color:#64748b; font-size:13px;}
    .table { width:100%; border-collapse: collapse; }
    .table th, .table td { border-bottom:1px solid #e2e8f0; padding:8px 6px; text-align:left; }
    .btn { display:inline-block; padding:8px 12px; border-radius:10px; background:#0ea5e9; color:#fff; text-decoration:none; }
    @media print { .no-print { display:none; } body { margin:0; } html { background:#fff; } }
  </style>

  <div class="no-print" style="display:flex; gap:8px; margin-bottom:12px;">
    <a class="btn" href="javascript:window.print()">พิมพ์รายงาน</a>
    <a class="btn" href="/edit-idol.php?id=<?php echo (int)$idol_id; ?>">กลับไปแก้ไขโปรไฟล์</a>
  </div>

  <!-- Header -->
  <div class="card">
    <h1 style="font-size:22px; margin:0 0 6px;">
      รายงานโปรไฟล์: <?php echo h($idol['name']); ?> (<?php echo h($idol['nickname']); ?>)
    </h1>
    <div class="muted">อัปเดตล่าสุด: <?php echo h($idol['dateupdate']); ?></div>
    <div class="grid grid-2" style="margin-top:10px;">
      <div>
        <div><b>ชื่อ - สกุล:</b> <?php echo h($idol['name']); ?></div>
        <div><b>วันเกิด:</b> <?php echo h($idol['dateofbirth']); ?></div>
        <div><b>ติดต่อ:</b> <a href="<?php echo h($idol['contact'] ?: '#'); ?>"><?php echo h($idol['contact'] ?: '—'); ?></a></div>
      </div>
      <div>
        <div><b>จำนวนผลงาน:</b> <?php echo $total_port; ?></div>
        <div><b>ยอดถูกใจรวม:</b> <?php echo $total_love; ?></div>
        <div><b>ผู้ชม (Unique IP):</b> <?php echo $unique_views; ?></div>
      </div>
    </div>
  </div>

  <!-- ผังสรุป -->
  <div class="grid grid-2">
    <div class="card">
      <h2 style="margin:0 0 8px;">ผู้กดถูกใจล่าสุด</h2>
      <table class="table">
        <thead><tr><th>ผู้ใช้</th><th>เวลา</th></tr></thead>
        <tbody>
          <?php foreach($recent_lovers as $lv): ?>
          <tr>
            <td><?php echo h($lv['nickname'] ?: ('UID#'.$lv['u_id'])); ?></td>
            <td><?php echo h($lv['date']); ?></td>
          </tr>
          <?php endforeach; if(!$recent_lovers){ echo '<tr><td colspan="2">—</td></tr>'; } ?>
        </tbody>
      </table>
    </div>
    <div class="card">
      <h2 style="margin:0 0 8px;">ผู้เข้าชมล่าสุด (IP)</h2>
      <table class="table">
        <thead><tr><th>IP</th><th>เวลา</th></tr></thead>
        <tbody>
          <?php foreach($recent_viewers as $rv): ?>
          <tr>
            <td><?php echo h($rv['ip_address']); ?></td>
            <td><?php echo h($rv['last_view']); ?></td>
          </tr>
          <?php endforeach; if(!$recent_viewers){ echo '<tr><td colspan="2">—</td></tr>'; } ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="card">
    <h2 style="margin:0 0 8px;">ผลงานทั้งหมด</h2>
    <table class="table">
      <thead>
        <tr>
          <th>#</th><th>หัวเรื่อง</th><th>ลิงก์</th><th>GitHub</th><th>Facebook</th><th>PDF</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($ports as $p): ?>
        <tr>
          <td><?php echo (int)$p['id']; ?></td>
          <td><?php echo h($p['title']); ?></td>
          <td><?php echo $p['url'] ? '<a href="'.h($p['url']).'">เปิด</a>' : '—'; ?></td>
          <td><?php echo $p['github'] ? '<a href="'.h($p['github']).'">เปิด</a>' : '—'; ?></td>
          <td><?php echo $p['facebook'] ? '<a href="'.h($p['facebook']).'">เปิด</a>' : '—'; ?></td>
          <td><?php echo $p['pdf'] ? '<a href="'.h($p['pdf']).'">เปิด</a>' : '—'; ?></td>
        </tr>
        <?php endforeach; if(!$ports){ echo '<tr><td colspan="6">—</td></tr>'; } ?>
      </tbody>
    </table>
  </div>

</main>