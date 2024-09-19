<?php

function GetCategoryName($position = 0, $custom_taxonomy = false, $category_type = '')
{
  if (!$custom_taxonomy):
    $categories = get_the_category();
    $categories = $categories[$position]->name;
  else :
    $categories = get_terms($category_type);
    $categories = $categories[$position]->name;
  endif;

  return $categories;
}

function GetCategoryID($position = 0, $custom_taxonomy = false, $category_type = '')
{
  if (!$custom_taxonomy):
    $categories = get_the_category();
    $categories = $categories[$position]->ID;
  else :
    $categories = get_terms($category_type);
    $categories = $categories[$position]->ID;
  endif;

  return $categories;
}

function pre_dump($value) {
  echo '<pre style="white-space: pre">';
  print_r($value);
  echo '</pre>';
}

add_action('admin_head', 'hide_posts_pages');

function hide_posts_pages() {
  global $current_user;
  wp_get_current_user();
  If($current_user->user_login != 'admin') {
    ?>
    <style>
      #menu-posts {
        display:none;
      }
    </style>
    <?php
  }
}
