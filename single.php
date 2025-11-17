<?php
/**
 * Template para exibir posts individuais (Single)
 * SEO otimizado + Schema.org
 * @package Eachline
 */

get_header();

if (have_posts()):
	while (have_posts()):
		the_post();
?>

<main id="main-content" class="site-main">


	<?php $is_services = has_category('servicos'); ?>

	<div class="container post-content content site-main <?php echo $is_services ? '' : 'py-5'; ?>">

		<?php if ($is_services): ?>

			<?php get_template_part('template-parts/section/hero'); ?>

		<?php else: ?>

			<!-- TÍTULO PRINCIPAL - H1 único (SEO) -->
			<header class="mb-4">
				<h1 class="section-title col-12 col-md-8 mx-auto"><?php the_title(); ?></h1>
			</header>

			<!-- META INICIAL DO ARTIGO (SEO + Acessibilidade) -->
			<section class="post-meta col-12 col-md-8 mx-auto d-flex flex-wrap justify-content-between align-items-center mb-4">

				<div class="col-md-6 d-flex align-items-center mb-3 mb-md-0">

					<!-- Avatar com ALT e SEO correto -->
					<?php
					echo get_avatar(
						get_the_author_meta('ID'),
						64,
						'',
						get_the_author(),
						[
							'class' => 'rounded-circle me-3',
							'extra_attr' => 'loading="lazy" decoding="async"'
						]
					);
					?>

					<div>
						<!-- Link para página do autor -->
						<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"
						   class="m-0 fw-semibold" rel="author">
							<?php the_author(); ?>
						</a>

						<p class="m-0 text-muted small">
							<!-- Data formatada com microdata (SEO) -->
							<time datetime="<?php echo get_the_date('c'); ?>">
								<?php echo get_the_date('d M Y'); ?>
							</time>
							•
							<?php
							$reading_time = ceil(str_word_count(strip_tags(get_post_field('post_content'))) / 200);
							echo $reading_time . ' min de leitura';
							?>
						</p>
					</div>
				</div>

				<div class="col-md-6 d-flex justify-content-md-end align-items-center gap-3">
					<?php include get_template_directory() . '/template-parts/social-share.php'; ?>
				</div>

			</section>

			<!-- THUMBNAIL PRINCIPAL COM SEO -->
			<?php if (has_post_thumbnail()): ?>
				<figure class="content-thumbnail text-center">
					<?php the_post_thumbnail('full', [
						'class' => 'object-fit-cover img-fluid rounded',
						'alt' => get_the_title() . ' – imagem de destaque',
						'loading' => 'eager', // SEO: primeira imagem deve ser eager
						'fetchpriority' => 'high'
					]); ?>
				</figure>
			<?php endif; ?>

		<?php endif; ?>
	</div>


	<!-- CONTEÚDO PRINCIPAL DO ARTIGO -->
	<div class="container">
		<article 
			class="<?php echo $is_services ? '' : 'col-12 col-md-8 mx-auto'; ?> entry-content mb-5"
			itemprop="articleBody">

			<?php the_content(); ?>
		</article>
	</div>


	<!-- Testemunhos -->
	<?php if ($is_services): ?>
		<?php get_template_part('template-parts/section/testimonial'); ?>
	<?php endif; ?>

	<footer class="container post-footer">

		<?php if ($is_services): ?>

			<?php
			eachline_posts_by_category(
				'cases',
				'Clientes',
				'post',
				3,
				false,
				'<p>Confira novidades e atualizações.</p>',
				true,
				'Acesse os cases'
			);
			?>

		<?php else: ?>

			<div class="col-12 col-md-8 mx-auto d-flex flex-wrap justify-content-between align-items-center gap-3">

				<div class="d-flex justify-content-md-end align-items-center gap-3">
					<span class="fw-bold">Compartilhe o artigo:</span>
					<?php include get_template_directory() . '/template-parts/social-share.php'; ?>
				</div>

				<!-- TAGS -->
				<div class="post-tags text-end">
					<?php
					$tags = get_the_tags();
					if ($tags):
						foreach ($tags as $tag):
							echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" 
								class="badge bg-light text-dark me-2" rel="tag">'
								. esc_html($tag->name) .
								'</a>';
						endforeach;
					endif;
					?>
				</div>

			</div>

		<?php endif; ?>

	</footer>

	<!-- POSTS RELACIONADOS -->
	<?php if (!$is_services): ?>
		<?php eachline_related_posts(posts_per_page: 3, show_link: true); ?>
	<?php endif; ?>

</main>

<?php
	/* SEO: JSON-LD DATA */
	$author_id = get_the_author_meta('ID');
	$thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');
	$publisher_logo = get_template_directory_uri() . '/assets/img/logo.png'; // ajuste se necessário
?>

<!-- DADOS ESTRUTURADOS (SEO avançado) -->
<script type="application/ld+json">
{
	"@context": "https://schema.org",
	"@type": "Article",
	"headline": "<?php echo esc_js(get_the_title()); ?>",
	"description": "<?php echo esc_js(wp_strip_all_tags(get_the_excerpt())); ?>",
	"image": "<?php echo esc_url($thumbnail); ?>",
	"datePublished": "<?php echo get_the_date('c'); ?>",
	"dateModified": "<?php echo get_the_modified_date('c'); ?>",
	"author": {
		"@type": "Person",
		"name": "<?php echo esc_js(get_the_author()); ?>",
		"url": "<?php echo esc_url(get_author_posts_url($author_id)); ?>"
	},
	"publisher": {
		"@type": "Organization",
		"name": "Eachline",
		"logo": {
			"@type": "ImageObject",
			"url": "<?php echo esc_url($publisher_logo); ?>"
		}
	},
	"mainEntityOfPage": {
		"@type": "WebPage",
		"@id": "<?php echo esc_url(get_permalink()); ?>"
	}
}
</script>

<?php
	endwhile;
endif;

get_footer();
?>
