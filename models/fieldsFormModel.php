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
    * @return localidades y provincias taxonomy
    */
    public function getLocalidadesValue(){
      $taxonomy = 'localidad_categories';
      $localidades = [];
      $terms = get_terms($taxonomy); // Get all terms of a taxonomy
      foreach ($terms as $term){
        if ($term->parent!=0) array_push($localidades,$term);
      }
      return $localidades;
    }

    /*
    * getProvinciasValue
    * @return provincias
    */
    public function getProvinciasValue(){
      $taxonomy = 'localidad_categories';
      $provincias = [];
      $terms = get_terms($taxonomy); // Get all terms of a taxonomy
      foreach ($terms as $term){
        if ($term->parent==0) array_push($provincias,$term);
      }
      return $provincias;
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

      //rango de edades
      if ($params['edad']!='0'){
        array_push($meta_args,array(
           'relation' => 'OR',
            array(
            'key' => 'edad',
            'value' =>  $params['edad']
          ),
          array(
            'key' => 'edad',
            'value' => '0'
          )
        ));
      }

      $args = array(
        'post_type' => 'actividad',
        'meta_query' => $meta_args,
        'posts_per_page' => -1
      );


      if ($_GET['categoria']!='null' or $_GET['provincia']!='null' or $_GET['localidad']!='null'){
        $args['tax_query'] = array('relation' => 'AND');

        if ($_GET['categoria']!='null'){
            array_push($args['tax_query'],
            array(
              'taxonomy' => 'actividad_categories',
              'field'    => 'term_id',
              'terms'    => $_GET['categoria'],
              'include_children' => true
            )
          );
        }

        if ($_GET['provincia']!='null'){
            array_push($args['tax_query'],
            array(
              'taxonomy' => 'localidad_categories',
              'field'    => 'term_id',
              'terms'    => $_GET['provincia'],
              'include_children' => true
            )
          );
        }

        if ($_GET['localidad']!='null'){
            array_push($args['tax_query'],
            array(
              'taxonomy' => 'localidad_categories',
              'field'    => 'term_id',
              'terms'    => $_GET['localidad'],
              'include_children' => true
            )
          );
        }

      }

      return new WP_Query($args);

      /*En caso de tener que implementar en Genesis:
      comentar return new WP_Query($args);
      get_header();
      genesis_custom_loop($args);
      get_footer();
      */

    }
  }
?>
