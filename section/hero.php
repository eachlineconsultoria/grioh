<?php
$display = get_field('hero_container'); // grupo principal
$hero = $display['display_hero'] ?? null; // subgrupo interno

if ($hero): ?>

  <section id="hero" class="container custom-page-header hero container">
    <div class="row">
      <div
        class="section hero-content position-relative d-flex flex-column justify-content-center align-self-start col-12 col-md-6 mb-3 mb-md-0">
        <h1 class="section-title">
          <?php $group = get_field('hero_container');
          echo esc_html($group['hero_title'] ?? ''); ?>
        </h1>
        <p class="section-description">
          <?php $group = get_field('hero_container');
          echo esc_html($group['hero_description'] ?? ''); ?>
        </p>

        <?php
        $hero_group = get_field('hero_container'); // grupo principal
        $button = $hero_group['hero_button'] ?? []; // subgrupo hero_button
      
        $link = esc_url($button['hero_button_link'] ?? '#');
        $text = esc_html($button['hero_button_text'] ?? '');
        $icon = $button['hero_button_icon'] ?? '';
        ?>

        <a href="<?php echo $link; ?>" class="hero-link link-text link-primary">
          <?php echo $text; ?>

          <?php if ($icon): ?>
            <i class="ms-2 <?php echo esc_attr($icon); ?>"></i>
          <?php else: ?>
            <i class="ms-2 fa-solid fa-arrow-right"></i>
          <?php endif; ?>
        </a>


        <?php
        $group = get_field('hero_container');
        $icon_choice = $group['icon_choice'] ?? ''; // campo direto no grupo principal
      
        if ($icon_choice):
          ?>
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