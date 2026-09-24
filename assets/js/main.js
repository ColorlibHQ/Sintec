/**
 * Sintec front-end behaviour, without jQuery.
 *
 * The plugin calls keep the options they always had; ColorlibUI provides
 * drop-in versions of Owl Carousel, Isotope, AjaxChimp and the parallax
 * background that build the same markup, so the theme's stylesheets apply
 * unchanged.
 */
(function () {
  'use strict';

  var UI = window.ColorlibUI;
  if (!UI) return;

  // An element's content height, as jQuery's .height() measured it.
  function contentHeight(el) {
    var style = window.getComputedStyle(el);
    return el.getBoundingClientRect().height -
      parseFloat(style.paddingTop) - parseFloat(style.paddingBottom) -
      parseFloat(style.borderTopWidth) - parseFloat(style.borderBottomWidth);
  }

  function onLoad(fn) {
    if (document.readyState === 'complete') {
      fn();
    } else {
      window.addEventListener('load', fn);
    }
  }

  /*-------------------------------------------------------------------------------
    Navbar
  -------------------------------------------------------------------------------*/

  //* Navbar Fixed
  UI.ready(function () {
    var header = document.querySelector('header');
    var areas = UI.toElements('.header_area');
    if (!header || !areas.length) return;
    var navOffsetTop = contentHeight(header) + 50;
    window.addEventListener('scroll', function () {
      var fixed = window.pageYOffset >= navOffsetTop;
      areas.forEach(function (area) { area.classList.toggle('navbar_fixed', fixed); });
    }, { passive: true });
  });

  /*----------------------------------------------------*/
  /*  Parallax Effect js
  /*----------------------------------------------------*/
  // The jquery.parallax plugin appended to the theme's stellar.js: the banner
  // overlay moves at a third of the scroll distance.
  UI.parallax('.bg-parallax');

  UI.ready(function () {
    if (document.getElementById('number-section')) {
      UI.counter('.counter', { time: 1000 });
    }
  });

  //------- Owl Carusel  js --------//
  UI.owl('.active-testimonial-carusel', {
    items: 2,
    loop: true,
    margin: 30,
    autoplayHoverPause: true,
    smartSpeed: 500,
    dots: true,
    // autoplay: true,
    responsive: {
      0: { items: 1 },
      480: { items: 1 },
      992: { items: 2 }
    }
  });

  // Search Toggle
  UI.ready(function () {
    var box = document.getElementById('search_input_box');
    var open = document.getElementById('search');
    var close = document.getElementById('close_search');
    if (!box) return;
    box.style.display = 'none';
    if (open) {
      open.addEventListener('click', function () {
        UI.slide(box, 'toggle');
        var input = document.getElementById('search_input');
        if (input) input.focus();
      });
    }
    if (close) {
      close.addEventListener('click', function () {
        UI.slide(box, 'up', 500);
      });
    }
  });

  //------- mailchimp --------//
  UI.ajaxChimp('#mc_embed_signup form');

  //-------- Portfolio filter --------//
  onLoad(function () {
    var workGrid = [];

    UI.toElements('.portfolio-filter ul li').forEach(function (item) {
      item.addEventListener('click', function () {
        UI.toElements('.portfolio-filter ul li').forEach(function (li) { li.classList.remove('active'); });
        item.classList.add('active');

        var data = item.getAttribute('data-filter');
        workGrid.forEach(function (grid) { grid.arrange({ filter: data }); });
      });
    });

    if (document.getElementById('portfolio')) {
      workGrid = UI.isotope('.portfolio-grid', {
        itemSelector: '.all',
        percentPosition: true,
        masonry: {
          columnWidth: '.grid-sizer'
        }
      });
    }
  });
}());
