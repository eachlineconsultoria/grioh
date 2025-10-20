<?php
/**
 * Template Name: Página de Contato
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
                    <span class="fa-stack fa-2x me-3">
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
                    <span class="fa-stack fa-2x me-3">
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
            <a class="mt-3 button button-primary " href="/imprensa">Clipping<i
                class="ms-2 fa-solid fa-arrow-right"></i></a>


            </p>

            <p>Para material institucional, acesse <a href="sobre/manual-marca">nosso manual da marca</a>.</p>
            <?php if (is_active_sidebar('aside-contact')): ?>
              <?php dynamic_sidebar('aside-contact'); ?>
            <?php endif; ?>
          </aside>
        </div>
      </div>


      <div class="row contact-way">
        <h3 class="col-12">Outras formas de contato</h3>
        <ul class="contact-way-list p-0 row">
          <!-- Contact email -->
          <?php
          $contact_way_email = get_field('contact_way'); // isso traz um array associativo
          if ($contact_way_email && !empty($contact_way_email['contact_email'])):
            $contact_email = $contact_way_email['contact_email'];
            ?>
            <li class="contact-way-item contact-way-item-email col-12 col-md">
              <div class="border rounded d-flex justify-content-start">
                <i class="fa-regular fa-2x me-3 fa-envelope"></i>
                <a href="mailto:<?php echo esc_attr($contact_email); ?>" target="_blank" rel="noopener">

                  <strong class="contact-way-name">Email</strong>
                  <span class="contact-way-description"><?php echo esc_html($contact_email); ?></span>
                </a>
              </div>
            </li>
          <?php endif; ?>

          <!-- Contact phone number -->
          <?php
          $contact_way_email = get_field('contact_way'); // isso traz um array associativo
          if ($contact_way_email && !empty($contact_way_email['contact_tel'])):
            $contact_tel = $contact_way_email['contact_tel'];
            ?>
            <li class="contact-way-item contact-way-item-phone col-12 col-md">
              <div class="border rounded d-flex justify-content-start">
                <i class="fa-brands fa-whatsapp fa-2x me-3"></i>

                <a href="http://wa.me/+<?php echo esc_attr($contact_tel); ?>" target="_blank" rel="noopener">

                  <strong class="contact-way-name">Telefone/WhatsApp</strong>
                  <span class="contact-way-description"><?php echo esc_html($contact_tel); ?></span>
                </a>
              </div>
            </li>
          <?php endif; ?>


          <!-- Contact location -->

          <?php
          $contact_way = get_field('contact_way');

          if ($contact_way && !empty($contact_way['contact_location'])):
            $location = $contact_way['contact_location'];
            $place = $location['contact_place'] ?? '';
            $map_link = $location['contact_map'] ?? '';
            ?>

            <li class="contact-way-item contact-way-item-location col-12 col-md">
              <div class="border rounded d-flex justify-content-start">
                <i class="fa-solid fa-2x me-3 fa-map-pin"></i>
                <a href="<?php echo esc_url($map_link); ?>" target="_blank" rel="noopener">
                  <strong class="contact-way-name">Localização</strong>
                  <span class="contact-way-description">
                    <?php echo esc_html($place); ?>
                  </span>
                </a>
              </div>
            </li>

          <?php endif; ?>
        </ul>


      </div>
    </div>
  </section>

  <?php require_once get_template_directory() . '/section/testimonial.php'; ?>

  <?php require_once get_template_directory() . '/section/cases.php'; ?>


</main>

<?php get_footer(); ?>