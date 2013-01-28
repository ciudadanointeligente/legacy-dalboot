<?php
/**
 * This file contains the Dal_Portfolio class.
 *
 * This class handles the creation of the "Portfolio" post type, and creates a
 * UI to display the Portfolio-specific data on the admin screens.
 */
class Dal_Portfolio {

    /**
     * Construct Method
     */
    function __construct() {

        /** Post Type and Taxonomy creation */
	add_action( 'init', array( $this, 'create_post_type' ) );
	add_action( 'init', array( $this, 'create_taxonomy' ) );
   

        /** Post Thumbnail Support */
        add_action( 'after_setup_theme', array( $this, 'add_post_thumbnail_support' ), '9999' );
	add_image_size( 'portfolio-mini', 125, 125, TRUE );
	add_image_size( 'portfolio-thumb', 225, 180, TRUE );
	add_image_size( 'portfolio-large', 620, 9999 );

        /** Modify the Post Type Admin Screen */
        add_action( 'admin_head', array( $this, 'admin_style' ) );
	add_filter( 'manage_edit-portfolio_columns', array( $this, 'columns_filter' ) );
	add_action( 'manage_posts_custom_column', array( $this, 'columns_data' ) );
	add_filter( 'post_updated_messages', array( $this, 'updated_messages' ) );

        /** Add our Scripts */
	add_action( 'init', array( $this , 'register_script' ) );
	add_action( 'wp_footer', array( $this , 'print_script' ) );
	add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_css' ) );

        /** Create/Modify Dashboard Widgets */
	add_action( 'right_now_content_table_end', array( $this, 'right_now' ) );
	add_action( 'wp_dashboard_setup', array( $this, 'register_dashboard_widget' ) );

        /** Add Shortcode */
	add_shortcode( 'dal_portfolio', array( $this, 'portfolio_shortcode' ) );
    add_filter( 'widget_text', 'do_shortcode' );

      if (function_exists('mfields_set_default_object_terms')) {
            add_action( 'save_post', 'mfields_set_default_object_terms', 100, 2 );
        }

    }

    /**
     * This var is used in the shortcode to flag the loading of javascript
     * @var type boolean
     */
    static $load_js;


    /**
     * Create Portfolio Post Type
     *
     * @since 0.9
     */
    function create_post_type() {

	$args = apply_filters( 'dal_portfolio_post_type_args',
	    array(
		'labels' => array(
		    'name' => __( 'Aplicaciones participantes', 'dal-portfolio' ),
		    'singular_name' => __( 'Aplicación', 'dal-portfolio' ),
		    'add_new' => __( 'Agregar nuevo', 'dal-portfolio' ),
		    'add_new_item' => __( 'Agregar nueva aplicación', 'dal-portfolio' ),
		    'edit' => __( 'Editar', 'dal-portfolio' ),
		    'edit_item' => __( 'Editar aplicación', 'dal-portfolio' ),
		    'new_item' => __( 'Nueva aplicación', 'dal-portfolio' ),
		    'view' => __( 'Ver aplicaciones', 'dal-portfolio' ),
		    'view_item' => __( 'Ver aplicación', 'dal-portfolio' ),
		    'search_items' => __( 'Buscar aplicaciones', 'dal-portfolio' ),
		    'not_found' => __( 'No se encontraron aplicaciones', 'dal-portfolio' ),
		    'not_found_in_trash' => __( 'No se encontraron aplicaciones en la papelera', 'dal-portfolio' ),

		),
		'public' => true,
		'query_var' => true,
		'menu_position' => 20,
		'menu_icon' => dal-portfolio_URL . 'images/portfolio-icon-16x16.png',
		'has_archive' => true,
		'supports' => array( 'title', 'thumbnail' ),
		'rewrite' => array( 'slug' => 'portfolio', 'with_front' => false ),
        //'taxonomies' => array('post_tag')
	    )
	);

	register_post_type( 'portfolio' , $args);
    }

    /**
     * Create the Custom Taxonomy
     *
     * @since 0.9
     */
    function create_taxonomy() {

	$args = apply_filters( 'dal_portfolio_taxonomy_args',
	    array(
		'labels' => array(
		    'name' => __( 'premiopais', 'dal-portfolio' ),
		    'singular_name' => __( 'Premio nacional', 'dal-portfolio' ),
		    'search_items' =>  __( 'Buscar premios nacionales', 'dal-portfolio' ),
		    'popular_items' => __( 'Premios populares', 'dal-portfolio' ),
		    'all_items' => __( 'Todos los premios nacionales', 'dal-portfolio' ),
		    'parent_item' => null,
		    'parent_item_colon' => null,
		    'edit_item' => __( 'Editar premio' , 'dal-portfolio' ),
		    'update_item' => __( 'Actualizar premio', 'dal-portfolio' ),
		    'add_new_item' => __( 'Agregar nuevo premio', 'dal-portfolio' ),
		    'new_item_name' => __( 'Nuevo premio', 'dal-portfolio' ),
		    'separate_items_with_commas' => __( 'separados por comas', 'dal-portfolio' ),
		    'add_or_remove_items' => __( 'Agregar o remover premio', 'dal-portfolio' ),
		    'choose_from_most_used' => __( 'Elige de los premios más usados', 'dal-portfolio' ),
		    'menu_name' => __( 'Premios nacionales', 'dal-portfolio' ),
		),
		'hierarchical' => true,
		'show_ui' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
		'rewrite' => array( 'slug' => 'premiopais' )
	    )
	);
  
    if (!taxonomy_exists('premiopais')) {
    	register_taxonomy( 'premiopais', 'portfolio', $args );
       

         if (!term_exists( 'empty', 'premiopais')){
         wp_insert_term('empty', 'premiopais');
       }
  
        if (!term_exists( '1er Lugar', 'premiopais')){
         wp_insert_term(
          '1er Lugar', //the term
          'premiopais'
          );
       }

        if (!term_exists( '2do Lugar', 'premiopais')){
         wp_insert_term(
          '2do Lugar',
          'premiopais'
          /*array(
            'slug' => '2lugarpais',
            )*/
          );
       }

        if (!term_exists( '3er Lugar', 'premiopais')){
         wp_insert_term(
          '3er Lugar', 
          'premiopais'
         /* array(
            'slug' => '3lugarpais',
            )*/
          );
       }

    };

  
     

 if (!taxonomy_exists('premioregional')) {
      register_taxonomy( 'premioregional', 'portfolio',

         array(
          'labels' => array(
              'name' => __( 'premioregional', 'dal-portfolio' ),
              'singular_name' => __( 'Premio regional', 'dal-portfolio' ),
              'search_items' =>  __( 'Buscar premios regionales', 'dal-portfolio' ),
              'popular_items' => __( 'Populares', 'dal-portfolio' ),
              'all_items' => __( 'Todos los premios regionales', 'dal-portfolio' ),
              'parent_item' => null,
              'parent_item_colon' => null,
              'edit_item' => __( 'Editar premio' , 'dal-portfolio' ),
              'update_item' => __( 'Actualizar premio', 'dal-portfolio' ),
              'add_new_item' => __( 'Agregar nuevo premio', 'dal-portfolio' ),
              'new_item_name' => __( 'Nuevo premio', 'dal-portfolio' ),
              'separate_items_with_commas' => __( 'Separa los premios con comas', 'dal-portfolio' ),
              'add_or_remove_items' => __( 'Agregar o remover premio', 'dal-portfolio' ),
              'choose_from_most_used' => __( 'Elige de los más usados', 'dal-portfolio' ),
              'menu_name' => __( 'Premios regionales', 'dal-portfolio' ),
          ),
          'hierarchical' => true,
          'show_ui' => true,
          'update_count_callback' => '_update_post_term_count',
          'query_var' => true,
          'rewrite' => array( 'slug' => 'premioregional' )
        )

       );
       

         if (!term_exists( 'empty', 'premioregional')){
         wp_insert_term('empty', 'premioregional');
       }
       
        if (!term_exists( '1er', 'premioregional')){
         wp_insert_term('1er', 'premioregional');
       }

        if (!term_exists( '2do', 'premioregional')){
         wp_insert_term('2do', 'premioregional');
       }

        if (!term_exists( '3er', 'premioregional')){
         wp_insert_term('3er', 'premioregional');
       }


    };




    if (!taxonomy_exists('apps_tags')) {
       
        register_taxonomy( 'apps_tags', 'portfolio', array( 'hierarchical' => false, 'label' => __('Tags de las aplicaciones', 'dal-portfolio' ), 'query_var' => 'apps_tags', 'rewrite' => array( 'slug' => 'apps_tags' ) ) );
    };

    $labels = array(
        'name' => _x( 'Tracks', 'taxonomy general name', 'dal-portfolio' ),
        'singular_name' => _x( 'Track', 'taxonomy singular name', 'dal-portfolio' ),
        'search_items' =>  __( 'Buscar tracks', 'dal-portfolio' ),
        'all_items' => __( 'Todos los tracks', 'dal-portfolio' ),
        'parent_item' => __( 'Track padre', 'dal-portfolio' ),
        'parent_item_colon' => __( 'Track padre:', 'dal-portfolio' ),
        'edit_item' => __( 'Editar track', 'dal-portfolio' ), 
        'update_item' => __( 'Actualizar track', 'dal-portfolio' ),
        'add_new_item' => __( 'Agregar nuevo track', 'dal-portfolio' ),
        'new_item_name' => __( 'Nuevo track', 'dal-portfolio' ),
        'menu_name' => __( 'Temas (tracks)', 'dal-portfolio' ),
      );    
 

    if (!taxonomy_exists('apps_tracks')) {

        register_taxonomy('apps_tracks', array('portfolio', 'dal_country'), array(
            'hierarchical' => True,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => 'track', 
            'rewrite' => array( 'slug' => 'track' ) )
        );
    };

    $labelsano = array(
        'name' => _x( 'Año', 'taxonomy general name', 'dal-portfolio' ),
        'singular_name' => _x( 'Año', 'taxonomy singular name', 'dal-portfolio' ),
        'search_items' =>  __( 'Buscar por año', 'dal-portfolio' ),
        'all_items' => __( 'Todos los años', 'dal-portfolio' ),
        'parent_item' => __( 'Año padre', 'dal-portfolio' ),
        'parent_item_colon' => __( 'Año padre:', 'dal-portfolio' ),
        'edit_item' => __( 'Editar año', 'dal-portfolio' ), 
        'update_item' => __( 'Actualizar año', 'dal-portfolio' ),
        'add_new_item' => __( 'Agregar nuevo año', 'dal-portfolio' ),
        'new_item_name' => __( 'Nuevo año', 'dal-portfolio' ),
        'menu_name' => __( 'Año de la aplicación', 'dal-portfolio' ),
      );   
       if (!taxonomy_exists('apps_ano')) {

        register_taxonomy('apps_ano', array('portfolio'), array(
            'hierarchical' => True,
            'labels' => $labelsano,
            'show_ui' => true,
            'query_var' => 'ano', 
            'rewrite' => array( 'slug' => 'ano' ) )
        );

        if (!term_exists( '2012', 'apps_ano')){
         wp_insert_term('2012', 'apps_ano');
       }

        if (!term_exists( '2011', 'apps_ano')){
         wp_insert_term('2011', 'apps_ano');
       }
       if (!term_exists( '2013', 'apps_ano')){
         wp_insert_term('2013', 'apps_ano');
       }
         if (!term_exists( '2014', 'apps_ano')){
         wp_insert_term('2014', 'apps_ano');
       }
    };

     if (!taxonomy_exists('apppais')) {
        register_taxonomy( 'apppais', 'portfolio', array( 'hierarchical' => false, 'label' => __('País de la aplicación', 'dal-portfolio' ), 'query_var' => 'apppais', 'rewrite' => array( 'slug' => 'apppais' ) ) );
        
      if (!term_exists( 'Argentina', 'apppais')){
         wp_insert_term('Argentina', 'apppais');
       }

       if (!term_exists( 'Bolivia', 'apppais')){
        wp_insert_term('Bolivia', 'apppais');
      }

      if (!term_exists( 'Brasil', 'apppais')){
        wp_insert_term('Brasil', 'apppais');
      }
      if (!term_exists( 'Chile', 'apppais')){
        wp_insert_term('Chile', 'apppais');
      }
      if (!term_exists( 'Colombia', 'apppais')){
        wp_insert_term('Colombia', 'apppais');
      }
      if (!term_exists( 'Costa-Rica', 'apppais')){
        wp_insert_term('Costa-Rica', 'apppais');
      }
      if (!term_exists( 'Cuba', 'apppais')){
        wp_insert_term('Cuba', 'apppais');
      }
      if (!term_exists( 'Ecuador', 'apppais')){
        wp_insert_term('Ecuador', 'apppais');
      }
      if (!term_exists( 'El-Salvador', 'apppais')){
      wp_insert_term('El-Salvador', 'apppais');
      }
      if (!term_exists( 'Guatemala', 'apppais')){
        wp_insert_term('Guatemala', 'apppais');
      }
      if (!term_exists( 'Haiti', 'apppais')){
        wp_insert_term('Haiti', 'apppais');
      }
      if (!term_exists( 'Honduras', 'apppais')){
        wp_insert_term('Honduras', 'apppais');
      }
      if (!term_exists( 'Mexico', 'apppais')){
        wp_insert_term('Mexico', 'apppais');
      }
      if (!term_exists( 'Nicaragua', 'apppais')){
        wp_insert_term('Nicaragua', 'apppais');
      }
      if (!term_exists( 'Panama', 'apppais')){
        wp_insert_term('Panama', 'apppais');
      }
      if (!term_exists( 'Paraguay', 'apppais')){
        wp_insert_term('Paraguay', 'apppais');
      }
      if (!term_exists( 'Peru', 'apppais')){
        wp_insert_term('Peru', 'apppais');
      }
      if (!term_exists( 'Republica-Dominicana', 'apppais')){
        wp_insert_term('Republica-Dominicana', 'apppais');
      }
      if (!term_exists( 'Uruguay', 'apppais')){
        wp_insert_term('Uruguay', 'apppais');
      }
      if (!term_exists( 'Venezuela', 'apppais')){
        wp_insert_term('Venezuela', 'apppais');
      }
      if (!term_exists( 'Puerto-Rico', 'apppais')){
        wp_insert_term('Puerto-Rico', 'apppais');
      }
       //The Caribbean

       if (!term_exists( 'Antigua-and-Barbuda', 'pais')){
         wp_insert_term('Antigua-and-Barbuda', 'pais');
       }
       if (!term_exists( 'Belize', 'pais')){
         wp_insert_term('Belize', 'pais');
       }
       if (!term_exists( 'Dominica', 'pais')){
         wp_insert_term('Dominica', 'pais');
       }
       if (!term_exists( 'Grenada', 'pais')){
         wp_insert_term('Grenada', 'pais');
       }
       if (!term_exists( 'Jamaica', 'pais')){
         wp_insert_term('Jamaica', 'pais');
       }
       if (!term_exists( 'Saint-Kitts-and-Nevis', 'pais')){
         wp_insert_term('Saint-Kitts-and-Nevis', 'pais');
       }
       if (!term_exists('Saint-Lucia', 'pais')){
         wp_insert_term('Saint-Lucia', 'pais');
       }
       if (!term_exists( 'Saint-Vincent-and-the-Grenadines', 'pais')){
         wp_insert_term('Saint-Vincent-and-the-Grenadines', 'pais');
       }
        if (!term_exists( 'Trinidad-and-Tobago', 'pais')){
         wp_insert_term('Trinidad-and-Tobago', 'pais');
       }
        };

    }



    /**
     * Correct messages when Portfolio post type is saved
     *
     * @global type $post
     * @global type $post_ID
     * @param type $messages
     * @return type
     * @since 0.9
     */
    function updated_messages( $messages ) {
	global $post, $post_ID;

	$messages['portfolio'] = array(
	    0 => '', // Unused. Messages start at index 1.
	    1 => sprintf( __('Ítem de DAL Portfolio actualizado. <a href="%s">View app</a>', 'dal-portfolio' ), esc_url( get_permalink($post_ID) ) ),
	    2 => __('Campo personalizado actualizado.', 'dal-portfolio' ),
	    3 => __('Campo personalizado eliminado.', 'dal-portfolio' ),
	    4 => __('Ítem de DAL Portfolio actualizado.', 'dal-portfolio' ),
	    /* translators: %s: date and time of the revision */
	    5 => isset($_GET['revision']) ? sprintf( __('DAL Portfolio item restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
	    6 => sprintf( __('Ítem de DAL Portfolio publicado. <a href="%s">View app </a>', 'dal-portfolio' ), esc_url( get_permalink($post_ID) ) ),
	    7 => __('Ítem de DAL Portfolio guardado.', 'dal-portfolio' ),
	    8 => sprintf( __('Ítem de DAL Portfolio enviado. <a target="_blank" href="%s">Previsualizar ítem de portfolio</a>', 'dal-portfolio' ), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	    9 => sprintf( __('Ítem de DAL Portfolio programado por: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Previsualizar ítem de DAL portfolio</a>', 'dal-portfolio' ),
	      // translators: Publish box date format, see http://php.net/date
	      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
	    10 => sprintf( __('Borrador de ítem DAL Portfolio actualizado. <a target="_blank" href="%s">Previsualizar aplicación</a>', 'dal-portfolio' ), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);

      return $messages;
    }

    /**
     * Filter the columns on the admin screen and define our own
     *
     * @param type $columns
     * @return string
     * @since 0.9
     */
    function columns_filter ( $columns ) {

	$columns = array(
	    'cb' => '<input type="checkbox" />',
	    'portfolio_thumbnail' => __( 'Imagen', 'dal-portfolio' ),
	    'title' => __( 'Título', 'dal-portfolio' ),
	    'portfolio_description' => __( 'Descripción', 'dal-portfolio' ),
	    'portfolio_premiopaises' => __( 'premiopaises', 'dal-portfolio' )
	);

	return $columns;
    }

    /**
     * Filter the data that shows up in the columns we defined above
     *
     * @global type $post
     * @param type $column
     * @since 0.9
     */
    function columns_data( $column ) {

	global $post;

	switch( $column ) {
	    case "portfolio_thumbnail":
		printf( '<p>%s</p>', the_post_thumbnail('portfolio-mini' ) );
		break;
	    case "portfolio_description":
		the_excerpt();
		break;
	    case "portfolio_premiopaises":
		echo get_the_term_list( $post->ID, 'premiopais', '', '', '', '' );
		break;
	}
    }

    /**
     * Check for post-thumbnails and add portfolio post type to it
     *
     * @global type $_wp_theme_premiopaises
     * @since 0.9
     */
    function add_post_thumbnail_support() {

	global $_wp_theme_premiopaises;

	if( !isset( $_wp_theme_premiopaises['post-thumbnails'] ) ) {

	    $_wp_theme_premiopaises['post-thumbnails'] = array( array( 'portfolio' ) );
	}

	elseif( is_array( $_wp_theme_premiopaises['post-thumbnails'] ) ) {

	    $_wp_theme_premiopaises['post-thumbnails'][0][] = 'portfolio';
	}
    }

    /**
     * DAL-Portfolio Shortcode
     *
     * @param type $atts
     * @param type $content
     * @since 0.9
     * @version 1.1
     */


     
     



    function portfolio_shortcode( $atts, $content = null ) {
        
	/*
	Supported Attributes
	    link =>  'page', image
	    thumb => any built-in image size
	    full => any built-in image size (this setting is ignored of 'link' is set to 'page')
            title => above, below or 'blank' ("yes" is converted to "above" for backwards compatibility)
	    display => content, excerpt (leave blank for nothing)
            heading => When displaying the 'apptrack' items in a row above the portfolio items, define the heading text for that section.
            orderby => date or any other orderby param available. http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters
            order => ASC (ascending), DESC (descending)
            terms => a 'apptrack' tag you want to filter on
            operator => 'IN', 'NOT IN' filter for the term tag above

	*/

	/**
	 * Currently 'image' is the only supported link option right now
	 *
	 * While 'page' is an available option, it can potentially require a lot of work on the part of the
	 * end user since the plugin can't possibly know what theme it's being used with and create the necessary
	 * page structure to properly integrate into the theme. Selecting page is only advised for advanced users.
   *------------------------
   ****For DAL and Dalboot theme the link=page option is available and ACTIVE AS DEFAULT!
	 */

	/** Load the javascript */
	self::$load_js = true;
	/** Shortcode defaults */
	$defaults = apply_filters( 'dal_portfolio_shortcode_args',
	    array(
		'link' => __( 'page', 'dal-portfolio' ),
		'thumb' => __( 'portfolio-thumb', 'dal-portfolio' ),
		'full'     => __( 'portfolio-large', 'dal-portfolio' ),
    'title' => __( 'above', 'dal-portfolio' ),
		'display' => '',
    'heading' => __( 'Display', 'dal-portfolio' ),
		'orderby' => __( 'date', 'dal-portfolio' ),
		'order' => __( 'desc', 'dal-portfolio' ),
    'datitos'=> __( 'info', 'dal-portfolio' ),
    'terms' => '',
    'operator' => __( 'IN', 'dal-portfolio' ),
    'apppais'=> $apppais,
    'apps_ano'=> $apps_ano,
    'premiados'=> __( 'nacional', 'dal-portfolio' ),
    
    
    
	    )
	);

	extract( shortcode_atts( $defaults, $atts ) );
        
        if( $title == "yes" ) $title == "above"; // For backwards compatibility

	/** Default Query arguments -- can be overridden by filter */
	$args = apply_filters( 'dal_portfolio_shortcode_query_args',
	    array(
		'post_type' => 'portfolio',
		'posts_per_page' => -1, // show all
    'meta_key' => '_thumbnail_id', // Should pull only items with featured images
		'orderby' => $orderby,
		'order' => $order,
    'taxonomy' =>'apppais',
    'tax_query'=> array()
    

	    )
	);

        /** If the user has defined any tax (premiopais) terms, then we create our tax_query and merge to our main query  */
        //si tiene un lugar hace esto

        if( $apppais ) {
            $post_meta_data = get_post_custom($post->ID);
            $args['tax_query'][]=   array(
                        'taxonomy' => 'apppais',
                        'terms' => $apppais,
                        'field' => 'slug',
                      
                    );         
        }

        if ($apps_ano) {
          $post_meta_data = get_post_custom($post->ID);
          $args['tax_query'][]=   array(
                        'taxonomy' => 'apps_ano',
                        'terms' => $apps_ano,
                        'field' => 'slug',
                      
                    );    
        }
       

          /* if ($premiopais){
             
              $post_meta_data = get_post_custom($post->ID);
              $premiopais = get_terms('premiopais');
              foreach ($premiopais as $premiopai => $premiopa) {
               print_r($premiopa);
             

              }
              $args['tax_query'][]=   array(
                            'taxonomy' => 'premiopais',
                            'terms' => $premiopa,
                            'field' => 'slug',            
                            );
           
           
          }   
   

*/

       

          switch( $premiados ) {
            case "nacional" :

              $termspremio = get_terms( 'premiopais' );
              $arraypremiosnac = array();

                     foreach ( $termspremio as $termp ) {
                       $arraypremiosnac[] = $termp ->slug;       

                     }
                         

              $args['tax_query'][]=   array(
                            'taxonomy' => 'premiopais',
                            'terms'=>$arraypremiosnac,
                            'field' => 'slug',            
                            );
            break;
            case "regional" :
             
              $termspremioreg = get_terms( 'premioregional' );
              $arraypremiosreg = array();

                     foreach ( $termspremioreg as $termpr ) {
                       $arraypremiosreg[] = $termpr ->slug;       

                     }
                         

              $args['tax_query'][]=   array(
                            'taxonomy' => 'premioregional',
                            'terms'=>$arraypremiosreg,
                            'field' => 'slug',            
                            );
            break;      
            default:
            break;

          }   
       



        /** Create a new query based on our own arguments */
	$portfolio_query = new WP_Query( $args );
  $pais_tracks = new WP_Query( $args );

        if( $portfolio_query->have_posts() ) {
            $a ='';

            
            if( $terms ) {
                
                /** Change the get_terms argument based on the shortcode $operator */
                switch( $operator) {
                    case "IN":
                        $a = array( 'include' => $terms );
                        break;
                
                    case "NOT IN":
                        $a = array( 'exclude' => $terms );
                        break;
                
                    default:
                        break;
                }
                
            }


            /** We're simply recycling the variable at this point */
            $terms = get_terms( 'apps_tracks', $a );
            $terms_nuevos = array();
            while( $pais_tracks->have_posts() ) 
            {
              ($pais_tracks->the_post());
               $terms_tracks = get_the_terms( get_the_ID(), 'apps_tracks' );
               
               if (!empty($terms_tracks)){ //do not draw it if there is not term assigned
                foreach ( $terms_tracks as $term_track ) {
                               $terms_nuevos[$term_track->slug] = $term_track->name;
                               }
                             
              }
            }
            

            /** If there are multiple terms in use, then run through our display list */
            $uid= uniqid();

            if( count( $terms ) > 1)  {
                if ($premiados == 'nacional' || $premiados == 'regional' ){
                    $preposicion ='Ganadores ';
                  } else {
                     $preposicion ='Aplicaciones ';
                  }

                $return .= '<div class="'.$uid.'" ><h2 class="dal-portf-title">'.$preposicion.'';
               if ($premiados == 'nacional'){
                 $return .= 'nacionales ';
               }
               if ($premiados == 'regional'){
                 $return .= 'regionales ';
               }

                if ($apppais){
                  $return .= ' <span style="text-transform: capitalize;">'.$apppais. '</span>';
                 }
               if ($apps_ano){
                $return .= ' '.$apps_ano.'';
               }

                $return .= '</h2></div>'; 
                 if ($premiados == 'nacional' ){
                $return .= '<div class="head-premios premios-nac"></div>';
              }
               if ($premiados == 'regional'){
                $return .= '<div class="head-premios"></div>';
              }
                if (!($premiados == 'nacional' || $premiados == 'regional' )){
                 
                  
                    $return .= '<ul class="dal-portfolio-filtro '.$uid.' "><li class="dal-portfolio-category-title">';
                    $return .= $heading;
                    $return .= '</li><li class="active"><a href="javascript:void(0)" class="all">all</a></li>';

                    $term_list = '';

                    /** break each of the items into individual elements and modify its output */



                    foreach( $terms_nuevos as $slug => $name ) {
                    
                        $term_list .= '<li><a href="javascript:void(0)" class="' . $slug . '">' . $name . '</a></li>';
                      
                        
                    }

                    /** Return our modified list */
                    $return .= $term_list . '</ul>';
                }
                $return .= "<script>";
                $return .= "jQuery(document).ready(function(){";
                $return .= "if(jQuery().quicksand) {portfolio_quicksand('".$uid."')}";
                $return .= "});</script>";
                
            }
            if ($premiados == 'nacional' || $premiados == 'regional' ){
                   $return .= '<ul class="dal-portfolio-grid colorganador '.$uid.'">';
                  } else {
                    
                  
            $return .= '<ul class="dal-portfolio-grid '.$uid.'">';
            }

            while( $portfolio_query->have_posts() ) : $portfolio_query->the_post();

                /** Get the terms list */
                $terms = get_the_terms( get_the_ID(), 'apps_tracks' );
                
                

                /** Add each term for a given portfolio item as a data type so it can be filtered by Quicksand */
               
                  $return .= '<li data-id="id-' . get_the_ID() . '" data-type="';
                
                if (!empty($terms)){ //do not draw it if there is not term assigned
                 
                  foreach ( $terms as $term ) {
                      $return .= $term->slug . ' ';
                  }
                }
                
                  $return .= '">';
                
                //get the year
                          $tyears =  wp_get_post_terms(get_the_ID(), 'apps_ano', array("fields" => "all"));
                          $countyear = count($tyears);

                             
                                   


                /** Above image Title output */
                if( $title == "above" ) $return .= '<h2 class="dal-portfolio-title">' . get_the_title() . '</h2>';
                if ( $countyear > 0 ){
                          
                               foreach ( $tyears as $tyear ) {
                                 $return .= "<div class='dal-portf-ano dal-ano-".$tyear->slug ."'>".$tyear->slug ."</div>";
                               }
                           
                             }      



                /** Handle the image link */
                switch( $link ) {
                    case "page" :
                        $return .= '<a href="' . get_permalink() . '" rel="bookmark">';
                  			$return .= get_the_post_thumbnail( get_the_ID(), $thumb );
                  			$return .= '</a>';


                        break;

                    case "image" :
                        $_portfolio_img_url = wp_get_attachment_image_src( get_post_thumbnail_id(), $full );

                        $return .= '<a href="' . $_portfolio_img_url[0] . '" title="' . the_title_attribute( 'echo=0' ) . '" >';
                        $return .= get_the_post_thumbnail( get_the_ID(), $thumb );
                        $return .= '</a>';
                        break;

                    default : // If it's anything else, return nothing.
                        break;
                }

		            /** Below image Title output */
                if( $title == "below" ) $return .= '<h2 class="dal-portfolio-title">' . get_the_title() . '</h2>';
                  
                /*datitos*/
                  switch($datitos) {
                    case "info" : 
                    
                    $return .="<div class='dal-portfolio-datitos'> <div class='dal-fila'>";
                        //get the flags
                        $terms = get_the_terms( get_the_ID(), 'apppais' );
                        if( count( $terms ) > 0 )  {
                           $return .= '<div class="dal-meta-item">';
                               foreach ( $terms as $term ) {
                                 $return .= "<div class='dal-portfolio-flag flag-". $term->slug. "'></div>";
                               }
                                 $return .= "</div>";
                             }

                       //get the tracks
                        $terms = get_the_terms( get_the_ID(), 'apps_tracks' );
                        if( count( $terms ) > 0 )  {
                           $return .= '<div class="dal-meta-item dal-portfolio-tracks">';
                            if (!empty($terms)){ //do not draw it if there is not term assigned
                               foreach ( $terms as $term ) {
                                 $return .= '<div>'. $term->name .'</div>';
                               }
                             }
                                 $return .= "</div>";
                             }
                       
                        //get the national prizes
                          $tpremiopaises = wp_get_post_terms(get_the_ID(), 'premiopais', array("fields" => "all"));
                          $countppais = count($tpremiopaises);
                           
                           if ( $countppais > 0 ){
                              
                               foreach ( $tpremiopaises as $tpremiopais ) {
                                 $return .= "<div class='dal-portf-premio premioNac dal-portf-".$tpremiopais->slug ."'></div>";
                               }
                             
                             }

                           //get the regional prizes
                          $tpremioregionales =  wp_get_post_terms(get_the_ID(), 'premioregional', array("fields" => "all"));
                          $countpreg = count($tpremioregionales);

                             
                           if ( $countpreg > 0 ){
                          
                               foreach ( $tpremioregionales as $tpremioregional ) {
                                 $return .= "<div class='dal-portf-premio premioReg dal-portf-".$tpremioregional->slug ." '></div>";
                               }
                           
                             }          

                         $return .= "</div>"; //end .dal-portfolio-datitos



                        break;

                  }


                /** Display the content */
                switch( $display ) {
                    case "content" :
                        $return .= '<div class="dal-portfolio-text">' . get_the_content() . '</div>';
                        break;

                    case "excerpt" :
                        $return .= '<div class="dal-portfolio-text">' . get_the_excerpt() . '</div>';
                        break;


                    default : // If it's anything else, return nothing.
                        break;
                }

               
            
                $return .= '</li>';


            endwhile;

            $return .= '</ul>';
        }

	return $return;
    }


    /**
     * Add the Portfolio Post type to the "Right Now" Dashboard Widget
     *
     * @link http://bajada.net/2010/06/08/how-to-add-custom-post-types-and-taxonomies-to-the-wordpress-right-now-dashboard-widget
     * @since 0.9
     */
    function right_now() {
	include_once( dirname( __FILE__ ) . '/views/right-now.php' );
    }


    /**
     * Style the portfolio icon on the admin screen
     *
     * @since 0.9
     */
    function admin_style() {
	printf( '<style type="text/css" media="screen">.icon32-posts-portfolio { background: transparent url(%s) no-repeat !important; }</style>', dal-portfolio_URL . 'images/portfolio-icon-32x32.png' );
    }


    /**
     * Register the necessary javascript, which can be overriden by creating your own file and
     * placing it in the root of your theme's folder
     *
     * @since 1.0
     * @version 1.1.0
     */
    function register_script() {

        wp_register_script( 'jquery-quicksand', "/wp-content/plugins/dal-portfolio/" . 'includes/js/jquery.quicksand.js', array( 'jquery' ), '1.2.2', true );
        wp_register_script( 'jquery-easing', "/wp-content/plugins/dal-portfolio/" . 'includes/js/jquery.easing.1.3.js', array( 'jquery' ), '1.3', true );

	if( file_exists( get_stylesheet_directory() . "/dal-portfolio.js" ) ) {
	    wp_register_script( 'dal-portfolio-js', get_stylesheet_directory_uri() . '/dal-portfolio.js', array( 'jquery-quicksand', 'jquery-easing' ), dal-portfolio_VERSION, true );
	}
	elseif( file_exists( get_template_directory() . "/dal-portfolio.js" ) ) {
	    wp_register_script( 'dal-portfolio-js', get_template_directory_uri() . '/dal-portfolio.js', array( 'jquery-quicksand', 'jquery-easing' ), dal-portfolio_VERSION, true );
	}
	else {
        wp_register_script( 'dal-portfolio-js', "/wp-content/plugins/dal-portfolio/" . 'includes/js/portfolio.js', array( 'jquery-quicksand', 'jquery-easing' ), dal-portfolio_VERSION, true );
	}
    }


    /**
     * Check the state of the variable. If true, load the registered javascript
     *
     * @since 1.0
     */
    function print_script() {

	if( ! self::$load_js )
	    return;

	wp_print_scripts( 'dal-portfolio-js' );
    }


    /**
     * Load the plugin css. If the css file is present in the theme directory, it will be loaded instead,
     * allowing for an easy way to override the default template
     *
     * @since 0.9
     * @version 1.0
     */
    function enqueue_css() {
  wp_enqueue_style( 'dal-portfolio',  "/wp-content/plugins/dal-portfolio/". '/includes/dal-portfolio.css', array(), dal-portfolio_VERSION );
    }


    /**
     * Adds a widget to the dashboard.
     *
     * @since 0.9.1
     */
    function register_dashboard_widget() {
        wp_add_dashboard_widget( 'ac-portfolio', 'Dal Portfolio', array( $this, 'dashboard_widget_output' ) );
    }


    /**
     * Output for the dashboard widget
     *
     * @since 0.9.1
     * @version 1.0
     */
    function dashboard_widget_output() {

        echo '<div class="rss-widget">';

        wp_widget_rss_output( array(
            'url' => 'http://dalpc.com/tag/dal-portfolio/feed', // feed url
            'title' => 'Dal Portfolio Posts', // feed title
            'items' => 3, //how many posts to show
            'show_summary' => 1, // display excerpt
            'show_author' => 0, // display author
            'show_date' => 1 // display post date
        ) );

        echo '<div class="dal-portfolio-widget-bottom"><ul>'; ?>
            <li><a href="http://arcnx.co/apwiki"><img src="<?php echo dal-portfolio_URL . 'images/page-16x16.png'?>">Wiki Page</a></li>
            <li><a href="http://arcnx.co/aphelp"><img src="<?php echo dal-portfolio_URL . 'images/help-16x16.png'?>">Support Forum</a></li>
            <li><a href="http://arcnx.co/aptrello"><img src="<?php echo dal-portfolio_URL . 'images/trello-16x16.png'?>">Dev Board</a></li>
        <?php echo '</ul></div>';
        echo "</div>";

        // handle the styling
        echo '<style type="text/css">
            #ac-portfolio .rsssummary { display: block; }
            #ac-portfolio .dal-portfolio-widget-bottom { border-top: 1px solid #ddd; padding-top: 10px; text-align: center; }
            #ac-portfolio .dal-portfolio-widget-bottom ul { list-style: none; }
            #ac-portfolio .dal-portfolio-widget-bottom ul li { display: inline; padding-right: 9%; }
            #ac-portfolio .dal-portfolio-widget-bottom img { padding-right: 3px; vertical-align: top; }
        </style>';
    }


}



?>
