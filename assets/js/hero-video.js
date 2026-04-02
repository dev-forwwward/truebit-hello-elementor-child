( function () {
    function initHeroVideos() {
        document.querySelectorAll( '.truebit-hero-video-wrapper' ).forEach( function ( wrapper ) {
            var intro = wrapper.querySelector( '.truebit-hero-intro' );
            var loop  = wrapper.querySelector( '.truebit-hero-loop' );

            if ( ! intro || ! loop ) return;

            /* ── Intro: block autoplay, delay start by 1s ── */
            var allowPlay = false;

            intro.removeAttribute( 'autoplay' );
            intro.autoplay = false;
            intro.pause();
            intro.currentTime = 0;
            intro.muted     = true;
            intro.playsInline = true;

            // Override play() so any early browser-triggered calls are blocked
            var originalPlay = intro.play.bind( intro );
            intro.play = function () {
                if ( ! allowPlay ) return Promise.resolve();
                return originalPlay();
            };

            setTimeout( function () {
                allowPlay = true;
                intro.play().catch( function () {} );
            }, 1000 );

            /* ── Loop: crossfade trigger ── */
            var triggered = false;

            intro.addEventListener( 'timeupdate', function () {
                if ( triggered ) return;
                if ( ! intro.duration ) return;

                if ( intro.currentTime >= intro.duration - 1.0 ) {
                    triggered = true;
                    loop.style.opacity       = '1';
                    loop.style.pointerEvents = '';
                    intro.style.opacity      = '0';
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
