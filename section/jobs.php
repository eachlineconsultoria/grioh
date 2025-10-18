<?php if (get_field('jobs_section')): ?>
  <section id="vagas" class="section-container vagas">
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between">
      <h2 class="section-title text-center text-md-start">Pronto para a jornada extraordinária conosco?</h2>

      <?php
      $slug = 'trabalhe-conosco'; // Slug da categoria
      $category = get_category_by_slug($slug);
      $link = $category ? get_category_link($category->term_id) : '#';
      ?>

      <a href="<?php echo esc_url('/trabalhe-conosco'); ?>" class="mt-5 mt-md-0 link-text link-white">
        Acesse as vagas <i class="ms-2 fa-solid fa-arrow-right"></i>
      </a>
    </div>
  </section>
<?php endif; ?>