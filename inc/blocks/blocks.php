<?php

include_once('example/example.php');

add_action('acf/init', 'my_acf_init_block_types');
function my_acf_init_block_types() {
  $name = WP_DEBUG ? '%s' : '%s.min';

  // Check function exists.
  if (function_exists('acf_register_block_type')) {
    example($name);
  }
}

add_filter( 'block_categories_all', 'example_block_category', 10, 2);
function example_block_category( $categories, $post ) {
  return array_merge(
    $categories,
    array(
      array(
        'slug' => 'theme',
        'title' => 'Theme',
      ),
    )
  );
}
