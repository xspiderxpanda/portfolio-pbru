
    <style>
       
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(14, 165, 233, 0.15);
        }
        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(14, 165, 233, 0.25);
        }
        .slide-in {
            animation: slideIn 0.5s ease-out;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }
       
        .security-badge {
            background: linear-gradient(45deg, #10b981, #34d399);
            animation: pulse 2s infinite;
        }
        .loading-spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #0ea5e9;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: none;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <?php
    function generateState() {
        return bin2hex(random_bytes(16));
    }
    
    function generateCSRFToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    $state = generateState();
    $csrf_token = generateCSRFToken();
    ?>

    <div class="min-h-screen flex items-center justify-center px-4 py-12 relative">
        <div class="w-full max-w-3xl space-y-8">
            
            <div class="text-center slide-in">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-full shadow-lg mb-6">
                    <img src="<?=$config['logo'];?>" class="w-full">
                </div>
                <h1 class="text-xl font-bold text-gray-800 mb-2">เข้าสู่ระบบ / สมัครสมาชิก</h1>
                <p class="text-gray-600">กรุณาเข้าสู่ระบบหรือสมัครสมาชิก ก่อนการดำเนินการต่อบนเว็บไซต์</p>
                
            </div>

            <div id="login" class="glass-effect rounded-2xl p-6 shadow-xl slide-in tabcontent">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">เข้าสู่ระบบ</h2>
                    <p class="text-gray-600 mt-2">กรุณาป้อนข้อมูลเข้าสู่ระบบของคุณ</p>
                </div>

                <form class="space-y-4">
                    <input type="hidden" id="csrf_token" value="<?= $csrf_token ?>">
                    
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-person text-gray-400"></i>
                        </div>
                        <input type="text" id="usernamelogin" 
                               class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-sky-400 focus:outline-none transition-all duration-300 input-focus bg-white/80"
                               placeholder="Username" required maxlength="50">
                    </div>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-lock text-gray-400"></i>
                        </div>
                        <input type="password" id="passwordlogin" 
                               class="w-full pl-10 pr-12 py-3 border-2 border-gray-200 rounded-xl focus:border-sky-400 focus:outline-none transition-all duration-300 input-focus bg-white/80"
                               placeholder="Password" required maxlength="100">
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('passwordlogin')">
                            <i class="bi bi-eye text-gray-400 hover:text-gray-600"></i>
                        </button>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-sky-500 focus:ring-sky-400">
                            <span class="ml-2 text-sm text-gray-600">Remember Me ?</span>
                        </label>
                    </div>

                    <button type="button" id="btn_login" 
                            class="w-full bg-gradient-to-r from-sky-400 to-sky-500 text-white py-3 px-4 rounded-xl font-medium hover:from-sky-500 hover:to-sky-600 transform transition-all duration-300 btn-hover focus:outline-none focus:ring-4 focus:ring-sky-300">
                        <div class="flex items-center justify-center">
                            <div class="loading-spinner mr-2" id="login_spinner"></div>
                            <i class="bi bi-box-arrow-in-right mr-2"></i>
                            <span id="login_text">เข้าสู่ระบบ</span>
                        </div>
                    </button>
                </form>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">หรือเข้าสู่ระบบด้วย</span>
                        </div>
                    </div>

                    <div class="mt-4 flex space-x-3">
                        <a href="https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=<?=$line['clientid'] ?? 'YOUR_LINE_CLIENT_ID';?>&redirect_uri=https://<?php echo $_SERVER['SERVER_NAME']; ?>/system/line.php&state=<?= $state ?>&scope=openid%20profile&bot_prompt=aggressive"
                           class="flex-1 bg-green-500 text-white py-3 px-4 rounded-xl text-center font-medium hover:bg-green-600 transform transition-all duration-300 btn-hover">
                            <i class="bi bi-line mr-2"></i>LINE
                        </a>
                        <a href="system/discord.php"
                           class="flex-1 bg-indigo-500 text-white py-3 px-4 rounded-xl text-center font-medium hover:bg-indigo-600 transform transition-all duration-300 btn-hover">
                            <i class="bi bi-discord mr-2"></i>Discord
                        </a>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="mt-6 text-center space-y-2">
                    <button onclick="toggleTab('forgotpassword')" 
                            class="text-sky-500 hover:text-sky-600 font-medium text-sm">
                        ลืมรหัสผ่าน?
                    </button>
                    <div class="text-gray-600">
                        <span class="text-sm">ยังไม่มีบัญชี?</span>
                        <button onclick="toggleTab('register')" 
                                class="text-sky-500 hover:text-sky-600 font-medium ml-1">
                            สมัครสมาชิก
                        </button>
                    </div>
                </div>
            </div>

            <!-- Register Form -->
            <div id="register" class="glass-effect rounded-2xl p-8 shadow-xl slide-in tabcontent" style="display: none;">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">สมัครสมาชิก</h2>
                    <p class="text-gray-600 mt-2">สร้างบัญชีใหม่เพื่อเข้าใช้งานระบบ</p>
                </div>

                <form class="space-y-4">
                    <input type="hidden" id="csrf_token_reg" value="<?= $csrf_token ?>">
                    
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-person-badge text-gray-400"></i>
                        </div>
                        <input type="text" id="nickname" 
                               class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-sky-400 focus:outline-none transition-all duration-300 input-focus bg-white/80"
                               placeholder="ชื่อเล่น" required maxlength="50">
                    </div>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-envelope text-gray-400"></i>
                        </div>
                        <input type="email" id="emailreg" 
                               class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-sky-400 focus:outline-none transition-all duration-300 input-focus bg-white/80"
                               placeholder="อีเมล" required maxlength="100">
                    </div>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-person text-gray-400"></i>
                        </div>
                        <input type="text" id="usernamereg" 
                               class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-sky-400 focus:outline-none transition-all duration-300 input-focus bg-white/80"
                               placeholder="Username" required maxlength="50">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="passwordreg" 
                                   class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-sky-400 focus:outline-none transition-all duration-300 input-focus bg-white/80"
                                   placeholder="รหัสผ่าน" required maxlength="100">
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-lock-fill text-gray-400"></i>
                            </div>
                            <input type="password" id="passwordreg1" 
                                   class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-sky-400 focus:outline-none transition-all duration-300 input-focus bg-white/80"
                                   placeholder="ยืนยันรหัสผ่าน" required maxlength="100">
                        </div>
                    </div>

                    <!-- Password Strength Indicator -->
                    <div id="password-strength" class="hidden">
                        <div class="text-sm text-gray-600 mb-2">ความแข็งแกร่งของรหัสผ่าน:</div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="strength-bar" class="h-2 rounded-full transition-all duration-300"></div>
                        </div>
                        <div id="strength-text" class="text-xs mt-1"></div>
                    </div>

                    <button type="button" id="btn_reg" 
                            class="w-full bg-gradient-to-r from-sky-400 to-sky-500 text-white py-3 px-4 rounded-xl font-medium hover:from-sky-500 hover:to-sky-600 transform transition-all duration-300 btn-hover focus:outline-none focus:ring-4 focus:ring-sky-300">
                        <div class="flex items-center justify-center">
                            <div class="loading-spinner mr-2" id="register_spinner"></div>
                            <i class="bi bi-person-plus mr-2"></i>
                            <span id="register_text">สมัครสมาชิก</span>
                        </div>
                    </button>
                </form>

                <!-- Social Register -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">หรือสมัครด้วย</span>
                        </div>
                    </div>

                    <div class="mt-4 flex space-x-3">
                        <a href="https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=<?=$line['clientid'] ?? 'YOUR_LINE_CLIENT_ID';?>&redirect_uri=https://<?php echo $_SERVER['SERVER_NAME']; ?>/system/line.php&state=<?= $state ?>&scope=openid%20profile&bot_prompt=aggressive"
                           class="flex-1 bg-green-500 text-white py-3 px-4 rounded-xl text-center font-medium hover:bg-green-600 transform transition-all duration-300 btn-hover">
                            <i class="bi bi-line mr-2"></i>LINE
                        </a>
                        <a href="system/discord.php"
                           class="flex-1 bg-indigo-500 text-white py-3 px-4 rounded-xl text-center font-medium hover:bg-indigo-600 transform transition-all duration-300 btn-hover">
                            <i class="bi bi-discord mr-2"></i>Discord
                        </a>
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <span class="text-sm text-gray-600">มีบัญชีอยู่แล้ว?</span>
                    <button onclick="toggleTab('login')" 
                            class="text-sky-500 hover:text-sky-600 font-medium ml-1">
                        เข้าสู่ระบบ
                    </button>
                </div>
            </div>

            <!-- Forgot Password Form -->
            <div id="forgotpassword" class="glass-effect rounded-2xl p-8 shadow-xl slide-in tabcontent" style="display: none;">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">รีเซ็ตรหัสผ่าน</h2>
                    <p class="text-gray-600 mt-2">กรอกอีเมลของคุณเพื่อรับรหัสยืนยัน</p>
                </div>

                <form class="space-y-4">
                    <input type="hidden" id="csrf_token_forgot" value="<?= $csrf_token ?>">
                    
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-envelope text-gray-400"></i>
                        </div>
                        <input type="email" id="emailforgot" 
                               class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-sky-400 focus:outline-none transition-all duration-300 input-focus bg-white/80"
                               placeholder="อีเมลของคุณ" required maxlength="100">
                    </div>

                    <div id="classotp" class="space-y-4" style="display: none;">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-key text-gray-400"></i>
                            </div>
                            <input type="text" id="otp" 
                                   class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-sky-400 focus:outline-none transition-all duration-300 input-focus bg-white/80"
                                   placeholder="รหัส OTP (6 หลัก)" maxlength="6">
                        </div>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="npass" 
                                   class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-sky-400 focus:outline-none transition-all duration-300 input-focus bg-white/80"
                                   placeholder="รหัสผ่านใหม่" maxlength="100">
                        </div>
                    </div>

                    <button type="button" id="btn_get_otp" 
                            class="w-full bg-gradient-to-r from-sky-400 to-sky-500 text-white py-3 px-4 rounded-xl font-medium hover:from-sky-500 hover:to-sky-600 transform transition-all duration-300 btn-hover focus:outline-none focus:ring-4 focus:ring-sky-300">
                        <div class="flex items-center justify-center">
                            <div class="loading-spinner mr-2" id="otp_spinner"></div>
                            <i class="bi bi-send mr-2"></i>
                            <span id="otp_text">ขอรหัส OTP</span>
                        </div>
                    </button>

                    <button type="button" id="verifyotp" style="display: none;"
                            class="w-full bg-gradient-to-r from-green-400 to-green-500 text-white py-3 px-4 rounded-xl font-medium hover:from-green-500 hover:to-green-600 transform transition-all duration-300 btn-hover focus:outline-none focus:ring-4 focus:ring-green-300">
                        <div class="flex items-center justify-center">
                            <div class="loading-spinner mr-2" id="verify_spinner"></div>
                            <i class="bi bi-check-circle mr-2"></i>
                            <span id="verify_text">ยืนยันและรีเซ็ต</span>
                        </div>
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <span class="text-sm text-gray-600">จำรหัสผ่านได้แล้ว?</span>
                    <button onclick="toggleTab('login')" 
                            class="text-sky-500 hover:text-sky-600 font-medium ml-1">
                        เข้าสู่ระบบ
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Security Functions
        function sanitizeInput(str) {
            const temp = document.createElement('div');
            temp.textContent = str;
            return temp.innerHTML;
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function validatePassword(password) {
            return {
                minLength: password.length >= 8,
                hasUpper: /[A-Z]/.test(password),
                hasLower: /[a-z]/.test(password),
                hasNumber: /\d/.test(password),
                hasSpecial: /[!@#$%^&*(),.?":{}|<>]/.test(password)
            };
        }

        function calculatePasswordStrength(password) {
            const checks = validatePassword(password);
            const score = Object.values(checks).filter(Boolean).length;
            
            if (score === 0) return { strength: 0, text: '', color: '' };
            if (score <= 2) return { strength: 20, text: 'อ่อนแอ', color: 'bg-red-500' };
            if (score === 3) return { strength: 40, text: 'ปานกลาง', color: 'bg-yellow-500' };
            if (score === 4) return { strength: 70, text: 'ดี', color: 'bg-blue-500' };
            return { strength: 100, text: 'แข็งแกร่งมาก', color: 'bg-green-500' };
        }

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash text-gray-400 hover:text-gray-600';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye text-gray-400 hover:text-gray-600';
            }
        }

        function toggleTab(tabName) {
            const tabContents = document.querySelectorAll('.tabcontent');
            tabContents.forEach(tab => {
                tab.style.display = 'none';
                tab.classList.remove('slide-in');
            });

            const activeTab = document.getElementById(tabName);
            activeTab.style.display = 'block';
            setTimeout(() => {
                activeTab.classList.add('slide-in');
            }, 10);
        }

        function showLoading(buttonId, spinnerId, textId, loadingText) {
            document.getElementById(buttonId).disabled = true;
            document.getElementById(spinnerId).style.display = 'inline-block';
            document.getElementById(textId).textContent = loadingText;
        }

        function hideLoading(buttonId, spinnerId, textId, originalText) {
            document.getElementById(buttonId).disabled = false;
            document.getElementById(spinnerId).style.display = 'none';
            document.getElementById(textId).textContent = originalText;
        }

        // Password strength checker
        document.getElementById('passwordreg').addEventListener('input', function(e) {
            const password = e.target.value;
            const strengthDiv = document.getElementById('password-strength');
            
            if (password.length > 0) {
                strengthDiv.classList.remove('hidden');
                const result = calculatePasswordStrength(password);
                const bar = document.getElementById('strength-bar');
                const text = document.getElementById('strength-text');
                
                bar.style.width = result.strength + '%';
                bar.className = `h-2 rounded-full transition-all duration-300 ${result.color}`;
                text.textContent = result.text;
                text.className = `text-xs mt-1 ${result.color.replace('bg-', 'text-')}`;
            } else {
                strengthDiv.classList.add('hidden');
            }
        });

        // AJAX Functions with enhanced security
        $("#btn_login").click(function(e) {
            e.preventDefault();
            
            const username = $("#usernamelogin").val().trim();
            const password = $("#passwordlogin").val();
            const csrfToken = $("#csrf_token").val();
            
            if (!username || !password) {
                Swal.fire({
                    icon: 'warning',
                    title: 'กรุณากรอกข้อมูล',
                    text: 'กรุณากรอก Username และ Password'
                });
                return;
            }
            
            if (username.length > 50 || password.length > 100) {
                Swal.fire({
                    icon: 'error',
                    title: 'ข้อมูลไม่ถูกต้อง',
                    text: 'ข้อมูลที่กรอกยาวเกินกำหนด'
                });
                return;
            }
            
            showLoading('btn_login', 'login_spinner', 'login_text', 'กำลังเข้าสู่ระบบ...');
            
            const formData = new FormData();
            formData.append('usernamelogin', sanitizeInput(username));
            formData.append('passwordlogin', password);
            formData.append('csrf_token', csrfToken);
            
            $.ajax({
                type: 'POST',
                url: 'system/login.php',
                data: formData,
                contentType: false,
                processData: false,
                timeout: 10000
            }).done(function(res) {
                if (res.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'เข้าสู่ระบบสำเร็จ',
                        text: res.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location = "/home";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เข้าสู่ระบบไม่สำเร็จ',
                        text: res.message
                    });
                }
            }).fail(function(jqXHR) {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้'
                });
            }).always(function() {
                hideLoading('btn_login', 'login_spinner', 'login_text', 'เข้าสู่ระบบ');
            });
        });

        $("#btn_reg").click(function(e) {
            e.preventDefault();
            
            const nickname = $("#nickname").val().trim();
            const email = $("#emailreg").val().trim();
            const username = $("#usernamereg").val().trim();
            const password = $("#passwordreg").val();
            const confirmPassword = $("#passwordreg1").val();
            const csrfToken = $("#csrf_token_reg").val();
            
            // Validation
            if (!nickname || !email || !username || !password || !confirmPassword) {
                Swal.fire({
                    icon: 'warning',
                    title: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    text: 'กรุณากรอกข้อมูลในทุกช่อง'
                });
                return;
            }
            
            if (!validateEmail(email)) {
                Swal.fire({
                    icon: 'error',
                    title: 'อีเมลไม่ถูกต้อง',
                    text: 'กรุณากรอกอีเมลในรูปแบบที่ถูกต้อง'
                });
                return;
            }
            
            if (password !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'รหัสผ่านไม่ตรงกัน',
                    text: 'กรุณาตรวจสอบรหัสผ่านและการยืนยันรหัสผ่าน'
                });
                return;
            }
            
            const passwordCheck = validatePassword(password);
            if (!passwordCheck.minLength) {
                Swal.fire({
                    icon: 'error',
                    title: 'รหัสผ่านไม่ปลอดภัย',
                    text: 'รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร'
                });
                return;
            }
            
            showLoading('btn_reg', 'register_spinner', 'register_text', 'กำลังสมัครสมาชิก...');
            
            const formData = new FormData();
            formData.append('nickname', sanitizeInput(nickname));
            formData.append('emailreg', sanitizeInput(email));
            formData.append('usernamereg', sanitizeInput(username));
            formData.append('passwordreg', password);
            formData.append('passwordreg1', confirmPassword);
            formData.append('csrf_token', csrfToken);
            
            $.ajax({
                type: 'POST',
                url: 'system/register.php',
                data: formData,
                contentType: false,
                processData: false,
                timeout: 15000
            }).done(function(res) {
                if (res.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'สมัครสมาชิกสำเร็จ',
                        text: res.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function() {
                        window.location = "/home";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'สมัครสมาชิกไม่สำเร็จ',
                        text: res.message
                    });
                }
            }).fail(function(jqXHR) {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้'
                });
            }).always(function() {
                hideLoading('btn_reg', 'register_spinner', 'register_text', 'สมัครสมาชิก');
            });
        });

        $("#btn_get_otp").click(function(e) {
            e.preventDefault();
            
            const email = $("#emailforgot").val().trim();
            const csrfToken = $("#csrf_token_forgot").val();
            
            if (!email) {
                Swal.fire({
                    icon: 'warning',
                    title: 'กรุณากรอกอีเมล',
                    text: 'กรุณากรอกอีเมลเพื่อขอรหัส OTP'
                });
                return;
            }
            
            if (!validateEmail(email)) {
                Swal.fire({
                    icon: 'error',
                    title: 'อีเมลไม่ถูกต้อง',
                    text: 'กรุณากรอกอีเมลในรูปแบบที่ถูกต้อง'
                });
                return;
            }
            
            showLoading('btn_get_otp', 'otp_spinner', 'otp_text', 'กำลังส่ง OTP...');
            
            $.ajax({
                type: 'POST',
                url: 'system/forgotpassword.php',
                data: { 
                    get_otp: true, 
                    emailforgot: sanitizeInput(email),
                    csrf_token: csrfToken
                },
                dataType: 'json',
                timeout: 15000
            }).done(function(res) {
                if (res.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'ส่ง OTP สำเร็จ',
                        text: res.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    
                    // Show OTP and new password fields
                    $("#classotp").slideDown();
                    $("#emailforgot").prop('disabled', true);
                    $("#btn_get_otp").hide();
                    $("#verifyotp").show();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'ไม่สามารถส่ง OTP ได้',
                        text: res.message
                    });
                }
            }).fail(function(jqXHR) {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถส่ง OTP ได้ในขณะนี้'
                });
            }).always(function() {
                hideLoading('btn_get_otp', 'otp_spinner', 'otp_text', 'ขอรหัส OTP');
            });
        });

        $("#verifyotp").click(function(e) {
            e.preventDefault();
            
            const otp = $("#otp").val().trim();
            const email = $("#emailforgot").val().trim();
            const newPassword = $("#npass").val();
            const csrfToken = $("#csrf_token_forgot").val();
            
            if (!otp || !newPassword) {
                Swal.fire({
                    icon: 'warning',
                    title: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    text: 'กรุณากรอกรหัส OTP และรหัสผ่านใหม่'
                });
                return;
            }
            
            if (!/^\d{6}$/.test(otp)) {
                Swal.fire({
                    icon: 'error',
                    title: 'รหัส OTP ไม่ถูกต้อง',
                    text: 'รหัส OTP ต้องเป็นตัวเลข 6 หลัก'
                });
                return;
            }
            
            const passwordCheck = validatePassword(newPassword);
            if (!passwordCheck.minLength) {
                Swal.fire({
                    icon: 'error',
                    title: 'รหัสผ่านไม่ปลอดภัย',
                    text: 'รหัสผ่านใหม่ต้องมีความยาวอย่างน้อย 8 ตัวอักษร'
                });
                return;
            }
            
            showLoading('verifyotp', 'verify_spinner', 'verify_text', 'กำลังยืนยัน...');
            
            const formData = new FormData();
            formData.append('otp', otp);
            formData.append('email', sanitizeInput(email));
            formData.append('passforgot', newPassword); // เปลี่ยนเป็น passforgot
            formData.append('cpassforgot', newPassword); // ใส่ซ้ำสำหรับยืนยัน
            formData.append('csrf_token', csrfToken);
            
            $.ajax({
                type: 'POST',
                url: 'system/verifyotp.php',
                data: formData,
                contentType: false,
                processData: false,
                timeout: 10000
            }).done(function(res) {
                if (res.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'รีเซ็ตรหัสผ่านสำเร็จ',
                        text: res.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function() {
                        toggleTab('login');
                        // Clear form
                        $("#emailforgot").val('').prop('disabled', false);
                        $("#otp").val('');
                        $("#npass").val('');
                        $("#classotp").hide();
                        $("#btn_get_otp").show();
                        $("#verifyotp").hide();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'การยืนยันไม่สำเร็จ',
                        text: res.message
                    });
                }
            }).fail(function(jqXHR) {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถยืนยันได้ในขณะนี้'
                });
            }).always(function() {
                hideLoading('verifyotp', 'verify_spinner', 'verify_text', 'ยืนยันและรีเซ็ต');
            });
        });

        // Rate limiting for security
        let loginAttempts = 0;
        let registerAttempts = 0;
        let otpAttempts = 0;
        const maxAttempts = 5;
        const lockoutTime = 300000; // 5 minutes

        function checkRateLimit(type) {
            const key = `${type}_lockout`;
            const lockout = localStorage.getItem(key);
            
            if (lockout && new Date().getTime() < parseInt(lockout)) {
                const remainingTime = Math.ceil((parseInt(lockout) - new Date().getTime()) / 60000);
                Swal.fire({
                    icon: 'warning',
                    title: 'ถูกล็อกชั่วคราว',
                    text: `กรุณารอ ${remainingTime} นาที ก่อนลองใหม่`
                });
                return false;
            }
            
            return true;
        }

        function incrementAttempts(type) {
            const attempts = {
                'login': ++loginAttempts,
                'register': ++registerAttempts,
                'otp': ++otpAttempts
            };
            
            if (attempts[type] >= maxAttempts) {
                const lockoutKey = `${type}_lockout`;
                localStorage.setItem(lockoutKey, (new Date().getTime() + lockoutTime).toString());
                
                Swal.fire({
                    icon: 'error',
                    title: 'มีการพยายามเข้าใช้งานมากเกินไป',
                    text: 'บัญชีถูกล็อกชั่วคราว 5 นาที'
                });
            }
        }

        // Initialize page
        window.onload = function() {
            toggleTab('login');
            
            // Add input validation
            $('input[type="email"]').on('blur', function() {
                const email = $(this).val();
                if (email && !validateEmail(email)) {
                    $(this).addClass('border-red-400');
                } else {
                    $(this).removeClass('border-red-400');
                }
            });
            
            $('input[type="password"]').on('input', function() {
                const password = $(this).val();
                if (password.length > 0 && password.length < 8) {
                    $(this).addClass('border-yellow-400');
                } else {
                    $(this).removeClass('border-yellow-400');
                }
            });
            
            // Auto-clear messages after some time
            setTimeout(() => {
                $('.alert').fadeOut();
            }, 10000);
        };

        // Prevent form submission on Enter key for better UX
        $('input').keypress(function(e) {
            if (e.which === 13) { // Enter key
                e.preventDefault();
                const form = $(this).closest('.tabcontent');
                if (form.attr('id') === 'login') {
                    $('#btn_login').click();
                } else if (form.attr('id') === 'register') {
                    $('#btn_reg').click();
                } else if (form.attr('id') === 'forgotpassword') {
                    if ($('#btn_get_otp').is(':visible')) {
                        $('#btn_get_otp').click();
                    } else {
                        $('#verifyotp').click();
                    }
                }
            }
        });

        // Add keyboard navigation
        $(document).keydown(function(e) {
            if (e.altKey) {
                switch(e.which) {
                    case 49: // Alt+1
                        toggleTab('login');
                        break;
                    case 50: // Alt+2
                        toggleTab('register');
                        break;
                    case 51: // Alt+3
                        toggleTab('forgotpassword');
                        break;
                }
            }
        });

        // Security: Clear sensitive data on page unload
        window.addEventListener('beforeunload', function() {
            $('input[type="password"]').val('');
            $('input[type="email"]').val('');
        });

        // Add copy protection (basic)
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        document.addEventListener('selectstart', function(e) {
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
                return true;
            }
            e.preventDefault();
        });

        // Add focus management for accessibility
        $('.tabcontent').on('shown', function() {
            $(this).find('input:first').focus();
        });
    </script>
