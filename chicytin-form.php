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
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
				'menu_icon'   => 'dashicons-admin-site'
    );

    register_post_type( 'Actividad', $args ); /* Registramos y a funcionar */
}

add_action( 'init', 'actividades_post' );
add_action('init','AdvancedFieldsForm::display_form_results');
add_shortcode( 'customFieldForm', 'AdvancedFieldsForm::display' );
?>
