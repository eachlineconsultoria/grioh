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

<main id="main-content">

  <?php require get_template_directory() . '/section/hero.php'; ?>

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
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/case-default.jpg'); ?>"
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
  require get_template_directory() . '/section/testimonial.php';
  require get_template_directory() . '/section/cases.php';
  ?>

</main>

<?php get_footer(); ?>
