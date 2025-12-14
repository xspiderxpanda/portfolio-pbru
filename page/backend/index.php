<style>
        nav.hidden.lg\:block.fixed.top-0 {
            display: none !important;
        }
        .glass {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .glass-dark {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .nav-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .nav-item:hover {
            transform: translateX(8px);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 12px rgba(56, 189, 248, 0.2);
        }
        
        .nav-item.active {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.15));
            border-left: 4px solid #38bdf8;
            box-shadow: 0 4px 20px rgba(56, 189, 248, 0.3);
        }
        
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        
        .shape {
            position: absolute;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(56, 189, 248, 0.05));
            border-radius: 50%;
            animation: float 25s infinite linear;
        }
        
        @keyframes float {
            0% { 
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { 
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
            }
        }
        
        .shape:nth-child(1) { width: 60px; height: 60px; left: 10%; animation-delay: -5s; }
        .shape:nth-child(2) { width: 80px; height: 80px; left: 25%; animation-delay: -10s; }
        .shape:nth-child(3) { width: 40px; height: 40px; left: 50%; animation-delay: -15s; }
        .shape:nth-child(4) { width: 100px; height: 100px; left: 75%; animation-delay: -20s; }
        .shape:nth-child(5) { width: 30px; height: 30px; left: 90%; animation-delay: -25s; }
        
        .sidebar-toggle {
            transition: all 0.3s ease;
        }
        
        .sidebar-toggle:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }
        
        .content-glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 45px rgba(56, 189, 248, 0.1);
        }
        
        .menu-icon {
            transition: all 0.3s ease;
        }
        
        .nav-item:hover .menu-icon {
            transform: scale(1.2);
            color: #38bdf8;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(56, 189, 248, 0.2);
        }

        .btn-primary {
            background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(56, 189, 248, 0.3);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(56, 189, 248, 0.2);
        }
    </style>
</head>

<body class="gradient-bg">
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="relative min-h-screen overflow-hidden">
        <div class="container-scroller">
            <nav class="sidebar fixed left-0 top-0 h-full w-64 glass-dark z-50 transition-transform duration-300" id="sidebar">
                <div class="p-6 border-b border-white/20">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-r from-sky-400 to-sky-500 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-graduation-cap text-white text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-sky-700 font-bold text-xl">PORTITPBRU</h1>
                                <p class="text-sky-500 text-sm">Admin Panel</p>
                            </div>
                        </div>
                        
                        <button type="button" class="sidebar-toggle md:hidden rounded-lg p-2 text-sky-600 hover:text-sky-700" onclick="toggleSidebar()">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <ul class="p-4 space-y-2">
                    <li class="nav-item rounded-xl p-3 cursor-pointer active" onclick="setActive(this)">
                        <a href="/backend" class="flex items-center space-x-3 text-sky-700 no-underline font-medium">
                            <span class="menu-icon w-6 h-6 flex items-center justify-center">
                                <i class="fas fa-home text-lg"></i>
                            </span>
                            <span class="menu-title">หน้าหลัก</span>
                        </a>
                    </li>

                    <li class="nav-item rounded-xl p-3 cursor-pointer" onclick="setActive(this)">
                        <a href="/website" class="flex items-center space-x-3 text-sky-700 no-underline font-medium">
                            <span class="menu-icon w-6 h-6 flex items-center justify-center">
                                <i class="fas fa-globe text-lg"></i>
                            </span>
                            <span class="menu-title">ตั้งค่าเว็บไซต์</span>
                        </a>
                    </li>

                    <li class="nav-item rounded-xl p-3 cursor-pointer" onclick="setActive(this)">
                        <a href="/idol" class="flex items-center space-x-3 text-sky-700 no-underline font-medium">
                            <span class="menu-icon w-6 h-6 flex items-center justify-center">
                                <i class="fas fa-user-graduate text-lg"></i>
                            </span>
                            <span class="menu-title">จัดการนักศึกษา</span>
                        </a>
                    </li>

                    <li class="nav-item rounded-xl p-3 cursor-pointer" onclick="setActive(this)">
                        <a href="/news_manage" class="flex items-center space-x-3 text-sky-700 no-underline font-medium">
                            <span class="menu-icon w-6 h-6 flex items-center justify-center">
                                <i class="fas fa-newspaper text-lg"></i>
                            </span>
                            <span class="menu-title">จัดการข่าวสาร</span>
                        </a>
                    </li>

                    <li class="nav-item rounded-xl p-3 cursor-pointer" onclick="setActive(this)">
                        <a href="/user_edit" class="flex items-center space-x-3 text-sky-700 no-underline font-medium">
                            <span class="menu-icon w-6 h-6 flex items-center justify-center">
                                <i class="fas fa-users text-lg"></i>
                            </span>
                            <span class="menu-title">จัดการสมาชิก</span>
                        </a>
                    </li>

                    <li class="nav-item rounded-xl p-3 cursor-pointer" onclick="setActive(this)">
                        <a href="/upload" class="flex items-center space-x-3 text-sky-700 no-underline font-medium">
                            <span class="menu-icon w-6 h-6 flex items-center justify-center">
                                <i class="fas fa-cloud-upload-alt text-lg"></i>
                            </span>
                            <span class="menu-title">อัปโหลดรูปภาพ</span>
                        </a>
                    </li>
                </ul>

                <!-- User Profile Section -->
                <div class="absolute bottom-0 left-0 right-0 p-4">
                    <div class="glass rounded-xl p-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-r from-sky-400 to-blue-500 rounded-full flex items-center justify-center shadow-lg">
                                <i class="fas fa-user text-white text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sky-700 font-semibold text-sm">ผู้ดูแลระบบ</p>
                                <p class="text-sky-500 text-xs flex items-center">
                                    <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                                    Online
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="ml-64 min-h-screen transition-all duration-300" id="main-content">
                <!-- Top Bar -->
                <div class="glass-dark p-4 m-4 rounded-2xl shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <button class="sidebar-toggle md:hidden rounded-lg p-2 text-sky-600" onclick="toggleSidebar()">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                            <h2 class="text-sky-700 text-2xl font-bold">แดชบอร์ด</h2>
                            <div class="hidden md:block">
                                <span class="bg-sky-100 text-sky-700 px-3 py-1 rounded-full text-sm font-medium">
                                    ระบบจัดการ PORTITPBRU
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                <button class="glass rounded-xl p-3 text-sky-600 hover:text-sky-700 hover:bg-white/20 transition-all duration-300">
                                    <i class="fas fa-bell text-lg"></i>
                                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full flex items-center justify-center">
                                        <span class="text-white text-xs">3</span>
                                    </span>
                                </button>
                            </div>
                            <div class="relative">
                                <button class="glass rounded-xl p-3 text-sky-600 hover:text-sky-700 hover:bg-white/20 transition-all duration-300">
                                    <i class="fas fa-cog text-lg"></i>
                                </button>
                            </div>
                            <div class="hidden md:block">
                                <button class="btn-primary text-white px-4 py-2 rounded-xl font-medium">
                                    <i class="fas fa-plus mr-2"></i>
                                    เพิ่มข้อมูล
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
             

                        <div class="glass rounded-2xl p-6">
                            <?php
                            if (admin($user) && isset($_GET['page']) && $_GET['page'] == "backend") {
                                require_once('page/backend/dashboard.php');
                            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "user_edit") {
                                require_once('page/backend/user_edit.php');    
                            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "upload") {
                                require_once('page/backend/upload.php');
                            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "add_idol") {
                                require_once('page/backend/add_idol.php');
                            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "news_manage") {
                                require_once('page/backend/news.php');
                            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "idol") {
                                require_once('page/backend/idol.php');    
                            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "idol_edit" && isset($_GET['id'])) {
                                require_once('page/backend/idol_edit.php');   
                            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "idol_port") {
                                require_once('page/backend/idol_port.php');    
                            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "idol_portedit" && isset($_GET['id'])) {
                                require_once('page/backend/idol_portedit.php');   
                            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "website") {
                                require_once('page/backend/website.php');    
                            } else {
                                echo '
                                <div class="text-center py-12">
                                    <div class="w-20 h-20 bg-gradient-to-r from-sky-400 to-sky-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                                        <i class="fas fa-graduation-cap text-white text-3xl"></i>
                                    </div>
                                    <h3 class="text-sky-700 text-3xl font-bold mb-4">ยินดีต้อนรับสู่ระบบจัดการ PORTITPBRU</h3>
                                    <p class="text-sky-600 text-lg mb-8 max-w-2xl mx-auto">
                                        ระบบจัดการผลงานนักศึกษามหาวิทยาลัยราชภัฏเพชรบุรี<br>
                                        เลือกเมนูจากแถบด้านซ้ายเพื่อเริ่มต้นการใช้งาน
                                    </p>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                                        <div class="glass rounded-xl p-6 text-center card-hover">
                                            <i class="fas fa-user-graduate text-sky-500 text-2xl mb-3"></i>
                                            <h4 class="text-sky-700 font-semibold mb-2">จัดการนักศึกษา</h4>
                                            <p class="text-sky-600 text-sm">เพิ่ม แก้ไข และจัดการข้อมูลนักศึกษา</p>
                                        </div>
                                        <div class="glass rounded-xl p-6 text-center card-hover">
                                            <i class="fas fa-newspaper text-sky-500 text-2xl mb-3"></i>
                                            <h4 class="text-sky-700 font-semibold mb-2">จัดการข่าวสาร</h4>
                                            <p class="text-sky-600 text-sm">สร้างและจัดการข่าวสารต่างๆ</p>
                                        </div>
                                        <div class="glass rounded-xl p-6 text-center card-hover">
                                            <i class="fas fa-globe text-sky-500 text-2xl mb-3"></i>
                                            <h4 class="text-sky-700 font-semibold mb-2">ตั้งค่าเว็บไซต์</h4>
                                            <p class="text-sky-600 text-sm">ปรับแต่งการตั้งค่าเว็บไซต์</p>
                                        </div>
                                    </div>
                                </div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
     document.addEventListener("DOMContentLoaded", function() {
        const oldNav = document.querySelector('nav.hidden.lg\\:block.fixed.top-0');
        if (oldNav) {
            oldNav.style.display = "none";
        }
    });
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('open');
            }
        }

        function setActive(element) {
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });
            element.classList.add('active');
        }

        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            
            if (window.innerWidth > 768) {
                sidebar.classList.remove('open');
                mainContent.classList.remove('ml-0');
                mainContent.classList.add('ml-64');
            } else {
                mainContent.classList.remove('ml-64');
                mainContent.classList.add('ml-0');
            }
        });

        if (window.innerWidth <= 768) {
            document.getElementById('main-content').classList.remove('ml-64');
            document.getElementById('main-content').classList.add('ml-0');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.stat-card, .card-hover');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
