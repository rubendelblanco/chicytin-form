<?php
$path = plugin_dir_path( __FILE__ );
include_once($path.'../models/fieldsFormModel.php');
$conn = new FieldsFormModel($wpdb);
$edad = $_GET['edad'];
$errores_validacion=[];

if ($_GET['precio']=='null') {
  $precio_minimo = 0;
  $precio_maximo = 999999;
}
else{
    $precios = explode ("-",$_GET['precio']);
    $precio_minimo = $precios[0];
    $precio_maximo = $precios[1];
}
//Validacion
if ($edad=='') $edad = 'null';
if ($edad!='null' and !is_numeric($edad)){
  array_push($errores_validacion,'La edad tiene que ser valor numerico');
}
// Si no hay errores, palantisimo
if (count($errores_validacion)==0){
  $params = [];
  $params['actividad'] = $_GET['tipo_de_actividad'];
  $params['ciudad'] = $_GET['ciudad'];
  $params['edad'] = $edad;
  $params['precio_minimo'] = $precio_minimo;
  $params['precio_maximo'] = $precio_maximo;
  $results = $conn->theFieldsQuery($params);
  include_once($path.'../views/fieldsArchiveView.php');
}

 ?>
