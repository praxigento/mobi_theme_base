define([
    'jquery',
    'mage/template',
    'uiRegistry',
    'jquery/ui',
    'prototype',
    'jquery/jquery-storageapi',
    "mage/mage"
], function (jQuery, mageTemplate, rg) {
    'use strict';

    $(document).ready(function () {
    var objToStick = $("#prxgt-footer-links-block"); //Получаем нужный объект
    var topOfObjToStick = $(objToStick).offset().top; //Получаем начальное расположение нашего блока

    $(window).scroll(function () {
    var windowScroll = $(window).scrollTop(); //Получаем величину, показывающую на сколько прокручено окно

    if (windowScroll > topOfObjToStick || true ) { // Если прокрутили больше, чем расстояние до блока, то приклеиваем его
    $(objToStick).addClass("prxgtTopWindow");
    } else {
    $(objToStick).removeClass("prxgtTopWindow");
    };
    });
  });
});
