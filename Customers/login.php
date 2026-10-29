<?php
session_start(); 
// CSRF Token for future
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Login | Hascol Customer Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Hascol Customer Portal Login">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        brand: { blue: '#1d4ed8', dark: '#0f172a', light: '#f8fafc' }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('../assets/images/login-bg.png'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            width: 100%;
            overflow-x: hidden; 
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bg-overlay {
            position: fixed;
            inset: 0;
            background: linear-gradient(to right, rgba(10, 25, 49, 0.85) 0%, rgba(10, 25, 49, 0.5) 50%, rgba(10, 25, 49, 0.2) 100%);
            z-index: 1;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .spinner {
            display: none;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Error message animation */
        .error-shake {
            animation: shake 0.4s ease-in-out;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
    </style>
</head>
<body>

    <div class="bg-overlay"></div>

    <div class="relative z-10 w-full min-h-screen grid grid-cols-1 lg:grid-cols-2">
        
        <div class="hidden lg:flex flex-col justify-start pt-24 lg:pt-32 p-12 lg:p-20 relative h-full">
            <div>
                <h1 class="text-white text-5xl font-light tracking-wide mb-3 drop-shadow-md">Welcome to</h1>
                <h2 class="text-white text-6xl font-extrabold tracking-tight mb-5 drop-shadow-2xl leading-tight">Hascol Customer Portal</h2>
                <p class="text-gray-200 text-lg max-w-lg drop-shadow-md font-medium">Fueling your journey with exclusive benefits, rewards and a better experience.</p>
            </div>
        </div>

        <div class="w-full flex items-center justify-center p-4 sm:p-8 h-full">
            
            <div class="w-full max-w-md glass-panel rounded-3xl p-8 sm:p-12">
                
                <div class="flex justify-center mb-8">
                    <img src="../assets/images/abc.png" alt="Hascol Logo" class="h-16 object-contain drop-shadow-md" onerror="this.src='https://1000logos.net/wp-content/uploads/2022/10/Hascol-Logo.png'">
                </div>

                <div class="text-center mb-6">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-2 tracking-tight">Customer Login</h2>
                    <p class="text-sm text-gray-500 font-medium">Access your account to manage orders<br>and view your rewards.</p>
                </div>

                <!-- 🔥 Error Alert Box (Hidden by default) -->
                <div id="errorAlert" class="hidden mb-5 p-3 rounded-xl bg-red-50 border border-red-200 text-red-600 text-sm font-medium text-center">
                    <i class="fa-solid fa-circle-exclamation mr-1"></i> <span id="errorText"></span>
                </div>

                <!-- 🔥 Form with ID for AJAX -->
                <form id="loginForm" onsubmit="submitLogin(event)">
                    
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                    <div class="mb-5">
                        <label for="username" class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <input 
                                type="text" 
                                id="username" 
                                name="login" 
                                required 
                                autocomplete="username"
                                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-medium outline-none transition-all placeholder-gray-400" 
                                placeholder="Enter your mobile or email">
                        </div>
                    </div>

                    <div class="mb-8">
                        <label for="passwordInput" class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <input 
                                type="password" 
                                id="passwordInput" 
                                name="password" 
                                required 
                                autocomplete="current-password"
                                class="w-full pl-11 pr-12 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-medium outline-none transition-all placeholder-gray-400" 
                                placeholder="Enter your password">
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-blue-600 focus:outline-none transition-colors" aria-label="Toggle password visibility">
                                <i class="fa-solid fa-eye-slash" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" id="loginBtn" class="w-full bg-gradient-to-r from-blue-700 to-blue-600 hover:from-blue-800 hover:to-blue-700 text-white font-bold py-4 px-4 rounded-xl transition-all flex items-center justify-center gap-2 shadow-[0_10px_20px_-10px_rgba(29,78,216,0.8)] hover:shadow-[0_15px_25px_-10px_rgba(29,78,216,0.9)] transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-lock text-sm" id="lockIcon"></i> 
                        <span id="btnText">Secure Login</span>
                        <i class="fa-solid fa-arrow-right text-xs ml-1" id="arrowIcon"></i>
                        <i class="fa-solid fa-circle-notch spinner text-sm" id="spinnerIcon"></i>
                    </button>
                </form>

            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("passwordInput");
            var eyeIcon = document.getElementById("eyeIcon");
            
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            }
        }

     // 🔥 AJAX API Integration
async function submitLogin(event) {
    event.preventDefault(); // Page refresh hone se roke

    // UI Elements
    var btn = document.getElementById("loginBtn");
    var errorAlert = document.getElementById("errorAlert");
    var errorText = document.getElementById("errorText");
    
    var loginValue = document.getElementById("username").value;
    var passwordValue = document.getElementById("passwordInput").value;

    // Reset Error
    errorAlert.classList.add("hidden");

    // Button Loading State
    btn.disabled = true;
    btn.classList.add("opacity-75", "cursor-not-allowed");
    document.getElementById("lockIcon").style.display = "none";
    document.getElementById("arrowIcon").style.display = "none";
    document.getElementById("spinnerIcon").style.display = "inline-block";
    document.getElementById("btnText").innerText = "Authenticating...";

    try {
        // API Endpoint (Apna API ka path check karein)
        const apiUrl = "http://localhost:8080/hascol_customer/api/auth/login.php?key=2170";

        // 🔥 Form Data Sahi Tarah Prepare Karein
        const formData = new URLSearchParams();
        formData.append('login', loginValue);
        formData.append('password', passwordValue);

        // Fetch Request
        const response = await fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            credentials: 'include', 
            body: formData
        });

        // Check karein ke response JSON hai ya nahi
        const data = await response.json();

        // API Response Check
        if (data.status === 1) {
            // Success: Button text change karein
            document.getElementById("btnText").innerText = "Success! Redirecting...";
            document.getElementById("spinnerIcon").style.color = "#ffffff";
            
            setTimeout(() => {
                // API jo url de rahi hai wahan bhej dein
                window.location.href = data.redirect; 
            }, 1000);
        } else {
            // Error: Show message from API
            throw new Error(data.message || 'Login failed');
        }

    } catch (error) {
        console.error("Login Error:", error); // Debugging ke liye

        // Reset Button UI
        btn.disabled = false;
        btn.classList.remove("opacity-75", "cursor-not-allowed");
        document.getElementById("lockIcon").style.display = "inline-block";
        document.getElementById("arrowIcon").style.display = "inline-block";
        document.getElementById("spinnerIcon").style.display = "none";
        document.getElementById("btnText").innerText = "Secure Login";

        // Show Error Alert
        errorText.innerText = error.message;
        errorAlert.classList.remove("hidden");
        
        // Shake animation
        errorAlert.classList.add("error-shake");
        setTimeout(() => { errorAlert.classList.remove("error-shake"); }, 500);
    }
}
    </script>
</body>
</html>