<?php
/*
Plugin Name: Formulario Chicytin
Description: Formulario con filtros para custom fields
Author: Hazmeweb
Version: 1.0
*/

class AdvancedFieldsForm
{
  public function display(){
    include ('views/fieldsFormView.php');
    add_shortcode( 'customFieldForm', $this->display() );
  }
}
?>
