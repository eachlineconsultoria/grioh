<?php
$term = get_queried_object();
$tax = isset($term->taxonomy) ? $term->taxonomy : 'category';
$slug = !empty($term->slug) ? sanitize_title($term->slug) : '';

$templates = [];
if ($slug) {
  $templates[] = "template-parts/{$tax}/{$slug}.php";
}
$templates[] = "template-parts/{$tax}/default.php";
$templates[] = "template-parts/default.php";

locate_template($templates, true, false);
