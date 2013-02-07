<?php

//add the metabox
function add_country_meta_box() {
    add_meta_box(
		'country_meta_box', // $id
		'Country Info', // $title 
		'show_country_meta_box', // $callback
		'dal_country', // $page
		'normal', // $context
		'high'); // $priority
}
add_action('add_meta_boxes', 'add_country_meta_box');

$prefix = 'country_';
$country_meta_fields = array(
	
	array(
		'label'	=> __('Registration','dal-functionality'),
		'desc'	=> __('Registration URL','dal-functionality'),
		'id'	=> $prefix.'inscribete',
		'type'	=> 'link'
	),
	
	array(
		'label'	=> __('Venue','dal-functionality'),
		'desc'	=> __('Venue or cities where the event will take place.','dal-functionality'),
		'id'	=> $prefix.'venue',
		'call'  => __('Add another','dal-functionality'),
		'type'	=> 'repeatable',
	),

	array(
		'label'	=> __('Datasets available at','dal-functionality'),
		'desc'	=> __('Url where participants can find available datasets','dal-functionality'),
		'id'	=> $prefix.'datasets',
		'type'	=> 'link'
	),

	array(
		'label'	=> __('More info:','dal-functionality'),
		'desc'	=> __('Select your "Country Page". Must be parent of all your country pages.','dal-functionality'),
		'id'	=>  $prefix.'post_id',
		'type'	=> 'country_page_list',
		'post_type' => array('page')
	),



);

// The Callback
function show_country_meta_box() {
	global $country_meta_fields, $post;
	// Use nonce for verification
	echo '<input type="hidden" name="country_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	
	// Begin the field table and loop
	echo '<table class="form-table">';
	foreach ($country_meta_fields as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '<tr>
				<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
				<td>';
				switch($field['type']) {
				
					//link
					case 'link':
						if ( !preg_match( "/http(s?):\/\//", $meta )) {
						    $errors = 'Url not valid';
						    $meta = 'http://';
						  } 
						echo '<input type="url" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30"  placeholder="http://url.com"/>
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// repeatable
					case 'repeatable':
						echo '<ul id="'.$field['id'].'-repeatable" class="custom_repeatable">';
						$i = 0;
						if ($meta) {
							foreach($meta as $row) {
								echo '<li><span class="sort hndle">|||</span>
											<input type="text" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="'.$row.'" size="30" />
											<a class="repeatable-remove button" href="#">-</a></li>';
								$i++;
							}
						} else {
							echo '<li><span class="sort hndle">|||</span>
										<input type="text" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="" size="30" />
										<a class="repeatable-remove button" href="#">-</a></li>';
						}
						echo '<a class="repeatable-add button-primary" href="#">+ '.$field['call'].'</a></ul>
							<span class="description">'.$field['desc'].'</span>';
					break;

					// repeatable link
					case 'repeatablelink':
						
						echo '<a class="repeatable-add button-primary" href="#">+</a>
								<ul id="'.$field['id'].'-repeatable" class="custom_repeatable">';
						$i = 0;
						if ($meta) {
							foreach($meta as $row) {
								if ( !preg_match( "/http(s?):\/\//", $row )) {
							    $errors = 'Url not valid';
							    $row = 'http://';
							  } 
								echo '<li><span class="sort hndle">|||</span>
											<input type="url" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="'.$row.'" size="30"  placeholder="http://url.com" />
											<a class="repeatable-remove button" href="#">-</a></li>';
								$i++;
							}
						} else {
							echo '<li><span class="sort hndle">|||</span>
										<input type="url" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="" size="30" placeholder="http://url.com" />
										<a class="repeatable-remove button" href="#">-</a></li>';
						}
						echo '</ul>
							<span class="description">'.$field['desc'].'</span>';
					break;
					// country_page_list
					case 'country_page_list':
					$items = get_posts( array (
						'post_type'	=> $field['post_type'],
						'posts_per_page' => -1,
						'sort_order' => 'DESC',
    					'sort_column' => 'post_name',
						'parent'=>0,
						'exclude_tree'=>-1,

					));
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
								<option value="">'.__("Select One",'dal-functionality').'</option>'; // Select One
							foreach($items as $item) {
								echo '<option value="'.$item->ID.'"',$meta == $item->ID ? ' selected="selected"' : '','>'.$item->post_type.': '.$item->post_title.'</option>';
							} // end foreach
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
				} //end switch
		echo '</td></tr>';
	} // end foreach
	echo '</table>'; // end table
}


// Save the Data
function save_country_meta($post_id) {
    global $country_meta_fields;
	
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
	foreach ($country_meta_fields as $field) {
		if($field['type'] == 'tax_select') continue;
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // enf foreach
	
	// save taxonomies
	$post = get_post($post_id);
	$category = $_POST['category'];
	wp_set_object_terms( $post_id, $category, 'category' );
	
}
add_action('save_post', 'save_country_meta');

?>
