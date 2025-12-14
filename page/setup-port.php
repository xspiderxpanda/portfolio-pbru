<?php 
$id1 = dd_q("SELECT * FROM idol WHERE u_admin = ?", [$_SESSION['id']]);
$id = $id1->fetch(PDO::FETCH_ASSOC);
?>
<br>
<div class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-sky-100">

    <div class="relative">
        <!-- Header -->
        <div class="px-6 py-4 bg-white/80 backdrop-blur-sm border-b border-sky-100">
            <div class="container mx-auto">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-sky-400 tracking-wide">MY PORTFOLIO</h1>
                       
                    </div>
                    <div class="ml-6 bg-sky-50 px-4 py-2 rounded-lg">
                        <span class="text-sky-500 text-sm">เลือกโปรไฟล์ของคุณ</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Selection Area -->
        <div class="container mx-auto px-6 py-12">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-light text-gray-800 mb-3">เลือกโปรไฟล์</h2>
                <p class="text-sky-400 text-lg">คุณต้องการแก้ไขโปรไฟล์ไหน?</p>
            </div>

            <!-- Profiles Grid -->
            <div class="flex flex-wrap justify-center gap-6 mb-12 max-w-4xl mx-auto">
                <?php 
                $find = dd_q("SELECT * FROM idol WHERE FIND_IN_SET(?, u_admin)", [$_SESSION['id']]);

                    while ($row = $find->fetch(PDO::FETCH_ASSOC)) {
                ?>  
                <!-- Profile Card -->
                <div class="group cursor-pointer transform transition-all duration-300 hover:scale-105" onclick="window.location.href='/edit-profile&id=<?php echo $row['id'];?>'">
                    <div class="text-center">
                        <!-- Profile Avatar -->
                        <div class="relative w-28 h-28 mx-auto rounded-2xl overflow-hidden mb-3 shadow-lg border-3 border-white group-hover:border-sky-300 group-hover:shadow-xl transition-all duration-300">
                            <img src="<?php echo $row['img'];?>" 
                                 class="w-full h-full object-cover transition-transform duration-300" 
                                 alt="<?php echo $row['nickname'];?>">
                            
                            <!-- Hover overlay -->
                            <div class="absolute inset-0 bg-sky-400 bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center pointer-events-none">
                                <i class="fas fa-edit text-white opacity-0 group-hover:opacity-100 text-xl transition-opacity duration-300"></i>
                            </div>
                        </div>
                        
                        <!-- Profile Name -->
                        <h3 class="text-base font-medium text-gray-700 group-hover:text-sky-400 transition-colors duration-300">
                            <?php echo $row['name'];?>
                        </h3>
                    </div>
                </div>
                <?php } ?>

                <!-- Add New Profile -->
                <?php if (!$id) { ?>
                <div class="group cursor-pointer transform transition-all duration-300 hover:scale-105" onclick="window.location.href='/create-profile'">
                    <div class="text-center">
                        <!-- Add Profile Avatar -->
                        <div class="w-28 h-28 mx-auto rounded-2xl bg-sky-50 border-2 border-dashed border-sky-300 group-hover:border-sky-500 mb-3 transition-all duration-300 group-hover:bg-sky-100 flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-plus text-2xl text-sky-400 group-hover:text-sky-500 mb-1 transition-colors duration-300"></i>
                                <div class="text-xs text-sky-500 group-hover:text-sky-600 transition-colors duration-300">เพิ่ม</div>
                            </div>
                        </div>
                        
                        <!-- Add Profile Text -->
                        <h3 class="text-base font-medium text-sky-500 group-hover:text-sky-600 transition-colors duration-300">
                            สร้างใหม่
                        </h3>
                    </div>
                </div>
                <?php } ?>
            </div>

            <!-- Management Button -->
            <div class="text-center">
                <button class="bg-white border-2 border-sky-200 hover:border-sky-400 text-sky-400 hover:text-sky-500 px-6 py-3 rounded-lg transition-all duration-300 font-medium shadow-sm hover:shadow-md transform hover:scale-105">
                    <i class="fas fa-cog mr-2"></i>
                    จัดการโปรไฟล์
                </button>
            </div>
        </div>

       
    </div>
</div>

<style>
/* Line clamp utility */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Smooth transitions */
* {
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Enhanced hover effects */
.group:hover .transform {
    transform: translateY(-2px);
}

/* Profile card enhancements */
.group {
    will-change: transform;
}

.group:active {
    transform: scale(0.98);
}
</style>

<script>
// Enhanced click handling to prevent conflicts
document.addEventListener('DOMContentLoaded', function() {
    // Profile cards click handling
    const profileCards = document.querySelectorAll('.group[onclick]');
    profileCards.forEach(card => {
        card.addEventListener('click', function(e) {
            e.stopPropagation();
            // Get the URL from onclick attribute
            const onclickAttr = this.getAttribute('onclick');
            const urlMatch = onclickAttr.match(/window\.location\.href='([^']+)'/);
            if (urlMatch) {
                window.location.href = urlMatch[1];
            }
        });
        
        // Prevent double-click issues
        card.addEventListener('dblclick', function(e) {
            e.preventDefault();
        });
    });
});

// Share functionality
function shareOnFacebook() {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent('ดูโปรไฟล์ของฉัน!');
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}&quote=${text}`, '_blank');
}

function copyToClipboard() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        // Show notification
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-sky-400 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in';
        notification.textContent = 'คัดลอกลิ้งค์แล้ว!';
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 2700);
    });
}

// Love button functionality
document.querySelectorAll('.loveprofile').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const idolId = this.dataset.id;
        const status = this.dataset.status || '1';
        
        // Toggle heart animation
        this.style.transform = 'scale(1.2)';
        setTimeout(() => {
            this.style.transform = 'scale(1)';
        }, 150);
        
        // Toggle visual state
        if (this.classList.contains('fas')) {
            this.classList.remove('fas', 'text-red-400');
            this.classList.add('far');
        } else {
            this.classList.remove('far');
            this.classList.add('fas', 'text-red-400');
        }
    });
});
</script>

<div class="h-20"></div>