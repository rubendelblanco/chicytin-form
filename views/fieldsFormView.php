<?php
  $path = plugin_dir_path( __FILE__ );
  include_once($path.'../models/fieldsFormModel.php');
  include_once ($path.'../controllers/taxonomiesController.php');
  global $wpdb;
  $conn = new FieldsFormModel($wpdb);
  $localidades = $conn->getLocalidadesValue(); //also distritos
  $categorias = $conn->getActividadesCat();
  $subcategories = $conn->getActividadesCat();
  $provincias = $conn->getProvinciasValue();
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
          <?php endif; ?>
          <?php endforeach;?>
      </select>
    </div>
    <div class="floating-box">
      <label for="subcategoria" class=""><?php _e( 'Especialidad: ', 'textdomain' ); ?></label>
      <select name="subcategoria" id="subcategoria">
          <option value="null"><?php _e( 'Todos', 'textdomain' ); ?></option>
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
    <label for="distrito" class=""><?php _e( 'Distrito: ', 'textdomain' ); ?></label>
      <select name="distrito" id="distrito">
          <option value="null"><?php _e( 'Todos', 'textdomain' ); ?></option>
      </select>
    </div>
    <div class="floating-box">
      <label for="edad" class=""><?php _e( 'Edad del/la niño/a: ', 'textdomain' ); ?></label>
      <select name="edad" id="edad">
        <option value="0"> Todas las edades </option>
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
    var categorias = <?php echo json_encode (cfGetNestedCategorias()); ?>

    function colocarLocalidades(){
      jQuery("#localidad option[value!='null']").remove();
      var provinciaSeleccionada = jQuery('#provincia option:selected').attr('value');
      if (provinciaSeleccionada=='null') return;

      for (var i = 0; i< localidades.length; i++){
          if (localidades[i]['parent']==provinciaSeleccionada){
            jQuery('#localidad').append(
              '<option value="'+localidades[i]['term_id']+'">'+localidades[i]['name']+'</option>'
            );
          }
      }
    };

    function colocarDistritos(){
      jQuery("#distrito option[value!='null']").remove();
      var localidadSeleccionada = jQuery('#localidad option:selected').attr('value');
      if (localidadSeleccionada=='null') return;

      for (var i = 0; i< localidades.length; i++){
          if (localidades[i]['parent']==localidadSeleccionada){
            jQuery('#distrito').append(
              '<option value="'+localidades[i]['term_id']+'">'+localidades[i]['name']+'</option>'
            );
          }
      }
    };

    function colocarSubcategorias(){
      jQuery("#subcategoria option[value!='null']").remove();
      var categoriaSeleccionada = jQuery('#categoria option:selected').attr('value');
      if (categoriaSeleccionada=='null') return;

      for (var i = 0; i< categorias[categoriaSeleccionada]['subs'].length; i++){
          jQuery('#subcategoria').append(
            '<option value="'+categorias[categoriaSeleccionada]['subs'][i]['sub_id']+'">'+categorias[categoriaSeleccionada]['subs'][i]['sub_name']+'</option>'
          );
      }
    };

    colocarLocalidades();
    jQuery('#provincia').change(function(){
      colocarLocalidades();
    });
    jQuery('#categoria').change(function(){
      colocarSubcategorias();
    });
    jQuery('#localidad').change(function(){
      colocarDistritos();
    });

  });
</script>
