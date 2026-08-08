<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" />
    <meta name="theme-color" content="#020617" />
    <title>TESVRIX · About V2</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        /* ===== THEME VARIABLES ===== */
        :root {
            --primary: #e11d48;
            --primary-dark: #be123c;
            --primary-glow: rgba(225, 29, 72, 0.4);
            --accent-green: #10b981;
            --accent-blue: #3b82f6;
            --accent-amber: #f59e0b;
            --bg-main: rgba(8, 8, 16, 0.85);
            --text-primary: #f1f5f9;
            --text-muted: #94a3b8;
            --border-glow: rgba(225, 29, 72, 0.25);
            --transition: all 0.25s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #020617;
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            padding: 20px;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background grid & particles */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: radial-gradient(circle at 20% 30%, rgba(225, 29, 72, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(59, 130, 246, 0.05) 0%, transparent 50%),
                repeating-linear-gradient(45deg, rgba(255, 255, 255, 0.01) 0px, rgba(255, 255, 255, 0.01) 1px, transparent 1px, transparent 20px);
            pointer-events: none;
            z-index: 0;
        }

        .particle-field {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }
        .particle {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, var(--primary-glow), transparent 70%);
            animation: float-particle linear infinite;
            opacity: 0;
        }
        .particle:nth-child(1) {
            width: 200px;
            height: 200px;
            top: 10%;
            left: 5%;
            animation-duration: 18s;
            animation-delay: 0s;
        }
        .particle:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            left: 80%;
            animation-duration: 22s;
            animation-delay: 3s;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.15), transparent 70%);
        }
        .particle:nth-child(3) {
            width: 160px;
            height: 160px;
            top: 80%;
            left: 30%;
            animation-duration: 25s;
            animation-delay: 6s;
        }
        .particle:nth-child(4) {
            width: 90px;
            height: 90px;
            top: 20%;
            left: 70%;
            animation-duration: 20s;
            animation-delay: 2s;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.1), transparent 70%);
        }
        .particle:nth-child(5) {
            width: 140px;
            height: 140px;
            top: 50%;
            left: 15%;
            animation-duration: 28s;
            animation-delay: 8s;
        }

        @keyframes float-particle {
            0% {
                transform: translate(0, 0) scale(0.8);
                opacity: 0;
            }
            15% {
                opacity: 0.6;
            }
            50% {
                transform: translate(80px, -60px) scale(1.2);
                opacity: 0.4;
            }
            85% {
                opacity: 0.6;
            }
            100% {
                transform: translate(-40px, 40px) scale(0.8);
                opacity: 0;
            }
        }

        /* ===== MAIN CONTAINER ===== */
        .about-container {
            max-width: 1000px;
            width: 100%;
            background: rgba(2, 6, 23, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 28px;
            border: 1px solid var(--border-glow);
            box-shadow: 0 20px 35px -15px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(225, 29, 72, 0.08);
            padding: 40px 45px;
            position: relative;
            z-index: 1;
            transition: var(--transition);
            margin: 20px auto;
        }

        .about-container::before {
            content: '';
            position: absolute;
            top: -1px;
            left: 20%;
            right: 20%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--primary), rgba(59, 130, 246, 0.5), transparent);
            opacity: 0.7;
            animation: sidebar-glow 4s ease-in-out infinite;
        }
        @keyframes sidebar-glow {
            0%,
            100% {
                opacity: 0.3;
            }
            50% {
                opacity: 0.8;
            }
        }

        /* V2 badge pulse */
        .v2-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, rgba(225, 29, 72, 0.2), rgba(245, 158, 11, 0.15));
            border: 1px solid var(--primary);
            padding: 4px 16px 4px 12px;
            border-radius: 40px;
            font-family: 'Orbitron', sans-serif;
            font-size: 0.7rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 1px;
            animation: v2-pulse 2.5s ease-in-out infinite;
            box-shadow: 0 0 20px rgba(225, 29, 72, 0.15);
        }
        .v2-badge i {
            color: var(--accent-amber);
            font-size: 0.6rem;
        }
        @keyframes v2-pulse {
            0%,
            100% {
                box-shadow: 0 0 10px rgba(225, 29, 72, 0.1);
            }
            50% {
                box-shadow: 0 0 30px rgba(225, 29, 72, 0.3), 0 0 60px rgba(225, 29, 72, 0.1);
            }
        }

        /* ===== HEADER ===== */
        .about-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            padding-bottom: 25px;
        }

        .about-logo {
            width: 70px;
            height: 70px;
            object-fit: contain;
            filter: drop-shadow(0 0 18px var(--primary));
            animation: logo-breathe 3s ease-in-out infinite;
        }
        @keyframes logo-breathe {
            0%,
            100% {
                filter: drop-shadow(0 0 18px var(--primary));
            }
            50% {
                filter: drop-shadow(0 0 28px var(--primary)) drop-shadow(0 0 8px rgba(255, 255, 255, 0.15));
            }
        }

        .about-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.8rem;
            font-weight: 900;
            letter-spacing: 3px;
            background: linear-gradient(135deg, #fff 30%, var(--primary) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            flex: 1;
        }
        .about-subtitle {
            font-size: 0.75rem;
            color: var(--text-muted);
            letter-spacing: 2px;
            font-weight: 500;
            text-transform: uppercase;
        }
        .about-subtitle strong {
            color: var(--accent-amber);
            font-weight: 700;
        }

        /* ===== CONTENT CARDS ===== */
        .glass-card {
            background: rgba(8, 8, 16, 0.6);
            border: 1px solid rgba(225, 29, 72, 0.15);
            border-radius: 20px;
            padding: 24px 28px;
            margin-bottom: 24px;
            transition: var(--transition);
            backdrop-filter: blur(8px);
        }
        .glass-card:hover {
            border-color: var(--primary);
            box-shadow: 0 0 20px rgba(225, 29, 72, 0.08);
        }
        .glass-card.v2-highlight {
            border-color: var(--accent-amber);
            background: rgba(245, 158, 11, 0.04);
            position: relative;
        }
        .glass-card.v2-highlight::after {
            content: 'NEW';
            position: absolute;
            top: -8px;
            right: 18px;
            background: var(--accent-amber);
            color: #020617;
            font-size: 0.55rem;
            font-weight: 800;
            padding: 2px 12px;
            border-radius: 20px;
            letter-spacing: 1px;
        }

        .card-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: 1px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .card-title i {
            font-size: 1.1rem;
        }
        .card-title .v2-tag {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.5rem;
            font-weight: 700;
            background: var(--accent-amber);
            color: #020617;
            padding: 2px 10px;
            border-radius: 20px;
            letter-spacing: 0.5px;
            margin-left: 4px;
        }

        .card-text {
            color: var(--text-primary);
            font-size: 0.95rem;
            line-height: 1.7;
            font-weight: 400;
        }
        .card-text strong {
            color: var(--primary);
        }
        .card-text .highlight {
            color: var(--accent-green);
        }
        .card-text .amber {
            color: var(--accent-amber);
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 18px;
            margin-top: 12px;
        }
        .feature-item {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 16px;
            padding: 18px 16px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.04);
            transition: var(--transition);
        }
        .feature-item:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(225, 29, 72, 0.06);
        }
        .feature-item i {
            font-size: 1.8rem;
            color: var(--primary);
            margin-bottom: 8px;
            display: block;
        }
        .feature-item h4 {
            font-size: 0.8rem;
            color: #fff;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .feature-item p {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-top: 4px;
        }
        .feature-item.v2-feature {
            border-color: rgba(245, 158, 11, 0.25);
            background: rgba(245, 158, 11, 0.05);
        }
        .feature-item.v2-feature i {
            color: var(--accent-amber);
        }

        .team-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 8px;
        }
        .team-tag {
            background: rgba(225, 29, 72, 0.1);
            border: 1px solid rgba(225, 29, 72, 0.2);
            border-radius: 40px;
            padding: 6px 20px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-primary);
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .team-tag i {
            color: var(--primary);
        }

        .version-timeline {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 8px;
        }
        .timeline-row {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            padding-bottom: 8px;
        }
        .timeline-row .ver {
            font-family: 'Orbitron', monospace;
            font-weight: 700;
            font-size: 0.8rem;
            color: var(--primary);
            min-width: 50px;
        }
        .timeline-row .ver.v2 {
            color: var(--accent-amber);
            font-size: 0.9rem;
        }
        .timeline-row .date {
            font-size: 0.7rem;
            color: var(--text-muted);
            min-width: 100px;
        }
        .timeline-row .desc {
            font-size: 0.75rem;
            color: var(--text-primary);
            flex: 1;
        }
        .timeline-row .badge {
            font-size: 0.6rem;
            background: rgba(16, 185, 129, 0.15);
            color: var(--accent-green);
            padding: 2px 12px;
            border-radius: 20px;
        }
        .timeline-row .badge.v2-badge-tag {
            background: rgba(245, 158, 11, 0.2);
            color: var(--accent-amber);
        }

        .footer-note {
            text-align: center;
            font-size: 0.65rem;
            color: var(--text-muted);
            border-top: 1px solid rgba(255, 255, 255, 0.04);
            padding-top: 20px;
            margin-top: 10px;
            letter-spacing: 1px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .about-container {
                padding: 25px 20px;
            }
            .about-title {
                font-size: 1.4rem;
            }
            .about-logo {
                width: 55px;
                height: 55px;
            }
            .feature-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        @media (max-width: 480px) {
            .about-container {
                padding: 18px 14px;
            }
            .about-title {
                font-size: 1.2rem;
            }
            .about-header {
                gap: 12px;
            }
            .feature-grid {
                grid-template-columns: 1fr;
            }
            .glass-card {
                padding: 18px;
            }
        }
    </style>
</head>
<body>

    <!-- Floating Particles -->
    <div class="particle-field">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <!-- Main Content -->
    <div class="about-container">

        <!-- Header -->
        <div class="about-header">
            <img src="https://res.cloudinary.com/dde8dwjoy/image/upload/v1779174063/logo1_itflyy.png" alt="Tesvrix" class="about-logo" />
            <div>
                <div class="about-title">TESVRIX</div>
                <div class="about-subtitle">
                    Android Remote Administration · <strong>v2.0</strong> · 6 August 2026
                </div>
            </div>
            <div style="margin-left: auto; text-align: right;">
                <span class="v2-badge">
                    <i class="fas fa-bolt"></i> V2 · LIVE
                </span>
            </div>
        </div>

        <!-- About Description – V2 highlight -->
        <div class="glass-card v2-highlight">
            <div class="card-title">
                <i class="fas fa-info-circle"></i> About Tesvrix V2
                <span class="v2-tag">V2</span>
            </div>
            <div class="card-text">
                <strong>Tesvrix V2</strong> is the <span class="amber">next‑generation</span> Android Remote Administration Tool —
                rebuilt from the ground up with <span class="highlight">Android 16 bypass</span> technology, advanced
                obfuscation, and a completely redesigned C2 engine. Control, monitor and manage any Android device
                (7 – 16) from any browser, anywhere.
                <br /><br />
                <i class="fas fa-rocket" style="color:var(--accent-amber);"></i>
                <strong style="color:var(--accent-amber);">v2.0</strong> ·
                <span class="amber">Launched 6 August 2026</span> ·
                <span class="highlight">Android 16 bypass</span> ·
                <span class="highlight">Zero‑day protection</span> ·
                <span class="highlight">Stealth v2.0</span>
            </div>
        </div>

        <!-- Core Capabilities – updated with V2 features -->
        <div class="glass-card">
            <div class="card-title"><i class="fas fa-grip"></i> Core Capabilities <span class="v2-tag">V2</span></div>
            <div class="feature-grid">
                <div class="feature-item v2-feature">
                    <i class="fas fa-shield-halved"></i>
                    <h4>Android 16 Bypass</h4>
                    <p>Full bypass for Android 16 security policies · rootless</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-eye"></i>
                    <h4>Monitor</h4>
                    <p>Camera, mic, keylogger, SMS, calls, notifications</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-sliders"></i>
                    <h4>Control</h4>
                    <p>Remote shell, app launcher, file manager, geofencing</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-database"></i>
                    <h4>Manage</h4>
                    <p>Browser data, passwords, social media, device dumps</p>
                </div>
                <div class="feature-item v2-feature">
                    <i class="fas fa-ghost"></i>
                    <h4>Stealth v2.0</h4>
                    <p>Advanced obfuscation · anti‑sandbox · persistence</p>
                </div>
                <div class="feature-item v2-feature">
                    <i class="fas fa-bolt"></i>
                    <h4>Zero‑day Engine</h4>
                    <p>Custom exploit chain · live updates · C2 v2</p>
                </div>
            </div>
        </div>

        <!-- Developer & Telegram -->
        <div class="glass-card">
            <div class="card-title"><i class="fas fa-users"></i> Team &amp; Contact</div>
            <div class="card-text" style="display:flex; flex-wrap:wrap; gap:20px; justify-content:space-between;">
                <div>
                    <div style="font-size:0.7rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px;">Telegram</div>
                    <a href="https://t.me/Tesvrix" target="_blank" style="color:var(--text-primary); text-decoration:none; font-weight:600; font-size:1rem; display:inline-flex; align-items:center; gap:6px;">
                        <i class="fab fa-telegram" style="color:#26a5e4;"></i> @Tesvrix
                        <i class="fas fa-arrow-up-right-from-square" style="font-size:0.6rem; color:var(--text-muted);"></i>
                    </a>
                </div>
                <div>
                    <div style="font-size:0.7rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px;">Owner / Developers</div>
                    <div class="team-tags">
                        <span class="team-tag"><i class="fas fa-user-astronaut"></i> UV</span>
                        <span class="team-tag">CVE</span>
                        <span class="team-tag"><i class="fas fa-user-astronaut"></i> GHOST</span>
                        <span class="team-tag">FLAGO</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Version History – V2 now at top -->
        <div class="glass-card">
            <div class="card-title"><i class="fas fa-timeline"></i> Version History</div>
            <div class="version-timeline">
                <div class="timeline-row">
                    <span class="ver v2">v2.0</span>
                    <span class="date">6 August 2026</span>
                    <span class="desc"><span class="amber">Android 16 bypass</span> · Zero‑day engine · Stealth v2.0 · C2 overhaul</span>
                    <span class="badge v2-badge-tag"><i class="fas fa-bolt"></i> Latest</span>
                </div>
                <div class="timeline-row">
                    <span class="ver">v1.0</span>
                    <span class="date">3 July 2026</span>
                    <span class="desc">Initial release · Full C2 suite · Android 7–15</span>
                    <span class="badge"><i class="fas fa-check-circle"></i> Stable</span>
                </div>
                <div class="timeline-row">
                    <span class="ver" style="color:var(--accent-blue);">v0.9</span>
                    <span class="date">15 June 2026</span>
                    <span class="desc">Internal beta · Core functionality</span>
                    <span class="badge" style="background:rgba(59,130,246,0.15); color:var(--accent-blue);">Internal</span>
                </div>
                <div class="timeline-row">
                    <span class="ver" style="color:var(--text-muted);">v0.5</span>
                    <span class="date">1 May 2026</span>
                    <span class="desc">Prototype · Proof of concept</span>
                    <span class="badge" style="background:rgba(148,163,184,0.1); color:var(--text-muted);">Early dev</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-note">
            <i class="far fa-copyright"></i> Tesvrix Command &middot; For authorised security testing only &middot;
            <span class="amber">v2.0 · 6 August 2026</span>
        </div>

    </div>

</body>
</html>