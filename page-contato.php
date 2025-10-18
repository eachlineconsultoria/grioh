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
  <section id="form" class="container section-container forms">
    <div class="container">

      <header class="section-header">
        <h2 class="section-title">
          <?php if ($desc = get_field('form_title')): ?>
            <?php echo esc_html($desc); ?>
          <?php endif; ?>

        </h2>

      </header>
      <div class="row">
        <div class="col-12 col-md-8">

          <?php the_content() ?>
        </div>
        <div class="col-12 col-md">

          <aside class="border rounded aside-contact">

            <h3>Redes sociais</h3>
            <p class="mb-2">Conecte-se conosco nas redes sociais para acompanhar nossos trabalhos.</p>
            <ul class="aside-social m-0 p-0 ">
              <?php
              $contact_info = get_field('contact_social'); // isso traz um array associativo
              if ($contact_info && !empty($contact_info['contact_instagram'])):
                $instagram = $contact_info['contact_instagram'];
                ?>
                <li class="aside-social-item-instagram">
                  <a href="https://instagram.com/<?php echo esc_attr($instagram); ?>" target="_blank" rel="noopener">
                    <span class="fa-stack fa-2x">
                      <i class="fa-solid fa-square fa-stack-2x"></i>
                      <i class="fab fa-instagram fa-stack-1x fa-inverse"></i>
                    </span>

                    <div>
                      <strong class="aside-social-name">Instagram</strong>
                      <span class="aside-social-at">@<?php echo esc_html($instagram); ?></span>
                    </div>
                  </a>
                </li>
              <?php endif; ?>


              <?php
              $contact_info = get_field('contact_social'); // isso traz um array associativo
              if ($contact_info && !empty($contact_info['contact_linkedin'])):
                $linkedin = $contact_info['contact_linkedin'];
                ?>
                <li class="aside-social-item-linkedin"> <a
                    href="https://linkedin.com/company/<?php echo esc_attr($linkedin); ?>" target="_blank" rel="noopener">
                    <span class="fa-stack fa-2x">
                      <i class="fa-solid fa-square fa-stack-2x"></i>
                      <i class="fab fa-linkedin fa-stack-1x fa-inverse"></i>
                    </span>

                    <div>
                      <strong class="aside-social-name">LinkedIn</strong>
                      <span class="aside-social-at">@<?php echo esc_html($linkedin); ?></span>
                    </div>
                  </a>
                </li>
              <?php endif; ?>

            </ul>

            <hr class="my-3">

            <h3>Imprensa</h3>
            <p class="mb-0">Acompanhe as notícias na imprensa sobre nós.
              <div class="d-block w-100"></div>
              <a class="mt-3 button button-primary " href="/imprensa">Clipping<i class="ms-2 fa-solid fa-arrow-right"></i></a>


            </p>

            <p>Para material institucional, acesse <a href="sobre/manual-marca">nosso manual da marca</a>.</p>
            <?php if (is_active_sidebar('aside-contact')): ?>
              <?php dynamic_sidebar('aside-contact'); ?>
            <?php endif; ?>
          </aside>
        </div>
      </div>
    </div>
  </section>

  <?php require_once get_template_directory() . '/section/cta.php'; ?>

  <?php require_once get_template_directory() . '/section/testimonial.php'; ?>

  <?php require_once get_template_directory() . '/section/cases.php'; ?>


</main>

<?php get_footer(); ?>