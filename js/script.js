/*
Author       : Code-Theme
Template Name: Interior - HTML Template
Version      : 1.1
*/

(function ($) {

    /*----------------------------------
    //------ JQUERY SCROOLTOP ------//
    -----------------------------------*/
    var go = $(".go-up");
    $(window).on('scroll', function () {
        var scrolltop = $(this).scrollTop();
        if (scrolltop >= 50) {
            go.fadeIn();
        } else {
            go.fadeOut();
        }
    });



    /*----------------------------------
    //------ SMOOTHSCROLL ------//
    -----------------------------------*/
    smoothScroll.init({
        speed: 1000, // Integer. How fast to complete the scroll in milliseconds
        offset: 55, // Integer. How far to offset the scrolling anchor location in pixels

    });

    /*---------------------------------
     //------ Rev Slider ------//
     ----------------------------------*/
    var tpj = jQuery;
    var revapi26;
    if (tpj("#rev_slider_26_1").revolution === undefined) {
        revslider_showDoubleJqueryError("#rev_slider_26_1");
    } else {
        revapi26 = tpj("#rev_slider_26_1").show().revolution({
            sliderType: "standard",
            jsFileLocation: "revolution/js/",
            sliderLayout: "fullscreen",
            dottedOverlay: "none",
            delay: 9000,
            navigation: {
                keyboardNavigation: "off",
                keyboard_direction: "horizontal",
                mouseScrollNavigation: "off",
                mouseScrollReverse: "default",
                onHoverStop: "off",
                touch: {
                    touchenabled: "on",
                    touchOnDesktop: "off",
                    swipe_threshold: 75,
                    swipe_min_touches: 1,
                    swipe_direction: "horizontal",
                    drag_block_vertical: false
                },
                arrows: {
                    style: "uranus",
                    enable: true,
                    hide_onmobile: true,
                    hide_under: 778,
                    hide_onleave: false,
                    tmp: '',
                    left: {
                        h_align: "left",
                        v_align: "center",
                        h_offset: 15,
                        v_offset: 0
                    },
                    right: {
                        h_align: "right",
                        v_align: "center",
                        h_offset: 15,
                        v_offset: 0
                    }
                },
                bullets: {
                    enable: true,
                    hide_onmobile: false,
                    style: "bullet-bar",
                    hide_onleave: false,
                    direction: "horizontal",
                    h_align: "center",
                    v_align: "bottom",
                    h_offset: 0,
                    v_offset: 30,
                    space: 5,
                    tmp: ''
                }
            },
            responsiveLevels: [1240, 1024, 778, 480],
            visibilityLevels: [1240, 1024, 778, 480],
            gridwidth: [1240, 1024, 778, 480],
            gridheight: [868, 768, 960, 720],
            lazyType: "none",
            parallax: {
                type: "scroll",
                origo: "slidercenter",
                speed: 2000,
                levels: [5, 10, 15, 20, 25, 30, 35, 40, 45, 46, 47, 48, 49, 50, 51, 55],
            },
            shadow: 0,
            spinner: "off",
            stopLoop: "off",
            stopAfterLoops: -1,
            stopAtSlide: -1,
            shuffle: "off",
            autoHeight: "off",
            fullScreenAutoWidth: "off",
            fullScreenAlignForce: "off",
            fullScreenOffsetContainer: "",
            fullScreenOffset: "60px",
            hideThumbsOnMobile: "off",
            hideSliderAtLimit: 0,
            hideCaptionAtLimit: 0,
            hideAllCaptionAtLilmit: 0,
            debugMode: false,
            fallbacks: {
                simplifyAll: "off",
                nextSlideOnWindowFocus: "off",
                disableFocusListener: false,
            }
        });
    }

    /*----------------------------------
    //------ LIGHTCASE ------//
    -----------------------------------*/
    $('a[data-rel^=lightcase]').lightcase();


    /*----------------------------------
    //------ ISOTOPE GALLERY ------//
    -----------------------------------*/
    /* activate jquery isotope */
    $(window).on('load', function () {
        var $container = $('.portfolio-items').isotope({
            itemSelector: '.item',
            masonry: {
                columnWidth: '.col-sm-6'
            }
        });
    });
    // bind filter button click
    var filters = $('.filters-group ul li');
    filters.on('click', function () {
        filters.removeClass('active');
        $(this).addClass('active');
        var filterValue = $(this).attr('data-filter');
        // use filterFn if matches value
        $('.portfolio-items').isotope({
            filter: filterValue
        });
    });

    /*----------------------------------
    //------ OWL CAROUSEL ------//
    -----------------------------------*/
    $('.style1').owlCarousel({
        loop: true,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 5000,
        responsive: {
            0: {
                items: 1
            },
            400: {
                items: 1,
                margin: 20
            },
            500: {
                items: 1,
                margin: 20
            },
            768: {
                items: 2,
                margin: 20
            },
            991: {
                items: 2,
                margin: 20
            },
            1000: {
                items: 3,
                margin: 20
            }
        }
    });

    $('.style2').owlCarousel({
        loop: true,
        margin: 0,
        dots: false,
        autoWidth: false,
        autoplay: true,
        autoplayTimeout: 5000,
        responsive: {
            0: {
                items: 2,
                margin: 20
            },
            400: {
                items: 2,
                margin: 20
            },
            500: {
                items: 3,
                margin: 20
            },
            768: {
                items: 4,
                margin: 20
            },
            992: {
                items: 5,
                margin: 20
            },
            1000: {
                items: 6,
                margin: 20
            }
        }
    });

    /*----------------------------------
    //------ JQUERY SCROOLTOP ------//
    -----------------------------------*/
    var go = $(".go-up");
    $(window).on('scroll', function () {
        var scrolltop = $(this).scrollTop();
        if (scrolltop >= 50) {
            go.fadeIn();
        } else {
            go.fadeOut();
        }
    });


    /*---------------------------------
     //------ PRELOADER ------//
     ----------------------------------*/
    $('#status').fadeOut();
    $('#preloader').delay(200).fadeOut('slow');

})(jQuery);
