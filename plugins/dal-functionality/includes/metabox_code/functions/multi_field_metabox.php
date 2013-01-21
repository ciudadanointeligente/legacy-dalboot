<?php 
    $prefix = 'tz_';

    if(is_admin()) {
        wp_enqueue_script('custom-js', get_bloginfo('wpurl').'/wp-content/plugins/dal-functionality/includes/metabox_code/js/custom-js.js');
        wp_enqueue_style('jquery-ui-custom',get_bloginfo('wpurl').'/wp-content/plugins/dal-functionality/includes/metabox_code/css/jquery-ui-custom.css');
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('jquery-ui-slider');
        wp_enqueue_style('thickbox');
    }


    $organizers_fields = array(
         'id' => 'Organizers',
         'title' => 'Organizers',
         'page' => 'portfolio',
         'context' => 'normal',
         'priority' => 'high',
         'fields' => array(
            array(
                'name' => __('Add ','dal-functionality'),
                'desc' => __('This meta box is under development','dal-functionality'),
                'id' => $prefix . 'organizers',
                'type' => 'text',
                'std' => ''
            ),   
            array(
            'label' => __('Logo organizer','dal-functionality'),
            'desc'  => __('Agrega el logo de los organizadores locales','dal-functionality'),
            'id'    => $prefix.'orglogo',
            'type'  => 'image'
            ),                     
        )
    );

    /*-------------------------------------*/
    /* Add Meta Box to CPT screen 
    /*-------------------------------------*/

    function tz_add_box() {
        global $organizers_fields;

        add_meta_box($organizers_fields['id'], $organizers_fields['title'], 'tz_show_box_organizers', $organizers_fields['page'], $organizers_fields['context'], $organizers_fields['priority']);


    }

 

 add_action('admin_menu', 'tz_add_box');

    /*------------------------------------------*/
    /* Callback function/show fields in meta box
    This is taken directly from: http://wordpress.stackexchange.com/questions/19838/create-more-meta-boxes-as-needed
    /*------------------------------------------*/


    function tz_show_box_organizers() {
        global $organizers_fields, $post;
        // Use nonce for verification
        echo '<input type="hidden" name="tz_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
        ?>



        <div id="meta_inner">
        <?php
        //get the saved meta as an array
       
        $orgs = get_post_meta( $post->ID, 'orgs', true );
        $c = 0;
        if ( count( $orgs ) > 0 ) {
            foreach ( (array)$orgs as $org ) {
                print_r($org);
                if ( isset( $org['title'] ) || isset( $org['orglink'] ) || isset( $org['orglogo'] ) ) {

                    $singleorg = '<p>Org Name<input type="text" name="orgs[%1$s][title]" value="%2$s" />';
                    $singleorg .= ' -- link organizer : <input type="text" name="orgs[%1$s][orglink]" value="%3$s" />';
                    $image = get_template_directory_uri().'/img/image.png';  
                    $singleorg .= '<span class="custom_default_image" style="display:none">'.$image.'</span>';
                    if ($org['orglogo']) { $image = wp_get_attachment_image_src($org['orglogo'], 'medium'); $image = $image[0]; }    

                    $singleorg .= '<input name="orgs[%1$s][orglogo]" type="hidden" class="custom_upload_image" value="%5$s" />
                                    <img src="'.$image.'" class="custom_preview_image" alt="" />
                                    <br />
                                    <input class="custom_upload_image_button button" type="button" value="'.__("Choose Image",'dal-functionality').'" />
                                    <small>&nbsp;<a href="#" class="custom_clear_image_button">'.__("Remove Image",'dal-functionality').'</a></small>';
                    $singleorg .='<br clear="all" /><span class="description">'.$org['desc'].'</span>';
                    $singleorg .= '<span class="remove">%4$s</span></p>';
                    printf( $singleorg, $c, $org['title'], $org['orglink'], __( 'Remove org' ), $org['orglogo'] );
                    $c++;
                }
            }
        }



        ?>
        <div class="custom_upload_image_button button"> hola</div>
        <span id="here"></span>
        <span class="add"><?php _e('Add organizer','dal-functionality'); ?></span>
        <script>
        var $ =jQuery.noConflict();
        $(document).ready(function() {
        var count = <?php echo $c; ?>;
        $(".add").click(function() {
        count = count + 1;
        $('#here').before($('<p> Org Name <input type="text" name="orgs['+count+'][title]" value="" /> -- Link: <input type="url" name="orgs['+count+'][orglink]" value="" /> <span class="custom_default_image" style="display:none">--</span> <input name="orgs['+count+'][orglogo]" type="hidden" class="custom_upload_image" value=""/> <img src="" class="custom_preview_image" alt="" /><br /><input class="custom_upload_image_button button" type="button" onclick="imageLoader()" value="Choose Image"/><span class="remove">Remove organization link</span></p>'));
        return false;
        });
        $(".remove").live('click', function() {
        $(this).parent().remove();
        });
        });
        </script>
        </div>
        <?php

    }

/*-------------------------------------*/
/* Save data when post is edited
/*-------------------------------------*/


function tz_save_data($post_id) {
    global $organizers_fields, $post;
    // verify nonce
    if (!wp_verify_nonce($_POST['tz_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }


 $orgs = $_POST['orgs'];
    update_post_meta($post_id,'orgs',$orgs);

}

add_action('save_post', 'tz_save_data');
?>