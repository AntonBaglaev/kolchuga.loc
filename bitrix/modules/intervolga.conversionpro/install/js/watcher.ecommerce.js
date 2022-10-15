(function () {

  "use strict";


  /**
   * Проверка среды исполнения модуля
   */
  if (!window.BX || !window.BX.ajax) {

    throw new Error('BX.ajax not loaded');

  }

  function DetailWatcher(currency, containerName, debug) {
    this._currency = currency;
    if (typeof this._currency !== 'string' || 0 === this._currency.length) {
      throw new Error('Wrong base currency');
    }

    this._containerName = containerName;
    if (typeof this._containerName !== 'string' || 0 === this._containerName.length) {
      throw new Error('Wrong data layer name');
    }

    this._debug = debug;

    this._sent = [];
    this._inProgress = false;

    window['conversionpro_products'] = window['conversionpro_products'] || {};
    window['conversionpro_detail'] = window['conversionpro_detail'] || [];
  }

  DetailWatcher.prototype.check = function () {
    if (!this._inProgress) {
      this._inProgress = true;
      this._debug('Product detail --> started check');
    } else {
      this._debug('Product detail <-- blocked');
      return;
    }


    this._debug('Product detail --- check list');
    for (var i = 0; i < window['conversionpro_detail'].length; i++) {
      var id = window['conversionpro_detail'][i],
        product = window['conversionpro_products'][id];

      if (this._sent.indexOf(id) !== -1) {
        this._debug('Product detail --- product ' + id + ' was processed earlier');
        continue;
      }

      if (product) {
        this._debug('Product detail --- product ' + id + ' found');
        this._debug(product);
      } else {
        this._debug('Product detail --- product ' + id + ' not found');
      }

      var action = {
        event: 'ivcp.detail_viewed',
        ecommerce: {
          currencyCode: this._currency,
          detail: {
            products: [product]
          }
        }
      };

      try {
        window[this._containerName].push(action);
        this._sent.push(id);
        this._debug('Product detail --- event was sent');
      } catch (e) {
        this._debug('Product detail --- error while sending ' + e.message);
      }
    }


    this._debug('Product detail --- clean list');
    for (var j = 0; j < this._sent.length; j++) {
      var k = window['conversionpro_detail'].indexOf(this._sent[j]);
      if (-1 === k) {
        continue;
      }

      window['conversionpro_detail'].splice(k, 1);
    }

    this._debug('Product detail <-- finished check');

    this._inProgress = false;
  };


  /**
   * Спусковой механизм
   */
  BX.addCustomEvent('onConversionProReady', function (config, debug) {
    debug('EC --> started settings check');

    var metrikaId = parseInt(config['metrika_id']);
    if (metrikaId > 0 && window['yaCounter' + metrikaId]) {
      if (!window['yaCounter' + metrikaId]._ecommerce) {
        debug('EC --- option "ecommerce" not enabled in Yandex.Metrika counter ' + metrikaId);
      } else {
        debug('EC --- option "ecommerce" enabled in Yandex.Metrika counter ' + metrikaId);
      }

      if (window['yaCounter' + metrikaId]._ecommerce !== config['container_name']) {
        debug('EC --- incorrect data layer name in Yandex.Metrika counter ' + metrikaId);
      } else {
        debug('EC --- correct data layer name in Yandex.Metrika counter ' + metrikaId);
      }

    } else {
      debug('EC --- Yandex.Metrika counter not found or not specified in settings');
    }

    var analyticsId = config['analytics_id'];
    if (analyticsId && analyticsId.length > 0 && window.ga && window.ga.getAll) {
      var trackers = ga.getAll(),
        tracker = null;

      for (var i = 0; i < trackers.length; i++) {
        if (trackers[i].get('trackingId') !== analyticsId) {
          continue;
        }
        tracker = trackers[i];
      }

      if (!tracker) {
        debug('EC --- Universal Analytics counter not found');
      } else {
        debug('EC --- loading "ec" module for Universal Analytics');
        ga('require', 'ec');
      }
    } else {
      debug('EC --- Universal Analytics counter not found or not specified in settings');
    }

    debug('EC <-- finished settings check');


    var detail = new DetailWatcher(config['base_currency'], config['container_name'], debug);
    detail.check();

    BX.addCustomEvent('onConversionProDetailShown', function () {
      detail.check();
    });
    
  });


})();
