<?php

/**
 * Template Name: Contato
 * Descrição: Página de contato com blocos dinâmicos via ACF.
 *
 * Otimizado para:
 * - performance (menos queries)
 * - acessibilidade
 * - escapa de dados (segurança)
 * - organização modular
 *
 * @package Eachline
 */

get_header();
?>

<main id="main-content">

  <!-- HERO / Banner superior -->
  <?php get_template_part('template-parts/section/hero'); ?>


  <!-- SEÇÃO DE SERVIÇOS RELACIONADOS AO CONTATO (opcional via ACF) -->
  <?php if (get_field('services_section')): ?>
    <section id="services" class="container section-container services">

      <header class="section-header">
        <h2 class="section-title">
          <?php if ($title = get_field('services_title')) echo esc_html($title); ?>
        </h2>

        <?php if ($desc = get_field('services_description')): ?>
          <p class="section-description"><?php echo wp_kses_post($desc); ?></p>
        <?php endif; ?>
      </header>

      <?php
      // Carregando subpáginas (serviços filhos)
      $subpages = get_pages([
        'parent'      => get_the_ID(),
        'sort_column' => 'menu_order',
        'sort_order'  => 'ASC',
      ]);

      if (!empty($subpages)):
      ?>
        <div class="row">
          <?php foreach ($subpages as $page): ?>

            <?php
            $thumb = get_the_post_thumbnail(
              $page->ID,
              'medium_large',
              ['class' => 'img-fluid card-image object-fit-cover rounded-top w-100', 'alt' => esc_attr($page->post_title)]
            );

            $excerpt = wp_trim_words($page->post_excerpt ?: wp_strip_all_tags($page->post_content), 20);
            ?>

            <div class="col-12 col-md-4 mb-5 mb-md-0">
              <article class="card h-100">

                <figure class="m-0 card-container">
                  <?php if ($thumb): ?>
                    <a href="<?php echo esc_url(get_permalink($page->ID)); ?>"><?php echo $thumb; ?></a>
                  <?php else: ?>
                    <img
                      src="<?php echo esc_url(get_template_directory_uri() . '/img/case-default.jpg'); ?>"
                      alt="Imagem padrão"
                      class="img-fluid card-image rounded-top w-100">
                  <?php endif; ?>
                </figure>

                <div class="card-body p-3">
                  <h3 class="card-title mb-2">
                    <a href="<?php echo esc_url(get_permalink($page->ID)); ?>" class="card-link">
                      <?php echo esc_html($page->post_title); ?>
                    </a>
                  </h3>
                  <p class="card-excerpt mb-0"><?php echo esc_html($excerpt); ?></p>
                </div>

                <footer class="card-footer border-0">
                  <a href="<?php echo esc_url(get_permalink($page->ID)); ?>" class="card-link link-text link-primary">
                    Leia mais <i class="ms-2 fa-solid fa-arrow-right"></i>
                  </a>
                </footer>

              </article>
            </div>

          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </section>
  <?php endif; ?>


  <!-- FORMULÁRIO PRINCIPAL -->
  <section id="form" class="container section-container forms">
    <div class="container">

      <header class="section-header">
        <?php if ($form_title = get_field('form_title')): ?>
          <h2 class="section-title"><?php echo esc_html($form_title); ?></h2>
        <?php endif; ?>
      </header>

      <div class="row">
        <!-- Conteúdo (formulário do editor) -->
        <div class="col-12 col-md-8">
          <?php the_content(); ?>
        </div>

        <!-- ASIDE LATERAL -->
        <div class="col-12 col-md">
          <aside class="border rounded aside-contact p-3">

            <!-- REDES SOCIAIS -->
            <h3>Redes sociais</h3>
            <p class="mb-2">Conecte-se conosco nas redes sociais para acompanhar nossos trabalhos.</p>

            <?php $contact_social = get_field('contact_social'); ?>

            <ul class="aside-social m-0 p-0">

              <!-- Instagram -->
              <?php if (!empty($contact_social['contact_instagram'])): ?>
                <li class="aside-social-item-instagram">
                  <a href="https://instagram.com/<?php echo esc_attr($contact_social['contact_instagram']); ?>"
                    target="_blank" rel="noopener">

                    <span class="fa-stack fa-2x me-3">
                      <i class="fa-solid fa-square fa-stack-2x"></i>
                      <i class="fab fa-instagram fa-stack-1x fa-inverse"></i>
                    </span>

                    <div>
                      <strong class="aside-social-name">Instagram</strong>
                      <span class="aside-social-at">@<?php echo esc_html($contact_social['contact_instagram']); ?></span>
                    </div>

                  </a>
                </li>
              <?php endif; ?>

              <!-- LinkedIn -->
              <?php if (!empty($contact_social['contact_linkedin'])): ?>
                <li class="aside-social-item-linkedin">
                  <a href="https://linkedin.com/company/<?php echo esc_attr($contact_social['contact_linkedin']); ?>"
                    target="_blank" rel="noopener">

                    <span class="fa-stack fa-2x me-3">
                      <i class="fa-solid fa-square fa-stack-2x"></i>
                      <i class="fab fa-linkedin fa-stack-1x fa-inverse"></i>
                    </span>

                    <div>
                      <strong class="aside-social-name">LinkedIn</strong>
                      <span class="aside-social-at">@<?php echo esc_html($contact_social['contact_linkedin']); ?></span>
                    </div>

                  </a>
                </li>
              <?php endif; ?>

            </ul>

            <hr class="my-3">

            <!-- IMPRENSA -->
            <h3>Imprensa</h3>
            <p>Acompanhe as notícias na imprensa sobre nós.</p>

            <a class="my-3 button button-primary" href="<?php echo esc_url(home_url('/category/imprensa')); ?>">
              Clipping <i class="ms-2 fa-solid fa-arrow-right"></i>
            </a>

            <p>Para material institucional, acesse <a href="<?php echo esc_url(home_url('/sobre/manual-marca')); ?>">nosso manual da marca</a>.</p>

            <!-- Widgets adicionais -->
            <?php if (is_active_sidebar('aside-contact')) dynamic_sidebar('aside-contact'); ?>

          </aside>
        </div>
      </div>


      <!-- OUTRAS FORMAS DE CONTATO -->
      <div class="row contact-way mt-5">
        <h3 class="col-12">Outras formas de contato</h3>

        <?php $contact_way = get_field('contact_way'); ?>

        <ul class="contact-way-list p-0 row">

          <!-- E-mail -->
          <?php if (!empty($contact_way['contact_email'])): ?>
            <li class="contact-way-item-email col-12 col-md">
              <div class="border rounded d-flex align-items-center p-3">
                <i class="fa-regular fa-2x me-3 fa-envelope"></i>
                <a href="mailto:<?php echo esc_attr($contact_way['contact_email']); ?>" target="_blank" rel="noopener">
                  <strong class="d-block contact-way-name">Email</strong>
                  <span class="contact-way-description"><?php echo esc_html($contact_way['contact_email']); ?></span>
                </a>
              </div>
            </li>
          <?php endif; ?>

          <!-- Telefone / WhatsApp -->
          <?php if (!empty($contact_way['contact_tel'])): ?>
            <li class="contact-way-item-phone col-12 col-md">
              <div class="border rounded d-flex align-items-center p-3">
                <i class="fa-brands fa-whatsapp fa-2x me-3"></i>
                <a href="https://wa.me/<?php echo esc_attr($contact_way['contact_tel']); ?>" target="_blank" rel="noopener">
                  <strong class="d-block contact-way-name">Telefone / WhatsApp</strong>
                  <span class="contact-way-description"><?php echo esc_html($contact_way['contact_tel']); ?></span>
                </a>
              </div>
            </li>
          <?php endif; ?>

          <!-- Localização -->
          <?php if (!empty($contact_way['contact_location']['contact_place'])): ?>
            <?php
            $loc = $contact_way['contact_location'];
            $place = $loc['contact_place'];
            $map   = $loc['contact_map'] ?? '#';
            ?>
            <li class="contact-way-item-location col-12 col-md">
              <div class="border rounded d-flex align-items-center p-3">
                <i class="fa-solid fa-map-pin fa-2x me-3"></i>
                <a href="<?php echo esc_url($map); ?>" target="_blank" rel="noopener">
                  <strong class="d-block contact-way-name">Localização</strong>
                  <span class="contact-way-description"><?php echo esc_html($place); ?></span>
                </a>
              </div>
            </li>
          <?php endif; ?>

        </ul>

      </div>

    </div>
  </section>

</main>

<?php get_footer(); ?>