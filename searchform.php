<form
  role="search"
  method="get"
  class="search-form w-50"
  action="<?php echo esc_url(home_url('/')); ?>">

  <div class="d-flex gap-2 align-items-center mb-4">

    <label for="modal-search-input" class="visually-hidden">
      Buscar no site
    </label>

    <input
      type="search"
      id="modal-search-input"
      class="form-control p-2"
      placeholder="Pesquisar no site"
      name="s"
      value="<?php echo esc_attr(get_search_query()); ?>"
      autocomplete="off"
      aria-label="Pesquisar no site" />

    <button
      class="btn btn-outline-secondary p-2"
      type="submit"
      id="button-search"
      title="Pesquisar">
      <span class="visually-hidden">Buscar</span>
      <i class="fa-solid fa-magnifying-glass"></i>
    </button>

  </div>



</form>