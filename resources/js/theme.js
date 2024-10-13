import $ from 'jquery';

window.$ = $;
window.jQuery = $;

$(function () {
    'use strict'

    // This template is mobile first so active menu in navbar
    // has submenu displayed by default but not in desktop
    // so the code below will hide the active menu if it's in desktop
    if (window.matchMedia('(min-width: 992px)').matches) {
        $('.navbar .active').removeClass('show');
        $('.header-menu .active').removeClass('show');
    }

    // this will show navbar in left for mobile only
    $('#navShow, #navBarShow').on('click', function (e) {
        e.preventDefault();
        $('body').addClass('navbar-show');
    });

    // navbar backdrop for mobile only
    $('body').append('<div class="navbar-backdrop"></div>');
    $('.navbar-backdrop').on('click touchstart', function () {
        $('body').removeClass('navbar-show');
    });

    $('#menuShow').on('click', function (e) {
        e.preventDefault();
        $('body').toggleClass('header-menu-show');
    });

    $('.header-menu-header .close').on('click', function (e) {
        e.preventDefault();
        $('body').removeClass('header-menu-show');
    })

});
