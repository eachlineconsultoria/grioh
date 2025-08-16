<!-- Modal de Busca -->
<div class="modal fade" id="modalBusca" tabindex="-1" aria-labelledby="modalBuscaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header">
        <h5 class="modal-title" id="modalBuscaLabel"><?php esc_html_e('Buscar no site', 'grioh'); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php esc_attr_e('Fechar', 'grioh'); ?>"></button>
      </div>
      <div class="modal-body">
        <?php get_search_form(); ?>
      </div>
    </div>
  </div>
</div>