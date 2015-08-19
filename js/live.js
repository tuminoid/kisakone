/*
 * live.js
 *
 * Copyright 2015 (c) Tuomo Tanskanen <tuomo@tanskanen.org>
 */

function setup_reloading(presentation) {
    var presentation = typeof presentation !== 'undefined' ? presentation : 0;
    var onemin = 1 * 60 * 1000;
    var threemin = 3 * onemin;
    var scrolltime = 2 * presentation * 1000;
    var reloadtime = scrolltime > 0 ? scrolltime + 10*1000 : threemin;
    if (scrolltime < onemin)
        reloadtime = onemin;

    setTimeout(reload_page, reloadtime);

    if (presentation)
        start_scrolling(scrolltime);
}

function start_scrolling(scrolltime) {
    $('#filter-form').hide();
    $('html, body').animate({ scrollTop: $('#footer').offset().top }, scrolltime);
    $('html, body').animate({ scrollTop: $('#header').offset().top }, scrolltime);
}

function stop_scrolling() {
    $('#filter-form').show();
    $('html, body').stop(true, false).animate({ scrollTop: $('#header').offset().top }, 0);
}

function reload_page() {
    window.location.reload();
}

$(document).keyup(function (e) {
    if (e.keyCode === 27)
        stop_scrolling();
});
