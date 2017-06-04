<?php
  $path = plugin_dir_path( __FILE__ );
  include_once($path.'../models/fieldsFormModel.php');
  global $wpdb;
  $conn = new FieldsFormModel($wpdb);
  $actividades = $conn->getActividadesValue();
  $ciudades = $conn->getLocalidadValue();
  $categorias = $conn->getActividadesCat();
  $subcategories = $conn->getActividadesCat();
 ?>
 <style>
.floating-box {
    display: inline-block;
    width: 150px;
    height: 75px;
    margin: 10px;
}
</style>
<form method="get" id="advanced-searchform" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>">

    <h3><?php _e( 'Búsqueda por campos', 'textdomain' ); ?></h3>
    <input type="hidden" name="search" value="advanced">
    <div class="floating-box">
      <label for="categoria" class=""><?php _e( 'Categorías: ', 'textdomain' ); ?></label>
      <select name="categoria" id="categoria">
          <option value="null"><?php _e( 'Todos', 'textdomain' ); ?></option>
          <?php foreach($categorias as $a): ?>
          <?php if ($a->parent==0):?>
          <option value="<?php echo $a->term_id?>"><?php _e( $a->name, 'textdomain' ); ?></option>
            <?php foreach ($subcategories as $sub): ?>
              <?php if ($sub->parent==$a->term_id):?>
                <option value="<?php echo $sub->term_id?>">— <?php _e( $sub->name, 'textdomain' ); ?></option>
              <?php endif;?>
            <?php endforeach;?>
          <?php endif; ?>
          <?php endforeach;?>
      </select>
    </div>
    <div class="floating-box">
    <label for="ciudad" class=""><?php _e( 'Ciudad/localidad: ', 'textdomain' ); ?></label>
      <select name="ciudad" id="ciudad">
          <option value="null"><?php _e( 'Todos', 'textdomain' ); ?></option>
          <?php foreach($ciudades as $a): ?>
          <option value="<?php echo $a['meta_value']?>"><?php _e( $a['meta_value'], 'textdomain' ); ?></option>
          <?php endforeach;?>
      </select>
    </div>
    <div class="floating-box">
      <label for="edad" class=""><?php _e( 'Edad del/la niño/a: ', 'textdomain' ); ?></label>
      <input type="number" name="edad" id="edad" min="1" max="20" size="2">
    </div>
    <div class="floating-box">
      <input type="submit" id="searchsubmit" value="Buscar" />
    </div>
</form>
