require([
    'jquery',
    'mage/template',
    'uiRegistry',
    'jquery/ui',
    'prototype',
    'jquery/jquery-storageapi',
    "mage/mage"
], function ($) {
    'use strict';

    $(document).ready(function () {
    var objToStick = $("#prxgt-footer-links-block"); //Получаем нужный объект
    var topOfObjToStick = $(objToStick).offset().top; //Получаем начальное расположение нашего блока

    $(window).scroll(function () {
    var windowScroll = $(window).scrollTop(); //Получаем величину, показывающую на сколько прокручено окно

    if ((windowScroll > topOfObjToStick)  || true ) { // Если прокрутили больше, чем расстояние до блока, то приклеиваем его
    $(objToStick).addClass("prxgtBottomLine");
        //$("#element").collapsible({ collapsible: true});
    } else {
    $(objToStick).removeClass("prxgtBottomLine");
    }
    });
  });
});

    require([
    'jquery'
    ], function($){
     var sBackTop = $('#prxgt-back-top-button');
                if(sBackTop.length){
                    //var sClickBackTop = $('#back-top a');
                    sBackTop.hide();
                    // fade in #back-top

                        $(window).scroll(function() {
                            if ($(this).scrollTop() > 100) {
                                sBackTop.fadeIn();
                            } else {
                                sBackTop.fadeOut();
                            }
                        });
                        // scroll body to 0px on click
                        $('a', sBackTop).click(function() {
                            $('body,html').animate({
                                scrollTop: 0
                            }, 800);
                            return false;
                        });

                }
    });
