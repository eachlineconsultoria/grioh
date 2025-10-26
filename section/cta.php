<?php
$cta = get_field('cta_container');

if (!empty($cta['cta_section'])):
  $title = trim($cta['cta_title'] ?? '');
  $link = esc_url($cta['cta_link'] ?? '#');
  ?>
  <section class="cta border-top border-bottom section-container position-relative">
    <div class="container">
      <a href="<?php echo $link; ?>"
        class="section-title text-center text-md-start d-flex align-items-center stretched-link"
        title="<?php echo esc_attr($title ?: 'Transforme sua jornada digital'); ?>">

        <?php echo esc_html($title ?: 'Transforme sua jornada digital'); ?>

        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/animated-icon.gif"
          alt="Ícone animado decorativo" class="ms-3">
      </a>
    </div>
  </section>
<?php endif; ?>