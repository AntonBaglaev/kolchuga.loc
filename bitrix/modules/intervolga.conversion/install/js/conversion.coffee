# ===================================================================
# ============================= HELPERS =============================
# ===================================================================
# Fix IE support for console
noop = () ->
  return
methods = [
  'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
  'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
  'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
  'timeStamp', 'trace', 'warn'
]
if !@console?
  try
    @console = {}
  catch
for method in methods
  try
    if (!@console[method]?)
      @console[method] = noop;
  catch
#old version - may cause error in firefox v4
#console = @console = @console || {}
#for method in methods
#  if (!console[method]?)
#    console[method] = noop;


# Ready function
bindReady = (handler) ->
  called = false

  ready = () ->
    return if called

    called = true
    handler()

  if document.addEventListener
    document.addEventListener "DOMContentLoaded", () ->
      ready()
    , false
  else if document.attachEvent
    if document.documentElement.doScroll && @ is @top
      tryScroll = () ->
        return if called
        return if !document.body
        try
          document.documentElement.doScroll "left"
          ready()
        catch e
          setTimeout tryScroll, 0
      tryScroll()

    document.attachEvent "onreadystatechange", () ->
      if document.readyState is "complete"
        ready()

  if @addEventListener
    @addEventListener 'load', ready, false
  else if @attachEvent
    @attachEvent 'onload', ready

readyList = []

onReady = (handler) ->
  if !readyList.length
    bindReady () ->
      readyHandler() for readyHandler in readyList
  readyList.push handler


# Helper function to get YaCounter variable
yaCounter = null
getYaCounter = () ->
  if !yaCounter?
    yaTitle = (name for name of @ when name.search('yaCounter') isnt -1)[0]
    if yaTitle?
      console.debug "Ya counter found: " + yaTitle
      yaCounter = @[yaTitle]
    else
      console.debug "Ya counter not found"
      yaCounter = null
  yaCounter


# Helper function to register handler that will be invoked on YaCounter ready
yaCounterHandlers = []
doOnYaCounter = (handler) ->
  yaCounterHandlers.push handler

  if yaC = getYaCounter()
    readyHandler(yaC) for readyHandler in yaCounterHandlers
    yaCounterHandlers = []
  else if @yandex_metrika_callbacks
    console.debug "Not found ready YaCounter, trying to wait it for"
    doOnYaCounterWaitable = () ->
      if yaC = getYaCounter()
        readyHandler(yaC) for readyHandler in yaCounterHandlers
        yaCounterHandlers = []
      else
        setTimeout doOnYaCounterWaitable, 2000
    setTimeout doOnYaCounterWaitable, 2000
  else
    console.debug "Ya counter is not installed"

getBXCookiePrefix = () ->
  (@BX||top.BX)?.message?('COOKIE_PREFIX') || 'BITRIX_SM'

# Helper function to get cookie by name
getCookie = (name) ->
  bxname = getBXCookiePrefix() + '_' + name
  matches = document.cookie.match new RegExp "(?:^|; )" + bxname.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"

  if matches then decodeURIComponent matches[1].toString().split('+').join(' ') else null;


# Helper function to set cookie by name
setCookie = (name, value, options) ->
  bxname = getBXCookiePrefix() + '_' + name
  options = options || {};
  expires = options.expires;

  if typeof expires is "number" && expires
    d = new Date
    d.setTime d.getTime() + expires*1000
    expires = options.expires = d

  if expires && expires.toUTCString
    options.expires = expires.toUTCString()

  value = encodeURIComponent value.toString().split(' ').join('+')
  updatedCookie = bxname + "=" + value

  for propName of options
    updatedCookie += "; " + propName
    propValue = options[propName]

    if propValue isnt true
      updatedCookie += "=" + propValue

  document.cookie = updatedCookie;

# ===================================================================
# ============================= HANDLERS ============================
# ===================================================================
# Send event 'GOAL_ADD2BASKET' to all counters
checkBasket = () ->
  try
    basketCookie = getCookie 'BASKET_ADDED_G'
    if basketCookie is 'Y'
      console.debug "Found cookie BASKET_ADDED_G"
      if @ga?
        @ga 'send', 'event', 'conversion', 'GOAL_ADD2BASKET'
        @ga 'send', 'pageview', '/conversion-pages/add2basket/'
        console.debug "Sended goal GOAL_ADD2BASKET and hit '/conversion-pages/add2basket/' to GA"
      else if @_gaq?
        @_gaq.push ['_trackEvent', 'conversion', 'GOAL_ADD2BASKET']
        @_gaq.push ['_trackPageview', '/conversion-pages/add2basket/']
        console.debug "Sended goal GOAL_ADD2BASKET and hit '/conversion-pages/add2basket/' to GAQ"
      else
        console.debug "Not found ready GA/GAQ counter"

      console.debug "Handled cookie BASKET_ADDED_G"
      setCookie 'BASKET_ADDED_G', 'N',
        'path': '/'
        'expires': 1

      console.debug "Removed cookie BASKET_ADDED_G"
  catch e
    console.debug e

  try
    basketCookie = getCookie 'BASKET_ADDED_Y'
    if basketCookie is 'Y'
      console.debug "Found cookie BASKET_ADDED_Y"
      doOnYaCounter (yaCounter) ->
        yaCounter.reachGoal 'GOAL_ADD2BASKET'
        yaCounter.hit('/conversion-pages/add2basket/')
        console.debug "Sended goal GOAL_ADD2BASKET and hit '/conversion-pages/add2basket/' to YA"

        console.debug "Handled cookie BASKET_ADDED_Y"
        setCookie 'BASKET_ADDED_Y', 'N',
          'path': '/'
          'expires': 1

        console.debug "Removed cookie BASKET_ADDED_Y"
  catch e
    console.debug e


# Send event 'GOAL_MAKEORDER' and order details to all counters
checkOrder = () ->
  try
    orderCookie = getCookie 'ORDER_ADDED_G'
    orderCookie?=''
    orderID = orderCookie
    if orderID.length is 0
      orderCookie = getCookie 'ORDER_ADDED_Y'
      orderCookie?=0
      orderID = orderCookie

    if orderID.length > 0
      if @eshopOrder?
        console.debug "Found order data"
        checkOrderInner()
      else
        console.debug "Not found order data"
        if @jQuery?
          console.debug "Loading order data via jQuery"
          @jQuery.getScript '/bitrix/admin/intervolga.conversion_order.php'
        else if @BX? and @BX.ajax?
          console.debug "Loading order data via BX"
          @BX.ajax.loadScriptAjax '/bitrix/admin/intervolga.conversion_order.php'
        else
          console.debug "Cant load order data: jQuery or BX are not present"
  catch e
    console.debug e


checkOrderInner = () ->
  try
    orderCookie = getCookie 'ORDER_ADDED_G'
    orderCookie?=0
    orderID = orderCookie
    if orderID.length > 0 and @eshopOrder? and @eshopOrder.id.toString() is orderCookie
      order = @eshopOrder
      console.debug "Found cookie ORDER_ADDED_G"

      if @ga?
        @ga 'require', 'ecommerce', 'ecommerce.js'
        @ga 'ecommerce:addTransaction',
          'id': order.id
          'affiliation': order.affiliation
          'revenue': order.revenue
          'shipping': order.shipping
          'tax': order.tax
          'currency': order.currency
        for item in order.items
          @ga 'ecommerce:addItem',
            'id': order.id
            'name': item.name
            'sku': item.id
            'category': item.category
            'price': item.price
            'quantity': item.quantity
            'currency': item.currency

        @ga 'ecommerce:send'
        console.debug "Sended order data to GA"
        @ga 'send', 'event', 'conversion', 'GOAL_MAKEORDER'
        @ga 'send', 'pageview', '/conversion-pages/makeorder/'
        console.debug "Sended goal GOAL_MAKEORDER and hit '/conversion-pages/makeorder/' to GA"
      else if @_gaq
        @_gaq.push ['_addTrans',
                    order.id,
                    order.affiliation,
                    order.revenue,
                    order.tax,
                    order.shipping,
                    order.city,
                    order.state,
                    order.country]
        for item in order.items
          @_gaq.push ['_addItem',
                      order.id,
                      item.id,
                      item.name,
                      item.category,
                      item.price,
                      item.quantity]
        @_gaq.push ['_set', 'currencyCode', order.currency]
        @_gaq.push ['_trackTrans']
        console.debug "Sended order data to GAQ"
        @_gaq.push ['_trackEvent', 'conversion', 'GOAL_MAKEORDER']
        @_gaq.push ['_trackPageview', '/conversion-pages/makeorder/']
        console.debug "Sended goal GOAL_MAKEORDER and hit '/conversion-pages/makeorder/' to GAQ"
      else
        console.debug "Not found ready GA/GAQ counter"

      console.debug "Handled cookie ORDER_ADDED_G"

      setCookie 'ORDER_ADDED_G', 0,
        'path': '/'
        'expires': 1

      console.debug "Removed cookie ORDER_ADDED_G"
  catch e
    console.debug e

  try
    orderCookie = getCookie 'ORDER_ADDED_Y'
    orderCookie?=0
    orderID = orderCookie
    if orderID.length > 0
      doOnYaCounter (yaCounter) ->
        orderCookie = getCookie 'ORDER_ADDED_Y'
        orderCookie?=0
        orderID = orderCookie
        if orderID.length > 0 and @eshopOrder? and @eshopOrder.id.toString() is orderCookie
          order = @eshopOrder
          console.debug "Found cookie ORDER_ADDED_Y"

          yaParams = {}
          yaParams.order_id = order.id
          yaParams.order_price = order.revenue
          yaParams.currency = if order.currency=="RUB" then "RUR" else order.currency
          yaParams.exchange_rate = 1
          yaParams.goods = []
          for item in order.items
            yaParams.goods.push {id: item.id, name: item.name, price: item.price, quantity: item.quantity}

          yaCounter.reachGoal 'GOAL_MAKEORDER', yaParams
          console.debug "Sended order data and goal GOAL_MAKEORDER to YA"
          yaCounter.hit('/conversion-pages/makeorder/')
          console.debug "Sended hit '/conversion-pages/makeorder/' to YA"

          console.debug "Handled cookie ORDER_ADDED_Y"

          setCookie 'ORDER_ADDED_Y', 0,
            'path': '/'
            'expires': 1

          console.debug "Removed cookie ORDER_ADDED_Y"
  catch e
    console.debug e



# ===================================================================
# ============================= MAIN LOGIC ==========================
# ===================================================================
# Setting trap to ajax request in jQuery and BX
captureJQueryAjax = () ->
  try
    if @jQuery?
      $(document).ajaxSuccess (e, jqXHR, config) =>
        if config?
          console.debug "Catch jQuery succes request: " + config.url
          checkBasket()
          checkOrder()
  catch e
    console.debug e

captureBXAjax = () ->
  try
    if @BX?
      BX.addCustomEvent 'onAjaxSuccess', (data, config) ->
        if config?
          console.debug "Catch BX succes request: " + config.url
          checkBasket()
          checkOrder()
  catch e
    console.debug e



# Check and send 'BASKET_ADDED' and 'ORDER_ADDED' on page load
onReady checkBasket
onReady checkOrder
onReady captureJQueryAjax
onReady captureBXAjax
