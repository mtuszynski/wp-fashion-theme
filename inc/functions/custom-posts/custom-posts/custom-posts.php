<?php


function custom_posts_post_type()
{
  $labels = array(
    'name' => _x('Posty', 'Post Type General Name', 'theme'),
    'singular_name' => _x('Posty', 'Post Type Singular Name', 'theme'),
    'menu_name' => __('Posty', 'theme'),
    'parent_item_colon' => __('Rodzic posta', 'theme'),
    'all_items' => __('Wszystkie posty', 'theme'),
    'view_item' => __('Pokaż post', 'theme'),
    'add_new_item' => __('Dodaj nowy post', 'theme'),
    'add_new' => __('Dodaj post', 'theme'),
    'edit_item' => __('Edytuj post', 'theme'),
    'update_item' => __('Aktualizuj post ', 'theme'),
    'search_items' => __('Szukaj posta', 'theme'),
    'not_found' => __('Nie znaleziono', 'theme'),
    'not_found_in_trash' => __('Nie znaleziono w koszu', 'theme'),
  );

  $args = array(
    'label' => __('custom-posts', 'theme'),
    'description' => __('', 'theme'),
    'labels' => $labels,
    'taxonomies' => array('category_custom_posts'),
    'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields',),
    'hierarchical' => false,
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => true,
    'show_in_admin_bar' => true,
    'menu_position' => 5,
    'can_export' => true,
    'has_archive' => true,
    'rewrite' => true,
    'exclude_from_search' => false,
    'publicly_queryable' => true,
    'capability_type' => 'post',
    'show_in_rest' => true,
  );

  register_post_type('custom-posts', $args);
}

add_action('init', 'custom_posts_post_type', 0);

add_action('init', 'create_custom_posts_category', 0);

function create_custom_posts_category()
{

  $labels = array(
    'name' => _x('Kategorie', 'taxonomy general name'),
    'singular_name' => _x('Kategoria', 'taxonomy singular name'),
    'search_items' => __('Szukaj kategorii'),
    'all_items' => __('Wszystkie kategorie'),
    'parent_item' => __('Rodzic kategorii'),
    'parent_item_colon' => __('Rodzic kategorii:'),
    'edit_item' => __('Edytuj kategorie'),
    'update_item' => __('Aktualizuj kategorie'),
    'add_new_item' => __('Dodaj nową kategorie'),
    'new_item_name' => __('Nowa nazwa kategorii'),
    'menu_name' => __('Kategorie'),
  );

  register_taxonomy('category_custom_posts', array('custom-posts'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => true,
  ));
}

/* Links posts */

function custom_posts_cpt_generating_rule($wp_rewrite) {
  $rules = array();
  $terms = get_terms( array(
    'taxonomy' => 'category_custom_posts',
    'hide_empty' => false,
  ) );

  $post_type = 'custom-posts';

  foreach ($terms as $term) {

    $rules[$term->slug . '/blog' .  '/([^/]*)$'] = 'index.php?post_type=' . $post_type. '&custom-posts=$matches[1]&name=$matches[1]';

  }

  // merge with global rules
  $wp_rewrite->rules = $rules + $wp_rewrite->rules;
}
add_filter('generate_rewrite_rules', 'custom_posts_cpt_generating_rule');

flush_rewrite_rules();

function change_link_posts ( $permalink, $post ) {
  if( $post->post_type == 'custom-posts' ) {
    $permalink = home_url(get_the_terms( $post->ID, 'category_custom_posts' )[0]->name . '/blog/' . $post->post_name );
  }
  return $permalink;
}
add_filter('post_type_link',"change_link_posts",10,2);

/* Links posts end */

