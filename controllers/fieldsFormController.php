<?php
$path = plugin_dir_path( __FILE__ );
include_once($path.'../models/fieldsFormModel.php');
$conn = new FieldsFormModel($wpdb);
$params = [];
$params['categoria'] = $_GET['categoria'];
$params['provincia'] = $_GET['provincia'];
$params['localidad'] = $_GET['localidad'];
$params['edad'] = $_GET['edad'];
$results = $conn->theFieldsQuery($params);
include_once($path.'../views/fieldsArchiveView.php');
 ?>
