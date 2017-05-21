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

add_action('init','AdvancedFieldsForm::display_form_results');
add_shortcode( 'customFieldForm', 'AdvancedFieldsForm::display' );
?>
