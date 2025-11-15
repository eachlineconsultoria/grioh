<form role="search" method="get" class="search-form w-50" action="<?php echo esc_url(home_url('/')); ?>">

  <div class="d-flex gap-2 align-items-center mb-4">

    <input type="search" class=" p-2 form-control" placeholder="Pesquisar no site"
      value="<?php echo get_search_query(); ?>" name="s" aria-label="Campo de busca" />

    <button class=" p-2 btn btn-outline-secondary" type="submit" id="button-search" title="Pesquisar">
      <i class="fa-solid fa-magnifying-glass"></i>
    </button>

  </div>

  <!-- Botão de fechar abaixo -->
  <div class="text-center mt-3">
    <button type="button" class="btn btn-link text-muted" data-bs-dismiss="modal" aria-label="Fechar">
    </button>
  </div>

</form>