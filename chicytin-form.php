<?php
/*
Plugin Name: Formulario Chicytin
Description: Formulario con filtros para custom fields
Author: Hazmeweb
Version: 1.0
*/

class AdvancedFieldsForm
{
  public static function display(){
    include ('views/fieldsFormView.php');
  }

  public static function display_form_results(){
      if( isset($_REQUEST['search']) == 'advanced' ) {
          $path = plugin_dir_path( __FILE__ );
          include_once($path.'controllers/fieldsFormController.php');
          die();
      }
  }
}

function actividades_post() {
	$labels = array(
	'name' => _x( 'Actividades', 'post type general name' ),
        'singular_name' => _x( 'Actividad', 'post type singular name' ),
        'add_new' => _x( 'Añadir nuevo', 'book' ),
        'add_new_item' => __( 'Añadir nueva actividad' ),
        'edit_item' => __( 'Editar Actividad' ),
        'new_item' => __( 'Nueva Actividad' ),
        'view_item' => __( 'Ver Actividad' ),
        'search_items' => __( 'Buscar Actividads' ),
        'not_found' =>  __( 'No se han encontrado Actividades' ),
        'not_found_in_trash' => __( 'No se han encontrado Actividades en la papelera' ),
        'parent_item_colon' => ''
    );

    // Creamos un array para $args
    $args = array( 'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'has_archive'  => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
		'menu_icon'   => 'dashicons-admin-site',
        'taxonomies'  => array('post_tag'),
    );

    register_post_type( 'Actividad', $args ); /* Registramos y a funcionar */
}

function create_actividad_taxonomies() {
    $labels = array(
        'name'              => _x( 'Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Categories' ),
        'all_items'         => __( 'All Categories' ),
        'parent_item'       => __( 'Parent Category' ),
        'parent_item_colon' => __( 'Parent Category:' ),
        'edit_item'         => __( 'Edit Category' ),
        'update_item'       => __( 'Update Category' ),
        'add_new_item'      => __( 'Add New Category' ),
        'new_item_name'     => __( 'New Category Name' ),
        'menu_name'         => __( 'Categories' ),
    );

    $args = array(
        'hierarchical'      => true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'categories' ),
    );

    register_taxonomy( 'actividad_categories', array( 'actividad' ), $args );
}

function create_localidad_taxonomies() {
    $labels = array(
        'name'              => _x( 'Localidades/Provincias/Distritos', 'taxonomy general name' ),
        'singular_name'     => _x( 'Localidad/Provincia/Distrito', 'taxonomy singular name' ),
        'search_items'      => __( 'Buscar localidad/provincia' ),
        'all_items'         => __( 'Todas las localidades, provincias y distritos' ),
        'parent_item'       => __( 'Parent' ),
        'parent_item_colon' => __( 'Parent:' ),
        'edit_item'         => __( 'Editar Localidades/Provincias/Distritos' ),
        'update_item'       => __( 'Editar Localidad/Provincia/Distritos' ),
        'add_new_item'      => __( 'Añadir nueva localidad/provincia/distrito' ),
        'new_item_name'     => __( 'Nueva Localidad/Provincia/Distrito' ),
        'menu_name'         => __( 'Localidades/Provincias/Distritos' ),
    );

    $args = array(
        'hierarchical'      => true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'localidades' ),
    );

    register_taxonomy( 'localidad_categories', array( 'actividad' ), $args );
}


add_action( 'init', 'create_actividad_taxonomies', 0 );
add_action('init', 'create_localidad_taxonomies', 0);
add_action( 'init', 'actividades_post' );
add_action('init','AdvancedFieldsForm::display_form_results');
add_action( 'wp_ajax_nopriv_get_subcategorias', 'cf_get_subcategorias' );
add_action( 'wp_ajax_get_subcategorias', 'cf_get_subcategorias' );
add_shortcode( 'customFieldForm', 'AdvancedFieldsForm::display' );
?>
