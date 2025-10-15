<section class="cta border-top border-bottom section-container position-relative">
  <div class="container">
    <?php
    $slug = 'contato';
    $page = get_page_by_path($slug);

    if ($page):
      $link = get_permalink($page->ID);
      ?>
      <a href="<?php echo esc_url($link); ?>" class="d-flex align-items-center stretched-link" title="Vamos aplicar acessibilidade no seu produto digital?">
        Transforme sua Jornada digital
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/animated-icon.gif" alt="" class="ms-3">
      </a>
    <?php endif; ?>
  </div>


</section>