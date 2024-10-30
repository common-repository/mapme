<?php
/*
 * Prevent direct access to the file
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



/*
 * Mapme admin menu
 */
function mapme_add_admin_menu() { 

	add_options_page(
		__( 'Mapme', 'mapme' ),
		__( 'Mapme', 'mapme' ),
		'manage_options',
		'mapme',
		'mapme_options_page'
	);
	add_action( 'admin_print_styles-' . $page, 'my_plugin_admin_styles' );
}
add_action( 'admin_menu', 'mapme_add_admin_menu' );
/*
Start Add Mapme Button on Editor
*/
function mapme_add_my_tc_button() {
    global $typenow;
    // check user permissions
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
    return;
    }
    // verify the post type
    if( ! in_array( $typenow, array( 'post', 'page' ) ) )
        return;
    // check if WYSIWYG is enabled
    if ( get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", "mapme_add_tinymce_plugin");
        add_filter('mce_buttons', 'mapme_register_my_tc_button');
    }
}

function mapme_add_tinymce_plugin($plugin_array) {
    $plugin_array['mapme_tc_button'] = plugins_url( 'js/text-button.js', __FILE__ ); 
    return $plugin_array;
}

function mapme_register_my_tc_button($buttons) {
   array_push($buttons, "mapme_tc_button");
   return $buttons;
}

add_action('admin_head', 'mapme_add_my_tc_button');

function mapme_settings_css() {
	wp_enqueue_style('mapme-tc', plugins_url('css/setting.css', __FILE__));
}

add_action('admin_enqueue_scripts', 'mapme_settings_css');
   
/*
End Add Mapme Button on Editor
*/

/*
 * Mapme admin layout
 */


function mapme_options_page() { 
	echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script>";
	echo "<script src='".plugins_url( 'js/script.js', __FILE__ )."'></script>";
	?>
	<h1><?php esc_html_e( 'Mapme Wordpress Plugin', 'mapme' ); ?></h1>
    <?php
    echo "<h4>";
	_e("If you need any help, visit the","mapme");
	echo " <a href=' http://mapme.com/support/knowledgebase/wordpress-plugin/' title='Create your Map' target='_blank'>Mapme Help Center</a>";
	echo "</h4>";
	?>
	<form action='options.php' method='post'>
		<?php
		settings_fields( 'mapme_admin_page' );
		do_settings_sections( 'mapme_admin_page' );
		?>
        <h3>Step 3. Leave a Review</h3>
    	<p>We'll love you forever if you leave a review here of Mapme <a href="https://wordpress.org/plugins/mapme/" title=""> Leave a Review</a></p>
	</form>
	<?php
}



/*
 * Register Mapme settings
 */
function mapme_settings_init() { 

	register_setting(
		'mapme_admin_page',
		'mapme_settings'
	);

	add_settings_section(
		'mapme_mapme_admin_page_section', 
		__( "Step 1. Let's create a smart map with Mapme", 'mapme' ), 
		'mapme_settings_section_render', 
		'mapme_admin_page'
	);
	
	add_settings_field( 
		'mapme_map_id', 
		__( 'Map URL', 'mapme' ), 
		'mapme_map_id_render', 
		'mapme_admin_page', 
		'mapme_mapme_admin_page_section' 
	);

	add_settings_field( 
		'mapme_company_link', 
		__( 'Company Info Link', 'mapme' ), 
		'mapme_company_link_render', 
		'mapme_admin_page', 
		'mapme_mapme_admin_page_section' 
	);
	add_settings_field( 
		'mapme_company_link', 
		__( 'Shortcodes', 'mapme' ), 
		'generate_shortcode', 
		'mapme_admin_page', 
		'mapme_mapme_admin_page_section' 
	);
}
add_action( 'admin_init', 'mapme_settings_init' );

function generate_shortcode()
{
	?>
	<p>
		<label class="mapme_label">Map Height:</label><br/>
        <input type="text" id="mapme_height_v" placeholder="Enter Map Height">
        <select id="units_mapme_h">
        	<option value="px">Pixels</option>
            <option value="%">Percent</option>
        </select>
	</p>
    <p>
		<label class="mapme_label">Map Width:</label><br/>
        <input type="text" id="mapme_width_v" placeholder="Enter Map Width"/>
        <select id="units_mapme_w">
        	<option value="%">Percent</option>
        	<option value="px">Pixels</option>
        </select>
	</p>
    <p><button id="mapme_create_short" class="button button-primary">Create Shortcode</button></p>
    <p>
    	<label class="mapme_label">Shortcode:</label><br/>
        <textarea id="mapme_op_short"></textarea>
    </p>
    <p>
    	<button id="copytoclip" class="button button-primary">Copy to Clipboard</button>
        <?php submit_button('Save Values');?>
    </p>
	<?php
}

function mapme_settings_section_render() {

	echo '<p>';
	_e( "If you don't have a Mapme account yet, click here to create your map ", 'mapme' );
	echo " <a href='http://mapme.com/mapcreation/createmap/details/?utm_source=worpdress&utm_medium=plugin' title='Create your Map' target='_blank'>Map Creator Wizard</a>";
	echo '</p>';
	echo "<p>";
	_e("When you are done, click on the Publish button, grab your Map URL and come back here","mapme");
	echo "</p>";
	echo "<h3>Step 2. Generate your shortcode</h3>";

}

function mapme_map_id_render() { 

	$options = get_option( 'mapme_settings' );
	?>
	<input type='text' name='mapme_settings[mapme_map_id]' value='<?php echo $options['mapme_map_id']; ?>' class='regular-text' id="mapme_map_id" placeholder="Enter Map URL e.g. http://mapme.com/my-map">
	<?php /*?><p class="description"><?php _e( 'Map id from the <a href="http://mapme.com/content/maps/">Map list</a>.', 'mapme' ); ?></p><?php */?>
	<?php

}
function mapme_companies_list_render() { 

	$options = get_option( 'mapme_settings' );
	?>
    
	<input type='checkbox' name='mapme_settings[mapme_companies_list]' <?php checked( $options['mapme_companies_list'], 1 ); ?> value='1'> <?php _e( 'In the company list, make the companies clickable URLs', 'mapme' ); ?>
	<p class="description"><?php printf( __( 'When using the %s shortcode, you can show a simple list of companies or a linkble list.', 'mapme' ), '<code>[mapme-list]</code>' ); ?></p>
	<?php

}
function mapme_company_link_render() { 

	$options = get_option( 'mapme_settings' );
	?>
	<input type='text' name='mapme_settings[mapme_company_link]' value='<?php echo $options['mapme_company_link']; ?>' class='regular-text'>
	<p class="description"><?php printf( __( 'Link to the page with the %s shortcode.', 'mapme' ), '<code>[mapme-info]</code>' ); ?></p>
	<?php

}
