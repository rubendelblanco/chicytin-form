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

    /*
    * theFilterQuery
    * @return el resultado que todos estamos esperando: la consulta del formulario
    */
    public function theFieldsQuery($params){
      $posts = $wpdb->prefix.'posts';
      $postmeta = $wpdb->prefix.'postmeta';
      $meta_args = [];

      //tipo de actividad
      if ($params['actividad']!='null'){
        array_push($meta_args, array(
          'key' => 'tipo_de_actividad',
          'value' =>  $params['actividad']
        ));
      }

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

      //precio

      array_push($meta_args,array(
        'key' => 'precio',
        'value' =>  array($params['precio_minimo'], $params['precio_maximo']),
        'compare' => 'BETWEEN',
        'type' => 'numeric'
      ));

      $args = array(
        'post_type' => 'actividad',
        'meta_query' => $meta_args
      );

      return new WP_Query($args);
    }
  }
?>
