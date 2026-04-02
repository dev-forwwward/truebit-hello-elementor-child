<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * https://developers.elementor.com/docs/hello-elementor-theme/
 *
 * @package HelloElementorChild
 */

 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_CHILD_VERSION', '1.0.0' );

/**
 * Enqueue child theme styles
 */
function hello_elementor_child_enqueue_styles() {
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'hello-elementor-theme-style' ), // Make sure it loads after the parent
		HELLO_ELEMENTOR_CHILD_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_styles', 20 );

function hello_child_enqueue_admin_style() {
    wp_enqueue_style(
		'hello-elementor-child-style',
        get_stylesheet_directory_uri() . '/admin-style.css',
        [],
        filemtime(get_stylesheet_directory() . '/admin-style.css')
    );
}
add_action('admin_enqueue_scripts', 'hello_child_enqueue_admin_style');

function my_enqueue_swiper_assets() {
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'my_enqueue_swiper_assets');

/* ######################################################## */
/*                  FORWWWARD STUDIO - code                 */
/* ######################################################## */

// ADMIN CSS
// function my_admin_style() {
//   wp_enqueue_style( 'admin-style', get_stylesheet_directory_uri() . '/admin-style.css' );
// }
// add_action( 'admin_enqueue_scripts', 'my_admin_style');

// This disables the automatic downscaling
add_filter( 'big_image_size_threshold', '__return_false' );


//ADD a class to a specific page template

function custom_class( $classes ) {
    if ( is_page_template( 'post-page-template.php' ) ) {
        $classes[] = 'truebit-post';
    }
    return $classes;
}
add_filter( 'body_class', 'custom_class' );

function custom_class_case( $classes ) {
    if ( is_page_template( 'case-study-page-template.php' ) || is_page_template( 'case-study-page-template-v2.php' ) ) {
        $classes[] = 'truebit-case-study';
    }
    return $classes;
}
add_filter( 'body_class', 'custom_class_case' );

function fwd_add_custom_body_class( $classes ) {
    if ( is_category() || is_search() ) {
        $classes[] = 'fwd-menu-transparent';
    }
    return $classes;
}
add_filter( 'body_class', 'fwd_add_custom_body_class' );

// ONLY SHOW PAGES ON - RESULTS PAGE
if (!is_admin()) {
    function mv_search_filter($query) {
    if ($query->is_search) {
    $query->set('post_type', array( 'post','product'));
    }
    return $query;
    }
    add_filter('pre_get_posts','mv_search_filter');
}


// ADD Font Awesome - Custom
function add_font_awesome() {
    wp_enqueue_style( 'font-awesome-2', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css' );
}
add_action( 'wp_enqueue_scripts', 'add_font_awesome' );

/* ######################################################## */
/*               FORWWWARD STUDIO - Features                */
/* ######################################################## */
add_filter( 'body_class', 'custom_body_class' );
/**
 * Add custom field body class(es) to the body classes.
 *
 * It accepts values from a per-page custom field, and only outputs when viewing a singular static Page.
 *
 * @param array $classes Existing body classes.
 * @return array Amended body classes.
 */
function custom_body_class( array $classes ) {
	$new_class = is_page() ? get_post_meta( get_the_ID(), 'body_class', true ) : null;

	if ( $new_class ) {
		$classes[] = $new_class;
	}

	return $classes;
}

// function remove_h1_from_heading_block_editor_script() {
//     ? >
//     <script>
//     wp.domReady(() => {
//         // Target heading blocks only
//         const allowedLevels = [2, 3, 4, 5, 6];

//         wp.blocks.registerBlockVariation('core/heading', {
//             name: 'no-h1',
//             isDefault: true,
//             attributes: {
//                 level: 2,
//             },
//             scope: ['block'],
//             edit(props) {
//                 const { level } = props.attributes;

//                 // Force downgrade from h1 to h2
//                 if (level === 1) {
//                     props.setAttributes({ level: 2 });
//                 }

//                 return wp.element.createElement(
//                     wp.blockEditor.BlockControls,
//                     {},
//                     wp.element.createElement(
//                         wp.blockEditor.ToolbarGroup,
//                         {},
//                         wp.element.createElement(
//                             wp.blockEditor.ToolbarDropdownMenu,
//                             {
//                                 icon: 'heading',
//                                 label: 'Select heading level',
//                                 controls: allowedLevels.map((lvl) => ({
//                                     title: 'Heading ' + lvl,
//                                     isActive: lvl === props.attributes.level,
//                                     onClick: () => props.setAttributes({ level: lvl })
//                                 }))
//                             }
//                         )
//                     ),
//                     wp.element.createElement(
//                         wp.blockEditor.RichText,
//                         {
//                             tagName: 'h' + props.attributes.level,
//                             className: props.className,
//                             value: props.attributes.content,
//                             onChange: (content) => props.setAttributes({ content }),
//                             placeholder: 'Heading…'
//                         }
//                     )
//                 );
//             }
//         });
//     });
//     </script>
//     <?php
// }
// add_action('admin_footer', 'remove_h1_from_heading_block_editor_script');

// function strip_h1_from_saved_content($content) {
//     return preg_replace('/<h1\b[^>]*>(.*?)<\/h1>/is', '<p>$1</p>', $content);
// }
// add_filter('content_save_pre', 'strip_h1_from_saved_content');

/* ######################################################## */
/*            FORWWWARD STUDIO - Security Fixes             */
/* ######################################################## */

// The following was moved to the .htaccess file for better efficiency

// Using /?author=1 Query Parameter
function redirect_to_home_if_author_parameter() {

    $is_author_set = get_query_var( 'author', '' );
    if ( $is_author_set != '' && !is_admin()) {
        wp_redirect( home_url(), 301 );
        exit;
    }
}
add_action( 'template_redirect', 'redirect_to_home_if_author_parameter' );


// Using WordPress JSON REST Endpoints
function disable_rest_endpoints ( $endpoints ) {
    if ( isset( $endpoints['/wp/v2/users'] ) ) {
        unset( $endpoints['/wp/v2/users'] );
    }
    if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
        unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
    }
    return $endpoints;
}
add_filter( 'rest_endpoints', 'disable_rest_endpoints');


// Disable author archives
// function disable_author_archives() {
//     global $wp_query;

//     if (is_author()) {
//         $wp_query->set_404();
//         status_header(404);
//         nocache_headers();
//     }
// }
// add_action('template_redirect', 'disable_author_archives');


if (!is_admin()) {
    // default URL format
    if (preg_match('/author=([0-9]*)/i', $_SERVER['QUERY_STRING'])) die();
    add_filter('redirect_canonical', 'shapeSpace_check_enum', 10, 2);
}

function shapeSpace_check_enum($redirect, $request) {
    // permalink URL format
    if (preg_match('/\?author=([0-9]*)(\/*)/i', $request)) die();
    else return $redirect;
}

// Disable iframes on other domains pages
function block_frames() {
    header( 'X-FRAME-OPTIONS: SAMEORIGIN' );
}
add_action( 'send_headers', 'block_frames', 10 );


function my_custom_slider_output() {
    $groups = [
        [
            'overline' => 'Traditional',
            'title'    => 'Centralized Systems',
            'cards' => [
                [
                    'icon'  => '/wp-content/uploads/2025/06/01-card-icon.svg',
                    'title' => 'Closed Assets',
                    'desc'  => 'Assets controlled by central institutions with limited transparency',
                    'theme' => 'dark'
                ],
                [
                    'icon'  => '/wp-content/uploads/2025/06/01-card-icon.svg',
                    'title' => 'Walled Data',
                    'desc'  => 'Data trapped in organizational boundaries with restricted access',
                    'theme' => 'dark'
                ],
                [
                    'icon'  => '/wp-content/uploads/2025/06/01-card-icon.svg',
                    'title' => 'Fragmented Value',
                    'desc'  => 'Supply chains requiring multiple trusted intermediaries',
                    'theme' => 'dark'
                ]
            ]
        ],
        [
            'overline' => 'Truebit today',
            'title'    => 'Verified Economy',
            'cards' => [
                [
                    'icon'  => '/wp-content/uploads/2025/06/02-card-icon.svg',
                    'title' => 'Verified Tokenized Assets',
                    'desc'  => 'Real world assets with immutable proof of authenticity, ownership and value',
                    'theme' => 'green'
                ],
                [
                    'icon'  => '/wp-content/uploads/2025/06/03-card-icon.svg',
                    'title' => 'Provable Data',
                    'desc'  => 'Data with verifiability and tamper-evident processing',
                    'theme' => 'green'
                ],
                [
                    'icon'  => '/wp-content/uploads/2025/06/04-card-icon.svg',
                    'title' => 'Transparent Value',
                    'desc'  => 'End-to-end verified data across organizational boundaries',
                    'theme' => 'green'
                ]
            ]
        ],
        [
            'overline' => 'The Future',
            'title'    => 'Verified Society',
            'cards' => [
                [
                    'icon'  => '/wp-content/uploads/2025/06/02-card-icon.svg',
                    'title' => 'Autonomous Tokenized Assets',
                    'desc'  => 'Self-verifying assets that automatically prove their integrity',
                    'theme' => 'light'
                ],
                [
                    'icon'  => '/wp-content/uploads/2025/06/02-card-icon.svg',
                    'title' => 'Sovereign Data',
                    'desc'  => 'Individual ownership of data with built-in verification',
                    'theme' => 'light'
                ],
                [
                    'icon'  => '/wp-content/uploads/2025/06/02-card-icon.svg',
                    'title' => 'Trustless Value Chains',
                    'desc'  => 'Frictionless global value exchange without intermediaries',
                    'theme' => 'light'
                ]
            ]
        ]
    ];

    ob_start();
    ?>
    <section class="grouped-swiper-section">
        <div class="swiper grouped-swiper">
            <div class="swiper-wrapper">
                <?php foreach ($groups as $group): ?>
                    <div class="swiper-slide group-slide">
                        <div class="group-header">
                            <span class="slide-overline"><?php echo esc_html($group['overline']); ?></span>
                            <div class="title_wrapper">
                                <div class="slide-title"><?php echo esc_html($group['title']); ?></div>
                                <div class="title-line"></div>
                            </div>
                        </div>
                        <div class="group-cards">
                            <?php foreach ($group['cards'] as $card): ?>
                                <div class="card <?php echo $card['theme']; ?>">
                                    <div class="card-top">
                                        <img src="<?php echo esc_url($card['icon']); ?>" alt="">
                                    </div>
                                    <div class="card-bottom">
                                        <div class="card-title"><?php echo esc_html($card['title']); ?></div>
                                        <p class="card-desc"><?php echo esc_html($card['desc']); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="swiper-navigation">
            <button class="swiper-button-prev" aria-label="Previous">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 8H1M1 8L8 1M1 8L8 15" stroke="#ECF0F3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <button class="swiper-button-next" aria-label="Next">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 8H15M15 8L8 1M15 8L8 15" stroke="#ECF0F3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

            </button>
        </div>

        <style>
        .swiper.grouped-swiper {
            overflow: visible !important;
              padding-right: 0;
  margin-right: 0;
        }

        .grouped-swiper .swiper-wrapper {
            display: flex;
            align-items: flex-start;
            scroll-behavior: smooth;
            padding-right: 1px; /* eliminates leftover scroll width */
        }

        .group-slide {
            width: auto;
            flex-shrink: 0;
            scroll-snap-align: start;
            margin-right: 3rem;
        }

        @media (max-width: 768px) {
            .group-slide {
                margin-right: 1.5rem;
            }
        }

        .group-slide:last-child {
            margin-right: 0 !important;
        }

        .group-slide:last-child .card:last-child{
            margin-right: 0 !important;
        }

        .group-header {
            margin-bottom: 1.25rem;
        }

        .title_wrapper {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .section-title {
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        .slide-title-line {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .slide-overline {
            color: #767D84;
            font-size: 1rem;
        }

        .slide-title {
            color: #ffffff;
            margin: 0;
            font-size: 1.25rem;
            /* display: inline-block; */
        }

        .title-line {
            flex-grow: 1;
            height: 1px;
            background: #66676E;
            margin: 0 2.5rem;
        }

        .group-cards {
            display: flex;
            gap: 1rem;
        }

        .card {
            width: 240px;
            height: 260px;
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            flex-direction: column;
        }

        .card.dark {
            background: #1E1F24;
            color: #fff;
            border: 1px solid #000000;
        }

        .card.green {
            background: #50f2ae;
            color: #000;
        }

        .card.light {
            background: #ffffff;
            color: #000;
        }

        .card-icon {
            width: 32px;
            height: 32px;
            margin-bottom: 1rem;
        }

        .card-icon img {
            width: 100%;
            height: auto;
            display: block;
        }

        .card-title {
            margin: 0 0 0.5rem;
            font-size: 1.25rem;
            font-weight: 600;
            line-height: 120%;
        }

        .card-desc {
            font-size: 0.875rem;
            line-height: 1.4;
            margin-top: 0;
        }

        @media (min-width: 1026px) {
            .card-desc {
                max-height: 0;
                /* opacity: 0; */
                overflow: hidden;
                transition: all 0.5s ease-in-out;
            }
        }

        /* 🖱️ Reveal on hover, desktop only */
        @media (hover: hover) and (pointer: fine) {
            .card:hover .card-desc {
                /* opacity: 1; */
                max-height: 200px; /* big enough for longest description */
                /* margin-top: 1rem; */
            }
        }

        .swiper-navigation {
            display: flex;
            gap: 2rem;
            justify-content: flex-end;
            margin-top: 2rem;
        }

        .swiper-button-prev,
        .swiper-button-next {
            position: relative;
            background: none;
            color: #fff;
            cursor: pointer;
            transition: background 0.2s ease;
            border: 0;
            padding: 0;
            top: unset;
            margin: 0;
            height: unset;
        }

        .swiper-button-prev:hover,
        .swiper-button-next:hover,
        .swiper-button-prev:focus,
        .swiper-button-next:focus {
            background: transparent;
        }

        .swiper-button-prev:after,
        .swiper-button-next:after {
            content: unset;
        }

        .swiper-button-next svg, .swiper-button-prev svg {
            width: 16px;
            height: 16px
        }

        </style>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Swiper('.grouped-swiper', {
                slidesPerView: 'auto',
                spaceBetween: 0,
                freeMode: true,
                mousewheel: {
                    forceToAxis: true, // allows only horizontal scrolling
                    releaseOnEdges: true
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                },
            });
        });
        </script>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('my_custom_slider', 'my_custom_slider_output');

// Register Image Accordion widget assets
add_action( 'wp_enqueue_scripts', function () {
	wp_register_style(
		'fwd-image-accordion',
		get_stylesheet_directory_uri() . '/assets/fwd-image-accordion.css',
		[],
		filemtime( get_stylesheet_directory() . '/assets/fwd-image-accordion.css' )
	);
	wp_register_script(
		'fwd-image-accordion',
		get_stylesheet_directory_uri() . '/assets/fwd-image-accordion.js',
		[],
		filemtime( get_stylesheet_directory() . '/assets/fwd-image-accordion.js' ),
		true
	);
} );

// Register the custom Elementor widget
add_action( 'elementor/widgets/register', function ( $widgets_manager ) {
	require_once get_stylesheet_directory() . '/widgets/class-image-accordion-widget.php';
	$widgets_manager->register( new FWD_Image_Accordion_Widget() );
} );


/* ─── Register Custom Elementor Widgets ─── */
add_action( 'elementor/widgets/register', function ( $widgets_manager ) {

    // Image Accordion (if it exists)
    $accordion_file = get_stylesheet_directory() . '/widgets/class-image-accordion-widget.php';
    if ( file_exists( $accordion_file ) ) {
        require_once $accordion_file;
        if ( class_exists( 'Truebit_Image_Accordion_Widget' ) ) {
            $widgets_manager->register( new \Truebit_Image_Accordion_Widget() );
        }
    }

    // Features Slider
    require_once get_stylesheet_directory() . '/widgets/class-features-slider-widget.php';
    $widgets_manager->register( new \Truebit_Features_Slider_Widget() );

    // Posts Slider
    require_once get_stylesheet_directory() . '/widgets/class-posts-slider-widget.php';
    $widgets_manager->register( new \Truebit_Posts_Slider_Widget() );

    // Hero Video
    require_once get_stylesheet_directory() . '/widgets/class-hero-video-widget.php';
    $widgets_manager->register( new \Truebit_Hero_Video_Widget() );
});

/* ─── Enqueue Swiper + Widget Assets ─── */
add_action( 'wp_enqueue_scripts', function () {
    // Only load if Elementor is active
    if ( ! did_action( 'elementor/loaded' ) ) return;

    // Swiper (CDN)
    wp_register_style(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        [],
        '11.0'
    );
    wp_register_script(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        [],
        '11.0',
        true
    );

    // Features Slider widget assets
    wp_register_style(
        'truebit-features-slider',
        get_stylesheet_directory_uri() . '/assets/css/features-slider.css',
        [ 'swiper' ],
        filemtime( get_stylesheet_directory() . '/assets/css/features-slider.css' )
    );
    wp_register_script(
        'truebit-features-slider',
        get_stylesheet_directory_uri() . '/assets/js/features-slider.js',
        [ 'swiper' ],
        filemtime( get_stylesheet_directory() . '/assets/js/features-slider.js' ),
        true
    );

    // Posts Slider widget assets
    wp_register_style(
        'truebit-posts-slider',
        get_stylesheet_directory_uri() . '/assets/css/posts-slider.css',
        [ 'swiper' ],
        filemtime( get_stylesheet_directory() . '/assets/css/posts-slider.css' )
    );
    wp_register_script(
        'truebit-posts-slider',
        get_stylesheet_directory_uri() . '/assets/js/posts-slider.js',
        [ 'swiper' ],
        filemtime( get_stylesheet_directory() . '/assets/js/posts-slider.js' ),
        true
    );

    // Hero Video widget assets
    wp_register_style(
        'truebit-hero-video',
        get_stylesheet_directory_uri() . '/assets/css/hero-video.css',
        [],
        filemtime( get_stylesheet_directory() . '/assets/css/hero-video.css' )
    );
    wp_register_script(
        'truebit-hero-video',
        get_stylesheet_directory_uri() . '/assets/js/hero-video.js',
        [],
        filemtime( get_stylesheet_directory() . '/assets/js/hero-video.js' ),
        true
    );
});

/* ─── Also load in Elementor Editor Preview ─── */
add_action( 'elementor/preview/enqueue_scripts', function () {
    wp_enqueue_style( 'swiper' );
    wp_enqueue_script( 'swiper' );
    wp_enqueue_style( 'truebit-features-slider' );
    wp_enqueue_script( 'truebit-features-slider' );
    wp_enqueue_style( 'truebit-posts-slider' );
    wp_enqueue_script( 'truebit-posts-slider' );
    wp_enqueue_style( 'truebit-hero-video' );
    wp_enqueue_script( 'truebit-hero-video' );
});

/* ─── Posts Mobile Slider (CSS class helper) ─── */
add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'posts-mobile-slider',
        get_stylesheet_directory_uri() . '/assets/css/posts-mobile-slider.css',
        [],
        filemtime( get_stylesheet_directory() . '/assets/css/posts-mobile-slider.css' )
    );
    wp_enqueue_script(
        'posts-mobile-slider',
        get_stylesheet_directory_uri() . '/assets/js/posts-mobile-slider.js',
        [],
        filemtime( get_stylesheet_directory() . '/assets/js/posts-mobile-slider.js' ),
        true
    );

    // GSAP + plugins required by hero-char-reveal.js - tested with GSAP 3.13.0
    wp_enqueue_script(
        'gsap',
        'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/gsap.min.js',
        [],
        '3.13.0',
        true
    );
    wp_enqueue_script(
        'gsap-scrolltrigger',
        'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/ScrollTrigger.min.js',
        [ 'gsap' ],
        '3.13.0',
        true
    );
    wp_enqueue_script(
        'gsap-splittext',
        'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/SplitText.min.js',
        [ 'gsap' ],
        '3.13.0',
        true
    );
    wp_enqueue_script(
        'hero-char-reveal',
        get_stylesheet_directory_uri() . '/assets/js/hero-char-reveal.js',
        [ 'gsap', 'gsap-scrolltrigger', 'gsap-splittext' ],
        filemtime( get_stylesheet_directory() . '/assets/js/hero-char-reveal.js' ),
        true
    );
} );



