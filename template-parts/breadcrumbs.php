<?php
/**
 * Breadcrumbs estilo Bootstrap
 * Suporte: páginas, posts, categorias e custom post types
 * Inclui microdados schema.org
 *
 * @package Eachline
 */

if (is_front_page() || is_home()) {
  return; // não exibe na home
}

global $post;
?>

<nav aria-label="breadcrumb" class="container mb-3" itemscope itemtype="https://schema.org/BreadcrumbList">
  <ol class="breadcrumb m-0">

    <!-- Home -->
    <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
      <a href="<?php echo esc_url(home_url('/')); ?>" itemprop="item">
        <span itemprop="name">Página inicial</span>
      </a>
      <meta itemprop="position" content="1" />
    </li>

    <?php
    $position = 2;

    // ------------------------------
    // Páginas e hierarquia de páginas
    // ------------------------------
    if (is_page() && !is_front_page()) {
      $ancestors = array_reverse(get_post_ancestors($post->ID));

      foreach ($ancestors as $ancestor_id): ?>
        <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
          <a href="<?php echo esc_url(get_permalink($ancestor_id)); ?>" itemprop="item">
            <span itemprop="name"><?php echo esc_html(get_the_title($ancestor_id)); ?></span>
          </a>
          <meta itemprop="position" content="<?php echo $position++; ?>" />
        </li>
      <?php endforeach; ?>

      <li class="breadcrumb-item active fw-bold" aria-current="page" itemprop="itemListElement"
          itemscope itemtype="https://schema.org/ListItem">
        <span class="fw-bold" itemprop="name"><?php echo esc_html(get_the_title()); ?></span>
        <meta itemprop="position" content="<?php echo $position; ?>" />
      </li>
    <?php }

    // ------------------------------
    // Posts e CPTs
    // ------------------------------
    elseif (is_singular()) {
      $post_type = get_post_type();

      if ($post_type === 'post') {
        $category = get_the_category();
        if ($category) {
          $main_cat = $category[0]; ?>
          <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a href="<?php echo esc_url(get_category_link($main_cat->term_id)); ?>" itemprop="item">
              <span itemprop="name"><?php echo esc_html($main_cat->name); ?></span>
            </a>
            <meta itemprop="position" content="<?php echo $position++; ?>" />
          </li>
        <?php }
      } elseif ($post_type !== 'page' && $post_type_obj = get_post_type_object($post_type)) {
        if (!empty($post_type_obj->has_archive)) { ?>
          <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a href="<?php echo esc_url(get_post_type_archive_link($post_type)); ?>" itemprop="item">
              <span itemprop="name"><?php echo esc_html($post_type_obj->labels->singular_name); ?></span>
            </a>
            <meta itemprop="position" content="<?php echo $position++; ?>" />
          </li>
        <?php }
      } ?>

      <li class="breadcrumb-item active fw-bold" aria-current="page" itemprop="itemListElement"
          itemscope itemtype="https://schema.org/ListItem">
        <span itemprop="name"><?php echo esc_html(get_the_title()); ?></span>
        <meta itemprop="position" content="<?php echo $position; ?>" />
      </li>

    <?php }

    // ------------------------------
    // Categorias e arquivos
    // ------------------------------
    elseif (is_category()) { ?>
      <li class="breadcrumb-item active fw-bold" aria-current="page" itemprop="itemListElement"
          itemscope itemtype="https://schema.org/ListItem">
        <span itemprop="name"><?php single_cat_title(); ?></span>
        <meta itemprop="position" content="<?php echo $position; ?>" />
      </li>
    <?php }

    elseif (is_post_type_archive()) {
      $post_type_obj = get_post_type_object(get_post_type()); ?>
      <li class="breadcrumb-item active fw-bold" aria-current="page" itemprop="itemListElement"
          itemscope itemtype="https://schema.org/ListItem">
        <span itemprop="name"><?php echo esc_html($post_type_obj->labels->name); ?></span>
        <meta itemprop="position" content="<?php echo $position; ?>" />
      </li>
    <?php }

    // ------------------------------
    // Busca e 404
    // ------------------------------
    elseif (is_search()) { ?>
      <li class="breadcrumb-item active fw-bold" aria-current="page" itemprop="itemListElement"
          itemscope itemtype="https://schema.org/ListItem">
        <span itemprop="name">Busca por “<?php echo esc_html(get_search_query()); ?>”</span>
        <meta itemprop="position" content="<?php echo $position; ?>" />
      </li>
    <?php }

    elseif (is_404()) { ?>
      <li class="breadcrumb-item active fw-bold" aria-current="page" itemprop="itemListElement"
          itemscope itemtype="https://schema.org/ListItem">
        <span itemprop="name">Página não encontrada</span>
        <meta itemprop="position" content="<?php echo $position; ?>" />
      </li>
    <?php } ?>
  </ol>
</nav>
