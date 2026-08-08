<?php
/**
 * TESVRIX SECURE GATEWAY
 * STRICTLY SERVER-SIDE GENERATED
 */
header("Content-Type: application/javascript");

// SECURITY: Only your Render Proxy URL and a Website-Specific Token
$proxy_url = 'render url';
$web_token = 'app token';

?>

(function() {
    'use strict';

    // Set globals for index.php compatibility (Fixed Slashes)
    window.SB_URL = '<?php echo rtrim($proxy_url, "/"); ?>/rest/v1/';
    window.SB_KEY = 'PROXY_MODE';

    window.PROXY_URL = '<?php echo rtrim($proxy_url, "/"); ?>';
    window.PROXY_TOKEN = '<?php echo $web_token; ?>';

    window.getApiUrl = function(path) {
        var base = window.PROXY_URL;
        var cleanPath = path.replace(/^\/+/, '');

        // Ensure path starts with rest/v1/ and avoids double slashes
        if (cleanPath.indexOf('rest/v1/') !== 0) {
            cleanPath = 'rest/v1/' + cleanPath;
        }
        return base + '/' + cleanPath;
    };

    window.getApiHeaders = function(contentType = 'application/json') {
        const auth = JSON.parse(localStorage.getItem('user') || '{}');
        var h = {
            'x-access-token': window.PROXY_TOKEN,
            'x-operator-id': auth.telegram_channel_id || auth.operator_id || ''
        };
        if (contentType) h['Content-Type'] = contentType;
        return h;
    };

    window.getDownloadUrl = function(id, name) {
        var base = window.PROXY_URL;
        return base + '/download?id=' + id + '&name=' + encodeURIComponent(name) + '&token=' + encodeURIComponent(window.PROXY_TOKEN);
    };

    console.log("TESVRIX: Secure Bridge Active.");
})();

