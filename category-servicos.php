<?php
/**
 * Template Name: Serviços
 * Description: Exibe os serviços a partir de subpáginas.
 * @package Eachline
 */

get_header();

$services = [
  'show' => get_field('services_section'),
  'title' => trim(get_field('services_title') ?? ''),
  'desc' => trim(get_field('services_description') ?? ''),
];
?>

<main id="main-content" class="site-main">

  <?php get_template_part('template-parts/section/hero'); ?>

  <?php if (!empty($services['show'])): ?>
    <section id="services" class="container section-container services">
      <header class="section-header text-center text-md-start">
        <?php if ($services['title']): ?>
          <h2 class="section-title"><?php echo esc_html($services['title']); ?></h2>
        <?php endif; ?>

        <?php if ($services['desc']): ?>
          <p class="section-description"><?php echo wp_kses_post($services['desc']); ?></p>
        <?php endif; ?>
      </header>

      <?php
      $subpages = get_pages([
        'parent' => get_the_ID(),
        'sort_column' => 'menu_order',
        'sort_order'  => 'ASC',
      ]);

      if (!empty($subpages)): ?>
        <div class="row">
          <?php foreach ($subpages as $page):
            $thumbnail = get_the_post_thumbnail($page->ID, 'medium_large', [
              'class' => 'img-fluid card-image object-fit-cover rounded-top w-100',
              'alt'   => esc_attr($page->post_title),
            ]);
            $excerpt = wp_trim_words($page->post_excerpt ?: wp_strip_all_tags($page->post_content), 20);
            $permalink = get_permalink($page->ID);
          ?>
            <div class="col-12 col-md-4 mb-5 mb-md-0">
              <article class="card h-100">
                <figure class="m-0 card-container">
                  <?php if ($thumbnail): ?>
                    <a href="<?php echo esc_url($permalink); ?>"><?php echo $thumbnail; ?></a>
                  <?php else: ?>
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/img/case-default.jpg'); ?>"
                         class="img-fluid card-image rounded-top w-100"
                         alt="Imagem padrão">
                  <?php endif; ?>
                </figure>

                <div class="card-body p-3">
                  <h3 class="card-title mb-2">
                    <a href="<?php echo esc_url($permalink); ?>" class="card-link">
                      <?php echo esc_html($page->post_title); ?>
                    </a>
                  </h3>
                  <p class="card-excerpt mb-0"><?php echo esc_html($excerpt); ?></p>
                </div>

                <footer class="border-0 card-footer">
                  <a href="<?php echo esc_url($permalink); ?>" class="card-link link-text link-primary">
                    Leia mais <i class="ms-2 fa-solid fa-arrow-right" aria-hidden="true"></i>
                  </a>
                </footer>
              </article>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </section>
  <?php endif; ?>
<section id="servicos" class="container section-container my-5">
  <header class="section-header text-center text-md-start mb-4">
    <h2 class="section-title">Todos os serviços</h2>
    <p class="section-description">Confira os serviços disponíveis e saiba mais sobre cada um.</p>
  </header>

  <?php
  // Loop padrão da categoria "servicos"
  $servicos_query = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => -1,
    'category_name'  => 'servicos',
    'orderby'        => 'date',
    'order'          => 'DESC',
  ]);

  if ($servicos_query->have_posts()): ?>
    <div class="row g-4">
      <?php while ($servicos_query->have_posts()): $servicos_query->the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4 col-sm-6'); ?>>
          <div class="card h-100 border-0">

            <?php if (has_post_thumbnail()): ?>
              <a href="<?php the_permalink(); ?>" class="ratio ratio-16x9 d-block overflow-hidden">
                <?php the_post_thumbnail('large', [
                  'class' => 'card-img-top object-fit-cover img-fluid rounded-0 rounded-top',
                  'alt'   => esc_attr(get_the_title()),
                ]); ?>
              </a>
            <?php else: ?>
              <img src="<?php echo esc_url(get_template_directory_uri() . '/img/case-default.jpg'); ?>"
                   alt="Imagem padrão"
                   class="img-fluid rounded-top object-fit-cover w-100">
            <?php endif; ?>

            <div class="card-body rounded-bottom d-flex flex-column">
              <h3 class="card-title h5 mb-2">
                <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark">
                  <?php the_title(); ?>
                </a>
              </h3>

              <p class="card-text text-muted flex-grow-1">
                <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
              </p>

              <a href="<?php the_permalink(); ?>" class="link-text link-primary mt-2">
                Saiba mais <i class="fa-solid fa-arrow-right ms-1"></i>
              </a>
            </div>

          </div>
        </article>
      <?php endwhile; ?>
    </div>

  <?php else: ?>
    <p class="text-center text-muted my-5">Nenhum serviço encontrado no momento.</p>
  <?php endif; ?>

  <?php wp_reset_postdata(); ?>
</section>


  <?php
  get_template_part('section/bignumbers');

  if (is_active_sidebar('bignumbers')): ?>
    <section class="container bignumbers">
      <div class="row">
        <?php dynamic_sidebar('bignumbers'); ?>
      </div>
    </section>
  <?php endif; ?>

  <?php
  get_template_part('template-parts/section/testimonial');  ?>

<!-- // clientes -->
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


</main>

<?php get_footer(); ?>
