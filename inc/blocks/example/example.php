<?php

function example ($name) {
  return acf_register_block_type(array(
    'name'              => 'example',
    'title'             => __('Example'),
    'description'       => __('A custom example block.'),
    'render_template'   => 'template-parts/blocks/example/example.php',
    'category'          => 'theme',
    'mode'              => 'edit',
    'example'  => array(
      'attributes' => array(
        'mode' => 'preview',
        'data' => array(
          'example'   => "Your testimonial text here",
          'author'        => "John Smith"
        )
      )
    ),
    'icon'              => 'admin-comments',
    'keywords'          => array( 'testimonial', 'quote' ),
    /*'enqueue_assets' => function() use ($name) {
      wp_enqueue_style( 'block-example', get_template_directory_uri() . '/css/blocks/' . sprintf($name, 'example') . '.css', false, false);
      wp_enqueue_script( 'block-example', get_template_directory_uri() . '/js/blocks/' . sprintf($name, 'example') . '.js', array(), false, true);
    },*/
  ));
}
