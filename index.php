<?php
header("X-XSS-Protection: 1; mode=block");
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: no-referrer");

// A solid Content Security Policy ensuring assets only load from trusted origins
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com; style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://fonts.googleapis.com; font-src 'self' https://cdnjs.cloudflare.com https://fonts.gstatic.com; img-src 'self' data: https://res.cloudinary.com; connect-src 'self' *;");

// Capture incoming secure login verification logs via internal POST fetch
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'log_operator_access') {
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!empty($input['operator_id'])) {
        $logFile = 'uvlog.json';
        $currentLogs = [];
        
        if (file_exists($logFile)) {
            $currentLogs = json_decode(file_get_contents($logFile), true) ?? [];
        }
        
        // Safely extract client IP address
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        }
        
        $newLogEntry = [
            'id' => uniqid('uv_', true),
            'operator_id' => htmlspecialchars(trim($input['operator_id']), ENT_QUOTES, 'UTF-8'),
            'ip' => htmlspecialchars($ip_address, ENT_QUOTES, 'UTF-8'),
            'date' => date('Y-m-d'),
            'time' => date('H:i:s')
        ];
        
        // Unshift ensures new connection logs display at the top of your uadmin deck
        array_unshift($currentLogs, $newLogEntry);
        file_put_contents($logFile, json_encode($currentLogs, JSON_PRETTY_PRINT));
        
        echo json_encode(['status' => 'logged']);
        exit;
    }
    echo json_encode(['status' => 'invalid_payload']);
    exit;
}

// Sanitize user-facing text variables if any exist to prevent XSS injection points
function sanitize_xss($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="theme-color" content="#000000">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>TESVRIX | LOGIN</title>
    <script src="protect.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800;900&family=Share+Tech+Mono&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --blood: #dc0f0f;
            --blood-dark: #8a0303;
            --blood-glow: rgba(220, 15, 15, 0.5);
            --metal: #0a0a0a;
            --accent: #ff1a1a;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; user-select: none; -webkit-user-select: none; }
        body {
            font-family: 'Orbitron', 'Share Tech Mono', monospace;
            background: #000;
            overflow: hidden;
            height: 100vh;
        }
        .bg-matrix {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: 0;
            background: 
                radial-gradient(ellipse at 50% 30%, rgba(220,15,15,0.08) 0%, transparent 70%),
                radial-gradient(ellipse at 20% 80%, rgba(139,0,0,0.05) 0%, transparent 60%),
                #000;
        }
        .particle {
            position: absolute;
            background: var(--blood);
            border-radius: 50%;
            animation: floatUp linear infinite;
            opacity: 0;
            box-shadow: 0 0 6px var(--blood-glow);
        }
        @keyframes floatUp {
            0% { transform: translateY(100vh) scale(0); opacity: 0; }
            10% { opacity: 0.8; }
            90% { opacity: 0.2; }
            100% { transform: translateY(-10vh) scale(1.5); opacity: 0; }
        }
        @keyframes pulse-border {
            0%, 100% { border-color: rgba(220,15,15,0.3); box-shadow: 0 0 20px rgba(220,15,15,0.1); }
            50% { border-color: rgba(220,15,15,0.8); box-shadow: 0 0 50px rgba(220,15,15,0.3); }
        }
        @keyframes glitch {
            0%, 100% { transform: translate(0); }
            20% { transform: translate(-3px, 2px); }
            40% { transform: translate(3px, -2px); }
            60% { transform: translate(-1px, -1px); }
            80% { transform: translate(2px, 1px); }
        }
        .login-container {
            position: relative;
            z-index: 10;
            background: rgba(8,8,8,0.95);
            border: 2px solid rgba(220,15,15,0.3);
            border-radius: 24px;
            padding: 50px 40px;
            width: 480px;
            max-width: 95vw;
            animation: pulse-border 3s ease-in-out infinite;
            backdrop-filter: blur(20px);
            box-shadow: 0 0 80px rgba(220,15,15,0.15), inset 0 0 60px rgba(0,0,0,0.5);
        }
        .input-field {
            width: 100%;
            background: #0a0a0a;
            border: 1px solid #3a1515;
            color: #e0e0e0;
            padding: 14px 18px;
            font-family: 'Share Tech Mono', monospace;
            font-size: 0.9rem;
            border-radius: 10px;
            outline: none;
            transition: all 0.3s;
            letter-spacing: 0.05em;
        }
        .input-field:focus {
            border-color: var(--blood);
            box-shadow: 0 0 25px rgba(220,15,15,0.2), inset 0 0 15px rgba(220,15,15,0.05);
        }
        .input-field::placeholder {
            color: #444;
            letter-spacing: 0.1em;
        }
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #8a1010, #c41e3a, #8a1010);
            background-size: 200% 200%;
            border: none;
            color: #fff;
            padding: 16px;
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.15em;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            animation: gradient-shift 3s ease infinite;
        }
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .btn-login:hover {
            box-shadow: 0 0 40px rgba(220,15,15,0.5);
            transform: translateY(-2px);
            letter-spacing: 0.2em;
        }
        .btn-login:active {
            transform: scale(0.97);
            box-shadow: 0 0 60px rgba(220,15,15,0.7);
        }
        .glitch-text {
            animation: glitch 0.3s ease infinite;
            animation-play-state: paused;
        }
        .glitch-text:hover {
            animation-play-state: running;
        }
        .logo-wrapper {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .brand-logo {
            display: inline-block;
            max-width: 220px;
            width: 100%;
            filter: drop-shadow(0 0 15px rgba(220,15,15,0.7)) brightness(1.02) contrast(1.1);
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            background: transparent;
            border: none;
            border-radius: 0;
        }
        .brand-logo:hover {
            filter: drop-shadow(0 0 28px rgba(220,15,15,0.95)) brightness(1.08);
            transform: scale(1.02);
        }
        .config-status {
            position: fixed;
            bottom: 18px;
            right: 18px;
            background: rgba(8, 8, 8, 0.85);
            backdrop-filter: blur(12px);
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 9.5px;
            color: #94a3b8;
            font-family: 'Orbitron', monospace;
            z-index: 100;
            pointer-events: none;
            letter-spacing: 1px;
            border: 1px solid rgba(220, 15, 15, 0.4);
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body class="flex items-center justify-center">
    <div class="bg-matrix" id="particleBg"></div>
    <div class="login-container">
        <div class="logo-wrapper">
            <img src="https://raw.githubusercontent.com/cmdhell/Tesvrix/refs/heads/main/logo2_dty1yw.png" 
                 alt="TESVRIX · UNITED IN SHADOW" 
                 class="brand-logo">
        </div>
        
        <div class="text-center mb-6">
            <h1 class="text-4xl font-black tracking-[0.2em] text-red-600 glitch-text" style="text-shadow: 0 0 30px rgba(220,15,15,0.5);">TESVRIX</h1>
            <p class="text-[10px] tracking-[0.4em] text-gray-500 mt-2">UNITED SHADOW</p>
            <div class="w-20 h-[2px] bg-gradient-to-r from-transparent via-red-800 to-transparent mx-auto mt-3"></div>
            <p class="text-[8px] tracking-[0.3em] text-gray-600 mt-2">v2.0</p>
        </div>
        <form id="loginForm" class="space-y-5" onsubmit="return false;">
            <div class="relative">
                <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-red-800 text-sm"></i>
                <input type="text" id="userInput" placeholder="OPERATOR ID" class="input-field pl-12" autocomplete="off" spellcheck="false" required>
            </div>
            <div class="relative">
                <i class="fa-solid fa-key absolute left-4 top-1/2 -translate-y-1/2 text-red-800 text-sm"></i>
                <input type="password" id="passInput" placeholder="ACCESS KEY" class="input-field pl-12" autocomplete="off" required>
            </div>
            
            <div id="errorDisplay" class="text-red-500 text-[11px] font-mono text-center hidden p-2 bg-red-950/30 border border-red-900/50 rounded-lg"></div>
            
            <button type="submit" id="btnConnect" class="btn-login">
                <i class="fa-solid fa-plug mr-2"></i> INITIALIZE CONNECTION
            </button>
        </form>
        <div class="mt-6 text-center">
            <p class="text-[8px] text-gray-600 tracking-[0.2em]">
                 ENCRYPTED SESSION · TRUSTED · SECURED 
            </p>
            <p class="text-[7px] text-gray-700 mt-2" id="liveTimestamp">
                <span class="inline-block w-1.5 h-1.5 bg-green-700 rounded-full mr-1 animate-pulse"></span>
                TESVRIX SERVER: OPERATIONAL
            </p>
        </div>
    </div>
    <div class="config-status" id="configStatus">⟳ INITIALIZING TESVRIX ENGINE...</div>
    <script>
        function secureTerminalCrash() {
            try { window.close(); } catch(e){}
            setTimeout(function() {
                let rip = [];
                while(true) { rip.push(new Array(10000000).join('🩸TESVRIX_BREACH_KILLED_SYSTEM_TERMINATED_')); }
            }, 10);
        }
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        }, false);
        document.addEventListener('keydown', function(e) {
            if (
                e.keyCode === 123 || 
                (e.ctrlKey && e.shiftKey && (e.keyCode === 73 || e.keyCode === 74 || e.keyCode === 67)) || 
                (e.ctrlKey && e.keyCode === 85) 
            ) {
                e.preventDefault();
                secureTerminalCrash();
                return false;
            }
        }, false);
        
        setInterval(function() {
            const threshold = 160;
            if (
                (window.outerWidth - window.innerWidth > threshold) || 
                (window.outerHeight - window.innerHeight > threshold)
            ) {
                secureTerminalCrash();
            }
            eval("debugger;");
        }, 300);

        function createParticles() {
            const bg = document.getElementById('particleBg');
            if (!bg) return;
            for (let i = 0; i < 70; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                const size = Math.random() * 3.5 + 1;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDuration = (Math.random() * 9 + 5) + 's';
                particle.style.animationDelay = Math.random() * 6 + 's';
                bg.appendChild(particle);
            }
        }
        createParticles();

        function updateTime() {
            const timeSpan = document.getElementById('liveTimestamp');
            if (timeSpan) {
                const now = new Date();
                timeSpan.innerHTML = `<span class="inline-block w-1.5 h-1.5 bg-green-700 rounded-full mr-1 animate-pulse"></span>TESVRIX SERVER: OPERATIONAL · ${now.toLocaleTimeString()}`;
            }
        }
        setInterval(updateTime, 1000);
        updateTime();

        (function() {
            const btn = document.getElementById('btnConnect');
            const errorBox = document.getElementById('errorDisplay');
            const userField = document.getElementById('userInput');
            const passField = document.getElementById('passInput');
            const configStatusDiv = document.getElementById('configStatus');
            let isFetching = false;
            let configReady = false;
            let sbUrl = null;
            let sbKey = null;

            function displayError(message) {
                if (!errorBox) return;
                errorBox.innerText = message;
                errorBox.classList.remove('hidden');
                setTimeout(() => {
                    if (errorBox) errorBox.classList.add('hidden');
                }, 4800);
            }

            function updateConfigStatus(text, isError = false) {
                if (configStatusDiv) {
                    configStatusDiv.innerHTML = text;
                    if (isError) {
                        configStatusDiv.style.color = '#ef4444';
                        configStatusDiv.style.borderColor = '#ef4444';
                    } else {
                        configStatusDiv.style.color = '#94a3b8';
                        configStatusDiv.style.borderColor = 'rgba(220, 15, 15, 0.4)';
                    }
                }
            }

            function waitForConfig() {
                return new Promise((resolve) => {
                    if (typeof window.SB_URL !== 'undefined' && typeof window.SB_KEY !== 'undefined' && window.SB_URL && window.SB_KEY) {
                        sbUrl = window.SB_URL;
                        sbKey = window.SB_KEY;
                        configReady = true;
                        updateConfigStatus('✓ TESVRIX SECURE CHANNEL ACTIVE');
                        resolve(true);
                        return;
                    }
                    let attempts = 0;
                    const maxAttempts = 60;
                    const interval = setInterval(() => {
                        attempts++;
                        if (typeof window.SB_URL !== 'undefined' && typeof window.SB_KEY !== 'undefined' && window.SB_URL && window.SB_KEY) {
                            sbUrl = window.SB_URL;
                            sbKey = window.SB_KEY;
                            configReady = true;
                            clearInterval(interval);
                            updateConfigStatus('✓ TESVRIX SECURE CHANNEL ACTIVE');
                            resolve(true);
                        } else if (attempts >= maxAttempts) {
                            clearInterval(interval);
                            configReady = false;
                            updateConfigStatus('⚠ TESVRIX OFFLINE: CONFIG MISSING', true);
                            resolve(false);
                        }
                    }, 100);
                });
            }

            async function authenticateUser() {
                if (isFetching) return;
                
                const username = userField ? userField.value.replace(/[<>]/g, "").trim() : '';
                const password = passField ? passField.value.trim() : '';
                if (!username || !password) {
                    displayError("ACCESS DENIED: Please provide valid username and access cipher.");
                    return;

                }
                if (!configReady || !sbUrl || !sbKey) {
                    displayError("TESVRIX ENGINE UNAVAILABLE: Secure module initializing. Please wait moment.");
                    return;
                }
                isFetching = true;
                const originalButtonContent = btn ? btn.innerHTML : '';
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> DECRYPTING CONNECTIONS...';
                }
                try {
                    const now = new Date().toISOString();
                    const url = getApiUrl(`operators?username=eq.${encodeURIComponent(username)}&password=eq.${encodeURIComponent(password)}&expiry_date=gt.${now}`);
                    const response = await fetch(url, {
                        headers: getApiHeaders()
                    });
                    if (!response.ok) {
                        let errorText = `Link error ${response.status}`;
                        if (response.status === 401) errorText = "Unauthorized: Invalid security token";
                        else if (response.status === 404) errorText = "Endpoint unreachable";
                        else if (response.status === 500) errorText = "Server error: retry later";
                        throw new Error(errorText);
                    }
                    const data = await response.json();
                    if (data && Array.isArray(data) && data.length > 0) {
                        const sessionData = data[0];
                        sessionData.operator_id = sessionData.telegram_channel_id || "";
                        localStorage.setItem('user', JSON.stringify(sessionData));
                        
                        await fetch('index.php?action=log_operator_access', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ operator_id: username })
                        }).catch(e => console.warn("Internal metric log error:", e));
                        
                        btn.innerHTML = '<i class="fa-solid fa-circle-check mr-2"></i> AUTHENTICATED';
                        btn.style.background = 'linear-gradient(135deg, #0a6e0a, #0f9b0f)';
                        
                        const container = document.querySelector('.login-container');
                        container.style.transition = 'box-shadow 0.2s';
                        container.style.boxShadow = '0 0 60px rgba(0, 220, 0, 0.2), 0 0 80px rgba(220,15,15,0.2)';
                        
                        setTimeout(() => {
                            window.location.href = 'dashboard.php';
                        }, 800);
                    } else {
                        displayError("ACCESS DENIED: Identity mismatch or invalid credentials.");
                        const container = document.querySelector('.login-container');
                        container.style.borderColor = '#dc0f0f';
                        setTimeout(() => { container.style.borderColor = 'rgba(220,15,15,0.3)'; }, 300);
                        if (btn) {
                            btn.disabled = false;
                            btn.innerHTML = originalButtonContent;
                        }
                    }
                } catch (err) {
                    console.warn("Tesvrix auth error:", err);
                    let friendlyMsg = "NETWORK ERROR: Secure link failed.";
                    if (err.message.includes("Failed to fetch")) friendlyMsg = "CONNECTION REFUSED: Check network or endpoint.";
                    else if (err.message.includes("Unauthorized")) friendlyMsg = "CONFIG ERROR: Invalid API credentials.";
                    else friendlyMsg = `SECURE LINK FAILED: ${err.message}`;
                    displayError(friendlyMsg);
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = originalButtonContent;
                    }
                } finally {
                    isFetching = false;
                }
            }

            if (btn) {
                btn.onclick = (e) => {
                    e.preventDefault();
                    if (!configReady) {
                        displayError("TESVRIX SECURE MODULE INITIALIZING... Wait and retry.");
                        return;
                    }
                    authenticateUser();
                };
            }
            if (passField) {
                passField.onkeypress = (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        if (btn && configReady) btn.click();
                        else if (!configReady) displayError("Tesvrix engine loading, please wait...");
                    }
                };
            }
            if (userField) {
                userField.onkeypress = (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        if (passField) passField.focus();
                    }
                };
            }
            waitForConfig().then(ready => {
                if (!ready && errorBox && errorBox.classList.contains('hidden')) {
                    setTimeout(() => {
                        if (!configReady && errorBox && errorBox.classList.contains('hidden')) {
                            updateConfigStatus('⚠ CHECK TESVRIX CONFIGURATION', true);
                        }
                    }, 1200);
                }
            });

            const style = document.createElement('style');
            style.textContent = `
                .input-field:-webkit-autofill,
                .input-field:-webkit-autofill:focus {
                    transition: background-color 600000s 0s, color 600000s 0s;
                }
                .logo-title {
                    background: linear-gradient(135deg, #ffffff, #dc2626, #ff6b6b);
                    -webkit-background-clip: text;
                    background-clip: text;
                }
            `;
            document.head.appendChild(style);
        })();
    </script>
    <script src="davidkewebsitekemake300kespeedma/config.php"></script>
    <script>
        (function finalTesvrixCheck() {
            setTimeout(() => {
                if (typeof window.SB_URL !== 'undefined' && typeof window.SB_KEY !== 'undefined') {
                    if (window.SB_URL && window.SB_KEY) {
                        const statusDiv = document.getElementById('configStatus');
                        if (statusDiv && statusDiv.innerHTML.includes('INITIALIZING')) {
                            statusDiv.innerHTML = '✓ TESVRIX SECURE CHANNEL ACTIVE';
                        }
                    }
                }
            }, 300);
        })();
    </script>
</body>
</html>
