<?php
/**
 * Formulário de busca estilizado para modal (Eachline)
 * Inclui animações, acessibilidade e foco automático.
 * @package Eachline
 */
?>

<form role="search" method="get" class="eachline-search-form" action="<?php echo esc_url(home_url('/')); ?>">
  <div class="search-wrapper position-relative mx-auto">

    <label for="search-field" class="visually-hidden">Buscar no site</label>

    <input
      type="search"
      id="search-field"
      name="s"
      class="search-input form-control rounded-pill px-5 py-3 shadow-sm border-0"
      placeholder="O que você quer encontrar?"
      value="<?php echo get_search_query(); ?>"
      autocomplete="off"
      aria-label="Buscar"
    />

    <button type="submit" class="search-btn btn btn-primary rounded-pill px-4">
      <span>Buscar</span>
      <i class="fa-solid fa-arrow-right ms-2"></i>
    </button>

    <i class="fa-solid fa-magnifying-glass search-icon position-absolute top-50 start-0 translate-middle-y ps-4 text-muted"></i>
  </div>
</form>
