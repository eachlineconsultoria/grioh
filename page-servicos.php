<?php
/**
 * Template Name: Página de Serviços
 * Description: Template que exibe os serviços a partir de subpáginas.
 *
 * @package Eachline
 */

get_header();
?>

<main>

  <?php require_once get_template_directory() . '/section/hero.php'; ?>

  <?php if (get_field('services_section')): ?>
    <section id="services" class="container section-container services">
      <header class="section-header">
        <h2 class="section-title">
          <?php if ($title = get_field('services_title')): ?>
            <?php echo esc_html($title); ?>
          <?php endif; ?>
        </h2>

        <?php if ($desc = get_field('services_description')): ?>
          <div class="section-description">
            <?php echo esc_html($desc); ?>
          </div>
        <?php endif; ?>
      </header>

      <?php
      $parent_id = get_the_ID(); // ID da página atual
      $subpages = get_pages(array(
        'parent' => $parent_id,
        'sort_column' => 'menu_order',
        'sort_order' => 'asc',
      ));

      if ($subpages): ?>
        <div class="row">
          <?php foreach ($subpages as $page): ?>
            <div class="col-12 col-md-4 mb-5 mb-md-0">
              <article class="card h-100">
                <figure class="m-0 card-container">
                  <?php if (get_the_post_thumbnail($page->ID)): ?>
                    <a href="<?php echo get_permalink($page->ID); ?>">
                      <?php echo get_the_post_thumbnail($page->ID, 'medium_large', ['class' => 'img-fluid card-image object-fit-cover rounded-top w-100']); ?>
                    </a>
                  <?php else: ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/case-default.jpg"
                      class="img-fluid card-image rounded-top w-100" alt="Imagem padrão">
                  <?php endif; ?>
                </figure>

                <div class="card-body p-3">
                  <h3 class="card-title mb-0">
                    <a href="<?php echo get_permalink($page->ID); ?>" class="card-link">
                      <?php echo esc_html($page->post_title); ?>
                    </a>
                  </h3>
                  <p class="card-excerpt mb-0">
                    <?php echo wp_trim_words($page->post_excerpt ?: $page->post_content, 20); ?>
                  </p>
                </div>

                <footer class="border-0 card-footer">
                  <a href="<?php echo get_permalink($page->ID); ?>" class="card-link link-text link-primary">
                    Leia mais<i class="ms-2 fa-solid fa-arrow-right"></i>
                  </a>
                </footer>
              </article>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </section>
  <?php endif; ?>

  <?php get_template_part('section/bignumbers'); ?>

  <?php if (is_active_sidebar('bignumbers')): ?>
    <div class="container bignumbers">
      <div class="row">
        <?php dynamic_sidebar('bignumbers'); ?>
      </div>
    </div>
  <?php endif; ?>

  <?php require_once get_template_directory() . '/section/testimonial.php'; ?>

  <?php require_once get_template_directory() . '/section/cases.php'; ?>


</main>

<?php get_footer(); ?>