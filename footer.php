</main>
<?php get_sidebar(); ?>
</div>
<footer class="py-4 border-top" id="footer" role="contentinfo">
  <div class="container small text-muted">
    &copy; <?php echo date('Y'); ?> Grioh Games — <?php esc_html_e('Desenvolvido por', 'grioh'); ?> Wagner Beethoven.
  </div>
</footer>
</div>
<?php wp_footer(); ?>
<?php get_template_part('parts/modal-search');?>
</body>
</html>