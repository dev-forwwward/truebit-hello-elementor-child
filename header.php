<?php
/**
 * The template for displaying the header
 *
 * This is the template that displays all of the <head> section, opens the <body> tag and adds the site's header.
 *
 * @package HelloElementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$viewport_content = apply_filters( 'hello_elementor_viewport_content', 'width=device-width, initial-scale=1' );
$enable_skip_link = apply_filters( 'hello_elementor_enable_skip_link', true );
$skip_link_url = apply_filters( 'hello_elementor_skip_link_url', '#content' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="<?php echo esc_attr( $viewport_content ); ?>">
	<link rel="profile" href="https://gmpg.org/xfn/11">
    <style>
        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 100%;
            background-color: #1E1F24;
            /* background-color: transparent;
            background-image: linear-gradient(180deg, #12232A 0%, #0F1517 100%); */
            opacity: 1;
            pointer-events: none;
            z-index: 9999999;
            transition: opacity .5s ease;
        }
        body.overlay-hidden::after {
            opacity: 0;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            setTimeout(() => {
                document.body.classList.add("overlay-hidden");
            }, 1500);  //1s delay + 1s transition
            //}, 500);  1s delay + 1s transition
        });

        // // video autoplay handling
        // (function () {

        //     let allowPlay = false;

        //     function handleVideo($scope) {

        //         const video = $scope[0].querySelector('.hero-video video');
        //         if (!video) return;

        //         // remove native autoplay
        //         video.removeAttribute('autoplay');
        //         video.autoplay = false;

        //         video.pause();
        //         video.currentTime = 0;
        //         video.muted = true;
        //         video.playsInline = true;

        //         // block early play calls
        //         const originalPlay = video.play.bind(video);
        //         video.play = function () {
        //         if (!allowPlay) return Promise.resolve();
        //         return originalPlay();
        //         };

        //         // delayed start
        //         setTimeout(() => {
        //         allowPlay = true;
        //         video.play().catch(()=>{});
        //         }, 100);

        //     }

        //     // Elementor lifecycle
        //     window.addEventListener('elementor/frontend/init', () => {

        //         elementorFrontend.hooks.addAction(
        //         'frontend/element_ready/video.default',
        //         handleVideo
        //         );

        //     });

        // })();

    </script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="site">
<?php wp_body_open(); ?>

<?php if ( $enable_skip_link ) { ?>
<a class="skip-link screen-reader-text" href="<?php echo esc_url( $skip_link_url ); ?>"><?php echo esc_html__( 'Skip to content', 'hello-elementor' ); ?></a>
<?php } ?>

<?php
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
	if ( hello_elementor_display_header_footer() ) {
		if ( did_action( 'elementor/loaded' ) && hello_header_footer_experiment_active() ) {
			get_template_part( 'template-parts/dynamic-header' );
		} else {
			get_template_part( 'template-parts/header' );
		}
	}
}
