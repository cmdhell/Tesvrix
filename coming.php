<!DOCTYPE html>
<html lang="en">
<head>
    <script src="../protect.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Coming Soon</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Orbitron', monospace;
        }
        body {
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .coming-card {
            text-align: center;
            padding: 40px;
        }
        i {
            font-size: 55px;
            color: #dc2626;
            margin-bottom: 20px;
            display: block;
            animation: spin 4s infinite linear;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        h2 {
            color: white;
            font-size: 22px;
            margin-bottom: 10px;
            letter-spacing: 2px;
        }
        p {
            color: #6b7280;
            font-size: 12px;
        }
        @media (max-width: 768px) {
            i { font-size: 40px; }
            h2 { font-size: 18px; }
        }
    
        /* UNIVERSAL MOBILE RESPONSIVE FIX */
        @media (max-width: 992px) {
            body { padding: 10px; height: auto !important; min-height: 100vh; overflow-y: auto !important; }
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
    <div class="coming-card">
        <i class="fas fa-cog fa-spin"></i>
        <h2>COMING SOON</h2>
        <p>This feature is under development</p>
    </div>
</body>
</html>