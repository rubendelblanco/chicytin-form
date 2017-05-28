<?php
  class FieldsFormModel {

    private $postmeta, $users;
    private $conn;
    public function __construct($wpdb) {
      $this->conn=$wpdb;
      $this->postmeta = $this->conn->prefix.'postmeta';
    }

    /*
    * getActividadesValue
    * @return meta_value
    */
    public function getActividadesValue(){
      $query = "SELECT DISTINCT (meta_value) FROM $this->postmeta WHERE meta_key='tipo_de_actividad'";
      return $this->conn->get_results($query,ARRAY_A);
    }

    /*
    * getLocalidadValue
    * @return meta_value
    */
    public function getLocalidadValue(){
      $query = "SELECT DISTINCT (meta_value) FROM $this->postmeta WHERE meta_key='ciudad'";
      return $this->conn->get_results($query,ARRAY_A);
    }

    /*
    * getEdadMinimaValue
    * @return meta_value
    */
    public function getEdadMinimaValue(){
      $query = "SELECT DISTINCT (meta_value) FROM $this->postmeta WHERE meta_key='edad_minima'";
      return $this->conn->get_results($query,ARRAY_A);
    }

    /*
    * getEdadMaximaValue
    * @return meta_value
    */
    public function getEdadMaximaValue(){
      $query = "SELECT DISTINCT (meta_value) FROM $this->postmeta WHERE meta_key='edad_maxima'";
      return $this->conn->get_results($query,ARRAY_A);
    }

    /*
    * getPrecioValue
    * @return meta_value
    */
    public function getPrecioValue(){
      $query = "SELECT DISTINCT (meta_value) FROM $this->postmeta WHERE meta_key='precio'";
      return $this->conn->get_results($query,ARRAY_A);
    }

    /*getActividadesCat
    *@return categorias de actividades
    */

    public function getActividadesCat(){
      $taxonomy = 'actividad_categories';
      $terms = get_terms($taxonomy); // Get all terms of a taxonomy
      print_r($terms);
      return $terms;
    }


    /*
    * theFilterQuery
    * @return el resultado que todos estamos esperando: la consulta del formulario
    */
    public function theFieldsQuery($params){
      $posts = $wpdb->prefix.'posts';
      $postmeta = $wpdb->prefix.'postmeta';
      $meta_args = [];

      //localidad o ciudad
      if ($params['ciudad']!='null'){
        array_push($meta_args, array(
          'key' => 'tipo_de_actividad',
          'value' =>  $params['actividad']
        ));
      }

      //edad minima y maxima
      if ($params['edad']!='null'){
        array_push($meta_args,array(
          'key' => 'edad_minima',
          'value' =>  $params['edad'],
          'compare' => '<=',
          'type' => 'numeric'
        ));

        array_push($meta_args,array(
          'key' => 'edad_maxima',
          'value' =>  $params['edad'],
          'compare' => '>=',
          'type' => 'numeric'
        ));
      }

      $args = array(
        'post_type' => 'actividad',
        'meta_query' => $meta_args
      );

      if ($_GET['categoria']!='null'){
        $args = array(
          'post_type' => 'actividad',
          'meta_query' => $meta_args,
          'tax_query' => array(
          'relation' => 'AND',
             array(
                 'taxonomy' => 'actividad_categories',
                 'field'    => 'term_id',
                 'terms'    => $_GET['categoria'],
                 'include_children' => false
             )
         ));
      }

      return new WP_Query($args);
    }
  }
?>
