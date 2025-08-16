<?php
add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', [], '5.3.3');
  wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css', [], '1.11.3');
  wp_enqueue_style('grioh-google-fonts', 'https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap', [], null);

  wp_enqueue_style('grioh-style', get_stylesheet_uri(), ['bootstrap'], filemtime(get_stylesheet_directory() . '/style.css'));

  wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', [], '5.3.3', true);
});

// preconnect
add_action('wp_head', function () {
  echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
  echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}, 1);
