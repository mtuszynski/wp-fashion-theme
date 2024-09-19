<?php

function custom_get_posts($number_posts = '5',
                          $post_type = 'post',
                          $category_name = '',
                          $order_by = 'date',
                          $order = 'DESC',
                          $additional_args = array())
{
  if ($post_type === 'post') :
    $args = array(
      'post_type' => $post_type,
      'order_by' => $order_by,
      'order' => $order,
      'category_name' => $category_name,
      'fields' => 'ids',
      'posts_per_page' => $number_posts,
    );

  elseif ($category_name === '' && $post_type != 'post') :
    $args = array(
      'post_type' => $post_type,
      'order_by' => $order_by,
      'order' => $order,
      'fields' => 'ids',
      'posts_per_page' => $number_posts,
    );
  else :
    $args = array(
      'post_type' => $post_type,
      'order_by' => $order_by,
      'order' => $order,
      'tax_query' => array(
        array(
          'taxonomy' => 'category_know',
          'field' => 'slug',
          'terms' => $category_name
        )
      ),
      'fields' => 'ids',
      'posts_per_page' => $number_posts,
    );
  endif;

  $result = array_merge($args, $additional_args);

  $query = new WP_Query($result);

  wp_reset_postdata();
  return $query;
}
