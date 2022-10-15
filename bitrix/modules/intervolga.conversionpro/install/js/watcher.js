(function () {

  'use strict';


  /**
   * Полифил для поддержки метода Array.indexOf из ECMA262-5 в старых IE
   */
  if (!('indexOf' in Array.prototype)) {
    Array.prototype.indexOf = function (find, i /*opt*/) {
      if (i === undefined) i = 0;
      if (i < 0) i += this.length;
      if (i < 0) i = 0;
      for (var n = this.length; i < n; i++)
        if (i in this && this[i] === find)
          return i;
      return -1;
    };
  }


  /**
   * Управление куками
   */
  var Cookies = {
    _prefix: '',
    prefix: function (newPrefix) {

      if (typeof newPrefix === 'string') {
        Cookies._prefix = newPrefix;
      }

      return Cookies._prefix + '_';

    },
    get: function (name) {

      name = Cookies.prefix() + name;

      var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
      ));

      return matches ? decodeURIComponent(matches[1]) : null;

    },
    set: function (name, value, options) {

      name = Cookies.prefix() + name;
      value = encodeURIComponent(value);
      options = options || {};

      var expires = options.expires;

      if (typeof expires === 'number' && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
      }
      if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
      }

      if (!options.path) {
        options.path = '/';
      }

      var updatedCookie = name + "=" + value;
      for (var propName in options) {
        if (!options.hasOwnProperty(propName))
          continue;
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
          updatedCookie += "=" + propValue;
        }
      }
      document.cookie = updatedCookie;

    },
    del: function (name) {
      Cookies.set(name, '', {expires: -1});
    }
  };


  /**
   * Ожидание загрузки Яндекс.Метрики
   */
  function MetrikaWatcher(counterId, debug) {
    this._counterId = parseInt(counterId);
    if (0 >= this._counterId) {
      throw new Error('Wrong Yandex.Metrika counter ID');
    }

    this._debug = (typeof debug === 'function') ? debug : function () {
    };
    this._timer = null;
  }

  MetrikaWatcher.prototype.counterName = function () {
    return 'yaCounter' + this._counterId;
  };
  MetrikaWatcher.prototype.isActive = function () {
    return null !== this._timer;
  };
  MetrikaWatcher.prototype.counterReady = function () {
    var counters = null;

    if (window.Ya && window.Ya.Metrika && window.Ya.Metrika.counters) {
      counters = window.Ya.Metrika.counters();
    }

    if (window.Ya && window.Ya.Metrika2 && window.Ya.Metrika2.counters) {
      counters = window.Ya.Metrika2.counters();
    }

    if (null === counters) {
      return false;
    }

    for (var i = 0; i < counters.length; i++) {
      if (counters[i].id === this._counterId) {
        return true;
      }
    }

    return false;
  };
  MetrikaWatcher.prototype.start = function (onSuccess) {
    if (this.isActive()) {
      return false;
    }

    onSuccess = (typeof onSuccess === 'function') ? onSuccess : function () {
    };

    if (this.counterReady()) {
      this._debug('Yandex.Metrika <-> counter ' + this._counterId + ' loaded');
      onSuccess();

      return false;
    }

    this._debug('Yandex.Metrika --> started waiting for counter ' + this._counterId);

    var ticks = 0;
    var self = this;
    this._timer = setInterval(function () {
      if (!self.counterReady()) {
        ticks += 1;
        if (30 === ticks) {
          self._debug('Yandex.Metrika --- counter ' + self._counterId + ' not loaded after 30 ticks');
          var notReadyPath = '/bitrix/components/intervolga/conversionpro.queue/ajax.php';
          BX.ajax({
            'url': notReadyPath,
            'method': 'POST',
            'dataType': 'html',
            'data': BX.ajax.prepareData({'NOTREADY': 'YM'})
          });
        }

        self._debug('Yandex.Metrika --- counter ' + self._counterId + ' not loaded');
        return;
      }

      self._debug('Yandex.Metrika --- counter ' + self._counterId + ' loaded');

      self.stop();
      onSuccess();

    }, 1000);

    return true;
  };
  MetrikaWatcher.prototype.stop = function () {
    if (!this.isActive()) {
      return false;
    }

    clearInterval(this._timer);
    this._debug('Yandex.Metrika <-- finished waiting for counter ' + this._counterId);

    return true;
  };


  /**
   * Ожидание загрузки Universal Analytics
   */
  function AnalyticsWatcher(counterId, debug) {
    this._counterId = counterId;
    if (typeof this._counterId !== 'string' || 0 === this._counterId.length) {
      throw new Error('Wrong Universal Analytics view ID');
    }

    this._debug = (typeof debug === 'function') ? debug : function () {
    };
    this._timer = null;
  }

  AnalyticsWatcher.prototype.isActive = function () {
    return null !== this._timer;
  };
  AnalyticsWatcher.prototype.counterReady = function () {
    if (!window.ga || !window.ga.getAll) {
      return false;
    }

    var trackers = ga.getAll(),
      tracker = null;

    for (var i = 0; i < trackers.length; i++) {
      if (trackers[i].get('trackingId') !== this._counterId) {
        continue;
      }
      tracker = trackers[i];
    }

    return null !== tracker;
  };
  AnalyticsWatcher.prototype.start = function (onSuccess) {
    if (this.isActive()) {
      return false;
    }

    onSuccess = (typeof onSuccess === 'function') ? onSuccess : function () {
    };

    if (this.counterReady()) {
      this._debug('Universal Analytics <-> counter ' + this._counterId + ' loaded');
      onSuccess();

      return false;
    }

    this._debug('Universal Analytics --> started waiting for counter ' + this._counterId);

    var ticks = 0;
    var self = this;
    this._timer = setInterval(function () {
      if (!self.counterReady()) {
        ticks += 1;
        if (30 === ticks) {
          self._debug('Universal Analytics --- counter ' + self._counterId + ' not loaded after 30 ticks');
          var notReadyPath = '/bitrix/components/intervolga/conversionpro.queue/ajax.php';
          BX.ajax({
            'url': notReadyPath,
            'method': 'POST',
            'dataType': 'html',
            'data': BX.ajax.prepareData({'NOTREADY': 'UA'})
          });
        }

        self._debug('Universal Analytics --- counter ' + self._counterId + ' not loaded');
        return;
      }

      self._debug('Universal Analytics --- counter ' + self._counterId + ' loaded');

      self.stop();
      onSuccess();

    }, 1000);

    return true;
  };
  AnalyticsWatcher.prototype.stop = function () {
    if (!this.isActive()) {
      return false;
    }

    clearInterval(this._timer);
    this._debug('Universal Analytics <-- finished waiting for counter ' + this._counterId);

    return true;
  };


  /**
   * Ожидание готовности модуля к работе
   */
  function ModuleWatcher(readyWhen, metrikaId, analyticsId, debug) {
    this._metrikaReady = false;
    this._analyticsReady = false;

    switch (readyWhen) {
      case 'yg':
        break;

      case 'oy':
        this._analyticsReady = true;
        break;

      case 'og':
        this._metrikaReady = true;
        break;

      case 'dr':
        this._analyticsReady = true;
        this._metrikaReady = true;
        break;

      default:
        throw new Error('Unknown module ready type');
    }

    this._metrikaWatcher = false;
    if (!this._metrikaReady) {
      this._metrikaWatcher = new MetrikaWatcher(metrikaId, debug);
    }

    this._analyticsWatcher = false;
    if (!this._analyticsReady) {
      this._analyticsWatcher = new AnalyticsWatcher(analyticsId, debug);
    }

    this._debug = (typeof debug === 'function') ? debug : function () {
    };
  }

  ModuleWatcher.prototype.isReady = function () {
    return this._metrikaReady && this._analyticsReady;
  };
  ModuleWatcher.prototype.checkReady = function (onSuccess) {
    if (this.isReady()) {
      this._debug('Module <-- ready to work');
      onSuccess();
    } else {
      this._debug('Module --- not ready to work');
    }
  };
  ModuleWatcher.prototype.start = function (onSuccess) {
    this._debug('Module --> started waiting for ready');

    onSuccess = (typeof onSuccess === 'function') ? onSuccess : function () {
    };

    var self = this;
    BX.ready(function () {
      self.checkReady(onSuccess);

      self._metrikaWatcher && self._metrikaWatcher.start(function () {
        self._metrikaReady = true;
        self.checkReady(onSuccess);
      });

      self._analyticsWatcher && self._analyticsWatcher.start(function () {
        self._analyticsReady = true;
        self.checkReady(onSuccess);
      });
    });

    return true;
  };


  /**
   * Работа с очередью событий
   */
  function EventsQueue(containerName, debug) {
    this._containerName = containerName;
    if (typeof this._containerName !== 'string' || 0 === this._containerName.length) {
      throw new Error('Wrong data layer name');
    }

    this._inProgress = false;
    this._queuePath = '/bitrix/components/intervolga/conversionpro.queue/ajax.php';
    this._debug = (typeof debug === 'function') ? debug : function () {
    };
  }

  EventsQueue.prototype.check = function () {
    this._debug('Queue --> check');
    if (!this._inProgress) {
      this._inProgress = true;
    } else {
      this._debug('Queue <-- blocked');
      return;
    }

    if ('Y' !== Cookies.get('IEC_CHK')) {
      this._debug('Queue <-- no events');
      this._inProgress = false;
      return;
    }

    this._debug('Queue --- has events');
    this.load();
  };
  EventsQueue.prototype.load = function () {
    this._debug('Queue --- loading from server');
    var self = this;

    BX.ajax.loadJSON(
      this._queuePath,
      function (data) {

        self._debug('Queue --- loaded from server');
        Cookies.del('IEC_CHK');

        if (Object.prototype.toString.call(data) !== '[object Array]') {
          self._debug('Queue <-- wrong answer format');
          self._inProgress = false;
          return;
        }

        if (0 === data.length) {
          self._debug('Queue <-- empty answer');
          self._inProgress = false;
          return;
        }

        var processed = [];
        for (var i = 0; i < data.length; i++) {
          var event = data[i];

          self._debug(event);

          try {
            window[self._containerName].push(event['DATA']);
            processed.push(event['ID']);
          } catch (e) {
            self._debug('Queue --- error while sending ' + e.message);
          }
        }

        if (processed.length === data.length) {
          debug('Queue --- all events were sent');
        } else if (0 !== processed.length) {
          debug('Queue --- some events were not sent');
        } else {
          debug('Queue <-- no events were sent');
          queue._inProgress = false;
          return;
        }

        setTimeout(function () {
          // Remove with timeout, so events have more chances to be sent from data layer
          self.remove(processed);
        }, 2000);
      },
      function () {
        self._debug('Queue <-- error during loading from server');
        self._inProgress = false;
      }
    );
  };
  EventsQueue.prototype.remove = function (processed) {
    this._debug('Queue --- remove processed events #: ' + processed.join(', '));
    var self = this;

    BX.ajax({
      'url': self._queuePath,
      'method': 'POST',
      'dataType': 'html',
      'data': BX.ajax.prepareData({
        'PROCESSED': processed.join(',')
      }),
      'onsuccess': function () {
        self._debug('Queue <-- processed events were removed');
        self._inProgress = false;
        self.check(); // next portion?
      },
      'onfailure': function () {
        self._debug('Queue <-- error remove processed events');
        self._inProgress = false;
      }
    });
  };
  EventsQueue.prototype.ajaxDaemon = function () {
    var self = this;

    BX.addCustomEvent('onAjaxSuccess', function (data, config) {
      if (config && config.url && config.url.indexOf(self._queuePath) === -1) {
        self._debug('Queue --- found success BX Ajax-request ' + config.url);
        self.check();
      } else if (config && !config.url) {
        self._debug('Queue --- found success BX Ajax-request (no url)');
        self.check();
      }
    });

    if (window.jQuery) {
      jQuery(document).ajaxSuccess(function (e, jqXHR, config) {
        if (config && config.url && config.url.indexOf(self._queuePath) === -1) {
          self._debug('Queue --- found success jQuery Ajax-request ' + config.url);
          self.check();
        } else if (config && !config.url) {
          self._debug('Queue --- found success jQuery Ajax-request (no url)');
          self.check();
        }
      });
    }
  };


  /**
   * Вывод отладочной информации
   */
  var debug = function (message) {

    if (window.location.href.indexOf('conversionpro_debug=Y') >= 0) {
      Cookies.set('IEC_DEBUG', 'Y');
    }

    if (window.location.href.indexOf('conversionpro_debug=N') >= 0) {
      Cookies.del('IEC_DEBUG');
    }

    if (Cookies.get('IEC_DEBUG') === 'Y') {
      console.debug(message);
    }

  };


  /**
   * Проверка среды исполнения модуля
   */
  if (!window.BX || !window.BX.ajax) {
    throw new Error('BX.ajax not loaded');
  }

  if (!window['conversionpro_config'] || typeof window['conversionpro_config'] !== 'object') {
    throw new Error('Configuration for module intervolga.conversionpro not found on page');
  }
  var config = window['conversionpro_config'];

  if (!config['container_name'] || !window[config['container_name']]) {
    throw new Error('Data layer not found on page');
  }

  Cookies.prefix('BITRIX_SM');
  if (BX.message && BX.message('COOKIE_PREFIX') !== null) {
    Cookies.prefix(BX.message('COOKIE_PREFIX'));
  }

  if ('Y' === Cookies.get('IEC_ADM')) {
    debug('You are administrator. Module intervolga.conversionpro will not send any data.');
    return;
  }

  /**
   * DoNotTrack helper
   * @url https://github.com/schalkneethling/dnt-helper/blob/master/js/dnt-helper.js
   *
   * Returns true or false based on whether doNotTack is enabled. It also takes into account the
   * anomalies, such as !bugzilla 887703, which effect versions of Fx 31 and lower. It also handles
   * IE versions on Windows 7, 8 and 8.1, where the DNT implementation does not honor the spec.
   * @see https://bugzilla.mozilla.org/show_bug.cgi?id=1217896 for more details
   * @params {string} [dnt] - An optional mock doNotTrack string to ease unit testing.
   * @params {string} [userAgent] - An optional mock userAgent string to ease unit testing.
   * @returns {boolean} true if enabled else false
   */
  function dntEnabled(dnt, userAgent) {

    'use strict';

    // for old version of IE we need to use the msDoNotTrack property of navigator
    // on newer versions, and newer platforms, this is doNotTrack but, on the window object
    // Safari also exposes the property on the window object.
    var dntStatus = dnt || navigator.doNotTrack || window.doNotTrack || navigator.msDoNotTrack;
    var ua = userAgent || navigator.userAgent;

    // List of Windows versions known to not implement DNT according to the standard.
    var anomalousWinVersions = ['Windows NT 6.1', 'Windows NT 6.2', 'Windows NT 6.3'];

    var fxMatch = ua.match(/Firefox\/(\d+)/);
    var ieRegEx = /MSIE|Trident/i;
    var isIE = ieRegEx.test(ua);
    // Matches from Windows up to the first occurance of ; un-greedily
    // http://www.regexr.com/3c2el
    var platform = ua.match(/Windows.+?(?=;)/g);

    // With old versions of IE, DNT did not exist so we simply return false;
    if (isIE && typeof Array.prototype.indexOf !== 'function') {
      return false;
    } else if (fxMatch && parseInt(fxMatch[1], 10) < 32) {
      // Can't say for sure if it is 1 or 0, due to Fx bug 887703
      dntStatus = 'Unspecified';
    } else if (isIE && platform && anomalousWinVersions.indexOf(platform.toString()) !== -1) {
      // default is on, which does not honor the specification
      dntStatus = 'Unspecified';
    } else {
      // sets dntStatus to Disabled or Enabled based on the value returned by the browser.
      // If dntStatus is undefined, it will be set to Unspecified
      dntStatus = {'0': 'Disabled', '1': 'Enabled'}[dntStatus] || 'Unspecified';
    }

    return dntStatus === 'Enabled' ? true : false;
  }

  if (dntEnabled()) {
    window['conversionpro_config']['ready_when'] = 'dr';
    debug('DoNotTrack acquired, module will process events on document.ready');

    var dntPath = '/bitrix/components/intervolga/conversionpro.queue/ajax.php';
    BX.ajax({
      'url': dntPath,
      'method': 'POST',
      'dataType': 'html',
      'data': BX.ajax.prepareData({'DNT': 'Y'})
    });
  }


  /**
   * Спусковой механизм
   */
  var queue = new EventsQueue(config['container_name'], debug);
  var moduleReady = new ModuleWatcher(config['ready_when'], config['metrika_id'], config['analytics_id'], debug);
  moduleReady.start(function () {
    BX.onCustomEvent('onConversionProReady', [config, debug]);
    queue.check();
    queue.ajaxDaemon();
  });

})();
