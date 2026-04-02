( function () {
    function initHeroVideos() {
        document.querySelectorAll( '.truebit-hero-video-wrapper' ).forEach( function ( wrapper ) {
            var loopSrc = wrapper.dataset.loopSrc;
            if ( ! loopSrc ) return;

            var video = wrapper.querySelector( '.truebit-hero-video' );
            if ( ! video ) return;

            video.addEventListener( 'ended', function handler() {
                video.removeEventListener( 'ended', handler );
                video.src = loopSrc;
                video.loop = true;
                video.play();
            } );
        } );
    }

    if ( document.readyState === 'loading' ) {
        document.addEventListener( 'DOMContentLoaded', initHeroVideos );
    } else {
        initHeroVideos();
    }

    // Re-init after Elementor frontend renders (editor preview)
    if ( window.elementorFrontend ) {
        window.elementorFrontend.hooks.addAction( 'frontend/element_ready/truebit_hero_video.default', initHeroVideos );
    }
} )();
