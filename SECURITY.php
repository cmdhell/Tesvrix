<!DOCTYPE html>
<html lang="en">
<head>
    <script src="../protect.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>TESVRIX · THREAT INTELLIGENCE</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&family=Inter:opsz,wght@14..32,400;14..32,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary: #e11d48;
            --primary-glow: rgba(225, 29, 72, 0.45);
            --bg-deep: #020617;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
        }

        body {
            background: radial-gradient(ellipse at 30% 20%, #0a0f1f, var(--bg-deep));
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Scanline overlay */
        body::after {
            content: "";
            position: fixed;
            inset: 0;
            background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.08) 50%);
            background-size: 100% 3px;
            pointer-events: none;
            z-index: 100;
        }

        /* Floating hex grid background */
        .hex-grid {
            position: fixed;
            inset: 0;
            background-image:
                radial-gradient(circle at 50% 50%, rgba(225,29,72,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
            animation: grid-drift 30s linear infinite;
        }

        @keyframes grid-drift {
            0% { background-position: 0 0; }
            100% { background-position: 40px 40px; }
        }

        .coming-card {
            text-align: center;
            position: relative;
            z-index: 10;
            padding: 40px 30px;
            max-width: 800px;
            width: 100%;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(12px);
            border-radius: 32px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            margin: 20px;
            overflow-y: auto;
            max-height: 90vh;
        }

        /* Animated lock icon */
        .lock-container {
            width: 80px;
            height: 80px;
            margin: 0 auto 25px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lock-ring {
            position: absolute;
            inset: -10px;
            border-radius: 50%;
            border: 2px solid rgba(225,29,72,0.15);
            animation: ring-pulse 3s ease-in-out infinite;
        }

        .lock-ring:nth-child(2) {
            inset: -20px;
            border-color: rgba(225,29,72,0.08);
            animation-delay: 0.5s;
        }

        @keyframes ring-pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.08); opacity: 0.5; }
        }

        .lock-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: rgba(225,29,72,0.08);
            border: 2px solid rgba(225,29,72,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: var(--primary);
            filter: drop-shadow(0 0 15px var(--primary-glow));
        }

        .title {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: 4px;
            background: linear-gradient(135deg, #fff 30%, var(--primary) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .subtitle {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.8rem;
            color: var(--text-secondary);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 30px;
        }

        /* Threat Report Styles */
        .threat-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
            text-align: left;
        }

        .info-item {
            background: rgba(0, 0, 0, 0.3);
            padding: 15px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .info-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: 1.2px;
            margin-bottom: 6px;
            display: block;
        }

        .info-value {
            font-size: 0.9rem;
            font-weight: 600;
            color: #fff;
            word-break: break-all;
        }

        /* Analysis Table */
        .analysis-container {
            text-align: left;
            margin-top: 20px;
        }

        .analysis-header {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 2px;
            color: var(--text-secondary);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .analysis-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8rem;
        }

        .analysis-row {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: background 0.2s;
        }

        .analysis-row:hover {
            background: rgba(225, 29, 72, 0.05);
        }

        .analysis-cell {
            padding: 12px 10px;
        }

        .vendor-name {
            font-weight: 700;
            color: var(--text-secondary);
            width: 40%;
        }

        .detection-label {
            font-family: monospace;
            color: #ef4444;
            font-weight: 600;
        }

        .undetected {
            color: #10b981;
            opacity: 0.8;
        }

        .btn-automate {
            margin-top: 35px;
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 14px 28px;
            border-radius: 14px;
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 800;
            font-size: 0.75rem;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            box-shadow: 0 10px 20px var(--primary-glow);
        }

        .btn-automate:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px var(--primary-glow);
            filter: brightness(1.1);
        }

        /* MOBILE RESPONSIVE */
        @media (max-width: 992px) {
            body { padding: 20px; height: auto; min-height: 100vh; }
            .coming-card { padding: 30px 20px; }
            .title { font-size: 1.2rem; letter-spacing: 3px; }
            .lock-container { width: 60px; height: 60px; }
            .lock-icon { width: 50px; height: 50px; font-size: 1.4rem; }
            .threat-info-grid { grid-template-columns: 1fr; }
            .vendor-name { width: 45%; }
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
    <div class="hex-grid"></div>

    <div class="coming-card">
        <div class="lock-container">
            <div class="lock-ring"></div>
            <div class="lock-ring"></div>
            <div class="lock-icon">
                <i class="fas fa-shield-virus"></i>
            </div>
        </div>

        <h1 class="title">THREAT INTELLIGENCE</h1>
        <p class="subtitle">Detailed Security Analysis Report</p>

        <div class="threat-info-grid">
            <div class="info-item">
                <span class="info-label">Popular Threat Label</span>
                <div class="info-value">trojan.aazx/smssend</div>
            </div>
            <div class="info-item">
                <span class="info-label">Threat Categories</span>
                <div class="info-value">trojan, banker, pua</div>
            </div>
            <div class="info-item">
                <span class="info-label">Family Labels</span>
                <div class="info-value">aazx, smssend</div>
            </div>
        </div>

        <div class="analysis-container">
            <div class="analysis-header">
                <i class="fas fa-microscope"></i> VENDOR ANALYSIS
            </div>
            <table class="analysis-table">
                <tr class="analysis-row">
                    <td class="analysis-cell vendor-name">BitDefenderFalx</td>
                    <td class="analysis-cell detection-label">Android.Riskware.SMSSend.aAZX</td>
                </tr>
                <tr class="analysis-row">
                    <td class="analysis-cell vendor-name">ESET-NOD32</td>
                    <td class="analysis-cell detection-label">Android/Spy.Agent.GEI Trojan</td>
                </tr>
                <tr class="analysis-row">
                    <td class="analysis-cell vendor-name">Kaspersky</td>
                    <td class="analysis-cell detection-label">HEUR:Trojan-Banker.AndroidOS.Agent.tp</td>
                </tr>
                <tr class="analysis-row">
                    <td class="analysis-cell vendor-name">Acronis (Static ML)</td>
                    <td class="analysis-cell detection-label undetected">Undetected</td>
                </tr>
                <tr class="analysis-row">
                    <td class="analysis-cell vendor-name">AhnLab-V3</td>
                    <td class="analysis-cell detection-label undetected">Undetected</td>
                </tr>
                <tr class="analysis-row">
                    <td class="analysis-cell vendor-name">Alibaba</td>
                    <td class="analysis-cell detection-label undetected">Undetected</td>
                </tr>
                <tr class="analysis-row">
                    <td class="analysis-cell vendor-name">ALYac</td>
                    <td class="analysis-cell detection-label">Und. ya detack na kra'</td>
                </tr>
            </table>
        </div>

        <button class="btn-automate" onclick="window.parent.showToast('Automated check initiated', 'success')">
            <i class="fas fa-robot"></i> Automate checks
        </button>
    </div>
</body>
</html>
