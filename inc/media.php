<?php
/**
 * Mídia e tamanhos de imagem
 * @package grioh
 */

// Desabilita o redimensionamento "big" automático do WP
add_filter('big_image_size_threshold', '__return_false');

// Remove alguns tamanhos intermediários pesados
add_filter('intermediate_image_sizes_advanced', function ($sizes) {
  unset($sizes['medium_large'], $sizes['1536x1536'], $sizes['2048x2048']);
  return $sizes;
});

// (Opcional) declarar tamanhos custom
// add_image_size('grioh-card', 640, 360, true);
// add_image_size('grioh-thumb', 320, 180, true);
