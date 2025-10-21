<?php if (get_field('main_section')):
  $title = get_field('custom_header_title');
  $description = get_field('custom_header_description');
  $button_text = get_field('custom_button_text');
  $button_link = get_field('custom_button_link');
  $icon_choice = get_field('custom_icon_choice');
  $custom_section_icon = get_field('custom_section_icon');

  ?>

  <section id="hero" class="container custom-page-header hero container">
    <div class="row">
      <div
        class="section hero-content position-relative d-flex flex-column justify-content-center align-self-start col-12 col-md-6 mb-3 mb-md-0">

        <h1 class="section-title"><?php echo esc_html($title); ?></h1>

        <p class="section-description"><?php echo ($description); ?></p>

        <a href="<?php echo esc_url($button_link); ?>" class="hero-link link-text link-primary">

          <?php echo esc_html(get_field('main_section_button')['custom_button_text'] ?? ''); ?>

          <?php
          $main_section_button = get_field('main_section_button');
          $custom_section_icon = $main_section_button['custom_section_icon'] ?? '';

          if ($custom_section_icon): ?>
            <i class="ms-2 <?php echo esc_html($custom_section_icon); ?>"></i>
          <?php else: ?>
            <i class="ms-2 fa-solid fa-arrow-right"></i>
          <?php endif; ?>



        </a>

        <?php if ($icon_choice): ?>
          <div class="hero-icon position-absolute">
            <?php
            $icon_base = get_template_directory_uri() . '/assets/img/icons/';

            switch ($icon_choice) {
              case 'square':
                echo '<img src="' . $icon_base . 'icon-square.svg" alt="Ícone quadrado" class="custom-icon" />';
                break;
              case 'circle':
                echo '<img src="' . $icon_base . 'icon-circle.svg" alt="Ícone círculo" class="custom-icon" />';
                break;
              case 'equal':
                echo '<img src="' . $icon_base . 'icon-equal.svg" alt="Ícone igual" class="custom-icon" />';
                break;
              case 'arrow':
                echo '<img src="' . $icon_base . 'icon-arrow.svg" alt="Ícone seta" class="custom-icon" />';
                break;
            }
            ?>
          </div>
        <?php endif; ?>
      </div>

      <figure class="hero-image col-12 col-md-6 position-relative">
        <?php if (has_post_thumbnail()): ?>
          <img src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'large')); ?>"
            class="img-fluid w-100 h-100 rounded object-fit-cover" alt="">
        <?php endif; ?>
      </figure>
    </div>
  </section>

<?php endif; ?>