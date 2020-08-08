jQuery(document).ready(function ($) {
    $(document.body).removeClass('no-js').addClass('js');

    initPolyfills();

    // Utilities
    initClassToggle();
    initAnchorScroll();

    // CF7 Form Control
    //initCF7();
    //initFullheightMobile();

    initMap();
    initBacktoTop();
    initMenu();
});

// Initialize and add the map
function initMap() {
    // The location of Uluru
    var uluru = {
        lat: 39.9725341,
        lng: 116.3183093
    };
    // The map, centered at Uluru
    var map = new google.maps.Map(
        document.getElementById('map'), {
            zoom: 13,
            center: uluru
        });
    // The marker, positioned at Uluru
    var marker = new google.maps.Marker({
        position: uluru,
        map: map
    });
}


function isMobile() {
    return window.matchMedia('(max-width:767px)').matches;
}

function initPolyfills() {
    // CSS object-fit for IE
    objectFitImages();

    // polyfill for IE - startsWith
    if (!String.prototype.startsWith) {
        String.prototype.startsWith = function (searchString, position) {
            position = position || 0;
            return this.indexOf(searchString, position) === position;
        };
    }

    // polyfill for IE - forEach
    if ('NodeList' in window && !NodeList.prototype.forEach) {
        NodeList.prototype.forEach = function (callback, thisArg) {
            thisArg = thisArg || window;
            for (var i = 0; i < this.length; i++) {
                callback.call(thisArg, this[i], i, this);
            }
        };
    }
}


/**
 * Toggle class on click
 */
function initClassToggle() {
    $(document.body).on('click', '[data-toggle="class"][data-class]', function (event) {
        var $trigger = $(this);
        var $target = $($trigger.data('target') ? $trigger.data('target') : $trigger.attr('href'));

        if ($target.length) {
            event.preventDefault();
            $target.toggleClass($trigger.data('class'));
            $trigger.toggleClass('classed');
        }
    });
}


/**
 * Smooth anchor scrolling
 */
function initAnchorScroll() {
    $('a[href*="#"]:not([data-toggle])').click(function (event) {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name="' + this.hash.slice(1) + '"]');
            if (target.length && !target.parents('.woocommerce-tabs').length) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 1000);
            }
        }
    });
}

function initBacktoTop() {
    var btn = $('#back_to_top');


    document.body.addEventListener('scroll', function(){
        if (document.body.scrollTop > 300) {
            btn.addClass('show');
        } else {
            btn.removeClass('show');
        }
    });


    btn.on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        }, '300');
    });


}

// function initCF7(){
//     var wpcf7Elm = $('.wpcf7-form')[0];
//     var formbtn = $('.wpcf7-form input[type="submit"]');

//     formbtn.on('click', function(){
//         formbtn.val('SENDING...');
//     });

//     document.addEventListener( 'wpcf7invalid', function( event ) {
//         formbtn.val('SUBMIT');
//     }, false );

//     document.addEventListener( 'wpcf7mailsent', function( event ) {
//         formbtn.val('SENT!');
//     }, false );
// }

/*function initFullheightMobile() {
    // Fix mobile 100vh change on address bar show/hide
    var lastHeight = $(window).height();
    var heightChangeTimeout = undefined;
    if(isMobile()) {
        $('.vh').css('height', lastHeight);
    }
    (maybe_update_landing_height = function() {
        var winHeight = $(window).height();

        if(heightChangeTimeout !== undefined) {
            clearTimeout(heightChangeTimeout);
        }

        if(!isMobile()) {
            $('.vh').css('height', '');
        }
        else if(Math.abs(winHeight - lastHeight) > 100) {
            heightChangeTimeout = setTimeout(function() {
                var winHeight = $(window).height();
                $('.vh').css('height', winHeight);
                lastHeight = winHeight;
            }, 50);
        }
    })();
    $(window).resize(maybe_update_landing_height);
}*/

/*function initCopyToClipboard() {
  $(document.body).on('click', '[data-copy-to-clipboard]', function(event) {
    event.preventDefault();

    // Source: https://hackernoon.com/copying-text-to-clipboard-with-javascript-df4d4988697f
    var el = document.createElement('textarea');
    el.value = $(this).data('copy-to-clipboard');
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
  });
}*/

function initMenu() {
    $(".e-mobile-menu__main-menu>ul>li>a").on("click", document, function () {
        $(".e-mobile-menu-input").prop("checked", false)
        $(".e-mobile-menu__wrapper").prop("height", 0);
    });
}