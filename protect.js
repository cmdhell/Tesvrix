
(function() {
    'use strict';

    
    const path = window.location.pathname;
    const isLoginPage = path.includes('index.php') || path.endsWith('/');

    if (!isLoginPage && !localStorage.getItem('user')) {
        // Force hide everything
        document.documentElement.style.display = 'none';

        // Find correct root path to index.php
        let loginUrl = 'index.php';
        if (path.includes('/sections/')) {
            loginUrl = '../index.php';
        }

        // Redirect the top-level window to avoid 404
        if (window.top !== window.self) {
            window.top.location.href = loginUrl;
        } else {
            window.location.replace(loginUrl);
        }
        return;
    }

   
    const _0x1a2b = ['debugger', 'constructor', 'setInterval', 'addEventListener', 'contextmenu', 'preventDefault', 'keydown', 'keyCode', 'ctrlKey', 'shiftKey', 'clear', 'log', 'warn', 'error', 'info', 'debug', 'href', 'about:blank', 'location', 'top', 'self', 'includes', 'sections/'];
    const _0x1234 = (i) => _0x1a2b[i];

    
    setInterval(function() {
        (function() { return false; }[_0x1234(1)](_0x1234(0))());
    }, 200);

    
    document[_0x1234(3)](_0x1234(4), e => e[_0x1234(5)]());

    document[_0x1234(6)] = function(e) {
        if (e[_0x1234(7)] == 123 || (e[_0x1234(8)] && e[_0x1234(9)])) return false;
        if (e[_0x1234(8)] && (e[_0x1234(7)] == 85 || e[_0x1234(7)] == 83)) return false;
    };

   
    const _noop = () => {};
    console[_0x1234(11)] = console[_0x1234(12)] = console[_0x1234(13)] = console[_0x1234(14)] = console[_0x1234(15)] = console[_0x1234(10)] = _noop;

    
    if (window[_0x1234(19)] !== window[_0x1234(20)] && !window[_0x1234(18)][_0x1234(21)](_0x1234(22))) {
        
    } else if (window[_0x1234(19)] !== window[_0x1234(20)]) {
         
    }
})();
