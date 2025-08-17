<?php
// searchform.php
$unique_id = esc_attr(uniqid('search-form-'));
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
  <div class="input-group">
    <label class="visually-hidden" for="<?php echo $unique_id; ?>">
      <?php esc_html_e('Buscar por:', 'grioh'); ?>
    </label>
    <input type="search" id="<?php echo $unique_id; ?>" class="form-control"
      placeholder="<?php esc_attr_e('Digite e pressione Enter…', 'grioh'); ?>"
      value="<?php echo get_search_query(); ?>" name="s" required
      aria-label="<?php esc_attr_e('Campo de busca', 'grioh'); ?>">
    <button class="btn btn-primary" type="submit">
      <?php esc_html_e('Buscar', 'grioh'); ?>
    </button>
  </div>
</form>