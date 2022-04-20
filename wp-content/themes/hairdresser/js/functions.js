'use strict';

function replaceUrlParam(url, paramName, paramValue) {
    if (paramValue === null)
        paramValue = '';
    var pattern = new RegExp('\\b(' + paramName + '=).*?(&|$)')
    if (url.search(pattern) >= 0) {
        return url.replace(pattern, '$1' + paramValue + '$2');
    }
    return url + (url.indexOf('?') > 0 ? '&' : '?') + paramName + '=' + paramValue
}

function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}

jQuery.fn.isOnScreen = function () {
    var win = jQuery(window);

    var viewport = {
        top: win.scrollTop(),
        left: win.scrollLeft(),
    };
    viewport.right = viewport.left + win.width();
    viewport.bottom = viewport.top + win.height();

    var bounds = this.offset();
    bounds.right = bounds.left + this.outerWidth();
    bounds.bottom = bounds.top + this.outerHeight();

    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));

};

jQuery.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray();
    jQuery.each(a, function () {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

jQuery(function ($) {
    /* ----------------------------------------------------------------------------------- */
    /*  Site search
    /* ----------------------------------------------------------------------------------- */

    $('.site-search-close').on('click', function () {
        $('.site-wrapper').removeClass('site-search-opened');
    });

    $('.site-search-toggle button').on('click', function () {
        if ($('.site-search').length) {
            if (!$('.site-search-opened').length) {
                $(window).scrollTop(0);
            }

            $('.site-wrapper').toggleClass('site-search-opened');
        } else {
            $('.site-search-minimal').toggleClass('site-search-minimal--active');
        }
    });

    /* ----------------------------------------------------------------------------------- */
    /*  Mobile menu toggle
    /* ----------------------------------------------------------------------------------- */

    $('.navbar-toggle').on('click', function () {
        $('.site-navigation').toggleClass('site-navigation-opened');
        if ($('.site-navigation-opened').length) {
            mobileMenuOpened = true;
            $('.site-header-sticky-active').removeClass('site-header-sticky-active');
            $(window).scrollTop(0);
        } else {
            mobileMenuOpened = false;
        }
    });

    /* ----------------------------------------------------------------------------------- */
    /*  Mobile menu button
    /* ----------------------------------------------------------------------------------- */

    if ($('.menu-button').length) {
        var $nav = $('.site-navigation > ul');
        $nav.append('<li class="menu-item menu-button-wrap">' + $('.menu-button')[0].outerHTML + '</li>')
    }

    /* ----------------------------------------------------------------------------------- */
    /*  Animated submenu
    /* ----------------------------------------------------------------------------------- */

    if (!$('.menu-item-depth-0').length) {
        $('.site-navigation > ul > li').addClass('menu-item-depth-0');
    }

    if ($('.site-search-toggle') && !$('.site-search-toggle').hasClass('hidden-sm')) {
        $('.cartwrap').addClass('cart-search-space');
    }

    function submenuHeight() {
        $('.menu-item-depth-0 > .sub-menu').each(function () {
            $(this).css({
                'display': 'none',
                'height': 'auto',
            });
            $(this).attr('data-height', $(this).height());
            $(this).attr('style', '');
        });
    }

    if (window.innerWidth > 991) {
        submenuHeight();
    }

    $(window).on('resize', submenuHeight);

    $('.menu-item-depth-0 > a').on('mouseenter', function () {
        if (window.innerWidth > 991) {
            var $subMenu = $(this).siblings('.sub-menu');
            $subMenu.css('height', $subMenu.attr('data-height'));
        }
    });

    $('.menu-item-depth-0 > .sub-menu').on('mouseenter', function () {
        if (window.innerWidth > 991) {
            $(this).css('height', $(this).attr('data-height'));
            $(this).css('overflow', 'visible');
        }
    });

    $('.menu-item-depth-0 > a').on('mouseleave', function () {
        if (window.innerWidth > 991) {
            var $subMenu = $(this).siblings('.sub-menu');
            $subMenu.css('height', -1);
        }
    });

    $('.menu-item-depth-0 > .sub-menu').on('mouseleave', function () {
        if (window.innerWidth > 991) {
            $(this).css('height', -1);
            $(this).css('overflow', '');
        }
    });

    /* ----------------------------------------------------------------------------------- */
    /*  Sticky
    /* ----------------------------------------------------------------------------------- */

    var topOffset;
    var $wpBar = $('#wpadminbar');
    var $siteHeader = $('.site-header');
    var mobileMenuOpened = false;

    function changeTopOffset() {
        topOffset = $siteHeader.offset().top;

        if ($('.site-header-style-transparent').length && $('.top-bar').length) {
            topOffset = $('.top-bar').innerHeight() + $('.nav-wrap').css('top').replace('px', '') * 1;

            if (window.innerWidth < 600) {
                topOffset = $wpBar.height() + $('.top-bar').innerHeight();
            }
        }

        if (window.innerWidth > 600) {
            topOffset -= $wpBar.height();
        }

        /* Full screen menu type */
        if ($('.site-header-style-full-width, .site-header-style-boxed').length) {
            if (window.innerWidth > 991) {
                topOffset += $('.preheader-wrap').height();
            } else {
                topOffset = 0;

                if (window.innerWidth < 600) {
                    topOffset += $('#wpadminbar').height();
                }

                if ($('.site-search-opened').length) {
                    topOffset += $('.site-search').height();
                }
            }

            if ($('.site-header-style-boxed').length) {
                topOffset -= $('.nav-bar-wrapper').height() / 2;
            }
        }

        if (topOffset < 0) {
            topOffset = 0;
        }
    }

    function stickyHeader() {
        if ($('.site-header-sticky').length && $(window).scrollTop() > topOffset && (!mobileMenuOpened || window.innerWidth > 991)) {
            $siteHeader.addClass('site-header-sticky-active');
        } else {
            $siteHeader.removeClass('site-header-sticky-active');
        }
    }

    if ($('.site-header-sticky').length && $siteHeader.length) {
        $(window).on('resize', changeTopOffset);
        $(window).on('scroll', changeTopOffset);
        changeTopOffset();

        $(window).on('scroll', stickyHeader);
        stickyHeader();
    }

    function parallaxBackground() {
        if (window.innerWidth < 992) {
            $('.paralax-header').css({
                'background-size': 'auto ' + ($('.paralax-header').height() + 80) + 'px',
            });
        } else {
            $('.paralax-header').css({
                'background-size': 'cover',
            });
        }
    }

    parallaxBackground();
    $(window).on('resize', parallaxBackground);

    /* ----------------------------------------------------------------------------------- */
    /*  Top bar
    /* ----------------------------------------------------------------------------------- */

    function topBarSize() {
        $('.top-bar .container').css('height', $('.top-bar-left').innerHeight() + $('.top-bar-right').innerHeight() + 15);
    }

    $('.top-bar-close').on('click', function () {
        if (!$('.top-bar .container').attr('style')) {
            topBarSize();
            $('.top-bar').addClass('top-bar-show').removeClass('top-bar-hide');
        } else {
            $('.top-bar .container').attr('style', '');
            $('.top-bar').removeClass('top-bar-show').addClass('top-bar-hide');
        }

        $(this).trigger('blur');
    });

    $(window).on('resize', function () {
        if ($siteHeader.length) {
            changeTopOffset();
        }

        if (window.innerWidth > 991) {
            $('.top-bar .container').attr('style', '');
            $('.top-bar').removeClass('top-bar-show').removeClass('top-bar-hide');
        } else {
            if ($('.top-bar-show').length) {
                topBarSize();
            }
        }
    });

    /* ----------------------------------------------------------------------------------- */
    /*	Megamenu
    /* ----------------------------------------------------------------------------------- */

    function megamenu() {
        $('.megamenu > .sub-menu').css('left', 'auto');

        if (window.innerWidth > 991) {
            $('.megamenu').each(function () {
                var left = $('.site-header  .container').offset().left - $(this).find('> .sub-menu').offset().left;
                $(this).find('> .sub-menu').css('left', left + 15);
            });
        }
    }

    if ($('.megamenu').length) {
        megamenu();
        $(window).on('resize', megamenu);
    }

    /* ----------------------------------------------------------------------------------- */
    /*  Navigation links (smooth scroll)
    /* ----------------------------------------------------------------------------------- */

    $('.site-navigation a[href*="#"]:not([href="#"]):not([href*="="])').click(function () {
        if (!$(this).parents('.tabs').length && !$(this).parents('.nav-tabs').length && !$(this).parents('.panel').length && !$(this).parents('.vc_tta').length) {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') ||
                location.hostname == this.hostname) {
                var target = $(this.hash);
                var href = $.attr(this, 'href');
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    var $targetoffset = target.offset().top - $('.nav-wrap').outerHeight(true) + 20;

                    $('html,body').animate({
                        scrollTop: $targetoffset,
                    }, 1000);
                    return false;
                }
            }
        }
    });

    $(window).on('load', function () {
        if (window.location.hash.length > 0) {
            setTimeout(function () {
                window.scrollTo(0, $(window.location.hash).offset().top);
            }, 1);
        }
    });

    /* ----------------------------------------------------------------------------------- */
    /*  Waypoints
    /* ----------------------------------------------------------------------------------- */

    if ($('body').hasClass('home')) {
        var navLinkIDs = '';

        $('.site-navigation a[href*="#"]:not([href="#"]):not([href*="="])').each(function (index) {
            if (navLinkIDs !== '') {
                navLinkIDs += ', ';
            }
            var temp = $('.site-navigation a[href*="#"]:not([href="#"]):not([href*="="])').eq(index).attr('href').split('#');
            navLinkIDs += '#' + temp[1];
        });

        if (navLinkIDs) {
            $(navLinkIDs).waypoint(function (direction) {
                if (direction === 'down') {
                    $('.site-navigation a').parent().removeClass('current_page_item');
                    $('.site-navigation a[href="#' + $(this).attr('id') + '"]').parent().addClass('current_page_item');
                }
            }, {
                offset: 125,
            });

            $(navLinkIDs).waypoint(function (direction) {
                if (direction === 'up') {
                    $('.site-navigation a').parent().removeClass('current_page_item');
                    $('.site-navigation a[href="#' + $(this).attr('id') + '"]').parent().addClass('current_page_item');
                }
            }, {
                offset: function () {
                    return -$(this).height() + 20;
                },
            });
        }
    }

    /* Tabs */
    $('.nav-tabs a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    /* Portfolio */

    /* Build pagination */

    function buildPagination() {
        var page = $('.isotope').attr('data-page');
        var perPage = $('.isotope').attr('data-per-page');
        var number = $('.isotope').attr('data-number');

        $('.portfolio-pagination').html('');
        for (var i = 1; i <= Math.ceil(number / perPage); i++) {
            var selectedClass = '';

            if (i === page * 1) {
                selectedClass += ' portfolio-pagination-selected';
            }
            $('.portfolio-pagination').append('<button type="button" class="portfolio-pagination-item' + selectedClass + '">' + i + '</button>');
        }
    }

    function portfolioAjax() {
        $('.isotope').addClass('processing');

        var category = $('.filter .selected').attr('data-filter');

        if (category === '*') {
            category = '';
        }

        $.post(
            anps.ajaxurl,
            {
                'action': 'anps_portfolio_ajax',
                'per_page': $('.isotope').attr('data-per-page'),
                'category': category,
                'mobile_class': $('.isotope').attr('data-mobile-class'),
                'type': $('.isotope').attr('data-type'),
                'columns': $('.isotope').attr('data-columns'),
                'order': $('.isotope').attr('data-order'),
                'page': $('.portfolio-pagination-selected').html(),
                'orderby': $('.isotope').attr('data-orderby'),
            },
            function (response) {
                var el = $(response);

                var filterParam = getUrlParameter('filter');
                if (filterParam === undefined) {
                    filterParam = '*';
                }
                var pre = filterParam !== '*' ? '.' : '';

                $('.isotope').isotope({
                    filter: pre + filterParam,
                });
                $('.isotope').attr('data-number', el.attr('data-number'));
                $('.isotope').isotope('remove', $('.isotope-item'));
                $('.isotope').isotope('insert', $(el.html()));

                $('.isotope img').on('load', function () {
                    buildPagination();
                    $('.isotope').isotope('layout');
                    $('.isotope').removeClass('processing');
                });

            }
        );
    }

    if ($('.isotope[data-per-page]')) {
        buildPagination();
    }

    /* Switch pagination */
    $('body').on('click', '.portfolio-pagination-item', function () {
        $('.portfolio-pagination-selected').removeClass('portfolio-pagination-selected');
        $(this).addClass('portfolio-pagination-selected');
        $('.isotope').attr('data-page', $(this).html());
        portfolioAjax();
    });

    // bind filter button click
    $('.filter button').on('click', function () {
        $(this).parents('.filter').find('.selected').removeClass('selected');
        $(this).addClass('selected');

        // set filter in hash
        var newURL = replaceUrlParam(location.href, 'filter', $(this).attr('data-filter'));
        window.history.pushState('', '', newURL);

        if ($('.isotope[data-per-page]').length) {
            $('.portfolio-pagination-selected').removeClass('portfolio-pagination-selected');
            $('.portfolio-pagination-item:first-child').addClass('portfolio-pagination-selected');
            $('.isotope').attr('data-page', '1');

            portfolioAjax();
        } else {
            isotopeLayout.call(this);
        }
    });

    function isotopeLayout() {
        var parent = $('body');
        var el = $('.isotope');
        if (this !== window) {
            parent = $(this).parents('.filter');
            el = $(this).parents('.wpb_wrapper').find('.isotope');
        }

        var filterParam = getUrlParameter('filter');
        if (filterParam === undefined) {
            filterParam = parent.find('.filter > li:first-of-type button').data('filter');
        }
        var pre = filterParam !== '*' ? '.' : '';

        parent.find('button[data-filter="' + filterParam + '"]').addClass('selected');

        var options = {
            itemSelector: '.isotope-item',
            layoutMode: 'fitRows',
            filter: pre + filterParam,
        };

        if (el.hasClass('random')) {
            if ($('.isotope').width() > 1140) {
                options.layoutMode = 'masonry';
                options.masonry = {
                    columnWidth: 292,
                };
            } else if ($('.isotope').width() > 940) {
                options.layoutMode = 'masonry';
                options.masonry = {
                    columnWidth: 242,
                };
            }
        }

        el.isotope(options);
    }

    // Call Isotope
    if ($('.isotope').length) {
        isotopeLayout();
        $(window).on('load', isotopeLayout);
        $(window).on('resize', isotopeLayout);
    }

    /* Blog masonry */

    try {
        var $containerMasonry = $('.blog-masonry');
        $containerMasonry.imagesLoaded(function () {
            if ($containerMasonry.length) {
                $containerMasonry.isotope({
                    itemSelector: '.blog-masonry .post',
                    animationOptions: {
                        duration: 750,
                        queue: false,
                    },
                });
                $(window).resize(function () {
                    $containerMasonry.isotope('layout');
                });
                $(window).focus(function () {
                    $containerMasonry.isotope('layout');
                });
                $(document).ready(function () {
                    $(window).load(function () {
                        $containerMasonry.isotope('layout');
                    });
                });
            }
        });
    } catch (e) {
        console.error(e);
    }
    /* Twitter */
    try {
        $('[data-twitter]').each(function (index) {
            var el = $('[data-twitter]').eq(index);
            $.ajax({
                type: 'POST',
                url: 'http://localhost:8004/assets/php/twitter.php',
                data: {
                    account: el.attr('data-twitter'),
                },
                success: function (msg) {
                    el.find('.carousel-inner').html(msg);
                },
            });

        });
    } catch (e) {
        console.error(e);
    }

    function checkForOnScreen() {
        $('.counter-number').each(function (index) {
            if (!$(this).hasClass('animated') && $('.counter-number').eq(index).isOnScreen()) {
                $('.counter-number').eq(index).countTo({
                    speed: 5000,
                });
                $('.counter-number').eq(index).addClass('animated');
            }
        });
    }
    checkForOnScreen();
    $(window).scroll(function () {
        checkForOnScreen();
    });
    /* Fullscreen */
    if ($(window).height > 700) {
        $('.fullscreen').css('height', $(window).height() + 'px'); // menu position on home page
    }

    /* WordPress specific */
    // Comment button
    $('button[data-form="submit"]').on('click', function () {
        $('.form-submit #submit').click();
    });
    // Search widget
    $('.sidebar--classic .widget_product_search form').addClass('searchform');
    $('.sidebar--classic .searchform input[type="submit"]').remove();
    $('.sidebar--classic .searchform div').append('<button type="submit" class="fa fa-search" id="searchsubmit" value=""></button>');
    $('.searchform input[type="text"]').attr('placeholder', anps.search_placeholder);

    $('.sidebar--dark .searchform, .sidebar--white .searchform, .sidebar--classic .searchform').each(function () {
        $(this).find('input[type="text"]').css('padding-right', $(this).find('input[type="submit"]').innerWidth() + 20);
    });

    $('.blog-masonry').parent().removeClass('col-md-12');
    $('.post.style-3').parent().parent().removeClass('col-md-12').parent().removeClass('col-md-12');

    $('.site-navigation > div > ul').unwrap();

    $('.show-register').on('click', function () {
        $('#customer_login h3, #customer_login .show-register').addClass('hidden');
        $('#customer_login .register').removeClass('hidden');
    });

    function anpsLightbox() {
        if (rlArgs.script === 'swipebox') {
            $('.prettyphoto').swipebox();
        } else if (rlArgs.script === 'prettyphoto') {
            $('.prettyphoto').prettyPhoto();
        } else if (rlArgs.script === 'fancybox') {
            $('.prettyphoto').fancybox();
        } else if (rlArgs.script === 'nivo') {
            $('.prettyphoto').nivoLightbox();
        } else if (rlArgs.script === 'imagelightbox') {
            $('.prettyphoto').imageLightbox();
        }
    }

    if (typeof rlArgs !== 'undefined') {
        anpsLightbox();

        $(window).load(function () {
            /* Disable PrettyPhoto in VC */

            window.vc_prettyPhoto = function () {
                anpsLightbox();
            }
            anpsLightbox();
        });
    }

    $(document).ready(function () {
        $('.parallax-window[data-type="background"]').each(function () {
            var $bgobj = $(this); // assigning the object

            $(window).scroll(function () {
                var yPos = -($(window).scrollTop() / $bgobj.data('speed'));

                // Put together our final background position
                var coords = '50% ' + yPos + 'px';

                // Move the background
                $bgobj.css({
                    backgroundPosition: coords,
                });
            });
        });
    });


});

jQuery(document).ready(function ($) {
    $('.site-navigation ul').doubleTapToGo();

    jQuery('.ls-wp-fullwidth-helper:after').animate({
        width: '90px',
    }, 'slow');
});



jQuery(document).ready(function ($) {
    $('.scroll-top--fixed').hide();

    // fade in .scroll-top--fixed
    $(window).on('scroll', function () {

        if ($(this).scrollTop() > 300) {
            $('.scroll-top--fixed').fadeIn();
        } else {
            $('.scroll-top--fixed').fadeOut();
        }
    });

    // scroll body to 0px on click
    $('.scroll-top').on('click', function () {
        $('body, html').animate({
            scrollTop: 0,
        }, 800);
    });

    jQuery(document).ready(function ($) {
        if ($('.owl-carousel').length) {
            $('.owl-carousel').each(function () {
                var $owl = $(this);

                var numberItems = $owl.attr('data-col');

                var autoplay = $owl.attr('data-autoplay') === 'true';
                var autoplayTimeout = $owl.attr('data-autoplay-timeout') ? $owl.attr('data-autoplay-timeout') : 5000;
                var autoplayPause = $owl.attr('data-autoplay-pause') === 'true';

                var itemsXS = $owl.attr('data-xs') ? $owl.attr('data-xs') : 1;
                var itemsSM = $owl.attr('data-sm') ? $owl.attr('data-sm') : 2;

                var dataNav = $owl.attr('data-nav') ? true : false;

                var margin = $owl.attr('data-margin') ? $owl.attr('data-margin') * 1 : 30;

                $owl.owlCarousel({
                    loop: true,
                    margin: margin,
                    autoplay: autoplay,
                    autoplayTimeout: autoplayTimeout,
                    autoplayHoverPause: autoplayPause,
                    responsiveClass: true,
                    rtl: $('body').hasClass('rtl'),
                    responsive: {
                        0: {
                            items: itemsXS,
                            nav: dataNav,
                            slideBy: itemsXS,
                        },
                        600: {
                            items: itemsSM,
                            nav: dataNav,
                            slideBy: itemsSM,
                        },
                        992: {
                            items: numberItems,
                            nav: dataNav,
                            slideBy: numberItems,
                        },
                    },
                });

                // Custom Navigation Events
                $owl.parents('.wpb_wrapper').find('.owlnext').on('click', function () {
                    $owl.trigger('next.owl.carousel');
                });

                $owl.parents('.wpb_wrapper').find('.owlprev').on('click', function () {
                    $owl.trigger('prev.owl.carousel');
                });
            });
        }
    });

    /* Vertical menu */
    if (jQuery('body').hasClass('vertical-menu')) {
        jQuery('.nav-wrap > .hide-menu').click(function ($) {
            jQuery('header.vertical-menu, body.vertical-menu').toggleClass('hide-side-menu');
        });
    }



}); // end of (document).ready function


/* ----------------------------------------------------------------------------------- */
/*  Overwriting the vc row behaviour function for the vertical menu
/* ----------------------------------------------------------------------------------- */

if (typeof window['vc_rowBehaviour'] !== 'function') {
    window.vc_rowBehaviour = function () {
        function fullWidthRow() {
            var $elements = $('[data-vc-full-width="true"]');
            $.each($elements, function (key, item) {
                /* Anpthemes */
                var verticalOffset = 0;
                if ($('.site-header-vertical-menu').length && window.innerWidth > 992) {
                    verticalOffset = $('.site-header-vertical-menu').innerWidth();
                }

                var boxedOffset = 0;
                if ($('body.boxed').length && window.innerWidth > 992) {
                    boxedOffset = ($('body').innerWidth() - $('.site-wrapper').innerWidth()) / 2;
                }

                var $el = $(this);
                $el.addClass('vc_hidden');
                var $elFull = $el.next('.vc_row-full-width');
                $elFull.length || ($elFull = $el.parent().next('.vc_row-full-width'));
                var elMarginLeft = parseInt($el.css('margin-left'), 10),
                    elMarginRight = parseInt($el.css('margin-right'), 10),
                    offset = 0 - $elFull.offset().left - elMarginLeft,
                    width = $(window).width() - verticalOffset - boxedOffset * 2,
                    positionProperty = $('body.rtl').length ? 'right' : 'left';

                if (positionProperty === 'right') {
                    verticalOffset = 0;
                }

                var options = {
                    'position': 'relative',
                    'box-sizing': 'border-box',
                    'width': width,
                };
                options[positionProperty] = offset + verticalOffset + boxedOffset;

                $el.css(options);

                if (!$el.data('vcStretchContent')) {
                    var padding = -1 * offset - verticalOffset - boxedOffset;
                    0 > padding && (padding = 0);
                    var paddingRight = width - padding - $elFull.width() + elMarginLeft + elMarginRight;
                    0 > paddingRight && (paddingRight = 0),
                    $el.css({
                        'padding-left': padding + 'px',
                        'padding-right': paddingRight + 'px',
                    });
                }
                $el.attr('data-vc-full-width-init', 'true'),
                    $el.removeClass('vc_hidden')
            }),
            $(document).trigger('vc-full-width-row', $elements)
        }

        function parallaxRow() {
            var vcSkrollrOptions, callSkrollInit = !1;
            return window.vcParallaxSkroll && window.vcParallaxSkroll.destroy(),
                $('.vc_parallax-inner').remove(),
                $('[data-5p-top-bottom]').removeAttr('data-5p-top-bottom data-30p-top-bottom'),
                $('[data-vc-parallax]').each(function () {
                    var skrollrSpeed, skrollrSize, skrollrStart, skrollrEnd, $parallaxElement, parallaxImage, youtubeId;
                    callSkrollInit = !0,
                        'on' === $(this).data('vcParallaxOFade') && $(this).children().attr('data-5p-top-bottom', 'opacity:0;').attr('data-30p-top-bottom', 'opacity:1;'),
                        skrollrSize = 100 * $(this).data('vcParallax'),
                        $parallaxElement = $('<div />').addClass('vc_parallax-inner').appendTo($(this)),
                        $parallaxElement.height(skrollrSize + '%'),
                        parallaxImage = $(this).data('vcParallaxImage'),
                        youtubeId = vcExtractYoutubeId(parallaxImage),
                        youtubeId ? insertYoutubeVideoAsBackground($parallaxElement, youtubeId) : 'undefined' != typeof parallaxImage && $parallaxElement.css('background-image', "url(" + parallaxImage + ")"),
                        skrollrSpeed = skrollrSize - 100,
                        skrollrStart = -skrollrSpeed,
                        skrollrEnd = 0,
                        $parallaxElement.attr('data-bottom-top', 'top: ' + skrollrStart + '%;').attr('data-top-bottom', 'top: ' + skrollrEnd + '%;')
                }),
                callSkrollInit && window.skrollr ? (vcSkrollrOptions = {
                    forceHeight: !1,
                    smoothScrolling: !1,
                    mobileCheck: function () {
                        return !1
                    },
                },
                window.vcParallaxSkroll = skrollr.init(vcSkrollrOptions),
                window.vcParallaxSkroll) : !1
        }

        function fullHeightRow() {
            var $element = $('.vc_row-o-full-height:first');
            if ($element.length) {
                var $window, windowHeight, offsetTop, fullHeight;
                $window = $(window),
                    windowHeight = $window.height(),
                    offsetTop = $element.offset().top,
                    windowHeight > offsetTop && (fullHeight = 100 - offsetTop / (windowHeight / 100),
                        $element.css('min-height', fullHeight + 'vh'))
            }
            $(document).trigger('vc-full-height-row', $element)
        }

        function fixIeFlexbox() {
            var ua = window.navigator.userAgent,
                msie = ua.indexOf('MSIE ');
            (msie > 0 || navigator.userAgent.match(/Trident.*rv\:11\./)) && $('.vc_row-o-full-height').each(function () {
                'flex' === $(this).css('display') && $(this).wrap('<div class="vc_ie-flexbox-fixer"></div>')
            })
        }
        var $ = window.jQuery;
        $(window).off('resize.vcRowBehaviour').on('resize.vcRowBehaviour', fullWidthRow).on('resize.vcRowBehaviour', fullHeightRow),
            fullWidthRow(),
            fullHeightRow(),
            fixIeFlexbox(),
            vc_initVideoBackgrounds(),
            parallaxRow()
    }
}

/* Google Maps (using gmaps.js) */

function isFloat(n) {
    return parseFloat(n.match(/^-?\d*(\.\d+)?$/)) > 0;
}

function checkCoordinates(str) {
    if (!str) {
        return false;
    }

    str = str.split(',');
    var isCoordinate = true;

    if (str.length !== 2 || !isFloat(str[0].trim()) || !isFloat(str[1].trim())) {
        isCoordinate = false;
    }

    return isCoordinate;
}

jQuery(function ($) {
    $('.map').each(function () {
        /* Options */
        var gmap = {
            zoom: ($(this).attr('data-zoom')) ? parseInt($(this).attr('data-zoom')) : 15,
            address: $(this).attr('data-address'),
            markers: $(this).attr('data-markers'),
            icon: $(this).attr('data-icon'),
            typeID: $(this).attr('data-type'),
            ID: $(this).attr('id'),
        };

        var gmapScroll = ($(this).attr('data-scroll')) ? $(this).attr('data-scroll') : 'false';
        var markersArray = [];
        var bound = new google.maps.LatLngBounds();

        if (gmapScroll === 'false') {
            gmap.draggable = false;
            gmap.scrollwheel = false;
        }

        /* Google Maps with markers */

        if (gmap.markers) {
            gmap.markers = gmap.markers.split('|');

            /* Get markers and their options */
            gmap.markers.forEach(function (marker) {
                if (marker) {
                    marker = $.parseJSON(marker);

                    if (checkCoordinates(marker.address)) {
                        marker.latLng = marker.address.split(',');
                        delete marker.address;
                    }

                    markersArray.push(marker);
                }
            });

            /* Initialize map */
            $('#' + gmap.ID).gmap3({
                zoom: gmap.zoom,
                draggable: gmap.draggable,
                scrollwheel: gmap.scrollwheel,
                mapTypeId: google.maps.MapTypeId[gmap.typeID],
                styles: gmap.styles,
            }).marker(markersArray).then(function (results) {
                var center = null;

                if (typeof results[0].position.lat !== 'function' ||
                    typeof results[0].position.lng !== 'function') {
                    return false;
                }

                results.forEach(function (m, i) {
                    if (markersArray[i].center) {
                        center = new google.maps.LatLng(m.position.lat(), m.position.lng());
                    } else {
                        bound.extend(new google.maps.LatLng(m.position.lat(), m.position.lng()));
                    }
                });

                if (!center) {
                    center = bound.getCenter();
                }

                this.get(0).setCenter(center);
            }).infowindow({
                content: '',
            }).then(function (infowindow) {
                var map = this.get(0);
                this.get(1).forEach(function (marker) {
                    if (marker.data !== '') {
                        marker.addListener('click', function () {
                            infowindow.setContent(decodeURIComponent(marker.data));
                            infowindow.open(map, marker);
                        });
                    }
                });
            });
        }

        /* Google Maps Basic */

        if (gmap.address) {
            if (checkCoordinates(gmap.address)) {
                $('#' + gmap.ID).gmap3({
                    zoom: gmap.zoom,
                    draggable: gmap.draggable,
                    scrollwheel: gmap.scrollwheel,
                    mapTypeId: google.maps.MapTypeId[gmap.typeID],
                    center: gmap.address.split(','),
                }).marker({
                    latLng: gmap.address.split(','),
                    options: {
                        icon: gmap.icon,
                    },
                });
            } else {
                $('#' + gmap.ID).gmap3({
                    zoom: gmap.zoom,
                    draggable: gmap.draggable,
                    scrollwheel: gmap.scrollwheel,
                    mapTypeId: google.maps.MapTypeId[gmap.typeID],
                }).latlng({
                    address: gmap.address,
                }).then(function (result) {
                    if (!result) {
                        return
                    };

                    this.get(0).setCenter(new google.maps.LatLng(result.lat(), result.lng()));
                }).marker(function () {
                    return {
                        position: this.get(0).getCenter(),
                        icon: gmap.icon,
                    };
                });
            }
        }
    });

    /* Featured content style 2 */

    $('.f-content--style-2').each(function () {
        $(this).parents('.vc_row').find('.vc_column-inner').css({
            'padding-left': '0px',
            'padding-right': '0px',
        });

        $(this).parents('.vc_row').css({
            'padding-left': '15px',
            'padding-right': '15px',
        });

        $(this).parents('[data-vc-full-width="true"]').css({
            'margin-left': '0',
            'margin-right': '0',
        });
    });

    /* ----------------------------------------------------------------------------------- */
    /*	Fixed Footer
    /* ----------------------------------------------------------------------------------- */

    $(window).on('load', function () {
        if ($('.footer-parallax').length) {
            fixedFooter();

            $(window).on('resize', function () {
                fixedFooter();
            });
        }
    });

    function fixedFooter() {
        $('.site-wrapper').css('margin-bottom', $('.site-footer').innerHeight());
        $('.site-wrapper').css('padding-bottom', $('.site-footer').css('margin-top'));
    }

    /* ----------------------------------------------------------------------------------- */
    /*	Empty space with responsive options
    /* ----------------------------------------------------------------------------------- */

    function emptyElement() {
        $('.empty').each(function () {
            if (window.innerWidth > 1200) {
                $(this).height($(this).data('lg'));
            } else if (window.innerWidth > 992) {
                $(this).height($(this).data('md'));
            } else if (window.innerWidth > 768) {
                $(this).height($(this).data('sm'));
            } else {
                $(this).height($(this).data('xs'));
            }
        });
    }

    $(window).on('resize', emptyElement);
    emptyElement();

    /* ----------------------------------------------------------------------------------- */
    /*	Social bar
    /* ----------------------------------------------------------------------------------- */

    /* Check if the backgrounds of sections and footer */

    $('.vc_row[data-vc-full-width="true"]').each(function () {
        if ($(this).css('background-image') !== 'none') {
            $(this).addClass('has-background-image');
        }
    });

    $('.rev_slider').parents('.wpb_wrapper').addClass('background-ignore');

    if ($('.wpb_wrapper:not(.background-ignore) img, .has-background-image, .parallax-window[style*="background-image"]').length) {
        if ($('.social-bar').length) {
            BackgroundCheck.init({
                targets: '.social-bar__item',
                images: '.wpb_wrapper:not(.background-ignore) img, .has-background-image, .parallax-window[style*="background-image"]',
                classes: {
                    dark: 'social-bar__item--light-img',
                    light: '',
                    complex: '',
                },
            });
        }
    }

    $('.vc_row[data-vc-full-width="true"], .page-heading.style-2, .nav-wrap, .top-bar, .site-footer').each(function () {
        if ($(this).css('background-image') !== 'none' ||
            $(this).hasClass('.background--light') ||
            $(this).hasClass('.background--dark')) {
            return;
        }

        $(this).colourBrightness();
    });

    $('.social-bar-wrapper').height($('.social-bar').height());

    function socialBarColor() {
        $('.social-bar__item').each(function () {
            var $bar = $(this);
            var barTop = $(this).offset().top;
            var barHeight = $(this).height();

            /* Clear style */
            $(this).removeClass('social-bar__item--light');

            /* Find top and bottom sections */
            $('.top-bar, .nav-wrap, .page-heading.style-2, .vc_row, .site-footer').each(function () {
                if (!$(this).hasClass('background--light') && !$(this).hasClass('background--dark')) {
                    return;
                }

                var rowTop = $(this).offset().top;
                var rowHeight = $(this).innerHeight();

                if ((rowTop < barTop && rowTop + rowHeight > barTop) ||
                    (rowTop < barTop + barHeight && rowTop + rowHeight > barTop + barHeight)) {
                    if ($(this).hasClass('background--dark')) {
                        $bar.addClass('social-bar__item--light');
                    }
                }
            });
        });
    }

    $(window).on('load', socialBarColor);
    $(window).on('scroll', socialBarColor);

    window.sbi_custom_js = function () {
        var $owl = $('#sbi_images').addClass('owl-carousel').owlCarousel({
            loop: true,
            items: 5,
            nav: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2,
                    slideBy: 2,
                },
                500: {
                    items: 3,
                    slideBy: 3,
                },
                800: {
                    items: 4,
                    slideBy: 4,
                },
                1100: {
                    items: 5,
                    slideBy: 5,
                },
            },
        });

        // Custom Navigation Events
        $owl.parents('.wpb_wrapper').find('.owl-next').on('click', function () {
            $owl.trigger('next.owl.carousel');
        });

        $owl.parents('.wpb_wrapper').find('.owl-prev').on('click', function () {
            $owl.trigger('prev.owl.carousel');
        });
    }

    /* ----------------------------------------------------------------------------------- */
    /*	Portfolio modern
    /* ----------------------------------------------------------------------------------- */

    function portfolioFilter($items, className) {
        $items.isotope({
            filter: className,
        });
    }

    $('.portfolio-m').each(function () {
        var $portfolio = $(this);
        var $items = $portfolio.find('.portfolio-m__items');
        var perPage = $items.data('per-page');
        var order = $items.data('order');
        var orderby = $items.data('orderby');
        var currentPage = 1;
        var maxPage = 0;
        var inProgress = false;
        if ($portfolio.find('.next-prev-m').length) {
            maxPage = $portfolio.find('.next-prev-m').data('max-page');
        }

        if ($portfolio.find('.pagination-m').length) {
            maxPage = $portfolio.find('.pagination-m').data('max-page');
        }

        $(window).on('load', function () {
            $items.isotope({
                itemSelector: '.portfolio-m__item',
            });
        });

        function portfolioM() {
            $items = $portfolio.find('.portfolio-m__items');

            var $selectedFilter = $portfolio.find('.filter-m__button--active');

            var category = $selectedFilter.data('filter') === '*' ? '' : $selectedFilter.data('filter');

            var category = $selectedFilter.data('filter');
            if ($selectedFilter.data('filter') === '*') {
                if (typeof $items.data('category') !== 'undefined') {
                    category = $items.data('category');
                } else {
                    category = '';
                }
            }

            var linkType = $items.find('.portfolio-m__item').is('div') ? 'post' : 'image';

            $.post(
                anps.ajaxurl,
                {
                    'action': 'anps_portfolio_m_ajax',
                    'per_page': perPage,
                    'category': category,
                    'order': order,
                    'page': currentPage,
                    'orderby': orderby,
                    'link_type': linkType,
                },
                function (response) {
                    var el = $(response);

                    portfolioPagination();

                    $items.isotope('remove', $('.portfolio-m__item'));
                    $items.isotope('insert', el);

                    $items.find('img').on('load', function () {
                        $items.isotope('layout');

                        if (linkType === 'image') {
                            $items.find('a').prettyPhoto({
                                deeplinking: false,
                            });
                        }
                    });

                    inProgress = false;
                    $portfolio.removeClass('portfolio-m--in-progress');
                }
            );
        }

        function portfolioPagination() {
            var $buttons = $portfolio.find('.pagination-m__button');

            $buttons.each(function (index) {
                if (index < maxPage) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        function inProgressSet() {
            inProgress = true;
            $portfolio.addClass('portfolio-m--in-progress');
        }

        $portfolio.find('.filter-m__button').on('click', function () {
            if (!inProgress) {
                $portfolio.find('.filter-m__button--active').removeClass('filter-m__button--active');
                $(this).addClass('filter-m__button--active');

                var $selectedFilter = $portfolio.find('.filter-m__button--active');
                var category =  $selectedFilter.data('filter');
                if ($selectedFilter.data('filter') === '*') {
                    if (typeof $items.data('category') !== 'undefined') {
                        category = $items.data('category');
                    } else {
                        category = '';
                    }
                }
                currentPage = 1;
                inProgressSet();
                $portfolio.find('.pagination-m__button--active').removeClass('pagination-m__button--active');
                $portfolio.find('.pagination-m__button:first-child').addClass('pagination-m__button--active');

                $.post(
                    anps.ajaxurl,
                    {
                        'action': 'anps_portfolio_m_pagination_ajax',
                        'per_page': perPage,
                        'category': category,
                    },
                    function (response) {
                        maxPage = response;

                        portfolioM();
                    }
                );
            }
        });

        $portfolio.find('.next-prev-m__button--next').on('click', function () {
            if (!inProgress) {
                currentPage++;
                inProgressSet();

                if (currentPage > $portfolio.find('.next-prev-m').data('max-page')) {
                    currentPage = 1;
                }

                portfolioM();
            }
        });

        $portfolio.find('.next-prev-m__button--prev').on('click', function () {
            if (!inProgress) {
                currentPage--;
                inProgressSet();

                if (currentPage === 0) {
                    currentPage = $portfolio.find('.next-prev-m').data('max-page');
                }

                portfolioM();
            }
        });

        $portfolio.find('.pagination-m__button').on('click', function () {
            currentPage = $(this).text() * 1;
            $portfolio.find('.pagination-m__button--active').removeClass('pagination-m__button--active');
            $(this).addClass('pagination-m__button--active');

            portfolioM();
        });
    });

    /* Portfolio header */

    function portfolioHeader() {
        $('.portfolio-m__header').each(function () {
            var titleWidth = $(this).find('.portfolio-m__title span').innerWidth();
            var filterWidth = $(this).find('.filter-m').innerWidth();

            if (titleWidth * 2 + filterWidth > $(this).innerWidth()) {
                $(this).addClass('portfolio-m__header--center');
                $(this).removeClass('portfolio-m__header--default');
            } else {
                $(this).addClass('portfolio-m__header--default');
                $(this).removeClass('portfolio-m__header--center');
            }
        });
    }

    portfolioHeader();
    $(window).on('resize', portfolioHeader);

    /* Portfolio next / prev */

    $('.next-prev-m--fancy.next-prev-m').each(function () {
        var $row = $(this).parents('.vc_row');

        $(this).detach().appendTo($row);
    });

    /* ----------------------------------------------------------------------------------- */
    /*	Appointments
    /* ----------------------------------------------------------------------------------- */

    window.appointmentEvent = '';

    $('.ea-bootstrap.bootstrap').prepend('<div class="calendar-service"></div>');

    if ($('[data-c="location"] option').length > 1) {
        $('.ea-bootstrap.bootstrap').prepend('<div class="calendar-location"><button class="calendar-location__nav calendar-location__nav--prev"></button><span class="calendar-location__val"></span><button class="calendar-location__nav calendar-location__nav--next"></button></div>');
    }
    
    //If busy disable click
    $(document).on('DOMNodeInserted', function(){
        if($(".ui-datepicker-calendar tbody tr td").hasClass('busy')) {
            $('td.busy').addClass('no-slots');
        }
    });
    $('.ea-bootstrap').on('mouseenter', function(){
        if($("td.busy").length > 0) {
            $('td.busy').addClass('no-slots');
        }
    });
    //END If busy disable click
    /* location picker */

    function calendarLocationChange(index, triggerChange) {
        var val = $('[data-c="location"] option').eq(index).val();
        if ($('[data-c="location"] option').length > 1) {
            $('.calendar-location__val').html($('[data-c="location"] option').eq(index).text());
            $('.calendar-location__val').attr('data-val', $('[data-c="location"] option').eq(index).val());
        }

        $('.calendar-service__item--active').removeClass('calendar-service__item--active');
        if ($('[data-c="location"] option').length > 1) {
            $('[data-c="location"]').val(val);
        }
        $('.calendar-service__item:first-child').addClass('calendar-service__item--active');

        if (triggerChange) {
            $('[data-c="service"]').prop('selectedIndex', 1).change();
        }
    }

    calendarLocationChange(1, false);

    function calendarMonthChange(step) {
        $('.time-show').removeClass('time-show');
        $('.confirm-show').removeClass('confirm-show');
        var val = $('[data-c="location"]').prop('selectedIndex');
        val = step === 'next' ? val + 1 : val - 1;

        if (val === $('[data-c="location"] option').length) {
            val = 1;
        }

        if (val === 0) {
            val = $('[data-c="location"] option').length - 1;
        }

        calendarLocationChange(val, true);
    }

    $('.calendar-location__nav--next').on('click', function (e) {
        calendarMonthChange('next');

        e.preventDefault();
        e.stopPropagation();
    });

    $('.calendar-location__nav--prev').on('click', function (e) {
        calendarMonthChange('prev');

        e.preventDefault();
        e.stopPropagation();
    });

    /* Service picker */

    $('[data-c="service"] option').each(function () {
        if ($(this).html() !== '-') {
            $('.calendar-service').append('<button class="calendar-service__item" data-val="' + $(this).val() + '">' + $(this).html() + '</button>');
        }
    });

    $('.calendar-service__item:first-child').addClass('calendar-service__item--active');
    if ($('[data-c="service"] option').length === 1) {
        $('[data-c="service"]').click();
    } else {
        $('[data-c="service"]').prop('selectedIndex', 1).change();
    }

    $('.calendar-service__item').on('click', function (e) {
        $('.calendar-service__item--active').removeClass('calendar-service__item--active');
        $('[data-c="service"]').val($(this).data('val')).change();
        $(this).addClass('calendar-service__item--active');
        $('.time-show').removeClass('time-show');
        $('.confirm-show').removeClass('confirm-show');

        e.preventDefault();
        e.stopPropagation();
    });

    $('.ea-bootstrap .calendar').append('<div class="anps-calendar-time"></div>');
    $('.ea-bootstrap .calendar').append('<div class="anps-calendar-confirm"></div>');
    /* Available text */

    $('.ea-bootstrap .calendar').append('<span class="calendar-available"><span>' + anps.available_text + '</span></span>');
    $('body').on('mouseover', '.ui-state-default', function (e) {
        e.preventDefault();
        e.stopPropagation();

        $('.calendar-available').css({
            top: $(this).position().top,
            left: $(this).position().left + $(this).width() / 2,
            opacity: 1,
        });
    });

    $('body').on('mouseover', function () {
        $('.calendar-available').css({
            opacity: 0,
        });
    });

    /* Disable scrolling */

    if (window.ea_settings !== undefined) {
        window.ea_settings.scroll_off = 'true';
    }

    /* Show time */
    window.anpsAppointment = function (date) {
        createTime();
    };

    function createConfirm() {
        var html = '';

        html += '<div class="anps-step anps-confirm-step">';

        html += '<div class="anps-step__header">';

        html += '<button class="anps-step__back anps-step__back--confirm">' + anps.clock_icon + '</button>';

        html += '<div class="anps-step__title">' + anps.confirm_text + '</div>';

        html += '</div>';

        html += '<div class="anps-step__subtitle">' + $('.row-datetime .value').html() + '</div>';

        html += '<div class="anps-step__subtitle">' + $('.row-service .ea-label').html() + ': ' + $('.row-service .value').html() + '</div>';

        $('.step.final .form-group').each(function () {
            if (!$(this).find('.ea-submit').length) {
                var placeholderText = $(this).find('.control-label').text();
                placeholderText = placeholderText.replace('*', '');
                placeholderText = placeholderText.replace(':', '');

                $(this).find('input').attr('placeholder', placeholderText);
                html += $(this).find('.col-sm-8').html();
            }
        });

        html += '<button class="anps-step__button">' + anps.book_text + '</button>';

        html += '</div>';

        $('.anps-calendar-confirm').html(html);
    }

    function createTime() {
        var html = '';

        html += '<div class="anps-step anps-time-step">';

        html += '<div class="anps-step__header">';

        html += '<button class="anps-step__back anps-step__back--time">' + anps.calendar_icon + '</button>';

        html += '<div class="anps-step__title">' + anps.appointment_text + ' ' + $('.ui-datepicker-month').text() + ' ' + $('.ui-datepicker-current-day').text() + ', ' + $('.ui-datepicker-year').text() + '</div>';

        html += '</div>';

        html += '<ul class="anps-book-time">';
        $('.time-value').each(function () {
            html += '<li class="anps-book-time__item"><div class="anps-book-time__time">' + $(this).text() + '</div><div class="anps-book-time__wrap"><button class="anps-step__button" data-val="' + $(this).text() + '">' + anps.book_text + '</button></div></li>';
        });
        html += '</ul>';

        html += '</div>';

        $('.ea-bootstrap').addClass('time-show');
        $('.anps-calendar-time').html(html);
    }

    $('body').on('click', '.anps-step__back--time', function (e) {
        e.preventDefault();

        $('.time-show').removeClass('time-show');

        return false;
    });

    $('body').on('click', '.anps-step__back--confirm', function (e) {
        e.preventDefault();

        $('.step').removeClass('disabled');
        $('.ea-bootstrap').addClass('time-show');
        $('.confirm-show').removeClass('confirm-show');

        return false;
    });

    $('body').on('click', '.anps-book-time .anps-step__button', function (e) {
        e.preventDefault();

        $('.time-row a[data-val="' + $(this).data('val') + '"]').click();
        createConfirm();
        $('.time-show').removeClass('time-show');
        $('.ea-bootstrap').addClass('confirm-show');

        return false;
    });

    $('body').on('click', '.anps-confirm-step .anps-step__button', function (e) {
        e.preventDefault();

        $('.step.final .ea-submit').click();
        $('.anps-step__back--confirm').hide();

        return false;
    });

    $('body').on('change', '.anps-confirm-step input', function (e) {
        e.preventDefault();

        var name = $(this).attr('name');
        var val = $(this).val();

        $('.step.final input[name="' + name + '"]').val(val);

        return false;
    });

    window.anpsAppointmentDone = function () {
        $('.anps-confirm-step .anps-step__button').hide();
        $('.anps-confirm-step').append('<div class="anps-step__success">' + anps.success_text + '</div>');
    }

    /* Text & Image Switcher */

    $('.img-txt').each(function () {
        $(this).find('.img-txt__images').css('width', $(this).find('img').eq(0).width());
        $(this).find('.img-txt__images').css('height', $(this).find('img').eq(0).height());

        $(this).find('.img-txt__item-wrap').css('padding-right', $(this).find('img').length * 30)

        $(this).find('.img-txt__image').detach().appendTo($(this).find('.img-txt__images'));
    });

    function txtImageSize() {
        $('.img-txt__content').height('auto');

        $('.img-txt__content').each(function () {
            $(this).height($(this).find('.img-txt__item--active').innerHeight());
        });

        $('.img-txt').find('.img-txt__images').width('auto');
        $('.img-txt').find('.img-txt__images').height('auto');

        $('.img-txt').each(function () {
            var width = $(this).find('img').eq(0).width();
            var height = $(this).find('img').eq(0).height();

            if (window.innerWidth < 600) {
                width = width - 30;
                height = height - 30;
            }

            if (window.innerWidth > 900 && window.innerWidth < 1100) {
                width = width * 0.65;
                height = height * 0.65;
            }

            $(this).find('.img-txt__images').css('width', width);
            $(this).find('.img-txt__images').css('height', height);
        });
    }

    $(window).on('load', txtImageSize);
    $(window).on('resize', txtImageSize);

    var blocked = false;

    $('.img-txt__image').on('click', function () {
        if (!blocked && !$(this).hasClass('img-txt__img--active')) {
            var $parent = $(this).parents('.img-txt');
            var $el = $(this);
            $parent.find('.img-txt__item--active').addClass('img-txt__item--hide');
            $parent.find('.img-txt__item--active').removeClass('img-txt__item--active');
            $parent.find('.img-txt__item').eq($el.index()).addClass('img-txt__item--active');

            $parent.find('.img-txt__image--active').removeClass('img-txt__image--active');
            $(this).addClass('img-txt__image--animate');

            setTimeout(function () {
                $parent.find('.img-txt__image--animate').removeClass('img-txt__image--animate');
                $el.addClass('img-txt__image--active');
            }, 200);

            setTimeout(function () {
                $parent.find('.img-txt__item--hide').removeClass('img-txt__item--hide');
                blocked = false;
            }, 1200);
            blocked = true;
        }
    });

    $('.img-txt__btn--next').on('click', function () {
        var $parent = $(this).parents('.img-txt');
        var $next = $parent.find('.img-txt__image--active').next();

        if (!$next.length) {
            $next = $parent.find('.img-txt__image').eq(0);
        }

        $next.click();
        $(this).blur();
    });

    $('.img-txt__btn--prev').on('click', function () {
        var $parent = $(this).parents('.img-txt');
        var $prev = $parent.find('.img-txt__image--active').prev();

        if (!$prev.length) {
            $prev = $parent.find('.img-txt__image').eq($parent.find('.img-txt__image').length - 1);
        }

        $prev.click();
        $(this).blur();
    });

    $(document).on('added_to_cart', function () {
        var $el = $('.added_to_cart');
        $el.addClass('btn btn-woocommerce');

        $el.each(function () {
            if (!$(this).find('svg').length) {
                $(this).append(anps.view_icon);
            }
        })
    });

    $('.pagination-nav--prev').on('click', function () {
        var $parent = $(this).parents('.pagination');

        var href = $parent.find('.prev').attr('href');

        if (href !== undefined) {
            window.location.href = href;
        }
    });

    $('.pagination-nav--next').on('click', function () {
        var $parent = $(this).parents('.pagination');

        var href = $parent.find('.next').attr('href');

        if (href !== undefined) {
            window.location.href = href;
        }
    });

    $('.woocommerce--modern .woocommerce-product-gallery__trigger').append(anps.magnifier_icon);

    /*-----------------------------------------------------------------------------------*/
    /*	Quantity field
    /*-----------------------------------------------------------------------------------*/

    $('.quantity-field').append('<button type="button" class="quantity-field__button quantity-field__button--minus">-</button>');
    $('.quantity-field').append('<button type="button" class="quantity-field__button quantity-field__button--plus">+</button>');

    $('.quantity-field__button').on('click', function (e) {
        var field = $(this).parent().find('input'),
            val = parseInt(field.val(), 10),
            step = parseInt(field.attr('step'), 10) || 0,
            min = parseInt(field.attr('min'), 10) || 1,
            max = parseInt(field.attr('max'), 10) || 0;

        if ($(this).html() === '+' && (val < max || !max)) {
            /* Plus */
            field.val(val + step);
        } else if ($(this).html() === '-' && val > min) {
            /* Minus */
            field.val(val - step);
        }

        field.trigger('change');
    });

    if ($('.woocommerce--modern').length) {
        $('.single_add_to_cart_button').append(anps.add_to_cart_icon);
    }

    /* ----------------------------------------------------------------------------------- */
    /* Newsletter
    /* ----------------------------------------------------------------------------------- */

    $('.tnp-email').each(function () {
        $(this).attr('placeholder', $(this).parents('.tnp-field').find('label').text());
    });

    function tnpSize() {
        $('.tnp-email').css({
            paddingRight: $('.tnp-submit').innerWidth() + parseInt($('.tnp-email').css('padding-left')),
        });
    }

    $(window).on('resize', tnpSize);
    tnpSize();

    $('.tnp-field-button').on('click', function (e) {
        if (e.target.nodeName === 'DIV') {
            $(this).find('.tnp-button').click();
        }
    });

    $('.pricing__nav-link').on('click', function (e) {
        $(this).blur();
    });


    /* Recent Portfolio */

    function resetPagination(items, itemClass, perPage) {
        var pageTemp = 0;
        items.find(itemClass).removeClass('page-1 page-2 page-3 page-4 page-5 page-6 page-7 page-8 page-9 page-10');
        items.find(itemClass).each(function (index) {
            if (index % perPage === 0) {
                pageTemp += 1;
            }

            items.find(itemClass).eq(index).addClass('page-' + pageTemp);
        });
    }

    /* Projects (Isotope filtering) */
    window.onload = function () {
        $('.projects').each(function () {
            var items = $(this).find('.projects-content');
            var itemClass = '.projects-item';
            var filter = $(this).find('.projects-filter');
            var initialFilter = '';
            var hash = window.location.hash.replace('#', '');

            if (hash && filter.find('[data-filter="' + hash + '"]').length) {
                initialFilter = '.' + hash;
                filter.find('.selected').removeClass('selected');
                filter.find('[data-filter="' + hash + '"]').addClass('selected');
            }

            if ($(this).find('.projects-pagination').length) {
                var pageNum = 1;
                var perPage = items.attr('data-col');
                var numPages = Math.ceil(items.find(itemClass).length / perPage);

                if (window.innerWidth < 768) {
                    perPage = 2;
                }

                if (numPages < 2) {
                    $('.projects-pagination').hide();
                } else {
                    $('.projects-pagination').show();
                }

                $(window).on('resize', function () {
                    if (window.innerWidth < 768) {
                        perPage = 2;
                    } else {
                        perPage = items.attr('data-col');
                    }

                    filter.find('.selected').click();
                });

                resetPagination(items, itemClass, perPage);

                /* Layout */
                items.isotope({
                    itemSelector: itemClass,
                    layoutMode: 'fitRows',
                    filter: '.page-' + pageNum + initialFilter,
                    transitionDuration: '.3s',
                    hiddenStyle: {
                        opacity: 0,
                        transform: 'scale(1)'
                    },
                    visibleStyle: {
                        opacity: 1,
                        transform: 'scale(1)'
                    }
                });

                /* Filtering */
                filter.find('button').on('click', function (e) {
                    var value = $(this).attr('data-filter');
                    value = (value != '*') ? '.' + value : value;
                    pageNum = 1;

                    numPages = Math.ceil(items.find(itemClass + value).length / perPage);

                    if (numPages < 2) {
                        $('.projects-pagination').hide();
                    } else {
                        $('.projects-pagination').show();
                    }

                    resetPagination(items, itemClass + value, perPage)
                    items.isotope({ filter: value + '.page-1' });

                    /* Change select class */
                    filter.find('.selected').removeClass('selected');
                    $(this).addClass('selected');
                });

                $('.projects-pagination button').on('click', function () {
                    var value = $('.projects-filter .selected').attr('data-filter');
                    value = (value != '*') ? '.' + value : value;

                    if ($(this).hasClass('prev')) {
                        if (pageNum - 1 == 0) {
                            pageNum = numPages;
                        } else {
                            pageNum -= 1;
                        }
                    } else {
                        if (pageNum + 1 > numPages) {
                            pageNum = 1;
                        } else {
                            pageNum += 1;
                        }
                    }

                    items.isotope({ filter: value + '.page-' + pageNum });
                });
            } else {
                /* Layout */
                items.isotope({
                    itemSelector: itemClass,
                    layoutMode: 'fitRows',
                    filter: initialFilter,
                });

                /* Filtering */
                filter.find('button').on('click', function (e) {
                    var value = $(this).attr('data-filter');
                    value = (value != '*') ? '.' + value : value;

                    items.isotope({ filter: value });

                    /* Change select class */
                    filter.find('.selected').removeClass('selected');
                    $(this).addClass('selected');
                });
            }
        });
    }

    $('.post-password-form input[type="submit"]').addClass('btn btn-sm style-1');
});
