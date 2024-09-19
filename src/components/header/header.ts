const $ = require('jquery');
const AOS = require('aos');
const headerEl = $(".header");
const hamburgerEl = $(".js-header__hamburger");
const bodyEl = $("body");
let previousScroll = 0;

function header() {

  const header = $('header.header');
  $(document).ready(function () {
    let scroll = $(window).scrollTop();

    if (scroll > 0) {
      header.addClass('header--sticky')
    } else {
      header.removeClass('header--sticky')
    }

    $(window).on('scroll resize', function () {
      let scroll = $(this).scrollTop();
      if (scroll > 0) {
        header.addClass('header--sticky')
      } else {
        header.removeClass('header--sticky')
      }
    });

  });

  hamburgerEl.on("click", function() {
    headerEl.toggleClass("header--open");
    bodyEl.toggleClass("has-nav");
  });

  $('.nav-main .nav-main__item > .arrow-bottom').on('click', function (e) {
    e.preventDefault();
    $(this).toggleClass('active');
    $(this).next('.nav-sub').toggleClass('open-menu');
  });

  $('.header__nav .nav-sub__item > .arrow-bottom').on('click', function (e) {
    e.preventDefault();
    $(this).toggleClass('active');
    $(this).next('.nav-sub').toggleClass('open-menu');
  });

  $("a[href='#top']").click(function() {
    $("html, body").animate({ scrollTop: 0 }, "slow");
    return false;
  });

}

function onScroll() {

  let currentScroll = $(window).scrollTop();

  if (currentScroll > 200){
    headerEl.addClass('header--scroll');
    if (currentScroll > previousScroll) {
      headerEl.removeClass("header--scroll-up");
      headerEl.addClass("header--scroll-down");
    } else {
      headerEl.removeClass("header--scroll-down");
      headerEl.addClass("header--scroll-up");
    }
  } else {
    headerEl.removeClass('header--scroll')
    headerEl.removeClass("header--scroll-up");
    headerEl.removeClass("header--scroll-down");
  }
  previousScroll = currentScroll;

}

export default header;
