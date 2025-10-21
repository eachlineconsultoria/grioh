<?php
$title = get_field('case_title');
$link = get_field('case_link');
?>

<section id="cases" class="container section-container cases">
  <header
    class="section-header d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between">
    <h2 class="section-title">
      <?php if (get_field('case_title')): ?>
        <?php echo $title; ?> <?php else: ?> Clientes
      <?php endif; ?>
    </h2>
    <?php if (get_field('case_link')): ?>
      <a href="<?php bloginfo('url'); ?>/clientes#cases" class="card-link link-text link-primary">Acesse todos os cases<i
          class="ms-2 fa-solid fa-arrow-right"></i></a>
    <?php else: ?>
    <?php endif; ?>

  </header>
  <?php require_once get_template_directory() . '/loop/cases.php'; ?>

</section>