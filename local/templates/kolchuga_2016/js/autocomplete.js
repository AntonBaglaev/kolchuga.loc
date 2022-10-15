/**
 * Created by Corndev on 21/06/16.
 */
;(function($){
    $.fn.personalSearch = function (options) {
        var _q = $(this),
            _s = '.' + $(this).attr('class'),
            _f = _q.parents('form'),
            _c = $(options.result),
            _this = {
                running: false,
                cache: [],
                cache_k: '',
                old_value: ''
            },
            _current_set = [],
            _opt = options,
            jqxhr = false;

        //_f.on('submit', function (e) {
        //    e.preventDefault();
        //    //location.href = _opt.catalogFolder + '?q=' + _q.val();
        //
        //});

        _f.on('refreshComplete', function(){
            _q = _f.find(_s);
        });

        _f.on('getResult', function () {

            var q = _q.val();

            if (q.length < 3) return false;

            if (_this.old_value == q) return false;

            _this.cache_k = _q.attr('name') + '|' + q;

            if (_this.cache[_this.cache_k] == null) {

                if (jqxhr) {
                    jqxhr.abort();
                }

                jqxhr = $.ajax({
                    type: "GET",
                    url: _opt.dataProvider,
                    data: {
                        query: q
                    },
                    success: function (result) {

                        _q.trigger('showResult', [result]);

                        if($.isArray(result) && result.length > 0) {
                            _this.cache[_this.cache_k] = result;
                        }

                        _current_set = result;

                        if (q !== _q.val())
                            _q.trigger('getResult');

                    },
                    dataType: 'json'
                });
            }
            else {
                _q.trigger('showResult', _this.cache[_this.cache_k]);
            }

        }).on('showResult', function (e, data) {

            if ($.isArray(data)) {
                _c.html(render(data)).addClass('open');
            } else if (_c.hasClass('open')) {
                _c.removeClass('open');
            }


        }).on('keyup', function () {

            if (_q.val().length < 3) {
                _c.removeClass('open');
                return false;
            }

            setTimeout(function () {
                _q.trigger('getResult');
            }, 10);

        }).on('focusout', function (e) {


        }).on('focus', function () {
            if (_q.val() !== '' && _c.children().length > 0)
                _c.addClass('open');
        });

        $('body').click(function (e) {
            if ($(e.target).attr('class') == _q.attr('class')) return;
            if ($(e.target).parents(options.result).length == 0) {
                _c.removeClass('open');
            }
        });

        _c.on('click', '.js-result-i', function (e) {
            e.preventDefault();

            var key = $(this).data('entity'),
                entity = _current_set[key];

            _c.removeClass('open');
            _q.val('');

            if (typeof _opt.onSelect == 'function') {
                _opt.onSelect.call(entity);
            }

        });

        _f.on('click', '.btn-clear', function () {
            $(this).parents('.js-complete-res').addClass('hide');
            _f.find('input[name="PERSON[EXISTS_ID]"]').remove();
        });

        function render(items) {
            if (!items || items == null) return false;
            var html = '<div class="search-result-inner"><ul>';
            $.each(items, function (key, v) {
                var full_name = '',
                    ids = '';


                html += '<div class="search-result-item">' +
                    '<a href="#" class="js-result-i" data-id="' + v['ID'] + '" data-entity="' + key + '">' + v['NAME'] + '</a>' +
                    '</div>';
            });

            html += '</div></ul>';
            return html;
        }

    }

}(jQuery));