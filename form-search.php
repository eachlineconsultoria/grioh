<?php
/**
 * Formulário de busca estilizado para modal (Eachline)
 * Otimizado para acessibilidade, SEO, semântica e performance.
 *
 * @package Eachline
 */
?>

<form 
  role="search" 
  method="get" 
  class="eachline-search-form"
  action="<?php echo esc_url(home_url('/')); ?>"
  aria-label="Formulário de busca do site"
>

  <div class="search-wrapper position-relative mx-auto">

    <!-- Rótulo visualmente oculto para acessibilidade -->
    <label for="search-field" class="visually-hidden">Buscar no site</label>

    <!-- Campo de busca principal -->
    <input
      type="search"
      id="search-field"
      name="s"
      class="search-input form-control rounded-pill px-5 py-3 shadow-sm border-0"
      placeholder="O que você quer encontrar?"
      value="<?php echo esc_attr(get_search_query()); ?>"
      autocomplete="off"
      aria-label="Digite sua busca"
      spellcheck="false"
    />

    <!-- Ícone da lupa (decorativo, oculto para leitores de tela) -->
    <i 
      class="fa-solid fa-magnifying-glass search-icon position-absolute top-50 start-0 translate-middle-y ps-4 text-muted" 
      aria-hidden="true"
    ></i>

    <!-- Botão de envio -->
    <button 
      type="submit"
      class="search-btn btn btn-primary rounded-pill px-4"
      aria-label="Confirmar busca"
    >
      <span>Buscar</span>
      <i class="fa-solid fa-arrow-right ms-2" aria-hidden="true"></i>
    </button>

  </div>
</form>
