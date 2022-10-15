{"version":3,"sources":["status.bundle.js"],"names":["exports","ui_vue","pull_client","Vue","component","props","canReconnect","default","data","status","PullClient","PullStatus","Online","showed","created","_this","this","isMac","navigator","userAgent","toLowerCase","includes","setStatusTimeout","hideTimeout","pullUnSubscribe","$root","$bitrixPullClient","subscribe","$on","BX","PULL","window","beforeDestroy","methods","client","_this2","type","SubscriptionType","Status","callback","event","statusChange","reconnect","$emit","location","reload","_this3","clearTimeout","validStatus","Offline","Connecting","indexOf","timeout","setTimeout","isMobile","watch","_this4","computed","connectionClass","result","connectionText","localize","BX_PULL_STATUS_ONLINE","BX_PULL_STATUS_OFFLINE","BX_PULL_STATUS_CONNECTING","button","hotkey","name","BX_PULL_STATUS_BUTTON_RECONNECT","BX_PULL_STATUS_BUTTON_RELOAD","title","key","getFilteredPhrases","$bitrixMessages","template"],"mappings":"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","file":"status.bundle.map.js"}