<?php
/*
Plugin Name: DAL Functionality Plugin
Description: Crea países
Version: 0.1
License: GPL
Author: Montserrat Lobos for Ciudadano Inteligente
Author URI: http://ciudadanointeligente.org
	*/

// Plugin localization support
load_plugin_textdomain('dal-functionality', false, basename( dirname( __FILE__ ) ) . '/languages' );

define( 'DAL_FUCT_URL', plugin_dir_url( __FILE__ ) );
//
// 1- Agrega taxonomía "paises" con dropdown para pages.
//

add_action( 'init', 'create_pais_taxonomy', 0 );

 
function create_pais_taxonomy() {
	if (!taxonomy_exists('pais')) {
		register_taxonomy( 'pais', array( 'page','dal_country_sponsor', 'post', 'dal_country'), array( 'hierarchical' => false, 'label' => __('Pais'), 'query_var' => 'pais', 'rewrite' => array( 'slug' => 'pais' ) ) );
 
       if (!term_exists( 'Argentina', 'pais')){
         wp_insert_term('Argentina', 'pais');
       }
       if (!term_exists( 'Bolivia', 'pais')){
         wp_insert_term('Bolivia', 'pais');
       }
       if (!term_exists( 'Brasil', 'pais')){
         wp_insert_term('Brasil', 'pais');
       }
       if (!term_exists( 'Chile', 'pais')){
         wp_insert_term('Chile', 'pais');
       }
       if (!term_exists( 'Colombia', 'pais')){
         wp_insert_term('Colombia', 'pais');
       }
       if (!term_exists( 'Costa-Rica', 'pais')){
         wp_insert_term('Costa-Rica', 'pais');
       }
       if (!term_exists( 'Cuba', 'pais')){
         wp_insert_term('Cuba', 'pais');
       }
       if (!term_exists( 'Ecuador', 'pais')){
         wp_insert_term('Ecuador', 'pais');
       }
       if (!term_exists( 'El-Salvador', 'pais')){
         wp_insert_term('El-Salvador', 'pais');
       }
       if (!term_exists( 'Guatemala', 'pais')){
         wp_insert_term('Guatemala', 'pais');
       }
       if (!term_exists( 'Haiti', 'pais')){
         wp_insert_term('Haiti', 'pais');
       }
       if (!term_exists( 'Honduras', 'pais')){
         wp_insert_term('Honduras', 'pais');
       }
       if (!term_exists( 'Mexico', 'pais')){
         wp_insert_term('Mexico', 'pais');
       }
       if (!term_exists( 'Nicaragua', 'pais')){
         wp_insert_term('Nicaragua', 'pais');
       }
       if (!term_exists( 'Panama', 'pais')){
         wp_insert_term('Panama', 'pais');
       }
       if (!term_exists( 'Paraguay', 'pais')){
         wp_insert_term('Paraguay', 'pais');
       }
       if (!term_exists( 'Peru', 'pais')){
         wp_insert_term('Peru', 'pais');
       }
       if (!term_exists( 'Republica-Dominicana', 'pais')){
         wp_insert_term('Republica-Dominicana', 'pais');
       }
       if (!term_exists( 'Uruguay', 'pais')){
         wp_insert_term('Uruguay', 'pais');
       }
       if (!term_exists( 'Venezuela', 'pais')){
         wp_insert_term('Venezuela', 'pais');
       }
       if (!term_exists( 'Puerto-Rico', 'pais')){
         wp_insert_term('Puerto-Rico', 'pais');
       }
   }
}

function add_pais_box() {
  remove_meta_box('tagsdiv-pais', 'page','core');
  remove_meta_box('tagsdiv-pais', 'post','core');
  remove_meta_box('tagsdiv-pais', 'dal_country_sponsor','core');
  remove_meta_box('tagsdiv-pais', 'dal_organizers','core');
  remove_meta_box('tagsdiv-pais', 'dal_country','core');
  add_meta_box('pais_box_ID', __('Pais','dal-functionality'), 'select_dal_country','page', 'advanced', 'core');
  add_meta_box('pais_box_ID', __('Pais','dal-functionality'), 'select_dal_country','post', 'advanced', 'core');
  add_meta_box('pais_box_ID', __('Pais','dal-functionality'), 'select_dal_country','dal_country_sponsor', 'advanced', 'core');
  add_meta_box('pais_box_ID', __('Pais','dal-functionality'), 'select_dal_country','dal_country', 'advanced', 'high');
  add_meta_box('pais_box_ID', __('Pais','dal-functionality'), 'select_dal_country','dal_organizers', 'advanced', 'high');
}	
 
function add_pais_menus() {
  if ( ! is_admin() )
    return;
 
  add_action('admin_menu', 'add_pais_box');

  //Use the save_post action to save new post data 
  add_action('save_post', 'save_taxonomy_data');
}
 
add_pais_menus();

// This function gets called in edit-form-advanced.php
function select_dal_country($post) {
 
	echo '<input type="hidden" name="taxonomy_noncename" id="taxonomy_noncename" value="' . 
    		wp_create_nonce( 'taxonomy_pais' ) . '" />';
 
 
	// Get all pais taxonomy terms
	$paises = get_terms('pais', 'hide_empty=0'); 
 
?>
<select name='post_pais' id='post_pais'>
	<!-- Display paises as options -->
    <?php 
        $names = wp_get_object_terms($post->ID, 'pais'); 
        ?>
        <option class='pais-option' value='' 
        <?php if (!count($names)) echo "selected";?>><?php _e("Ninguno",'dal-functionality'); ?></option>
        <?php
	foreach ($paises as $pais) {
		if (!is_wp_error($names) && !empty($names) && !strcmp($pais->slug, $names[0]->slug)) 
			echo "<option class='pais-option' value='" . $pais->slug . "' selected>" . $pais->name . "</option>\n"; 
		
		else
			echo "<option class='pais-option' value='" . $pais->slug . "'>" . $pais->name . "</option>\n"; 
	}

   ?>
</select>    
<?php
}

function save_taxonomy_data($post_id) {
// verify this came from our screen and with proper authorization.
 
 	if ( !wp_verify_nonce( $_POST['taxonomy_noncename'], 'taxonomy_pais' )) {
    	return $post_id;
  	}
 
  	// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything
  	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
    	return $post_id;
 
 
  	// Check permissions
  	if ( 'page' == $_POST['post_type'] ) {
    	if ( !current_user_can( 'edit_page', $post_id ) )
      		return $post_id;
  	} else {
    	if ( !current_user_can( 'edit_post', $post_id ) )
      	return $post_id;
  	}
 
  	// OK, we're authenticated: we need to find and save the data
	$post = get_post($post_id);
	if (($post->post_type == 'dal_country_sponsor') || ($post->post_type == 'page') || ($post->post_type == 'post') || ($post->post_type == 'portfolio') || ($post->post_type == 'dal_country') || ($post->post_type == 'dal_organizers')){ 
           // OR $post->post_type != 'revision'
           $pais = $_POST['post_pais'];
	   wp_set_object_terms( $post_id, $pais, 'pais' );
        }
	return $pais;
}


//
//======== 2- Let's register our cuntry page custom sidebar
//
if ( function_exists ('register_sidebar')) { 
   register_sidebar(array(
  'name' => __( 'Country page sidebar' ),
  'id' => 'right-sidebar',
  'description' => __( 'Widgets in this area will be shown on the country pages.' ),
  'before_title' => '<h3>',
  'after_title' => '</h3>'
  ));
}

/* Puts content above the asides
function my_above_asides() { ?>
put the code to display your content here
<?php }

add_action('thematic_abovemainasides', 'my_above_asides');
*/


//
//========3-Let's create our "sponsors" CPT
//
add_action ('init', 'create_organizer_pt' );

function create_organizer_pt(){
   register_post_type( 'dal_organizers',
    array(
      'labels' => array(
        'name' => __( 'Organizers','dal-functionality' ),
        'singular_name' => __( 'Organizer','dal-functionality' ),
        'add_new' => __('Add New Organizer','dal-functionality'),
        'add_new_item' => __('Add New Organizer','dal-functionality'),
        'edit_item' => __('Edit Organizer','dal-functionality'),
        'new_item' => __('New Organizer','dal-functionality'),
        'all_items' => __('All Organizers','dal-functionality'),
        'view_item' => __('View Organizer','dal-functionality'),
        'search_items' => __('Search Organizer','dal-functionality'),
        'not_found' =>  __('No Organizer País found','dal-functionality'),
        'not_found_in_trash' => __('No Organizer found in Trash','dal-functionality'), 
        'parent_item_colon' => '',
        'menu_name' => __('Organizers','dal-functionality')
      ),
    'public' => true,
    'has_archive' => true,
    'supports' => array( 'title'),
    'menu_position' => 14
    )
  );
}

add_action( 'init', 'create_dal_post_type' );
function create_dal_post_type() {
  register_post_type( 'dal_country',
    array(
      'labels' => array(
        'name' => __( 'Ficha base paises en competencia' ,'dal-functionality'),
        'singular_name' => __( 'Ficha base país en competencia' ,'dal-functionality'),
        'add_new' => _x('Add New Ficha país', 'Ficha país','dal-functionality'),
        'add_new_item' => __('Add New ficha país','dal-functionality'),
        'edit_item' => __('Edit Ficha país','dal-functionality'),
        'new_item' => __('New Ficha país','dal-functionality'),
        'all_items' => __('All Fichas país','dal-functionality'),
        'view_item' => __('View Ficha país','dal-functionality'),
        'search_items' => __('Search Ficha país','dal-functionality'),
        'not_found' =>  __('No Ficha país found','dal-functionality'),
        'not_found_in_trash' => __('No Ficha país found in Trash','dal-functionality'), 
        'parent_item_colon' => '',
        'menu_name' => __('Ficha base país','dal-functionality'),
      ),
    'public' => true,
    'has_archive' => true,
    'supports' => array( 'title'),
    'show_in_menu'=> true,
    'menu_icon'=> DAL_FUCT_URL.'includes/images/flag.png',
    'menu_position' => 11
    )
  );
   
  register_post_type( 'dal_country_sponsor',
    array(
      'labels' => array(
        'name' => __( 'Sponsors','dal-functionality' ),
        'singular_name' => __( 'Sponsor' ,'dal-functionality'),
        'add_new' => _x('Add New', 'Sponsor'),
        'add_new_item' => __('Add New Sponsor','dal-functionality'),
        'edit_item' => __('Edit Sponsor','dal-functionality'),
        'new_item' => __('New Sponsor','dal-functionality'),
        'all_items' => __('All Sponsors','dal-functionality'),
        'view_item' => __('View Sponsor','dal-functionality'),
        'search_items' => __('Search Sponsors','dal-functionality'),
        'not_found' =>  __('No Sponsors found','dal-functionality'),
        'not_found_in_trash' => __('No Sponsors found in Trash','dal-functionality'), 
        'parent_item_colon' => '',
        'menu_name' => __('Sponsors','dal-functionality')
      ),
    'public' => true,
    'has_archive' => false,
    'supports' => array( 'title', 'thumbnail', 'excerpt' ),
    'menu_position' => 12
    )
  );

  register_post_type( 'dal_regional_sponsor',
    array(
      'labels' => array(
        'name' => __( 'Sponsors Regionales','dal-functionality' ),
        'singular_name' => __( 'Sponsor Regional','dal-functionality' ),
        'add_new' => _x('Add New', 'Sponsor Regional','dal-functionality'),
        'add_new_item' => __('Add New Regional Sponsor','dal-functionality'),
        'edit_item' => __('Edit Regional Sponsor','dal-functionality'),
        'new_item' => __('New Regional Sponsor','dal-functionality'),
        'all_items' => __('All Regional Sponsors','dal-functionality'),
        'view_item' => __('View Regional Sponsor','dal-functionality'),
        'search_items' => __('Search Regional Sponsors','dal-functionality'),
        'not_found' =>  __('No Regional Sponsors found','dal-functionality'),
        'not_found_in_trash' => __('No Regional Sponsors found in Trash','dal-functionality'), 
        'parent_item_colon' => '',
        'menu_name' => __('Regional Sponsors','dal-functionality')
      ),
    'public' => true,
    'has_archive' => false,
    'supports' => array( 'title', 'thumbnail', 'excerpt' ),
    'menu_position' => 13
    )
  );
}


//
//
//======================== add apppais
//
//
//
// 4- Agrega taxonomía "apppais" con dropdown para cpt apps./ importante para que no se confundan las queries de apps con las del blog
//
 

 function add_apppais_box() {
  remove_meta_box('tagsdiv-apppais', 'portfolio','core');
  add_meta_box('apppais_box_ID', __('apppais'), 'apppais_styling_function','portfolio','side','high');
 } 
 
 function add_apppais_menus() {
 
  if ( ! is_admin() )
    return;
 
  add_action('admin_menu', 'add_apppais_box');

  //Use the save_post action to save new post data 
  add_action('save_post', 'save_apppais_data');
 }
 
add_apppais_menus();

// This function gets called in edit-form-advanced.php
function apppais_styling_function($post) {
 
  echo '<input type="hidden" name="taxonomy_noncename" id="taxonomy_noncename" value="' . 
        wp_create_nonce( 'taxonomy_apppais' ) . '" />';
 
 
  // Get all apppais taxonomy terms
  $apppaises = get_terms('apppais', 'hide_empty=0'); 
 
?>
<select name='post_apppais' id='post_apppais'>
  <!-- Display apppaises as options -->
    <?php 
        $names = wp_get_object_terms($post->ID, 'apppais'); 
        ?>
        <option class='apppais-option' value='' 
        <?php if (!count($names)) echo "selected";?>><?php _e("Ninguno",'dal-functionality'); ?></option>
        <?php
  foreach ($apppaises as $apppais) {
    if (!is_wp_error($names) && !empty($names) && !strcmp($apppais->slug, $names[0]->slug)) 
      echo "<option class='apppais-option' value='" . $apppais->slug . "' selected>" . $apppais->name . "</option>\n"; 
    
    else
      echo "<option class='apppais-option' value='" . $apppais->slug . "'>" . $apppais->name . "</option>\n"; 
  }

   ?>
</select>    
<?php
}

function save_apppais_data($post_id) {
// verify this came from our screen and with proper authorization.
 
  if ( !wp_verify_nonce( $_POST['taxonomy_noncename'], 'taxonomy_apppais' )) {
      return $post_id;
    }
 
    // verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
      return $post_id;
 
 
    // Check permissions
    if ( 'page' == $_POST['post_type'] ) {
      if ( !current_user_can( 'edit_page', $post_id ) )
          return $post_id;
    } else {
      if ( !current_user_can( 'edit_post', $post_id ) )
        return $post_id;
    }
 
    // OK, we're authenticated: we need to find and save the data
  $post = get_post($post_id);
  if (($post->post_type == 'dal_country_sponsor') || ($post->post_type == 'page') || ($post->post_type == 'post') || ($post->post_type == 'portfolio') || ($post->post_type == 'dal_country')){ 
           // OR $post->post_type != 'revision'
           $apppais = $_POST['post_apppais'];
     wp_set_object_terms( $post_id, $apppais, 'apppais' );
        }
  return $apppais; 
}


//
//=========== 5- Include reusable metaboxes for apps


require_once( dirname( __FILE__ ) . '/includes/metabox_code/functions/add_portfolio_meta_box.php' );

//
//=========== 6- Include reusable metaboxes for dal_countries


require_once( dirname( __FILE__ ) . '/includes/metabox_code/functions/dal_country_meta_box.php' );

require_once( dirname( __FILE__ ) . '/includes/metabox_code/functions/organizer_metabox.php' );


//===== Add HOME hero space menu
function register_dal_menus() {
  register_nav_menus(
    array( 'hero-menu' => __( 'Hero Menu' ) )
  );
}
add_action( 'init', 'register_dal_menus' );
?>
