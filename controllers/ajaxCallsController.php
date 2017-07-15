<?php
function cf_get_subcategorias($cat_id){
    echo json_encode('sdkasjdflasdlf');
    $query = new FieldsFormModel($wpdb);
    $subcat = $query->getActividadesSubcat($cat_id);
    echo $subcat;
    die();
}
?>