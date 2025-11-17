<?php
/**
 * Related Posts – versão otimizada e acessível
 *
 * @package Eachline
 */

function eachline_related_posts(
	$title           = 'Conteúdo relacionado',
	$posts_per_page  = 3,
	$show_link       = true,
	$link_text       = 'Veja todos'
) {

	global $post;
	if ( ! $post ) {
		return;
	}

	$current_id = $post->ID;

	// Taxonomias do post atual
	$tag_ids  = wp_list_pluck( wp_get_post_tags( $current_id ), 'term_id' );
	$cat_ids  = wp_list_pluck( get_the_category( $current_id ), 'term_id' );

	// Link da categoria principal para CTA
	$primary_cat_link = ! empty( $cat_ids ) ? get_category_link( $cat_ids[0] ) : '';

	// Query base
	$args = [
		'post_type'           => 'post',
		'posts_per_page'      => absint( $posts_per_page ),
		'post__not_in'        => [ $current_id ],
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'tax_query'           => [ 'relation' => 'AND' ],
	];

	if ( ! empty( $tag_ids ) ) {
		$args['tax_query'][] = [
			'taxonomy' => 'post_tag',
			'field'    => 'term_id',
			'terms'    => $tag_ids,
		];
	}

	if ( ! empty( $cat_ids ) ) {
		$args['tax_query'][] = [
			'taxonomy' => 'category',
			'field'    => 'term_id',
			'terms'    => $cat_ids,
		];
	}

	$related_query = new WP_Query( $args );

	// 🔁 Fallback para TAGS OU CATEGORIA (não AND)
	if ( ! $related_query->have_posts() ) {

		$fallback_args = $args;
		$fallback_args['tax_query'] = [];

		if ( ! empty( $tag_ids ) ) {
			$fallback_args['tax_query'][] = [
				'taxonomy' => 'post_tag',
				'field'    => 'term_id',
				'terms'    => $tag_ids,
			];
		} elseif ( ! empty( $cat_ids ) ) {
			$fallback_args['tax_query'][] = [
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => $cat_ids,
			];
		}

		$related_query = new WP_Query( $fallback_args );
	}

	// Sem posts → encerra
	if ( ! $related_query->have_posts() ) {
		return;
	}

	$section_id = 'related-' . $current_id;
	?>

	<section id="<?php echo esc_attr( $section_id ); ?>"
			 class="related-posts container my-5"
			 aria-labelledby="<?php echo esc_attr( $section_id ); ?>-title">

		<div class="d-flex justify-content-between align-items-center mb-4">
			<h2 id="<?php echo esc_attr( $section_id ); ?>-title"
				class="h3 m-0 fw-bold">
				<?php echo esc_html( $title ); ?>
			</h2>

			<?php if ( $show_link && $primary_cat_link ) : ?>
				<a href="<?php echo esc_url( $primary_cat_link ); ?>"
				   class="link-text link-secondary">
					<?php echo esc_html( $link_text ); ?>
					<i class="fa-solid fa-arrow-right ms-1" aria-hidden="true"></i>
				</a>
			<?php endif; ?>
		</div>

		<div class="post-list row" role="list">
			<?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>

				<article
					id="post-<?php the_ID(); ?>"
					<?php post_class( 'col-md-4 mb-4' ); ?>
					role="listitem"
					aria-label="<?php echo esc_attr( get_the_title() ); ?>">

					<div class="card h-100 border-0 shadow-sm">

						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>"
							   class="d-block overflow-hidden ratio ratio-16x9"
							   aria-hidden="true" tabindex="-1">
								<?php the_post_thumbnail(
									'large',
									[
										'class'    => 'card-img-top object-fit-cover img-fluid',
										'alt'      => esc_attr( get_the_title() ),
										'loading'  => 'lazy',
										'decoding' => 'async'
									]
								); ?>
							</a>
						<?php endif; ?>

						<div class="card-body d-flex flex-column">

							<h3 class="card-title h5 mb-2">
								<a href="<?php the_permalink(); ?>" class="link-text link-primary">
									<?php the_title(); ?>
								</a>
							</h3>

							<p class="card-text text-muted small mb-3">
								<?php echo esc_html( wp_trim_words( get_the_excerpt(), 25, '…' ) ); ?>
							</p>

							<footer class="mt-auto">
								<a href="<?php the_permalink(); ?>" class="link-text link-primary">
									<?php esc_html_e( 'Ler artigo', 'eachline' ); ?>
									<i class="fa-solid fa-arrow-right ms-1" aria-hidden="true"></i>
								</a>
							</footer>

						</div>
					</div>

				</article>

			<?php endwhile; ?>
		</div>

	</section>

	<?php
	wp_reset_postdata();
}
