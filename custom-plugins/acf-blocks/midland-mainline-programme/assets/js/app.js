(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
'use strict';

(function ($) {
    'use strict';

    // When DOM is ready

    $(function () {

        function elSlide(selector) {
            if (selector.length) {
                var $accWrapper = $(selector);
                var opener = $accWrapper.find('.opener');
                var box = $accWrapper.find('.box-content');
                $(box).slideUp(0);
                opener.on('click', function () {
                    var _this = this;

                    if (!$(this).closest('.box').hasClass('opened')) {
                        setTimeout(function () {
                            $('.box').removeClass('opened');
                            $(_this).next().slideDown(300);
                            $(_this).closest('.box').toggleClass('opened');
                        }, 50);
                    } else {
                        $(this).closest('.box').removeClass('opened');
                    }
                    $(box).slideUp(300);
                });
                $(document).click(function (event) {
                    if (!$(event.target).closest('.opener').length) {
                        $(box).slideUp(0);
                        $('.box').removeClass('opened');
                    }
                });
            }
        }
        elSlide('#accordion1');
    });
})(jQuery);

},{}]},{},[1]);
