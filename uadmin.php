<?php
session_start();

// Anti-XSS and Clickjacking Security Headers
header("X-XSS-Protection: 1; mode=block");
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: no-referrer");
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com https://cdnjs.cloudflare.com https://unpkg.com; style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://fonts.googleapis.com https://unpkg.com; font-src 'self' https://cdnjs.cloudflare.com https://fonts.gstatic.com; img-src 'self' data: https://res.cloudinary.com https://tile.openstreetmap.org https://server.arcgisonline.com https://*.tile.openstreetmap.org; connect-src 'self' https://ip-api.com;");

$admin_user = "admin";
$admin_pass = "password";
$logFile = 'uvlog.json';

// Handle active session termination
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: uadmin.php");
    exit;
}

// Check inbound admin authentication
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_submission'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username === $admin_user && $password === $admin_pass) {
        $_SESSION['tesvrix_admin_session'] = true;
        header("Location: uadmin.php");
        exit;
    } else {
        $error = "ACCESS DENIED: Credentials Rejected.";
    }
}

// Handle administrative data purge (Delete log)
if (isset($_SESSION['tesvrix_admin_session']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'purge_entry') {
    $targetId = $_POST['log_id'] ?? '';
    if (file_exists($logFile)) {
        $logs = json_decode(file_get_contents($logFile), true) ?? [];
        $updatedLogs = array_filter($logs, function($entry) use ($targetId) {
            return $entry['id'] !== $targetId;
        });
        file_put_contents($logFile, json_encode(array_values($updatedLogs), JSON_PRETTY_PRINT));
    }
    header("Location: uadmin.php" . (!empty($_GET['search']) ? '?search=' . urlencode($_GET['search']) : ''));
    exit;
}

// Load logs and prep filters
$logs = [];
if (file_exists($logFile)) {
    $logs = json_decode(file_get_contents($logFile), true) ?? [];
}

$searchQuery = $_GET['search'] ?? '';
if (!empty($searchQuery)) {
    $logs = array_filter($logs, function($entry) use ($searchQuery) {
        return (stripos($entry['operator_id'], $searchQuery) !== false) || 
               (stripos($entry['date'], $searchQuery) !== false) ||
               (isset($entry['ip']) && stripos($entry['ip'], $searchQuery) !== false);
    });
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TESVRIX | COMMAND HQ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Share+Tech+Mono&display=swap" rel="stylesheet">
    
    <!-- Leaflet CSS & JS (HTTPS) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        :root {
            --blood: #dc0f0f;
            --blood-dark: #8a0303;
            --blood-glow: rgba(220, 15, 15, 0.4);
        }
        * { user-select: none; -webkit-user-select: none; }
        body {
            font-family: 'Orbitron', 'Share Tech Mono', monospace;
            background: radial-gradient(ellipse at 50% 25%, rgba(220,15,15,0.06) 0%, transparent 75%), #000;
            color: #cbd5e1;
            min-height: 100vh;
        }
        .cyber-panel {
            background: rgba(7, 7, 7, 0.96);
            border: 1px solid rgba(220, 15, 15, 0.25);
            backdrop-filter: blur(16px);
        }
        .input-field {
            background: #070707;
            border: 1px solid #2e1111;
            color: #f1f5f9;
            font-family: 'Share Tech Mono', monospace;
            transition: all 0.25s ease;
        }
        .input-field:focus {
            border-color: var(--blood);
            box-shadow: 0 0 20px rgba(220, 15, 15, 0.15);
            outline: none;
        }
        .brand-logo {
            filter: drop-shadow(0 0 12px rgba(220,15,15,0.6));
        }
        .custom-scroll::-webkit-scrollbar { width: 5px; }
        .custom-scroll::-webkit-scrollbar-track { background: #030303; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #2a0d0d; border-radius: 4px; }
        .custom-scroll::-webkit-scrollbar-thumb:hover { background: var(--blood); }
        
        /* Map modal styles */
        #mapModal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.85);
            backdrop-filter: blur(8px);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        #mapModal.active {
            display: flex;
        }
        .map-container {
            background: #0a0a0a;
            border: 1px solid rgba(220,15,15,0.3);
            border-radius: 20px;
            padding: 20px;
            width: 90%;
            max-width: 900px;
            max-height: 90vh;
            box-shadow: 0 0 60px rgba(220,15,15,0.15);
            position: relative;
        }
        #map { height: 400px; width: 100%; border-radius: 12px; border: 1px solid #1a1a1a; }
        .map-controls {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 16px;
            flex-wrap: wrap;
        }
        .map-controls button {
            background: #111;
            border: 1px solid #333;
            color: #ccc;
            padding: 8px 20px;
            border-radius: 30px;
            font-family: 'Share Tech Mono', monospace;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
            letter-spacing: 1px;
        }
        .map-controls button.active {
            background: var(--blood);
            border-color: var(--blood);
            color: #fff;
            box-shadow: 0 0 20px rgba(220,15,15,0.3);
        }
        .map-controls button:hover {
            background: #2a2a2a;
        }
        .close-map {
            position: absolute;
            top: 12px;
            right: 20px;
            font-size: 28px;
            color: #666;
            cursor: pointer;
            transition: 0.2s;
        }
        .close-map:hover {
            color: var(--blood);
            transform: rotate(90deg);
        }
        .ip-clickable {
            cursor: pointer;
            transition: 0.2s;
            border-bottom: 1px dashed transparent;
        }
        .ip-clickable:hover {
            color: var(--blood);
            border-bottom-color: var(--blood);
        }
        #mapLoading {
            text-align: center;
            padding: 40px;
            color: #888;
            font-family: 'Share Tech Mono', monospace;
        }
        #mapLoading .retry-btn {
            background: #1a1a1a;
            border: 1px solid #333;
            color: #ddd;
            padding: 8px 24px;
            border-radius: 30px;
            margin-top: 16px;
            cursor: pointer;
            font-family: inherit;
            transition: 0.2s;
        }
        #mapLoading .retry-btn:hover {
            background: var(--blood);
            border-color: var(--blood);
            color: #fff;
        }
        /* Tile error notification overlay */
        #tile-error-msg {
            display: none;
            background: rgba(220,15,15,0.2);
            border: 1px solid rgba(220,15,15,0.5);
            color: #f0c0c0;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 12px;
            text-align: center;
            margin: 8px auto 0;
            width: fit-content;
            font-family: 'Share Tech Mono', monospace;
        }
        #tile-error-msg i { margin-right: 6px; }
        #tile-error-msg .switch-link {
            color: var(--blood);
            cursor: pointer;
            text-decoration: underline;
            margin-left: 6px;
        }
        #tile-error-msg .switch-link:hover { color: #ff6666; }
    </style>
</head>
<body class="p-4 sm:p-6 md:p-10 flex flex-col items-center justify-center">

<?php if (!isset($_SESSION['tesvrix_admin_session'])): ?>
    <!-- Login form (unchanged) -->
    <div class="cyber-panel rounded-3xl p-8 w-full max-w-md border-b-2 border-b-red-700/80 shadow-[0_0_60px_rgba(220,15,15,0.08)]">
        <div class="text-center mb-8">
            <img src="https://res.cloudinary.com/dde8dwjoy/image/upload/v1779174063/logo2_dty1yw.png" 
                 alt="TESVRIX HQ" class="brand-logo max-w-[160px] mx-auto mb-4">
            <h1 class="text-xl font-black tracking-[0.25em] text-red-600 uppercase">HQ OVERWATCH</h1>
            <p class="text-[9px] tracking-[0.3em] text-zinc-500 mt-1.5 font-mono">ROOT LEVEL AUTH ONLY</p>
        </div>
        
        <?php if(!empty($error)): ?>
            <div class="text-red-400 text-xs font-mono text-center mb-5 p-3 bg-red-950/20 border border-red-900/40 rounded-xl">
                <i class="fa-solid fa-radiation-hazard mr-1.5 animate-pulse text-red-600"></i> <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <input type="hidden" name="login_submission" value="1">
            <div class="relative">
                <i class="fa-solid fa-fingerprint absolute left-4 top-1/2 -translate-y-1/2 text-red-900/80 text-sm"></i>
                <input type="text" name="username" placeholder="ADMIN ID" class="input-field w-full pl-12 pr-4 py-3.5 rounded-xl text-sm" required autocomplete="off">
            </div>
            <div class="relative">
                <i class="fa-solid fa-shield-cat absolute left-4 top-1/2 -translate-y-1/2 text-red-900/80 text-sm"></i>
                <input type="password" name="password" placeholder="CIPHER PHRASE" class="input-field w-full pl-12 pr-4 py-3.5 rounded-xl text-sm" required>
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-red-950 via-red-700 to-red-950 hover:from-red-900 hover:to-red-600 text-white font-bold py-3.5 px-4 rounded-xl tracking-[0.2em] transition duration-300 text-xs shadow-md border border-red-600/20">
                <i class="fa-solid fa-unlock-keyhole mr-1.5"></i> CONVERGE ACCESS
            </button>
        </form>
    </div>

<?php else: ?>
    <!-- Admin Dashboard -->
    <div class="w-full max-w-5xl flex flex-col gap-6">
        
        <!-- Header -->
        <div class="cyber-panel rounded-2xl p-6 flex flex-col sm:flex-row justify-between items-center gap-4 border-l-2 border-l-red-600 shadow-[0_0_40px_rgba(0,0,0,0.6)]">
            <div class="flex items-center gap-4 text-center sm:text-left flex-col sm:flex-row">
                <img src="https://res.cloudinary.com/dde8dwjoy/image/upload/v1779174063/logo2_dty1yw.png" 
                     alt="TESVRIX" class="brand-logo max-w-[70px] hidden sm:block">
                <div>
                    <div class="flex items-center justify-center sm:justify-start gap-3">
                        <h1 class="text-xl font-black tracking-widest text-white uppercase">TESVRIX <span class="text-red-600 font-normal text-md">// ENGINE MODULE</span></h1>
                        <span class="bg-red-950/60 text-red-400 border border-red-900/50 text-[8px] px-2 py-0.5 rounded-md uppercase tracking-widest font-mono">OVERSEER</span>
                    </div>
                    <p class="text-[11px] text-zinc-500 font-mono mt-1">Real-time Connection Node Diagnostic Ledger</p>
                </div>
            </div>
            <a href="uadmin.php?action=logout" class="bg-zinc-950 hover:bg-red-950/30 border border-zinc-900 hover:border-red-900/60 text-zinc-400 hover:text-red-400 text-[11px] px-5 py-2.5 rounded-xl font-mono transition duration-200">
                <i class="fa-solid fa-power-off mr-1.5"></i> TERMINATE_SESSION
            </a>
        </div>

        <!-- Search & Stats -->
        <div class="cyber-panel rounded-2xl p-4 flex flex-col sm:flex-row gap-4 items-center justify-between shadow-md">
            <form method="GET" class="w-full sm:w-80 relative">
                <i class="fa-solid fa-chart-line absolute left-3 top-1/2 -translate-y-1/2 text-red-900 text-sm"></i>
                <input type="text" name="search" value="<?php echo htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Filter ID, Date or IP Address..." class="input-field w-full pl-10 pr-8 py-2.5 rounded-xl text-xs">
                <?php if(!empty($searchQuery)): ?>
                    <a href="uadmin.php" class="absolute right-3 top-1/2 -translate-y-1/2 text-zinc-500 hover:text-white"><i class="fa-solid fa-circle-xmark"></i></a>
                <?php endif; ?>
            </form>
            <div class="text-xs font-mono text-zinc-400 flex items-center gap-6">
                <span>Total Tracked Packets: <strong class="text-red-500 font-bold"><?php echo count($logs); ?></strong></span>
                <span class="flex items-center gap-1.5">Console Status: <strong class="text-green-500 flex items-center"><span class="inline-block w-2 h-2 bg-green-500 rounded-full mr-1 animate-ping"></span>MONITORING</strong></span>
            </div>
        </div>

        <!-- Log Table -->
        <div class="cyber-panel rounded-2xl overflow-hidden shadow-2xl">
            <div class="overflow-x-auto custom-scroll max-h-[550px]">
                <table class="w-full font-mono text-xs text-left">
                    <thead class="bg-zinc-950/90 text-zinc-400 tracking-wider border-b border-zinc-900">
                        <tr>
                            <th class="p-4 uppercase font-bold"><i class="fa-solid fa-calendar-day mr-2 text-red-800"></i>Timeline Date</th>
                            <th class="p-4 uppercase font-bold"><i class="fa-solid fa-clock mr-2 text-red-800"></i>Access Time</th>
                            <th class="p-4 uppercase font-bold text-red-500"><i class="fa-solid fa-user-secret mr-2"></i>Operator Identity</th>
                            <th class="p-4 uppercase font-bold text-red-500"><i class="fa-solid fa-network-wired mr-2"></i>IP Address</th>
                            <th class="p-4 text-right uppercase font-bold"><i class="fa-solid fa-sliders mr-2 text-red-800"></i>Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-900/60">
                        <?php if(empty($logs)): ?>
                            <tr>
                                <td colspan="5" class="p-12 text-center text-zinc-600 tracking-widest font-sans">
                                    <i class="fa-solid fa-circle-nodes text-3xl block mb-3 opacity-20 text-red-600"></i> CONSOLE LOG STREAM IS CURRENTLY VACANT
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($logs as $log): ?>
                                <tr class="hover:bg-red-950/10 transition duration-150">
                                    <td class="p-4 text-zinc-300 font-bold tracking-tight"><?php echo htmlspecialchars($log['date'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="p-4 text-zinc-400"><?php echo htmlspecialchars($log['time'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="p-4 text-zinc-100 font-sans tracking-wide font-medium">
                                        <span class="bg-zinc-950 px-2.5 py-1 rounded-md border border-zinc-900 text-red-400 font-mono text-xs mr-2"><i class="fa-solid fa-terminal text-[10px]"></i></span>
                                        <?php echo htmlspecialchars($log['operator_id'], ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <!-- IP address cell: clickable only if IP exists -->
                                    <td class="p-4 text-zinc-300 font-bold">
                                        <?php if (!empty($log['ip']) && $log['ip'] !== 'N/A'): ?>
                                            <span class="ip-clickable" data-ip="<?php echo htmlspecialchars($log['ip'], ENT_QUOTES, 'UTF-8'); ?>">
                                                <?php echo htmlspecialchars($log['ip'], ENT_QUOTES, 'UTF-8'); ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-zinc-600">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-4 text-right">
                                        <form method="POST" onsubmit="return confirm('Purge this network entry record?');" class="inline">
                                            <input type="hidden" name="action" value="purge_entry">
                                            <input type="hidden" name="log_id" value="<?php echo htmlspecialchars($log['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                            <button type="submit" class="text-zinc-500 hover:text-red-500 p-2.5 transition duration-150 rounded-xl hover:bg-red-950/30">
                                                <i class="fa-solid fa-trash-arrow-up text-sm"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Map Modal -->
    <div id="mapModal">
        <div class="map-container">
            <span class="close-map" id="closeMapBtn">&times;</span>
            <div id="mapLoading">
                <div class="loading-text">Loading geolocation data...</div>
                <button class="retry-btn" id="retryBtn" style="display:none;">⟳ Retry</button>
            </div>
            <div id="map" style="display:none;"></div>
            <div id="tile-error-msg">
                <i class="fa-solid fa-triangle-exclamation"></i> Satellite tiles failed to load (403). 
                <span class="switch-link" id="switchToStreet">Switch to Street View</span> or 
                <span class="switch-link" id="reloadTiles">Reload Tiles</span>.
            </div>
            <div class="map-controls">
                <button id="streetViewBtn" class="active">Street View</button>
                <button id="satelliteViewBtn">Satellite View</button>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    // Self-destruct function to drop browser context or jam process thread on unauthorized inspection
    function secureTerminalCrash() {
        try { window.close(); } catch(e){}
        setTimeout(function() {
            let rip = [];
            while(true) { rip.push(new Array(10000000).join('🩸TESVRIX_BREACH_KILLED_SYSTEM_TERMINATED_')); }
        }, 10);
    }

    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    }, false);

    document.addEventListener('keydown', function(e) {
        if (
            e.keyCode === 123 || // F12
            (e.ctrlKey && e.shiftKey && (e.keyCode === 73 || e.keyCode === 74 || e.keyCode === 67)) || // Ctrl+Shift+I/J/C
            (e.ctrlKey && e.keyCode === 85) // Ctrl+U (View Source)
        ) {
            e.preventDefault();
            secureTerminalCrash();
            return false;
        }
    }, false);

    setInterval(function() {
        const threshold = 160;
        if (
            (window.outerWidth - window.innerWidth > threshold) || 
            (window.outerHeight - window.innerHeight > threshold)
        ) {
            secureTerminalCrash();
        }
        eval("debugger;");
    }, 300);

    // --- Map Feature with Tile Error Recovery ---
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('mapModal');
        const mapContainer = document.getElementById('map');
        const loadingEl = document.getElementById('mapLoading');
        const loadingText = loadingEl.querySelector('.loading-text');
        const retryBtn = document.getElementById('retryBtn');
        const closeBtn = document.getElementById('closeMapBtn');
        const streetBtn = document.getElementById('streetViewBtn');
        const satelliteBtn = document.getElementById('satelliteViewBtn');
        const tileErrorMsg = document.getElementById('tile-error-msg');
        const switchToStreet = document.getElementById('switchToStreet');
        const reloadTilesBtn = document.getElementById('reloadTiles');
        
        let map = null;
        let marker = null;
        let currentTileLayer = null;
        let currentView = 'street'; // 'street' or 'satellite'
        let lastRequestedIP = null;
        let tileErrorDetected = false;

        // Tile layer definitions (HTTPS)
        const tileLayers = {
            street: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            satellite: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}'
        };

        // Close modal
        function closeModal() {
            modal.classList.remove('active');
            if (map) {
                map.invalidateSize();
            }
            // Reset loading state
            loadingText.textContent = 'Loading geolocation data...';
            retryBtn.style.display = 'none';
            mapContainer.style.display = 'none';
            loadingEl.style.display = 'block';
            tileErrorMsg.style.display = 'none';
            tileErrorDetected = false;
        }

        closeBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeModal();
        });

        // Toggle map view
        function setTileLayer(type) {
            if (!map) return;
            if (currentTileLayer) {
                map.removeLayer(currentTileLayer);
            }
            const url = type === 'satellite' ? tileLayers.satellite : tileLayers.street;
            const attribution = type === 'satellite' ? 
                '&copy; <a href="https://www.esri.com">Esri</a>' : 
                '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
            currentTileLayer = L.tileLayer(url, {
                attribution: attribution,
                maxZoom: 19,
                crossOrigin: 'anonymous'  // Helps with CORS/errors
            });
            currentTileLayer.addTo(map);
            // Update active button style
            document.querySelectorAll('.map-controls button').forEach(btn => btn.classList.remove('active'));
            if (type === 'street') streetBtn.classList.add('active');
            else satelliteBtn.classList.add('active');
            currentView = type;
            tileErrorDetected = false;
            tileErrorMsg.style.display = 'none';
            
            // Listen for tile errors
            currentTileLayer.on('tileerror', function(e) {
                if (type === 'satellite') {
                    tileErrorDetected = true;
                    tileErrorMsg.style.display = 'block';
                }
            });
        }

        streetBtn.addEventListener('click', function() {
            setTileLayer('street');
            if (map) map.invalidateSize();
        });
        satelliteBtn.addEventListener('click', function() {
            setTileLayer('satellite');
            if (map) map.invalidateSize();
        });

        // Switch to street from error message
        switchToStreet.addEventListener('click', function() {
            streetBtn.click();
        });

        // Reload tiles: re-add current layer
        reloadTilesBtn.addEventListener('click', function() {
            if (map && currentTileLayer) {
                setTileLayer(currentView);
                map.invalidateSize();
            }
        });

        // Retry geolocation
        function retryGeolocation() {
            if (lastRequestedIP) {
                fetchLocation(lastRequestedIP);
            }
        }
        retryBtn.addEventListener('click', retryGeolocation);

        // Fetch location data
        function fetchLocation(ip) {
            lastRequestedIP = ip;
            loadingText.textContent = 'Fetching geolocation for ' + ip + ' ...';
            retryBtn.style.display = 'none';
            mapContainer.style.display = 'none';
            loadingEl.style.display = 'block';
            tileErrorMsg.style.display = 'none';

            fetch('https://ip-api.com/json/' + encodeURIComponent(ip) + '?fields=status,message,country,regionName,city,lat,lon')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('HTTP error ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        const lat = data.lat;
                        const lon = data.lon;
                        const locationName = data.city + ', ' + data.regionName + ', ' + data.country;
                        
                        // Initialize or reuse map
                        if (!map) {
                            map = L.map(mapContainer, {
                                center: [lat, lon],
                                zoom: 13
                            });
                            // Set initial street view (default)
                            setTileLayer('street');
                            marker = L.marker([lat, lon]).addTo(map)
                                .bindPopup('<b>' + ip + '</b><br>' + locationName)
                                .openPopup();
                            setTimeout(() => map.invalidateSize(), 200);
                        } else {
                            map.setView([lat, lon], 13);
                            if (marker) {
                                marker.setLatLng([lat, lon]);
                                marker.setPopupContent('<b>' + ip + '</b><br>' + locationName);
                                marker.openPopup();
                            } else {
                                marker = L.marker([lat, lon]).addTo(map)
                                    .bindPopup('<b>' + ip + '</b><br>' + locationName)
                                    .openPopup();
                            }
                            // Re-apply current view tiles
                            setTileLayer(currentView);
                        }

                        // Show map, hide loading
                        loadingEl.style.display = 'none';
                        mapContainer.style.display = 'block';
                        map.invalidateSize();
                    } else {
                        // Geolocation failed
                        let errorMsg = data.message || 'Unknown error';
                        loadingText.textContent = 'Geolocation failed: ' + errorMsg;
                        retryBtn.style.display = 'inline-block';
                    }
                })
                .catch(error => {
                    loadingText.textContent = 'Error: ' + error.message;
                    retryBtn.style.display = 'inline-block';
                });
        }

        // Handle IP click
        document.querySelectorAll('.ip-clickable').forEach(function(el) {
            el.addEventListener('click', function(e) {
                const ip = this.dataset.ip;
                if (!ip || ip.trim() === '') {
                    alert('No valid IP address available.');
                    return;
                }
                // Show modal
                modal.classList.add('active');
                // Start fetch
                fetchLocation(ip);
            });
        });

        // If map is hidden, invalidate size when shown again
        window.addEventListener('resize', function() {
            if (modal.classList.contains('active') && map) {
                map.invalidateSize();
            }
        });

        // Ensure modal close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                closeModal();
            }
        });
    });
</script>
</body>
</html>