<?php
/**
 * Exibe posts de uma categoria em layout de cards (versão otimizada)
 *
 * @package Eachline
 */

if ( ! function_exists( 'eachline_posts_by_category' ) ) :

function eachline_posts_by_category(
	$category_slug,
	$title             = '',
	$post_type         = 'post',
	$posts_per_page    = 3,
	$show_excerpt      = true,
	$description       = '',
	$show_link         = true,
	$link_text         = 'Ver todos',
	$card_link_text    = 'Ler mais'
) {

	// Busca categoria
	$category = get_category_by_slug( $category_slug );
	if ( ! $category ) {
		return;
	}

	$category_link = get_category_link( $category->term_id );

	// Query otimizada
	$query = new WP_Query( [
		'post_type'           => $post_type,
		'posts_per_page'      => absint( $posts_per_page ),
		'cat'                 => $category->term_id,
		'post_status'         => 'publish',
		'no_found_rows'       => true,     // ⚡ evita cálculo pesado de paginação
		'ignore_sticky_posts' => true,
	] );

	if ( ! $query->have_posts() ) {
		return;
	}
	?>

	<section class="eachline-category-section container my-5" aria-labelledby="section-<?php echo esc_attr( $category_slug ); ?>">
		
		<header class="section-header d-flex justify-content-between align-items-center flex-wrap mb-4">
			<div>
				<?php if ( $title ) : ?>
					<h2 id="section-<?php echo esc_attr( $category_slug ); ?>" class="section-title mb-2">
						<?php echo esc_html( $title ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( $description ) : ?>
					<div class="section-description text-muted mb-0">
						<?php echo wp_kses_post( $description ); ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $show_link ) : ?>
				<a href="<?php echo esc_url( $category_link ); ?>"
					class="link-text link-primary fw-semibold">
					<?php echo esc_html( $link_text ); ?>
					<i class="fa-solid fa-arrow-right ms-1" aria-hidden="true"></i>
				</a>
			<?php endif; ?>
		</header>

		<div class="row post-list">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				
				<article 
					id="post-<?php the_ID(); ?>" 
					<?php post_class( 'col-md-4 mb-4' ); ?> 
					aria-label="<?php echo esc_attr( get_the_title() ); ?>"
				>
					<div class="card h-100 border-0 shadow-sm">

						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" 
							   class="d-block overflow-hidden ratio ratio-16x9"
							   aria-hidden="true" tabindex="-1">
								<?php the_post_thumbnail( 'large', [
									'class' => 'card-img-top object-fit-cover img-fluid',
									'alt'   => esc_attr( get_the_title() ),
									'decoding' => 'async',
									'loading'  => 'lazy',
								] ); ?>
							</a>
						<?php endif; ?>

						<div class="card-body d-flex flex-column">
							
							<h3 class="card-title h5 mb-2">
								<a href="<?php the_permalink(); ?>" 
								   class="link-text link-primary">
									<?php the_title(); ?>
								</a>
							</h3>

							<?php if ( $show_excerpt ) : ?>
								<p class="card-text text-muted small mb-3">
									<?php echo esc_html( wp_trim_words( get_the_excerpt(), 25, '…' ) ); ?>
								</p>
							<?php endif; ?>

							<footer class="mt-auto">
								<a href="<?php the_permalink(); ?>" class="link-text link-primary">
									<?php echo esc_html( $card_link_text ); ?>
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
endif;
