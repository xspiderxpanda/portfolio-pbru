<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>window.location.href = '/home';</script>";
    exit;
}

// 1. ดึงข้อมูลผลงานจาก idol_portfolio
$portfolio_stmt = dd_q("SELECT * FROM idol_portfolio WHERE id = ? LIMIT 1", [$_GET['id']]);
$portfolio = $portfolio_stmt->fetch(PDO::FETCH_ASSOC);

if (!$portfolio) {
    echo "<script>window.location.href = '/home';</script>";
    exit;
}

// 2. ดึงข้อมูลนักศึกษาจาก idol
$idol_stmt = dd_q("SELECT * FROM idol WHERE id = ? LIMIT 1", [$portfolio['idol_id']]);
$idol = $idol_stmt->fetch(PDO::FETCH_ASSOC);

// 3. ดึงรูปภาพเพิ่มเติมจาก idol_portfolio_img
$extra_img_stmt = dd_q("SELECT * FROM idol_portfolio_img WHERE port_id = ? ORDER BY id ASC", [$portfolio['id']]);
$extra_imgs = $extra_img_stmt->fetchAll(PDO::FETCH_ASSOC);

$all_images = [];
if (!empty($idol['img'])) {
    $all_images[] = $idol['img']; // ภาพหลัก
}
foreach ($extra_images as $img) {
    $all_images[] = $img['img']; // ภาพเพิ่มเติม
}
?>

<!-- Alpine.js สำหรับ Lightbox -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-sky-100" x-data="{ openLightbox: false, currentImg: '' }">
    <div class="container mx-auto px-4 py-8">
        
        <!-- Header: ข้อมูลนักศึกษา -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
            <div class="relative h-64 md:h-80">
                <img src="<?php echo htmlspecialchars($idol['banner']); ?>" 
                     class="w-full h-full object-cover" alt="Profile Cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                
                <!-- รูปโปรไฟล์ -->
                <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2">
                    <img src="<?php echo htmlspecialchars($idol['img']); ?>" 
                         class="w-32 h-32 rounded-full border-4 border-white shadow-xl object-cover" alt="Profile">
                </div>
            </div>
            <div class="pt-20 pb-6 text-center">
                <h1 class="text-3xl font-bold text-gray-800"><?php echo htmlspecialchars($idol['name']); ?></h1>
                <p class="text-sky-500"><?php echo htmlspecialchars($idol['nickname']); ?></p>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
            <!-- รายละเอียดผลงาน -->
            <div class="xl:col-span-3">
                <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">
                        <?php echo htmlspecialchars($portfolio['title']); ?>
                    </h2>
                    
                    <!-- รูปผลงานหลัก -->
                    <div class="mb-6">
                        <img src="<?php echo htmlspecialchars($portfolio['img']); ?>" 
                             class="w-full rounded-xl shadow-md object-cover cursor-pointer hover:scale-105 transition-transform"
                             alt="<?php echo htmlspecialchars($portfolio['title']); ?>"
                             @click="openLightbox = true; currentImg = '<?php echo htmlspecialchars($portfolio['img']); ?>'">
                    </div>

                    <!-- รูปภาพเพิ่มเติม -->
                    <?php if (!empty($extra_imgs)): ?>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-6">
                        <?php foreach ($extra_imgs as $img): ?>
                            <div class="overflow-hidden rounded-lg border border-gray-200">
                                <img src="<?php echo htmlspecialchars($img['img']); ?>" 
                                     alt="Extra Image" 
                                     class="w-full h-32 object-cover cursor-pointer hover:scale-105 transition-transform duration-300"
                                     @click="openLightbox = true; currentImg = '<?php echo htmlspecialchars($img['img']); ?>'">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- รายละเอียดผลงาน -->
                    <p class="text-gray-700 leading-relaxed mb-6">
                        <?php echo nl2br(htmlspecialchars($portfolio['detail'])); ?>
                    </p>

                    <!-- ปุ่มลิงก์ -->
                    <div class="flex flex-wrap gap-3">
                        <?php if (!empty($portfolio['url'])): ?>
                            <a href="<?php echo htmlspecialchars($portfolio['url']); ?>" target="_blank" 
                               class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg font-medium transition">
                                <i class="fas fa-external-link-alt mr-2"></i> เปิดลิงก์
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($portfolio['github'])): ?>
                            <a href="<?php echo htmlspecialchars($portfolio['github']); ?>" target="_blank" 
                               class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg font-medium transition">
                                <i class="fab fa-github mr-2"></i> GitHub
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($portfolio['facebook'])): ?>
                            <a href="<?php echo htmlspecialchars($portfolio['facebook']); ?>" target="_blank" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
                                <i class="fab fa-facebook mr-2"></i> Facebook
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($portfolio['pdf'])): ?>
                            <a href="<?php echo htmlspecialchars($portfolio['pdf']); ?>" target="_blank" 
                               class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition">
                                <i class="fas fa-file-pdf mr-2"></i> ดาวน์โหลด PDF
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- ผลงานอื่น ๆ ของนักศึกษาคนนี้ -->
            <div class="xl:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-images mr-3 text-sky-400"></i>
                        ผลงานอื่น ๆ
                    </h3>
                    
                    <div class="space-y-4">
                        <?php 
                        $other = dd_q(
                            "SELECT * FROM idol_portfolio WHERE idol_id = ? AND id != ? ORDER BY id DESC",
                            [$portfolio['idol_id'], $portfolio['id']]
                        );
                        while ($row = $other->fetch(PDO::FETCH_ASSOC)): 
                        ?>
                        <div class="group bg-gray-50 hover:bg-sky-50 rounded-xl p-3 transition border border-gray-100 hover:border-sky-300">
                            <a href="/portfolio&id=<?php echo $row['id']; ?>" class="block">
                                <div class="relative overflow-hidden rounded-lg mb-2">
                                    <img src="<?php echo htmlspecialchars($row['img']); ?>" 
                                         class="w-full h-24 object-cover group-hover:scale-105 transition-transform" 
                                         alt="Portfolio">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition"></div>
                                </div>
                                <p class="text-sm font-medium text-gray-800 line-clamp-2">
                                    <?php echo htmlspecialchars($row['title']); ?>
                                </p>
                            </a>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lightbox -->
    <div x-show="openLightbox" 
         class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 p-4"
         x-transition>
        <div class="relative">
            <img :src="currentImg" class="max-h-[90vh] max-w-full rounded-lg shadow-2xl" alt="Lightbox Image">
            <button @click="openLightbox = false" 
                    class="absolute top-2 right-2 bg-black/50 hover:bg-black text-white p-2 rounded-full">
                ✕
            </button>
        </div>
    </div>
</div>
