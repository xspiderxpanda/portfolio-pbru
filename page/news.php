<?php
$api_url = "https://itpbru.mucity.online/api/";

// ฟังก์ชันดึงข้อมูลข่าว
function getNewsData($api_url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);
    $json = json_decode($response, true);
    return $json ?: [];
}
$news_list = getNewsData($api_url);

// จัดเรียงตามวันที่ (ใหม่ -> เก่า)
usort($news_list, function($a, $b) {
    return strtotime($b['date']) - strtotime($a['date']);
});

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // หน้าแสดงรายละเอียดข่าว
    $row = null;
    foreach ($news_list as $news) {
        if ($news['id'] == $id) {
            $row = $news;
            break;
        }
    }
    if ($row) {
        ?>
        <!-- Header -->
        <div class="bg-white shadow-lg border-b-4 border-sky-300">
            <div class="max-w-6xl mx-auto px-6 py-8">
                <div class="flex items-center space-x-4">
                    <a href="?" class="inline-flex items-center text-sky-600 hover:text-sky-800 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        กลับไปหน้าแรก
                    </a>
                    <span class="text-gray-300">|</span>
                    <span class="text-sky-700 font-medium">รายละเอียดข่าวสาร</span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="max-w-6xl mx-auto px-6 py-10">
            <article class="bg-white shadow-xl rounded-3xl overflow-hidden border border-sky-200">
                <div class="bg-gradient-to-r from-sky-300 to-sky-400 px-8 py-8 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-white rounded-full opacity-80"></div>
                            <span class="text-sky-100 text-sm font-medium">ข่าวสารประกาศ</span>
                        </div>
                        <div class="text-sky-100 text-sm">
                            <?php echo date("d M Y | H:i น.", strtotime($row['date'])); ?>
                        </div>
                    </div>
                    <h1 class="text-3xl font-bold leading-tight">
                        <?php echo htmlspecialchars($row['title']); ?>
                    </h1>
                </div>

                <?php if (!empty($row['img'])): ?>
                    <div class="relative">
                        <img src="<?php echo htmlspecialchars($row['img']); ?>" 
                             alt="<?php echo htmlspecialchars($row['des']); ?>" 
                             class="w-full h-80 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent"></div>
                    </div>
                <?php endif; ?>

                <div class="px-5 py-5">
                    <div class="p-6 bg-sky-50 rounded-2xl border border-sky-200">
                        <div class="text-gray-800 text-lg whitespace-pre-line"><?php echo htmlspecialchars($row['des']); ?></div>
                    </div>
                </div>

                <div class="px-5 py-1 mb-2">
    <div class="grid gap-6 <?php echo !empty($row['link']) ? 'md:grid-cols-2' : 'grid-cols-1'; ?>">
        <!-- ลิงก์ที่เกี่ยวข้อง (ถ้ามี) -->
        <?php if(!empty($row['link'])): ?>
        <div class="p-6 bg-sky-50 rounded-2xl border border-sky-200">
            <h3 class="text-center text-lg font-semibold text-sky-800 mb-3">ลิงก์ที่เกี่ยวข้อง</h3>
            <a href="<?php echo htmlspecialchars($row['link']); ?>" target="_blank"
               class="inline-flex items-center bg-sky-400 hover:bg-sky-500 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                อ่านเพิ่มเติม
            </a>
        </div>
        <?php endif; ?>

        <!-- แชร์ข่าว -->
        <div class="p-6 bg-sky-50 rounded-2xl border border-sky-200 <?php echo !empty($row['link']) ? 'md:col-span-1' : ''; ?>">
            <h3 class="text-center text-lg font-semibold text-sky-800 mb-3">แชร์ข่าวนี้</h3>
            <div class="text-center space-x-5">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>" 
                   target="_blank"
                   class="mt-2 mb-2 inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-medium shadow-md transition duration-200">
                    แชร์ไปที่ Facebook
                </a>

                <button onclick="copyShareLink()" 
                        class="text-center inline-flex items-center bg-sky-400 hover:bg-sky-500 text-white px-5 py-3 rounded-xl font-medium shadow-md transition duration-200">
                    คัดลอกลิงก์
                </button>
            </div>
        </div>
    </div>
</div>

                

          </div>
                        


                <script>
                function copyShareLink() {
                    const url = window.location.href;
                    navigator.clipboard.writeText(url).then(() => {
                        alert("คัดลอกลิงก์แล้ว!");
                    });
                }
                </script>

            </article>
        </div>
        <?php
    } else {
        echo "<div class='max-w-4xl mx-auto px-6 py-20 text-center'>ไม่พบข่าวสารนี้</div>";
    }
} else {
    // หน้าแสดงรายการข่าว
    ?>
    <div class="max-w-6xl mx-auto px-6 py-12">
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($news_list as $row): ?>
                <article class="bg-white rounded-3xl shadow-lg border border-sky-200 hover:shadow-2xl hover:scale-105 transition-all duration-300 overflow-hidden group">
                    <?php if (!empty($row['img'])): ?>
                        <div class="relative overflow-hidden">
                            <img src="<?php echo htmlspecialchars($row['img']); ?>" 
                                 alt="<?php echo htmlspecialchars($row['des']); ?>" 
                                 class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute top-4 left-4">
                                <span class="bg-sky-400 text-white px-3 py-1 rounded-full text-sm font-medium">
                                    <?php echo $row['categories']; ?>
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sky-600 text-sm font-medium">
                                📅 <?php echo date("d/m/Y", strtotime($row['date'])); ?>
                            </span>
                            <span class="text-gray-400 text-xs">
                                ID: #<?php echo $row['id']; ?>
                            </span>
                        </div>

                        <h2 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-sky-700 transition-colors duration-200">
                            <?php echo htmlspecialchars(mb_substr($row['des'],0,50)) . '...'; ?>
                        </h2>

                        <a href="?id=<?php echo $row['id']; ?>" 
                           class="inline-flex items-center text-sky-400 hover:text-sky-600 font-medium text-sm transition-colors duration-200 group">
                            อ่านต่อ
                            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform duration-200" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}
?>
