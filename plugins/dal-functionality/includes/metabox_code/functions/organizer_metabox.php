<?php 
if(is_admin()) {
        wp_enqueue_script('custom-js', get_bloginfo('wpurl').'/wp-content/plugins/dal-functionality/includes/metabox_code/js/custom-js.js');
        wp_enqueue_style('jquery-ui-custom',get_bloginfo('wpurl').'/wp-content/plugins/dal-functionality/includes/metabox_code/css/jquery-ui-custom.css');
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('jquery-ui-slider');
        wp_enqueue_style('thickbox');
    }

 // Add the Meta Box
function add_org_box() {
    add_meta_box(
        'organizer_m_box', // $id
        'Logo y URL', // $title 
        'show_org_m_box', // $callback
        'dal_organizers', // $page
        'normal', // $context
        'core'); // $priority
}
add_action('add_meta_boxes', 'add_org_box');

$prefix = 'org_';
$org_meta_fields = array(
    
    array(
        'label' => 'logo',
        'desc'  => 'logo de la organizacion',
        'id'    => $prefix.'logo',
        'type'  => 'image'
    ),
     array(
        'label' => 'link organización',
        'desc'  => 'url organización, debes anteponer http://',
        'id'    => $prefix.'link',
        'type'  => 'link'
    ),
     array(
        'label' => 'Descripción organización',
        'desc'  => '',
        'id'    => $prefix.'desc_org',
        'type'  => 'textarea'
    ),
    
);
// The Callback
function show_org_m_box() {
    global $org_meta_fields, $post;
    // Use nonce for verification
    echo '<input type="hidden" name="country_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
    
    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($org_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
                switch($field['type']) {
                    // image
                    case 'image':
                        $image = get_template_directory_uri().'/img/image.png'; 
                        echo '<span class="custom_default_image" style="display:none">'.$image.'</span>';
                        if ($meta) { $image = wp_get_attachment_image_src($meta, 'medium'); $image = $image[0]; }               
                        echo    '<input name="'.$field['id'].'" type="hidden" class="custom_upload_image" value="'.$meta.'" />
                                    <img src="'.$image.'" class="custom_preview_image" alt="" /><br />
                                        <input class="custom_upload_image_button button" type="button" value="Elegir imagen" />
                                        <small>&nbsp;<a href="#" class="custom_clear_image_button">Remove Image</a></small>
                                        <br clear="all" /><span class="description">'.$field['desc'].'</span>';
                    break;
                    //link
                    case 'link':
                        if ( !preg_match( "/http(s?):\/\//", $meta )) {
                            $errors = 'Url not valid';
                            $meta = 'http://';
                          } 
                        echo '<input type="url" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30"  placeholder="http://url.com"/>
                                <br /><span class="description">'.$field['desc'].'</span>';
                    break;
                    // textarea
                    case 'textarea':
                        echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
                                <br /><span class="description">'.$field['desc'].'</span>';
                    break;
                    } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function save_org_meta($post_id) {
    global $org_meta_fields;
    
    // verify nonce
    if (!wp_verify_nonce($_POST['country_meta_box_nonce'], basename(__FILE__))) 
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }
    
    // loop through fields and save the data
    foreach ($org_meta_fields as $field) {
        if($field['type'] == 'tax_select') continue;
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach
    
    
// save taxonomies
    $post = get_post($post_id);
    $category = $_POST['category'];
    wp_set_object_terms( $post_id, $category, 'category' );
    
}
add_action('save_post', 'save_org_meta');

?>
