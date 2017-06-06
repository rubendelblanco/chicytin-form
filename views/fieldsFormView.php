<?php
  $path = plugin_dir_path( __FILE__ );
  include_once($path.'../models/fieldsFormModel.php');
  global $wpdb;
  $conn = new FieldsFormModel($wpdb);
  $actividades = $conn->getActividadesValue();
  $localidades = $conn->getLocalidadesValue();
  $categorias = $conn->getActividadesCat();
  $subcategories = $conn->getActividadesCat();
  $provincias = $conn->getProvinciasValue();
  print_r(json_encode($provincias));
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
    <label for="provincia" class=""><?php _e( 'Provincia: ', 'textdomain' ); ?></label>
      <select name="provincia" id="provincia">
          <option value="null"><?php _e( 'Todos', 'textdomain' ); ?></option>
          <?php foreach($provincias as $p): ?>
          <option value="<?php echo $p->term_id;?>"><?php _e( $p->name, 'textdomain' ); ?></option>
          <?php endforeach;?>
      </select>
    </div>
    <div class="floating-box">
    <label for="localidad" class=""><?php _e( 'Localidad: ', 'textdomain' ); ?></label>
      <select name="localidad" id="localidad">
          <option value="null"><?php _e( 'Todos', 'textdomain' ); ?></option>
      </select>
    </div>
    <div class="floating-box">
      <label for="edad" class=""><?php _e( 'Edad del/la niño/a: ', 'textdomain' ); ?></label>
      <select name="edad" id="edad">
        <option value="1"> 0-3 años</option>
        <option value="2"> 4-6 años </option>
        <option value="3"> 7-9 años</option>
        <option value="4"> 10-12 años </option>
      </select>
    </div>
    <div class="floating-box">
      <input type="submit" id="searchsubmit" value="Buscar" />
    </div>
</form>
<script>
  jQuery(document).ready(function(){
    var localidades = <?php echo json_encode($localidades); ?>;
  });
</script>
