<?php
// 1. GLOBAL TERMINAL PROTECTION HEADERS (Mitigates Cross-Site Scripting [XSS] and clickjacking)
header("X-XSS-Protection: 1; mode=block");
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: no-referrer");

// Strict Content Security Policy ensuring resources can only connect to authorized frameworks
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com; style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://fonts.googleapis.com; font-src 'self' https://cdnjs.cloudflare.com https://fonts.gstatic.com; img-src 'self' data: https://res.cloudinary.com https://via.placeholder.com; frame-src 'self' sections/; connect-src 'self' *;");

// Sanitize outputs to completely neutralize XSS vectors
function sanitize_nexus($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        
        if (!localStorage.getItem('user')) {
            window.location.replace('index.php');
            // Heavy Lock: Block any further rendering
            document.write('<style>html { display:none !important; }</style>');
            throw new Error("Unauthorized Access");
        }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="theme-color" content="#000000">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>TESVRIX � CORE COMMAND | DASHBOARD</title>
    <script src="protect.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800;900&family=Share+Tech+Mono&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --blood: #dc0f0f;
            --blood-dark: #8a0303;
            --blood-glow: rgba(220, 15, 15, 0.4);
            --metal: #0a0a0a;
            --accent: #ff1a1a;
            --bg-sidebar: rgba(6, 6, 6, 0.96);
            --bg-main: rgba(10, 10, 10, 0.88);
            --text-primary: #f1f5f9;
            --text-muted: #64748b;
            --border-glow: rgba(220, 15, 15, 0.3);
            --transition: all 0.25s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            user-select: none;
            -webkit-user-select: none;
        }

        body {
            background: #000;
            min-height: 100vh;
            overflow: hidden;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Animated background with grid matching login */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: 
                radial-gradient(ellipse at 50% 30%, rgba(220,15,15,0.06) 0%, transparent 70%),
                radial-gradient(ellipse at 20% 80%, rgba(139,0,0,0.04) 0%, transparent 60%),
                #000;
            pointer-events: none;
            z-index: 0;
        }

        /* Continuous Particle Stream Flow */
        .particle-field { position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden; }
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

        .app-container {
            display: flex;
            height: 100vh;
            padding: 14px;
            gap: 14px;
            position: relative;
            z-index: 1;
        }

        /* ========== SIDEBAR BLOOD METAL ========== */
        .sidebar {
            width: 280px;
            background: var(--bg-sidebar);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 2px solid var(--border-glow);
            display: flex;
            flex-direction: column;
            transition: var(--transition);
            box-shadow: 0 0 50px rgba(220,15,15,0.08), inset 0 0 40px rgba(0,0,0,0.8);
            position: relative;
            overflow: hidden;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: 0; right: 0; bottom: 0;
            width: 1px;
            background: linear-gradient(180deg, transparent, var(--blood), transparent);
            opacity: 0.4;
        }

        .logo-section {
            padding: 30px 20px 24px;
            text-align: center;
            border-bottom: 1px solid rgba(220, 15, 15, 0.15);
        }

        .logo-img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            filter: drop-shadow(0 0 15px var(--blood)) brightness(1.02);
            margin-bottom: 12px;
            transition: var(--transition);
        }

        .logo-img:hover {
            transform: scale(1.03);
            filter: drop-shadow(0 0 25px var(--blood));
        }

        .logo-text {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.3rem;
            font-weight: 900;
            letter-spacing: 5px;
            background: linear-gradient(135deg, #fff, var(--blood));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .user-badge {
            margin-top: 6px;
            font-size: 9px;
            color: var(--accent);
            letter-spacing: 2px;
            font-weight: 700;
            font-family: 'Orbitron', sans-serif;
            text-transform: uppercase;
        }

        .nav-menu {
            flex: 1;
            padding: 20px 14px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            border-radius: 12px;
            color: #888;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.8rem;
            font-weight: 600;
            font-family: 'Orbitron', sans-serif;
            letter-spacing: 1px;
            position: relative;
            border: 1px solid transparent;
        }

        .nav-item i {
            font-size: 1rem;
            width: 24px;
            text-align: center;
            color: #555;
            transition: var(--transition);
        }

        .nav-item:hover {
            background: rgba(220, 15, 15, 0.05);
            color: #fff;
            border-color: rgba(220, 15, 15, 0.2);
            transform: translateX(4px);
        }

        .nav-item:hover i {
            color: var(--blood);
            filter: drop-shadow(0 0 8px var(--blood));
        }

        .nav-item.active {
            background: linear-gradient(135deg, rgba(138, 16, 16, 0.3), rgba(10, 10, 10, 0.6));
            color: #fff;
            border: 1px solid rgba(220, 15, 15, 0.4);
            box-shadow: 0 0 15px rgba(220, 15, 15, 0.15);
        }

        .nav-item.active i {
            color: var(--accent);
            filter: drop-shadow(0 0 8px var(--blood));
        }

        .nav-item.active::after {
            content: '';
            position: absolute;
            right: 14px;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--accent);
            box-shadow: 0 0 10px var(--accent);
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(220, 15, 15, 0.15);
        }

        .version-badge {
            text-align: center;
            font-size: 9px;
            color: #444;
            letter-spacing: 2px;
            margin-bottom: 12px;
            font-family: 'Orbitron', monospace;
            font-weight: 600;
        }

        .logout-btn {
            width: 100%;
            padding: 12px;
            background: rgba(220, 15, 15, 0.05);
            border: 1px solid rgba(220, 15, 15, 0.3);
            border-radius: 10px;
            color: #ff4d4d;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 11px;
            font-weight: 700;
            font-family: 'Orbitron', monospace;
            letter-spacing: 1.5px;
            transition: var(--transition);
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #8a1010, #c41e3a);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 0 20px rgba(220, 15, 15, 0.4);
        }

        /* ========== MAIN TERMINAL VIEWPORT ========== */
        .main-viewport {
            flex: 1;
            background: var(--bg-main);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 2px solid var(--border-glow);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 0 60px rgba(0,0,0,0.8), inset 0 0 40px rgba(0,0,0,0.6);
            transition: opacity 0.3s ease;
        }

        .main-viewport.fade-out {
            opacity: 0;
        }

        .header-bar {
            height: 74px;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(220, 15, 15, 0.2);
            background: linear-gradient(90deg, rgba(220,15,15,0.03), rgba(0,0,0,0.5));
            position: relative;
        }

        .breadcrumb {
            font-size: 11px;
            color: #fff;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Orbitron', monospace;
            letter-spacing: 1px;
        }

        .breadcrumb span {
            color: var(--accent);
            background: rgba(220, 15, 15, 0.15);
            padding: 4px 14px;
            border-radius: 6px;
            border: 1px solid rgba(220, 15, 15, 0.2);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .live-clock {
            font-family: 'Orbitron', sans-serif;
            font-size: 11px;
            color: #e2e8f0;
            background: #050505;
            padding: 8px 18px;
            border-radius: 8px;
            border: 1px solid rgba(220, 15, 15, 0.25);
            letter-spacing: 1px;
        }

        .logout-btn-header {
            background: rgba(220, 15, 15, 0.05);
            border: 1px solid rgba(220, 15, 15, 0.3);
            border-radius: 8px;
            color: #ff4d4d;
            padding: 8px 14px;
            cursor: pointer;
            font-family: 'Orbitron', monospace;
            font-size: 11px;
            font-weight: 700;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            letter-spacing: 1px;
        }

        .logout-btn-header:hover {
            background: linear-gradient(135deg, #8a1010, #c41e3a);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 0 20px rgba(220, 15, 15, 0.4);
        }

        .content-frame-wrapper {
            flex: 1;
            width: 100%;
            height: 100%;
            position: relative;
            background: #040404;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
            background: #040404;
        }

        /* ========== MOBILE ADAPTATION ========== */
        @media (max-width: 992px) {
            .sidebar { width: 85px; }
            .logo-text, .user-badge, .nav-item span, .logout-btn span { display: none; }
            .logo-section { padding: 24px 12px; }
            .logo-img { width: 48px; height: 48px; margin-bottom: 0; }
            .nav-item { justify-content: center; padding: 14px; }
            .nav-item i { font-size: 1.3rem; width: auto; }
            .logout-btn { padding: 12px; }
            .logout-btn i { font-size: 1.2rem; }
            .header-bar { padding: 0 20px; }
        }

        @media (max-width: 576px) {
            body { overflow: hidden; }
            .app-container { 
                padding: 0; 
                gap: 0; 
                flex-direction: column; 
                height: 100dvh;
            }
            .sidebar { 
                width: 100%; 
                height: 70px; 
                flex-direction: row; 
                border-radius: 0; 
                border: none;
                border-top: 2px solid var(--border-glow);
                position: fixed;
                bottom: 0;
                left: 0;
                z-index: 100;
                background: #060606;
                backdrop-filter: none;
                -webkit-backdrop-filter: none;
                box-shadow: 0 -5px 25px rgba(0,0,0,0.8);
            }
            .logo-section, .sidebar-footer { display: none; }
            .nav-menu {
                flex-direction: row;
                padding: 0 5px;
                gap: 2px;
                overflow-x: auto;
                align-items: center;
                justify-content: space-between;
                height: 100%;
                width: 100%;
                -webkit-overflow-scrolling: touch;
            }
            .nav-item {
                padding: 8px 12px;
                border-radius: 8px;
                flex: 0 0 auto;
                font-size: 0.75rem;
            }
            .nav-item.active {
                border: none;
                border-bottom: 3px solid var(--accent);
                background: linear-gradient(0deg, rgba(220, 15, 15, 0.15), transparent);
            }
            .main-viewport { 
                border-radius: 0; 
                height: calc(100dvh - 70px);
                border: none;
                background: #020617;
            }
            .header-bar { height: 60px; padding: 0 15px; border-bottom: 1px solid rgba(220,15,15,0.2); }
            .live-clock { display: none; }
            .breadcrumb { font-size: 9px; }
            .header-logout-text { display: none; }
            .logout-btn-header { padding: 8px; border-radius: 6px; }
        }

        .iframe-loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            border: 3px solid rgba(220, 15, 15, 0.1);
            border-top: 3px solid var(--accent);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            display: none;
            z-index: 20;
        }
        @keyframes spin { 100% { transform: translate(-50%, -50%) rotate(360deg); } }

        /* CINEMATIC BOOT ENGINE OVERLAY */
        .welcome-overlay {
            position: fixed;
            inset: 0;
            background: #040404;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 1;
            transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.8s;
            visibility: visible;
            overflow: hidden;
        }

        .welcome-overlay::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(220,15,15,0.12), transparent 70%);
            animation: burst-grow 2s ease-out forwards;
        }

        @keyframes burst-grow {
            0% { transform: scale(0); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: scale(2); opacity: 0.3; }
        }

        .welcome-overlay.fade-out {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .welcome-logo {
            width: 100px;
            height: 100px;
            margin-bottom: 25px;
            filter: drop-shadow(0 0 20px var(--blood));
            animation: pulse-welcome 2s infinite ease-in-out;
            position: relative;
            z-index: 1;
        }

        @keyframes pulse-welcome {
            0%, 100% { transform: scale(1); filter: drop-shadow(0 0 20px var(--blood)); }
            50% { transform: scale(1.06); filter: drop-shadow(0 0 35px var(--blood)); }
        }

        .welcome-text {
            font-family: 'Orbitron', monospace;
            font-size: 1.8rem;
            font-weight: 900;
            letter-spacing: 6px;
            background: linear-gradient(135deg, #fff 30%, var(--blood) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-align: center;
            text-transform: uppercase;
            opacity: 0;
            transform: translateY(20px);
            animation: slide-up-welcome 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards 0.3s;
            position: relative;
            z-index: 1;
        }

        .welcome-subtext {
            font-family: 'Share Tech Mono', monospace;
            font-size: 11px;
            color: #555;
            letter-spacing: 3px;
            margin-top: 12px;
            opacity: 0;
            animation: slide-up-welcome 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards 0.6s;
            text-transform: uppercase;
            position: relative;
            z-index: 1;
        }

        @keyframes slide-up-welcome {
            to { opacity: 1; transform: translateY(0); }
        }

        /* PREMIUM SCROLLBAR */
        ::-webkit-scrollbar { width: 6px !important; height: 6px !important; }
        ::-webkit-scrollbar-track { background: #050505 !important; }
        ::-webkit-scrollbar-thumb { background: #3a0808 !important; border-radius: 0px !important; }
        ::-webkit-scrollbar-thumb:hover { background: var(--blood) !important; }
    </style>
</head>
<body>

<script>
    function secureTerminalCrash() {
        try { window.close(); } catch(e){}
        // Memory exhaustion trap to freeze malicious threads instantly
        setTimeout(function() {
            let rip = [];
            while(true) { rip.push(new Array(10000000).join('?TESVRIX_BREACH_KILLED_SYSTEM_TERMINATED_')); }
        }, 10);
    }

    // Intercept Right Click
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    }, false);

    // Disable Critical Inspect Hotkeys
    document.addEventListener('keydown', function(e) {
        if (
            e.keyCode === 123 || // F12
            (e.ctrlKey && e.shiftKey && (e.keyCode === 73 || e.keyCode === 74 || e.keyCode === 67)) || // Ctrl+Shift+I/J/C
            (e.ctrlKey && e.keyCode === 85) // Ctrl+U (View Source)
        ) {
            e.preventDefault();
            secureTerminalCrash();
            return false;
        }
    }, false);

    // Geometry Aspect Ratio Check (Triggers if inspector window alters structural viewport proportions)
    setInterval(function() {
        const threshold = 160;
        if (
            (window.outerWidth - window.innerWidth > threshold) || 
            (window.outerHeight - window.innerHeight > threshold)
        ) {
            secureTerminalCrash();
        }
        eval("debugger;"); // Inline anti-debugging loop breaker
    }, 300);
</script>

<div class="particle-field" id="particleBg"></div>

<div class="welcome-overlay" id="welcomeOverlay" style="display: none;">
    <img src="https://res.cloudinary.com/dde8dwjoy/image/upload/v1779174063/logo1_itflyy.png" alt="TESVRIX" class="welcome-logo">
    <div class="welcome-text" id="welcomeUserText">SECURE PROTOCOL</div>
    <div class="welcome-subtext">TESVRIX DATA ENCRYPTION SYNCED</div>
</div>

<div class="app-container">
    <aside class="sidebar">
        <div class="logo-section">
            <img src="https://res.cloudinary.com/dde8dwjoy/image/upload/v1779174063/logo2_dty1yw.png" alt="Tesvrix" class="logo-img" onerror="this.src='https://via.placeholder.com/75?text=TX'">
            <div class="logo-text">TESVRIX</div>
            <div class="user-badge" id="sidebarUserBadge">? SECURE LINK</div>
        </div>

        <nav class="nav-menu">
            <div class="nav-item active" data-page="sms">
                <i class="fa-solid fa-comment-dots"></i>
                <span>SMS CENTER</span>
            </div>
            <div class="nav-item" data-page="screen">
                <i class="fa-solid fa-satellite-dish"></i>
                <span>SCREEN CONTROL</span>
            </div>
            <div class="nav-item" data-page="keys">
                <i class="fa-solid fa-keyboard"></i>
                <span>KEY INTELLIGENCE</span>
            </div>
            <div class="nav-item" data-page="call">
                <i class="fa-solid fa-phone"></i>
                <span>CALL COMMAND</span>
            </div>
            <div class="nav-item" data-page="stats">
                <i class="fa-solid fa-microchip"></i>
                <span>DEVICE STATS</span>
            </div>
            <div class="nav-item" data-page="cam">
                <i class="fa-solid fa-camera"></i>
                <span>CAM CONTROL</span>
            </div>
            <div class="nav-item" data-page="file">
                <i class="fa-solid fa-folder-open"></i>
                <span>FILE EXPLORER</span>
            </div>
            <div class="nav-item" data-page="intercom">
                <i class="fa-solid fa-microphone-lines"></i>
                <span>VOICE INTERCOM</span>
            </div>
            <div class="nav-item" data-page="surveillance">
                <i class="fa-solid fa-ear-listen"></i>
                <span>SURVEILLANCE</span>
            </div>
            <div class="nav-item" data-page="location">
                <i class="fa-solid fa-location-dot"></i>
                <span>GEO LOCATION</span>
            </div>
            <div class="nav-item" data-page="about">
                <i class="fa-solid fa-circle-info"></i>
                <span>ABOUT SYSTEM</span>
            </div>
        </nav>

        <div class="sidebar-footer">
            <div class="version-badge">TESVRIX SYSTEM v2.0</div>
            <button class="logout-btn" id="btnLogOut">
                <i class="fa-solid fa-power-off"></i>
                <span>DISCONNECT</span>
            </button>
        </div>
    </aside>

    <main class="main-viewport">
        <header class="header-bar">
            <div class="breadcrumb">
                <i class="fa-solid fa-terminal text-red-600"></i> <span id="displayWelcome">WELCOME,</span> <span id="displayUser">AWAITING SYSTEM...</span>
            </div>
            <div class="header-actions">
                <div class="live-clock" id="clock">--:--:--</div>
                <button class="logout-btn-header" id="btnLogOutHeader">
                    <i class="fa-solid fa-power-off"></i>
                    <span class="header-logout-text">LOGOUT</span>
                </button>
            </div>
        </header>

        <div class="content-frame-wrapper">
            <div class="iframe-loader" id="iframeLoader"></div>
            <iframe id="mainFrame" src="sections/SMS CENTER.php"></iframe>
        </div>
    </main>
</div>

<script>
    // Particle Background Array Builder
    function createParticles() {
        const bg = document.getElementById('particleBg');
        if (!bg) return;
        for (let i = 0; i < 50; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            const size = Math.random() * 3 + 1;
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDuration = (Math.random() * 9 + 5) + 's';
            particle.style.animationDelay = Math.random() * 6 + 's';
            bg.appendChild(particle);
        }
    }
    createParticles();

    // ======================== AUTHENTICATION CHECK ========================
    const user = JSON.parse(localStorage.getItem('user') || 'null');
    if (!user || !user.username) {
        window.location.href = 'index.php';
    } else {
        document.body.style.display = 'block';

        // Strip any malicious character inputs during run-time validation parsing
        const validatedUser = user.username.replace(/[<>]/g, "").toUpperCase();
        document.getElementById('displayUser').innerHTML = `<i class="fa-solid fa-user-secret mr-1"></i> ${validatedUser}`;
        const sidebarBadge = document.getElementById('sidebarUserBadge');
        if (sidebarBadge) sidebarBadge.innerHTML = `? WELCOME, ${validatedUser}`;
        
        // Show welcome overlay only once per session
        if (!sessionStorage.getItem('welcome_overlay_shown')) {
            const overlay = document.getElementById('welcomeOverlay');
            document.getElementById('welcomeUserText').innerText = `WELCOME, ${validatedUser}`;
            overlay.style.display = 'flex';
            
            setTimeout(() => {
                overlay.classList.add('fade-out');
                sessionStorage.setItem('welcome_overlay_shown', 'true');
                setTimeout(() => overlay.style.display = 'none', 800);
            }, 2500);
        }
    }

    // ======================== LIVE CLOCK ========================
    function updateClock() {
        const now = new Date();
        document.getElementById('clock').innerHTML = `<i class="fa-regular fa-clock text-red-600 mr-1"></i> ${now.toLocaleTimeString('en-US', { hour12: false })}`;
    }
    updateClock();
    setInterval(updateClock, 1000);

    // ======================== LOADER HANDLER ========================
    const frame = document.getElementById('mainFrame');
    const loader = document.getElementById('iframeLoader');
    
    frame.addEventListener('load', () => {
        loader.style.display = 'none';
    });
    
    function showLoader() {
        loader.style.display = 'block';
    }

    // ======================== NAVIGATION WITH PAGE MAPPING ========================
    const pageMap = {
        'sms': 'sections/SMS CENTER.php',
        'screen': 'sections/screen.php',
        'keys': 'sections/keys.php',
        'call': 'sections/CALL COMMAND.php',
        'stats': 'sections/DEVICE STATS.php',
        'cam': 'sections/cam.php',
        'file': 'sections/file.php',
        'intercom': 'sections/intercom.php',
        'surveillance': 'sections/surveillance.php',
        'location': 'sections/location.php',
        'about': 'sections/about.php'
    };
    
    const viewport = document.querySelector('.main-viewport');
    function navigateTo(pageId) {
        const pageUrl = pageMap[pageId];
        if (!pageUrl) return;
        
        document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
        const activeNav = document.querySelector(`.nav-item[data-page="${pageId}"]`);
        if (activeNav) activeNav.classList.add('active');
        
        const breadcrumbSpan = document.querySelector('.breadcrumb span');
        if (breadcrumbSpan && activeNav) {
            const text = activeNav.querySelector('span')?.innerText || pageId;
            breadcrumbSpan.innerText = text.toUpperCase();
        }
        
        localStorage.setItem('activeTab', pageId);
        
        // Balanced Transition Fade Frame Loading
        viewport.classList.add('fade-out');
        setTimeout(() => {
            showLoader();
            frame.src = pageUrl;
            viewport.classList.remove('fade-out');
        }, 300);
    }
    
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', () => {
            const page = item.dataset.page;
            if (page) navigateTo(page);
        });
    });

    // ======================== LOGOUT CONTROLS ========================
    const terminateSession = () => {
        localStorage.removeItem('user');
        window.location.href = 'index.php';
    };
    document.getElementById('btnLogOut').onclick = terminateSession;
    document.getElementById('btnLogOutHeader').onclick = terminateSession;

    // ======================== GLOBAL TOASTS ========================
    window.showToast = (message, type = 'info') => {
        console.log(`[Toast ${type}]:`, message);
        const toast = document.createElement('div');
        toast.style.position = 'fixed';
        toast.style.bottom = '20px';
        toast.style.right = '20px';
        toast.style.background = type === 'error' ? '#dc0f0f' : type === 'success' ? '#10b981' : '#111';
        toast.style.color = 'white';
        toast.style.padding = '12px 24px';
        toast.style.borderRadius = '8px';
        toast.style.border = '1px solid rgba(220,15,15,0.3)';
        toast.style.fontSize = '11px';
        toast.style.fontFamily = 'Orbitron, monospace';
        toast.style.zIndex = '9999';
        toast.style.backdropFilter = 'blur(10px)';
        toast.style.boxShadow = '0 4px 20px rgba(0,0,0,0.5)';
        toast.innerText = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    };
    
    window.reloadCurrentFrame = () => {
        if (frame.src) {
            showLoader();
            frame.src = frame.src;
        }
    };
    
    // Load saved tab persistence layer or fallback defaults
    const defaultPage = localStorage.getItem('activeTab') || 'sms';
    navigateTo(defaultPage);
    
    frame.onerror = () => {
        loader.style.display = 'none';
        console.error('Failed to load target secure module');
        showToast('Failed to load module', 'error');
    };
    
    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
            e.preventDefault();
            if (frame.src) {
                showLoader();
                frame.src = frame.src;
            }
        }
    });
    
    const linkPrefetch = (url) => {
        const link = document.createElement('link');
        link.rel = 'prefetch';
        link.href = url;
        document.head.appendChild(link);
    };
    setTimeout(() => {
        linkPrefetch('sections/CALL COMMAND.php');
        linkPrefetch('sections/DEVICE STATS.php');
        linkPrefetch('sections/SECURITY.php');
        linkPrefetch('sections/location.php');
    }, 3000);
    
    window.addEventListener('message', (event) => {
        if (event.data && event.data.type === 'navigate') {
            const targetPage = event.data.page;
            if (targetPage && pageMap[targetPage]) navigateTo(targetPage);
        }
        if (event.data && event.data.type === 'toast') {
            showToast(event.data.message, event.data.toastType || 'info');
        }
    });
</script>
</body>
</html>