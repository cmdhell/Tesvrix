<!DOCTYPE html>
<html lang="en">
<head>
    <script src="../protect.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>TESVRIX · NEURAL VOICE LINK</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Space+Grotesk:wght@400;500;600;700&family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary: #e11d48;
            --primary-glow: rgba(225, 29, 72, 0.5);
            --bg-deep: #020617;
            --bg-surface: rgba(15, 23, 42, 0.8);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --accent-cyan: #06b6d4;
            --accent-green: #10b981;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            background: radial-gradient(circle at 50% 50%, #0a0f1f, var(--bg-deep));
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Scanline effect */
        body::after {
            content: "";
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.1) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.03), rgba(0, 255, 0, 0.01), rgba(0, 0, 255, 0.03));
            z-index: 10;
            background-size: 100% 2px, 3px 100%;
            pointer-events: none;
        }

        .intercom-card {
            width: 100%;
            max-width: 480px;
            background: var(--bg-surface);
            backdrop-filter: blur(20px);
            border-radius: 40px;
            border: 1px solid rgba(225, 29, 72, 0.2);
            box-shadow: 0 0 50px rgba(0,0,0,0.8), inset 0 0 20px rgba(225,29,72,0.05), 0 0 0 1px rgba(225,29,72,0.05);
            padding: 50px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
            z-index: 20;
            animation: card-ambient-glow 5s ease-in-out infinite;
        }

        @keyframes card-ambient-glow {
            0%, 100% { box-shadow: 0 0 50px rgba(0,0,0,0.8), inset 0 0 20px rgba(225,29,72,0.05); }
            50% { box-shadow: 0 0 50px rgba(0,0,0,0.8), inset 0 0 25px rgba(225,29,72,0.08), 0 0 30px rgba(225,29,72,0.08); }
        }

        .intercom-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 4px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
        }

        .header h2 {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.2rem;
            letter-spacing: 4px;
            margin-bottom: 8px;
            color: #fff;
            text-transform: uppercase;
        }

        .header p {
            font-size: 0.7rem;
            color: var(--text-secondary);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 40px;
        }

        /* MIC BUTTON SYSTEM */
        .mic-outer {
            width: 160px;
            height: 160px;
            margin: 0 auto 40px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mic-ring {
            position: absolute;
            inset: -10px;
            border-radius: 50%;
            border: 2px solid rgba(225, 29, 72, 0.1);
            transition: var(--transition);
        }

        .mic-button {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background: rgba(15, 23, 42, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 3rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 5;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            -webkit-tap-highlight-color: transparent;
        }

        .mic-button i {
            transition: var(--transition);
            filter: drop-shadow(0 0 10px rgba(255,255,255,0.2));
        }

        /* Recording State */
        .mic-button.active {
            background: var(--primary);
            border-color: #fff;
            transform: scale(0.95);
            box-shadow: 0 0 40px var(--primary-glow);
        }

        .mic-button.active i {
            transform: scale(1.1);
            filter: drop-shadow(0 0 15px #fff);
        }

        .mic-outer.active .mic-ring {
            inset: -25px;
            border-color: var(--primary);
            animation: pulse-ring 1.5s infinite;
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.9); opacity: 0.8; }
            100% { transform: scale(1.3); opacity: 0; }
        }

        /* STATUS DISPLAY */
        .status-container {
            height: 60px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
        }

        .status-label {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.9rem;
            font-weight: 800;
            letter-spacing: 2px;
            color: var(--text-secondary);
            transition: var(--transition);
        }

        .status-label.active {
            color: var(--primary);
            text-shadow: 0 0 10px var(--primary-glow);
        }

        .wave-container {
            display: none;
            gap: 4px;
            height: 24px;
            align-items: center;
            margin-top: 10px;
        }

        .wave-bar {
            width: 3px;
            height: 8px;
            background: var(--primary);
            border-radius: 10px;
            animation: wave 0.8s infinite ease-in-out;
        }

        @keyframes wave {
            0%, 100% { height: 8px; }
            50% { height: 24px; }
        }

        .wave-bar:nth-child(2) { animation-delay: 0.1s; }
        .wave-bar:nth-child(3) { animation-delay: 0.2s; }
        .wave-bar:nth-child(4) { animation-delay: 0.3s; }
        .wave-bar:nth-child(5) { animation-delay: 0.4s; }

        /* FOOTER CONTROLS */
        .footer-tools {
            border-top: 1px solid rgba(255,255,255,0.05);
            padding-top: 25px;
        }

        .node-selector {
            background: rgba(0,0,0,0.4);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 12px 20px;
            color: #fff;
            width: 100%;
            font-family: 'Space Grotesk';
            font-size: 0.8rem;
            outline: none;
            cursor: pointer;
            transition: var(--transition);
        }

        .node-selector:focus {
            border-color: var(--primary);
            box-shadow: 0 0 15px rgba(225,29,72,0.15);
        }

        .hint {
            margin-top: 15px;
            font-size: 0.6rem;
            color: var(--text-secondary);
            letter-spacing: 1px;
            line-height: 1.5;
        }

        /* Mobile specific adjustments */
        @media (max-width: 480px) {
            .intercom-card { padding: 40px 25px; border-radius: 30px; }
            .mic-button { width: 110px; height: 110px; font-size: 2.5rem; }
            .mic-outer { width: 130px; height: 130px; }
        }
    
        /* UNIVERSAL MOBILE RESPONSIVE FIX */
        @media (max-width: 992px) {
            body { padding: 10px; height: auto !important; min-height: 100vh; overflow-y: auto !important; }
            .main-card { backdrop-filter: none !important; -webkit-backdrop-filter: none !important; background-color: rgba(15, 23, 42, 0.98); } /* Performance fix */
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
    <div class="intercom-card">
        <div class="header">
            <h2>NEURAL LINK</h2>
            <p>Direct Neural Audio Stream</p>
        </div>

        <div class="status-container">
            <div id="statusLabel" class="status-label">AWAITING INPUT</div>
            <div id="waveBox" class="wave-container">
                <div class="wave-bar"></div><div class="wave-bar"></div><div class="wave-bar"></div><div class="wave-bar"></div><div class="wave-bar"></div>
            </div>
        </div>

        <div class="mic-outer" id="micOuter">
            <div class="mic-ring"></div>
            <button class="mic-button" id="micBtn"
                onmousedown="startRecording()" onmouseup="stopRecording()"
                ontouchstart="startRecording()" ontouchend="stopRecording()">
                <i class="fas fa-microphone"></i>
            </button>
        </div>

        <div class="footer-tools">
            <select id="deviceSelector" class="node-selector"></select>
            <div class="hint">
                SECURE UPLINK: PCM 16-BIT  // 44.1KHZ MONO<br>
                HOLD BUTTON TO ESTABLISH BROADCAST
            </div>
        </div>
    </div>

    <script src="../davidkewebsitekemake300kespeedma/config.php"></script>
    <script>
        const auth = JSON.parse(localStorage.getItem('user') || '{}');
        let selectedId = null;
        let audioChunks = [];
        let audioContext;
        let recording = false;

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
        document.getElementById('deviceSelector').onchange = (e) => { selectedId = e.target.value; };

        async function startRecording() {
            if (!selectedId || recording) return;
            recording = true;

            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });

                 // UI Updates
                document.getElementById('micBtn').classList.add('active');
                document.getElementById('micOuter').classList.add('active');
                document.getElementById('statusLabel').innerText = "LIVE STREAMING";
                document.getElementById('statusLabel').classList.add('active');
                document.getElementById('waveBox').style.display = 'flex';

                audioContext = new (window.AudioContext || window.webkitAudioContext)({ sampleRate: 44100 });
                const source = audioContext.createMediaStreamSource(stream);
                const processor = audioContext.createScriptProcessor(4096, 1, 1);

                audioChunks = [];
                processor.onaudioprocess = (e) => {
                    const inputData = e.inputBuffer.getChannelData(0);
                    const pcmData = new Int16Array(inputData.length);
                    for (let i = 0; i < inputData.length; i++) {
                        pcmData[i] = Math.max(-1, Math.min(1, inputData[i])) * 0x7FFF;
                    }
                    audioChunks.push(pcmData);
                };

                source.connect(processor);
                processor.connect(audioContext.destination);

                window.recordingStream = stream;
                window.audioProcessor = processor;
                window.audioSource = source;

            } catch (err) {
                recording = false;
                alert("NEURAL LINK FAILURE: Mic Access Required");
            }
        }

        async function stopRecording() {
            if (!window.recordingStream || !recording) return;
            recording = false;

             // UI Reset
            document.getElementById('micBtn').classList.remove('active');
            document.getElementById('micOuter').classList.remove('active');
            document.getElementById('statusLabel').innerText = "TRANSMITTING...";
            document.getElementById('waveBox').style.display = 'none';

             // Stop streams
            window.recordingStream.getTracks().forEach(track => track.stop());
            window.audioProcessor.disconnect();
            window.audioSource.disconnect();
            if (audioContext) audioContext.close();

             // Process Data
            const totalLength = audioChunks.reduce((acc, val) => acc + val.length, 0);
            const mergedPcm = new Int16Array(totalLength);
            let offset = 0;
            for (const chunk of audioChunks) {
                mergedPcm.set(chunk, offset);
                offset += chunk.length;
            }

             // Correct binary-to-base64 conversion
            const uint8Array = new Uint8Array(mergedPcm.buffer);
            let binaryString = "";
            for (let i = 0; i < uint8Array.length; i++) {
                binaryString += String.fromCharCode(uint8Array[i]);
            }
            const base64 = btoa(binaryString);

             // UI Update for Transmission
            const label = document.getElementById('statusLabel');
            label.innerText = "UPLINK SYNCHRONIZING...";

            transmitVoice(base64);
            window.recordingStream = null;
        }

        async function transmitVoice(base64Data) {
            const label = document.getElementById('statusLabel');
            try {
                const startTime = Date.now();
                
                const body = { device_uuid: selectedId, type: '/voice', status: 'pending', data: JSON.stringify({ data: base64Data }), operator_id: auth.operator_id };

                const response = await fetch(getApiUrl("commands"), { method: 'POST', headers: getApiHeaders(), body: JSON.stringify(body) });

                if (response.ok) {
                    const latency = Date.now() - startTime;
                    label.innerText = `BROADCAST SYNCED (${latency}ms)`;
                    label.classList.add('active');
                    label.style.color = 'var(--accent-green)';
                } else {
                    throw new Error("POST Failed");
                }

                setTimeout(() => {
                    if(!recording) {
                        label.innerText = "AWAITING INPUT";
                        label.style.color = '';
                        label.classList.remove('active');
                    }
                }, 3000);
            } catch (e) {
                label.innerText = "UPLINK COLLAPSED";
                label.style.color = 'var(--accent-red)';
            }
        }

        fetchDevices();
         // Periodic Refresh for Device Status
        setInterval(fetchDevices, 10000);
    </script>
</body>
</html>
