<?php
/**
 * Sidebar principal do tema Eachline
 *
 * @package Eachline
 */

if ( ! is_active_sidebar('sidebar') ) {
    return;
}
?>

<aside 
  id="secondary" 
  class="widget-area col-12 col-md-4 sidebar"
  role="complementary"
  aria-label="Barra lateral"
>
  <?php dynamic_sidebar('sidebar'); ?>
</aside>
