<?php
function generateState() {
    $length = 10;
    
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
    $state = '';
    for ($i = 0; $i < $length; $i++) {
        $state .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $state;
}
$state = generateState();
?>


<style>
  /* โทนโดยรวม: ขาว-เทา-น้ำเงินเข้ม สุภาพ */
  :root{
    --brand-50:#f8fafc; --brand-100:#f1f5f9; --brand-200:#e2e8f0;
    --brand-300:#cbd5e1; --brand-400:#94a3b8; --brand-500:#64748b;
    --brand-600:#475569; --brand-700:#334155; --brand-800:#1f2937;
    --brand-primary:#1d4ed8; /* น้ำเงินเข้มสุภาพ */
  }

  .scrollbar-hide::-webkit-scrollbar{ display:none; }
  .scrollbar-hide{ -ms-overflow-style:none; scrollbar-width:none; }

  /* พื้นหลังเรียบ สุภาพ */
  .page-bg{ background: linear-gradient(180deg, var(--brand-50), #fff); }

  /* การ์ดสุภาพ */
  .card{
    background:#fff; border:1px solid var(--brand-200);
    border-radius: 14px; box-shadow: 0 6px 18px rgba(17,24,39,0.05);
    transition: box-shadow .2s ease, transform .2s ease;
  }
  .card:hover{ box-shadow: 0 10px 24px rgba(17,24,39,0.08); transform: translateY(-2px); }

  /* ปุ่มสุภาพ */
  .btn-primary{
    background: var(--brand-primary); color:#fff; border:1px solid var(--brand-primary);
    padding:.75rem 1.25rem; border-radius: 10px; font-weight:600;
    transition: background .2s ease, transform .2s ease;
  }
  .btn-primary:hover{ background:#1843bd; transform: translateY(-1px); }

  .btn-outline{
    background:#fff; color: var(--brand-700); border:1px solid var(--brand-300);
    padding:.75rem 1.25rem; border-radius:10px; font-weight:600;
  }
  .btn-outline:hover{ border-color: var(--brand-400); }

  /* หัวเรื่อง */
  .heading-xl{ font-size: clamp(1.75rem, 3vw, 2.5rem); font-weight:800; color: var(--brand-800); }
  .heading-lg{ font-size: clamp(1.25rem, 2.2vw, 1.75rem); font-weight:700; color: var(--brand-800); }
  .muted{ color: var(--brand-600); }

  /* Carousel: ลดเอฟเฟกต์ */
  .carousel-img{ border-radius: 16px; object-fit: cover; height: 22rem; }
  .indicator-dot{
    width:10px; height:10px; border-radius:999px; background: var(--brand-300);
  }
  .indicator-dot.active{ background: var(--brand-primary); transform: none; }

  /* ข่าว */
  .news-title{ color: var(--brand-800); font-weight:700; }
  .news-meta{ color: var(--brand-600); font-size:.9rem; }

  /* Modal */
  .modal-panel{
    background:#fff; border:1px solid var(--brand-200); border-radius:14px;
    box-shadow: 0 12px 28px rgba(17,24,39,.12);
  }

  /* ตัดอนิเมชันลอย/ซูมแรง */
  .no-float{ animation: none !important; }
</style>


    <style>

    
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 25%, #bae6fd 50%, #38bdf8 75%, #0ea5e9 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(56, 189, 248, 0.2);
        }
        .news-card:hover {
            transform: scale(1.02);
            transition: all 0.3s ease;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .floating {
            animation: float 3s ease-in-out infinite;
        }
        
    </style>


    <div class="relative">
    <div class="relative max-w-7xl mx-auto mb-8">
        <button id="turnleftbar" class="absolute z-20 left-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white p-3 rounded-full shadow-lg transition-all duration-300">
            <svg class="w-6 h-6 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <button id="turnrightbar" class="absolute z-20 right-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white p-3 rounded-full shadow-lg transition-all duration-300">
            <svg class="w-6 h-6 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>

        <div id="carousel-mumu" class="flex overflow-x-auto scroll-smooth space-x-4 snap-x snap-mandatory px-4 py-2 scrollbar-hide">
            <?php
            $find = dd_q("SELECT * FROM carousel");
            $index = 0;
            $slides = [];
            while ($row = $find->fetch(PDO::FETCH_ASSOC)) {
                $slides[] = $row;
            ?>
                <div class="min-w-full snap-center relative" data-index="<?php echo $index; ?>">
                    <img src="<?php echo htmlspecialchars($row['img']); ?>" 
                         class="rounded-2xl object-cover w-full h-96 shadow-2xl" 
                         alt="carousel">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent rounded-2xl"></div>
                </div>
            <?php $index++; } ?>
        </div>

        <div id="carouselIndicators" class="flex justify-center mt-4 space-x-3">
            <?php for ($i = 0; $i < count($slides); $i++) : ?>
                <button class="w-3 h-3 rounded-full bg-sky-300/50 indicator-dot transition-all duration-300 hover:scale-125" data-index="<?php echo $i; ?>"></button>
            <?php endfor; ?>
        </div>
    </div>


    <div class="text-center py-16 px-4 page-bg">
  <div class="max-w-4xl mx-auto">
    <div class="card p-10">
      <h1 class="heading-xl mb-3">
        ยินดีต้อนรับสู่ <span style="color:var(--brand-primary)">PORTITPBRU</span>
      </h1>
      <h2 class="heading-lg mb-3"><?= htmlspecialchars($config['name'] ?? '') ?></h2>
      <p class="muted mb-8" style="line-height:1.8">
        <?= htmlspecialchars($config['des'] ?? '') ?>
      </p>

      <?php if (!isset($_SESSION['id'])) { ?>
        <div class="flex flex-col items-center gap-3">
          <button id="openAuth" class="btn-primary">
            <i class="bi bi-patch-check-fill"></i> เข้าสู่ระบบ / สมัครสมาชิก
          </button>
          <button class="btn-outline">เริ่มต้นใช้งาน</button>
        </div>
      <?php } else { ?>
        <div class="flex items-center justify-center gap-3">
          <a href="/profile" class="btn-primary">
            <i class="bi bi-person-fill-check"></i> <?= htmlspecialchars($user['nickname'] ?? 'โปรไฟล์') ?>
          </a>
          <a href="/logout" class="btn-outline">ออกจากระบบ</a>
        </div>
      <?php } ?>
    </div>
  </div>
</div>


    <!-- Announcement Section -->
   <div class="max-w-6xl mx-auto px-4 mb-12">
  <div class="card p-4">
    <div class="flex items-start gap-3">
      <div style="background:var(--brand-primary); color:#fff" class="p-2 rounded-md">
        <i class="bi bi-megaphone"></i>
      </div>
      <div class="flex-1">
        <h3 class="heading-lg mb-1" style="font-size:1.1rem">ประกาศ</h3>
        <p class="muted">
          <?= nl2br(htmlspecialchars($config['ann'] ?? '')) ?>
        </p>
      </div>
    </div>
  </div>
</div>
</div>


<?php
$api_url = "https://itpbru.mucity.online/api/";
function getNewsData($api_url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // ปิดตรวจ SSL ชั่วคราว
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
    
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
        return [];
    }

    curl_close($ch);

    $json = json_decode($response, true);
    return $json ?: [];
}

$news_list = getNewsData($api_url);

$news_list = array_slice($news_list, 0, 6);
?>

<div class="max-w-7xl mx-auto px-4 mb-16">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-sky-600 mb-4">ข่าวสารและกิจกรรม</h2>
        <div class="w-24 h-1 bg-gradient-to-r from-sky-400 to-sky-500 mx-auto rounded-full"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($news_list as $news): ?>
            <article class="bg-white/40 backdrop-blur-lg rounded-2xl shadow-xl border border-white/30 overflow-hidden news-card">
                <img src="<?php echo htmlspecialchars($news['img']); ?>" 
                     alt="<?php echo htmlspecialchars($news['des']); ?>" 
                     class="w-full h-48 object-cover">
                
                <div class="p-6">
                    <div class="flex items-center text-sm text-sky-500 mb-3">
                        <i class="bi bi-calendar3 mr-2"></i>
                        <span><?php echo htmlspecialchars(date("d M Y", strtotime($news['date']))); ?></span>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">
                        <?php echo htmlspecialchars($news['title']); ?>
                    </h3>
                    
                    <p class="text-gray-600 mb-4 line-clamp-3">
                    <?php echo htmlspecialchars($news['des']); ?>
                        หมวดหมู่: <?php echo htmlspecialchars($news['categories']); ?><br>
                        ผู้โพสต์ ID: <?php echo htmlspecialchars($news['uploaded_by']); ?>
                    </p>
                    
                    <a href="/news&id=<?php echo $news['id']; ?>" 
                       class="inline-flex items-center text-sky-500 hover:text-sky-600 font-semibold transition-colors duration-300">
                        อ่านเพิ่มเติม
                        <i class="bi bi-arrow-right ml-2"></i>
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <div class="text-center mt-12">
        <a href="/news" class="inline-block bg-gradient-to-r from-sky-400 to-sky-500 hover:from-sky-500 hover:to-sky-600 text-white px-8 py-3 rounded-full font-semibold shadow-lg transform transition-all duration-300 hover:scale-105">
            <i class="bi bi-newspaper mr-2"></i>
            ดูข่าวสารทั้งหมด
        </a>
    </div>
</div>


<!-- Students Portfolio Section -->
<div class="max-w-7xl mx-auto px-4 mb-16">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-sky-600 mb-4">นักศึกษาของเรา</h2>
        <div class="flex items-center justify-center space-x-4 mb-4">
            <div class="w-16 h-1 bg-gradient-to-r from-sky-400 to-sky-500 rounded-full"></div>
            <span class="text-2xl font-extrabold bg-gradient-to-r from-sky-500 to-sky-600 bg-clip-text text-transparent">
                PORTITPBRU
            </span>
            <div class="w-16 h-1 bg-gradient-to-r from-sky-400 to-sky-500 rounded-full"></div>
        </div>
        <p class="text-gray-600 text-lg">แสดงผลงานและความสามารถของนักศึกษา</p>
    </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4  gap-6">
            <?php $find = dd_q("SELECT * FROM idol ORDER BY id ASC ");
                while ($row = $find->fetch(PDO::FETCH_ASSOC)) {
            ?>  
            <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-sky-300 hover:-translate-y-2">
                <div class="relative overflow-hidden">
                    <img src="<?php echo $row["img"];?>" 
                         class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-110" 
                         alt="<?php echo $row["nickname"];?>">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3 text-center">
                        <?php echo $row["name"];?>
                    </h3>
                    
                    <div class="space-y-3">
                        <a href="/portfolio&id=<?php echo $row["id"];?>" 
                           class="block w-full">
                            <button class="w-full bg-gradient-to-r from-sky-400 to-sky-500 hover:from-sky-500 hover:to-sky-600 text-white font-medium py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg">
                                <i class="fas fa-eye mr-2"></i>
                                ชมผลงาน
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
</div>

<!-- Authentication Modal -->
<div id="authentication" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto flex items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full border border-gray-200">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <i class="fas fa-shield-alt text-sky-400 mr-3"></i>
                            เข้าสู่ระบบ
                        </h3>
                        <p class="text-gray-600 text-sm mt-1">กรุณาเข้าสู่ระบบเพื่อใช้งาน</p>
                    </div>
                    <button id="closeAuth" class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition-all duration-300">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <div class="space-y-4">
                    <a href="https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=<?=$line['clientid'];?>&redirect_uri=https://<?php echo $_SERVER['SERVER_NAME']; ?>/system/line.php&state=<?= $state ?>&scope=openid%20profile&bot_prompt=aggressive" 
                       class="w-full bg-green-500 hover:bg-green-600 text-white py-3 px-4 rounded-xl font-semibold flex items-center justify-center transition-all duration-300 transform hover:scale-105">
                        <i class="fab fa-line mr-3 text-xl"></i>
                        เข้าสู่ระบบด้วย LINE
                    </a>

                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">หรือ</span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">อีเมล</label>
                            <input type="email" id="loginEmail" name="email" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-400 focus:border-transparent" 
                                   placeholder="name@example.com" required>
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">รหัสผ่าน</label>
                            <input type="password" id="loginPassword" name="password" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-400 focus:border-transparent" 
                                   placeholder="••••••••" required>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="button" id="closeAuths" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 px-4 rounded-xl font-semibold transition-all duration-300">
                        ยกเลิก
                    </button>
                    <button type="submit" id="deactivateButton" class="flex-1 bg-gradient-to-r from-sky-400 to-sky-500 hover:from-sky-500 hover:to-sky-600 text-white py-3 px-4 rounded-xl font-semibold transition-all duration-300">
                        เข้าสู่ระบบ
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Carousel functionality
const container = document.getElementById("carousel-mumu");
const btnLeft = document.getElementById("turnleftbar");
const btnRight = document.getElementById("turnrightbar");
const indicators = document.querySelectorAll(".indicator-dot");
const slides = document.querySelectorAll("#carousel-mumu > div");

let currentIndex = 0;

function updateIndicators(index) {
    indicators.forEach((dot, i) => {
        dot.classList.toggle("bg-sky-400", i === index);
        dot.classList.toggle("bg-sky-300/50", i !== index);
        dot.classList.toggle("scale-125", i === index);
    });
}

function scrollToIndex(index) {
    const target = slides[index];
    if (target) {
        container.scrollTo({
            left: target.offsetLeft,
            behavior: "smooth"
        });
        currentIndex = index;
        updateIndicators(index);
    }
}

btnLeft.addEventListener("click", () => {
    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
    scrollToIndex(currentIndex);
});

btnRight.addEventListener("click", () => {
    currentIndex = (currentIndex + 1) % slides.length;
    scrollToIndex(currentIndex);
});

indicators.forEach((dot) => {
    dot.addEventListener("click", () => {
        const index = parseInt(dot.dataset.index);
        scrollToIndex(index);
    });
});

container.addEventListener("scroll", () => {
    const scrollLeft = container.scrollLeft;
    slides.forEach((slide, i) => {
        if (Math.abs(slide.offsetLeft - scrollLeft) < slide.offsetWidth / 2) {
            currentIndex = i;
            updateIndicators(i);
        }
    });
});

updateIndicators(0);

// Modal functionality
const authenticationModal = document.getElementById("authentication");
const openModalButton = document.getElementById("openAuth");
const closeModalButton = document.getElementById("closeAuth");
const closeModalButtons = document.getElementById("closeAuths");

if (openModalButton) {
    openModalButton.addEventListener("click", () => {
        authenticationModal.classList.remove("hidden");
    });
}

closeModalButton.addEventListener("click", () => {
    authenticationModal.classList.add("hidden");
});

closeModalButtons.addEventListener("click", () => {
    authenticationModal.classList.add("hidden");
});

window.addEventListener("click", (event) => {
    if (event.target === authenticationModal) {
        authenticationModal.classList.add("hidden");
    }
});

// Auto-play carousel
setInterval(() => {
    if (slides.length > 1) {
        currentIndex = (currentIndex + 1) % slides.length;
        scrollToIndex(currentIndex);
    }
}, 5000);
</script>
