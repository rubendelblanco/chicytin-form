<?php
/*Funciones que devuelven en formato JSON los datos requeridos en el bsucador
* de forma anidada. Es decir, las subcategorias seran subarrays de su categoria
*/

/*
* cfGetNestedCategorias
* Devuelve el objeto JSON de las categorias y subcategorias anidadas
*/
function cfGetNestedCategorias(){
    global $wpdb;
    $conn = new FieldsFormModel($wpdb);
    $categorias = $conn->getActividadesCat();
    $object = Array();
    //print_r($categorias);die();
    
    foreach($categorias as $a){
        
        if ($a->parent==0){
            $o = [];
            $o['id'] = $a->term_id;
            $o['name'] = $a->name;
            $o['subs'] = [];
            $object[$a->term_id] = $o;
            //array_push($object,$o);
        }
    }

    foreach($categorias as $a){
        
        if ($a->parent!=0){
            if (array_key_exists($a->parent,$object))
            $o = [];
            $o['sub_id'] = $a->term_id;
            $o['sub_name'] = $a->name;
            array_push( $object[$a->parent]['subs'],$o);
            //array_push($object,$o);
        }
    }

    return $object;

    //print_r($object);die();
}
?>