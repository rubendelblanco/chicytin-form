<?php
  $path = plugin_dir_path( __FILE__ );
  include_once($path.'../models/fieldsFormModel.php');
  global $wpdb;
  $conn = new FieldsFormModel($wpdb);
  $actividades = $conn->getActividadesValue();
  $ciudades = $conn->getLocalidadValue();
 ?>
<form method="get" id="advanced-searchform" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>">

    <h3><?php _e( 'Búsqueda por campos', 'textdomain' ); ?></h3>
    <input type="hidden" name="search" value="advanced">

    <label for="tipo_de_actividad" class=""><?php _e( 'Actividad: ', 'textdomain' ); ?></label><br>
    <select name="tipo_de_actividad" id="tipo_de_actividad">
        <option value="null"><?php _e( 'Todos', 'textdomain' ); ?></option>
        <?php foreach($actividades as $a): ?>
        <option value="<?php echo $a['meta_value']?>"><?php _e( $a['meta_value'], 'textdomain' ); ?></option>
        <?php endforeach;?>
    </select>
    <label for="ciudad" class=""><?php _e( 'Ciudad/localidad: ', 'textdomain' ); ?></label><br>
    <select name="ciudad" id="ciudad">
        <option value="null"><?php _e( 'Todos', 'textdomain' ); ?></option>
        <?php foreach($ciudades as $a): ?>
        <option value="<?php echo $a['meta_value']?>"><?php _e( $a['meta_value'], 'textdomain' ); ?></option>
        <?php endforeach;?>
    </select>
    <label for="edad" class=""><?php _e( 'Edad del/la niño/a: ', 'textdomain' ); ?></label><br>
    <input type="number" name="edad" id="edad" min="1" max="20" size="2">

   <label for="precio" class=""><?php _e( 'Precio: ', 'textdomain' ); ?></label><br>
    <select name="precio" id="precio">
        <option value="null"><?php _e( 'Todos', 'textdomain' ); ?></option>
        <option value="10-40">10-40 EUR</option>
        <option value="40-70">40-70 EUR</option>
        <option value="70-100">70-100 EUR</option>
        <option value="100-130">100-130 EUR</option>
    </select>
    <input type="submit" id="searchsubmit" value="Search" />
</form>
