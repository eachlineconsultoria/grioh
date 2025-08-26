<?php if (is_active_sidebar('primary-widget-area')): ?>
  <aside id="sidebar" class="sidebar" role="complementary" aria-label="<?php esc_attr_e('Barra lateral', 'grioh'); ?>">
    <?php dynamic_sidebar('primary-widget-area'); ?>
  </aside>
<?php endif; ?>