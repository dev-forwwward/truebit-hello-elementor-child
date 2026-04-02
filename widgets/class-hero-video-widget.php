<?php
/**
 * Hero Video Widget — plays an intro video once, then loops a second video.
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Truebit_Hero_Video_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'truebit_hero_video';
	}

	public function get_title() {
		return esc_html__( 'Hero Video', 'hello-elementor-child' );
	}

	public function get_icon() {
		return 'eicon-video-camera';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	public function get_style_depends() {
		return [ 'truebit-hero-video' ];
	}

	public function get_script_depends() {
		return [ 'truebit-hero-video' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_videos',
			[
				'label' => esc_html__( 'Videos', 'hello-elementor-child' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'intro_video',
			[
				'label'       => esc_html__( 'Intro Video', 'hello-elementor-child' ),
				'description' => esc_html__( 'Plays once, then switches to the loop video.', 'hello-elementor-child' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'media_type'  => 'video',
				'default'     => [ 'url' => '' ],
			]
		);

		$this->add_control(
			'loop_video',
			[
				'label'       => esc_html__( 'Loop Video', 'hello-elementor-child' ),
				'description' => esc_html__( 'Plays on loop after the intro ends.', 'hello-elementor-child' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'media_type'  => 'video',
				'default'     => [ 'url' => '' ],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$intro_url  = ! empty( $settings['intro_video']['url'] ) ? esc_url( $settings['intro_video']['url'] ) : '';
		$loop_url   = ! empty( $settings['loop_video']['url'] ) ? esc_url( $settings['loop_video']['url'] ) : '';
		$widget_id  = 'tbhv-' . $this->get_id();
		?>
		<div class="truebit-hero-video-wrapper"
		     id="<?php echo esc_attr( $widget_id ); ?>"
		     data-loop-src="<?php echo esc_attr( $loop_url ); ?>">
			<video class="truebit-hero-video" autoplay muted playsinline>
				<?php if ( $intro_url ) : ?>
					<source src="<?php echo $intro_url; ?>" type="video/mp4">
				<?php endif; ?>
			</video>
		</div>
		<?php
	}
}
