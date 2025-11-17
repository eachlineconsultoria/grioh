<?php
/**
 * Custom Header (Optimized & Accessible)
 *
 * @package Eachline
 */

function eachline_custom_header_setup() {
	add_theme_support(
		'custom-header',
		array(
			'width'              => 1600,
			'height'             => 400,
			'flex-width'         => true,
			'flex-height'        => true,
			'default-text-color' => '000000',
			'wp-head-callback'   => 'eachline_header_style',
		)
	);
}
add_action( 'after_setup_theme', 'eachline_custom_header_setup' );

if ( ! function_exists( 'eachline_header_style' ) ) :

	function eachline_header_style() {

		$header_text_color = get_header_textcolor();
		$default_color     = get_theme_support( 'custom-header', 'default-text-color' );

		// Nada a renderizar — mantenha o head limpo.
		if ( $header_text_color === $default_color && display_header_text() ) {
			return;
		}

		?>
		<style>
			<?php if ( ! display_header_text() ) : ?>
				
				/* Acessível: oculta visualmente mas mantém para screen readers */
				.site-title,
				.site-description {
					position: absolute !important;
					width: 1px;
					height: 1px;
					padding: 0;
					margin: -1px;
					overflow: hidden;
					clip: rect(0, 0, 0, 0);
					white-space: nowrap;
					border: 0;
				}

			<?php else : ?>

				/* Cor personalizada do título/subtítulo */
				.site-title a,
				.site-description {
					color: #<?php echo esc_attr( $header_text_color ); ?>;
				}

			<?php endif; ?>
		</style>
		<?php
	}
endif;
