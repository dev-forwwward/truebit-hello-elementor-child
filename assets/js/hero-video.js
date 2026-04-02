( function () {
    function initHeroVideos() {
        document.querySelectorAll( '.truebit-hero-video-wrapper' ).forEach( function ( wrapper ) {
            var intro = wrapper.querySelector( '.truebit-hero-intro' );
            var loop  = wrapper.querySelector( '.truebit-hero-loop' );

            if ( ! intro || ! loop ) return;

            var triggered = false;

            intro.addEventListener( 'timeupdate', function () {
                if ( triggered ) return;
                if ( ! intro.duration ) return;

                // Fire 20ms before the intro ends
                if ( intro.currentTime >= intro.duration - 1.0 ) {
                    triggered = true;
                    loop.style.opacity      = '1';
                    loop.style.pointerEvents = '';
                    intro.style.opacity     = '0';
                    loop.play();
                }
            } );
        } );
    }

    if ( document.readyState === 'loading' ) {
        document.addEventListener( 'DOMContentLoaded', initHeroVideos );
    } else {
        initHeroVideos();
    }

    if ( window.elementorFrontend ) {
        window.elementorFrontend.hooks.addAction( 'frontend/element_ready/truebit_hero_video.default', initHeroVideos );
    }
} )();
