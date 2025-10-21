<?php if (get_field('press_section')):
  $title = get_field('press_header_title');
  $clipping = get_field('clipping');
  ?>
  <section id="press" class="section-container press">
    <div
      class="container d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between">
      <h2 class="section-title text-center text-md-start">
        <?php if (get_field('press_header_title')): ?>
          <?php echo $title; ?>   <?php else: ?> Saiba o que andamos fazendo na imprensa e nos eventos
        <?php endif; ?>


      </h2>

      <div class="button-group">
        <?php if (get_field('clipping')): ?>
          <a href="<?php bloginfo('url'); ?>/artigos/imprensa" class="mt-5 mt-md-0 link-text">
            Clipping <i class="ms-2 fa-solid fa-newspaper"></i>
          </a>
        <?php endif; ?>
        <?php if (get_field('events')): ?>
          <a href="<?php bloginfo('url'); ?>'/artigos/eventos" class="ms-4 mt-5 mt-md-0 link-text">
            Eventos <i class="ms-2 fa-solid fa-calendar"></i>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </section>
<?php endif; ?>