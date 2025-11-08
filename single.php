<?php
/**
 * Template para exibir posts individuais (Single)
 * @package Eachline
 */

get_header();

if (have_posts()):
	while (have_posts()):
		the_post();
		?>

		<main id="primary" class="post-content content site-main py-5">
			<div class="container">
				<header class="mb-4">
					<h1 class="section-title col-12 col-md-8 mx-auto"><?php the_title(); ?></h1>
				</header>

				<section
					class="post-meta  col-12 col-md-8 mx-auto d-flex flex-wrap justify-content-between align-items-center mb-4">
					<div class="col-md-6 d-flex align-items-center mb-3 mb-md-0">
						<?php echo get_avatar(get_the_author_meta('ID'), 64, '', get_the_author(), ['class' => 'rounded-circle me-3']); ?>
						<div>
							<p class="m-0 fw-semibold"><?php the_author_meta('display_name'); ?></p>
							<p class="m-0 text-muted small">
								<?php echo get_the_date('d M Y'); ?> •
								<?php
								$word_count = str_word_count(strip_tags(get_post_field('post_content', get_the_ID())));
								$reading_time = ceil($word_count / 200);
								echo $reading_time . ' min de leitura';
								?>
							</p>
						</div>
					</div>
					<div class="col-md-6 d-flex justify-content-md-end align-items-center gap-3">

						<!-- Link permanente -->
						<a href="#" class="copy-link text-dark" data-link="<?php echo esc_url(get_permalink()); ?>"
							aria-label="Copiar link permanente">
							<i class="fa-solid fa-link"></i>
						</a>

						<!-- LinkedIn -->
						<a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>"
							target="_blank" rel="noopener" aria-label="Compartilhar no LinkedIn">
							<i class="fa-brands fa-linkedin-in"></i>
						</a>

						<!-- Twitter -->
						<a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
							target="_blank" rel="noopener" aria-label="Compartilhar no Twitter">
							<i class="fa-brands fa-x-twitter"></i>
						</a>

						<!-- Facebook -->
						<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank"
							rel="noopener" aria-label="Compartilhar no Facebook">
							<i class="fa-brands fa-facebook-f"></i>
						</a>
						<!-- bluesky -->
						<a href="https://bsky.app/intent/compose?text=<?php echo urlencode(get_permalink()); ?>" target="_blank"
							rel="noopener" aria-label="Compartilhar no Bluesky">
							<i class="fa-brands fa-bluesky"></i>
						</a>
					</div>
				</section>
			</div>
			<?php if (has_post_thumbnail()): ?>
				<figure class="content-thumbnail text-center">
					<?php the_post_thumbnail('full', ['class' => 'object-fit-cover img-fluid rounded']); ?>
				</figure>
			<?php endif; ?>

			<!-- CONTEÚDO -->
			<div class="container">

				<article class=" col-12 col-md-8 mx-auto entry-content mb-5">
					<?php the_content(); ?>
				</article>
			</div>

			<div class="container  ">
				<footer class="post-footer ">

					<div class="col-12 col-md-8 mx-auto d-flex flex-wrap justify-content-between align-items-center gap-3">


						<div class=" d-flex justify-content-md-end align-items-center gap-3">
							<span class="fw-bold">Compartilhe o artigo:</span>
							<!-- Link permanente -->
							<a href="#" class="copy-link text-dark" data-link="<?php echo esc_url(get_permalink()); ?>"
								aria-label="Copiar link permanente">
								<i class="fa-solid fa-link"></i>
							</a>

							<!-- LinkedIn -->
							<a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>"
								target="_blank" rel="noopener" aria-label="Compartilhar no LinkedIn">
								<i class="fa-brands fa-linkedin-in"></i>
							</a>

							<!-- Twitter -->
							<a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
								target="_blank" rel="noopener" aria-label="Compartilhar no Twitter">
								<i class="fa-brands fa-x-twitter"></i>
							</a>

							<!-- Facebook -->
							<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>"
								target="_blank" rel="noopener" aria-label="Compartilhar no Facebook">
								<i class="fa-brands fa-facebook-f"></i>
							</a>
							<!-- bluesky -->
							<a href="https://bsky.app/intent/compose?text=<?php echo urlencode(get_permalink()); ?>" target="_blank"
								rel="noopener" aria-label="Compartilhar no Bluesky">
								<i class="fa-brands fa-bluesky"></i>
							</a>
						</div>

						<div class="post-tags text-end">
							<?php
							$post_id = get_the_ID() ?: get_queried_object_id();
							$tags = get_the_tags($post_id);

							if ($tags) {
								foreach ($tags as $tag) {
									echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="badge bg-light text-dark me-2">'
										. esc_html($tag->name) . '</a>';
								}
							} else {
								echo '<span class="text-muted small">Sem tags</span>';
							}
							?>
						</div>
					</div>
					<div class="post-footer-icon"></div>
				</footer>

				<?php
				eachline_related_posts(
					title: 'Artigos relacionados',
					posts_per_page: 3,
					show_link: true,
					link_text: 'Veja todos os artigos'
				);
				?>

			</div>
		</main>



		<?php
	endwhile;
endif;

get_footer();
