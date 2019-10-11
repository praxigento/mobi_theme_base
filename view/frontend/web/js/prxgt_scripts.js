require([
    'jquery'
], function ($) {
    'use strict';

    $(document).ready(function () {
        if (($("#prxgt-footer-links-block") != null) &&
            ($("#prxgt-footer-links-block-sticky") != null) &&
            ($("#prxgt-footer-links-collapsible") != null))
        {
            var objToStick = $("#prxgt-footer-links-block"); //Получаем нужный объект
            var topOfObjToStick = objToStick.offset().top; //Получаем начальное расположение нашего блока

            var windowScroll = $(window).scrollTop(); //Получаем величину, показывающую на сколько прокручено окно
            if ((windowScroll + $(window).height() < topOfObjToStick)) { // Если прокрутили больше, чем расстояние до блока, то приклеиваем его
                $("#prxgt-footer-links-block-sticky").removeClass("prxgtHidden");
            } else {
                $("#prxgt-footer-links-block-sticky").addClass("prxgtHidden");
            }


            $(window).scroll(function () {
                var windowScroll = $(window).scrollTop(); //Получаем величину, показывающую на сколько прокручено окно

                if ((windowScroll + $(window).height() < topOfObjToStick)) { // Если прокрутили больше, чем расстояние до блока, то приклеиваем его
                    $("#prxgt-footer-links-block-sticky").removeClass("prxgtHidden");

                    //$("#prxgt-footer-links-collapsible" ).collapsible("activate");
                } else {
                    $("#prxgt-footer-links-block-sticky").addClass("prxgtHidden");
                    // $("#prxgt-footer-links-collapsible").collapsible("deactivate");
                    //objToStick.removeClass("prxgtBottomLine");
                }
            });
        }
    });
});

require([
    'jquery'
], function ($) {
    if (($('#prxgt-back-top-button') != null))
    {
        var sBackTop = $('#prxgt-back-top-button');
        if (sBackTop.length) {
            //var sClickBackTop = $('#back-top a');
            sBackTop.hide();
            // fade in #back-top

            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    sBackTop.fadeIn();
                } else {
                    sBackTop.fadeOut();
                }
            });
            // scroll body to 0px on click
            $('a', sBackTop).click(function () {
                $('body,html').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });

        }
    }
});
