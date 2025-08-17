</main><!-- /#content -->

<footer class="py-4 border-top">
  <div class="container small text-muted">
    &copy; <?php echo date('Y'); ?> Grioh Games — <?php esc_html_e('Desenvolvido por', 'grioh'); ?> Wagner Beethoven.
  </div>
</footer>

<?php get_template_part('template-parts/modal-search'); ?>


<?php wp_footer(); ?>
<script src="<?php bloginfo('template_url')?>/js/show-hide-player.js"></script>
</body>

</html>