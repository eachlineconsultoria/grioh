<?php if (get_field('jobs_section')): ?>
  <section id="vagas" class="section-container vagas">
    <div class="container d-flex align-items-center justify-content-center justify-content-md-between">
      <h2 class="section-title">Pronto para a jornada extraordinária conosco?</h2>

      <?php
      $slug = 'trabalhe-conosco'; // Slug da categoria
      $category = get_category_by_slug($slug);
      $link = $category ? get_category_link($category->term_id) : '#';
      ?>

      <a href="<?php echo esc_url('/trabalhe-conosco'); ?>" class="card-link link link-branco">
        Acesse as vagas <i class="ms-2 fa-solid fa-arrow-right"></i>
      </a>
    </div>
  </section>
<?php endif; ?>