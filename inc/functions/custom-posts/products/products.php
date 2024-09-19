<?php


function products_post_type()
{
  $labels = array(
    'name' => _x('Produkty', 'Post Type General Name', 'theme'),
    'singular_name' => _x('Produkt', 'Post Type Singular Name', 'theme'),
    'menu_name' => __('Produkty', 'theme'),
    'parent_item_colon' => __('Rodzic produktu', 'theme'),
    'all_items' => __('Wszystkie produkty', 'theme'),
    'view_item' => __('Pokaż produkt', 'theme'),
    'add_new_item' => __('Dodaj nowy produkt', 'theme'),
    'add_new' => __('Dodaj produkt', 'theme'),
    'edit_item' => __('Edytuj produkt', 'theme'),
    'update_item' => __('Aktualizuj produkt ', 'theme'),
    'search_items' => __('Szukaj produktu', 'theme'),
    'not_found' => __('Nie znaleziono', 'theme'),
    'not_found_in_trash' => __('Nie znaleziono w koszu', 'theme'),
  );

  $args = array(
    'label' => __('products', 'theme'),
    'description' => __('', 'theme'),
    'labels' => $labels,
    'taxonomies' => array('category_products'),
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

  register_post_type('products', $args);
}

add_action('init', 'products_post_type', 0);

add_action('init', 'create_products_category', 0);

function create_products_category()
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

  register_taxonomy('category_products', array('products'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'query_var' => true,
  ));
}

/* Links posts */

function products_cpt_generating_rule($wp_rewrite) {
  $rules = array();
  $terms = get_terms( array(
    'taxonomy' => 'category_products',
    'hide_empty' => false,
  ) );

  $post_type = 'products';

  foreach ($terms as $term) {

    $rules[$term->slug .  '/([^/]*)$'] = 'index.php?post_type=' . $post_type. '&products=$matches[1]&name=$matches[1]';

  }

  // merge with global rules
  $wp_rewrite->rules = $rules + $wp_rewrite->rules;
}
add_filter('generate_rewrite_rules', 'products_cpt_generating_rule');

flush_rewrite_rules();

function change_link_products( $permalink, $post ) {
  if( $post->post_type == 'products' ) {
    $permalink = home_url(get_the_terms( $post->ID, 'category_products' )[0]->name . '/' . $post->post_name );
  }
  return $permalink;
}
add_filter('post_type_link',"change_link_products",10,2);
