<?php
$cases_container = get_field('cases_container');

if (!empty($cases_container['case_section'])):

  $title = trim($cases_container['case_title'] ?? '');
  $show_link = !empty($cases_container['case_link']);
  ?>
  <section id="cases" class="container section-container cases">
    <header
      class="section-header d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between">

      <h2 class="section-title">
        <?php echo esc_html($title ?: 'Clientes'); ?>
      </h2>

      <?php if ($show_link): ?>
        <a href="<?php
        $category = get_category_by_slug('cases');

        if ($category) {
          $category_link = get_category_link($category->term_id);
          echo esc_url($category_link);
        }
        ?>" class="card-link link-text link-primary" title="Acesse todos os cases">
          Acesse todos os cases
          <i class="ms-2 fa-solid fa-arrow-right" aria-hidden="true"></i>
        </a>
      <?php endif; ?>

    </header>

    <?php require_once get_template_directory() . '/loop/cases.php'; ?>
  </section>
<?php endif; ?>