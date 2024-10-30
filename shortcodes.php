<?php
/*
 * Prevent direct access to the file
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



/*
 * Map Shortcode
 */
function mapme_map_shortcode( $atts ) {

	// Load mapme site settings
	$options = get_option( 'mapme_settings' );
	$map_id  = $options['mapme_map_id'];

	// Load shortcode attributes
	$atts = shortcode_atts(
		array(
			'id'     => $map_id,
			'width'  => '100%',
			'height' => '100%',
		),
		$atts
	);


$source = array("http://mapme.com/","http://www.mapme.com/","https://www.mapme.com/","https://mapme.com/","mapme.com/","/");

$atts['id'] = str_replace($source,"",$atts['id']);

	// Embed Code
	return '<iframe src="https://mapme.com/' . $atts['id'] .'/" width="' . esc_attr( $atts['width'] ) . '" height="' . esc_attr( $atts['height'] ) . '" frameborder="0" border="0" scrolling="no" marginwidth="0" marginheight="0" hspace="0" vspace="0"></iframe>';

}
add_shortcode( 'mapme', 'mapme_map_shortcode' );



/*
 * Companies List Shortcode
 */
function mapme_list_shortcode( $atts ) {

	// Load mapme site settings
	$options = get_option( 'mapme_settings' );
	$map_id  = $options['mapme_map_id'];
	$info    = $options['mapme_companies_list'];
	$link    = $options['mapme_company_link'];

	// Load shortcode attributes, if no attrs use default mapme settings
	$atts = shortcode_atts(
		array(
			'id'   => $map_id,
			'info' => $info,
			'link' => $link,
		),
		$atts
	);

	// Returm companies list using Mapme API
	return mapme_api_companies_list( $atts['id'], $atts['info'], $atts['link'] );

}
add_shortcode( 'mapme-list', 'mapme_list_shortcode' );



/*
 * Company Info Shortcode
 */
function mapme_info_shortcode() {

	// Load mapme site settings
	$options = get_option( 'mapme_settings' );
	$map_id  = $options['mapme_map_id'];
	$link    = $options['mapme_company_link'];

	// Extract company name from the URL
	$url     = ( $_SERVER["HTTPS"] != 'on' ) ? 'http://' : 'https://';
	$url    .= $_SERVER["SERVER_NAME"];
	$url    .= $_SERVER["REQUEST_URI"];
	$url     = rtrim( $url, '/' );
	$company = ltrim( stripslashes( str_replace( $link, '', $url ) ), '/' );

	// Return Company Info using Mapme API
	if ( !empty( $map_id ) ) {

		return mapme_api_company_info( $map_id, $company );

	}

}
add_shortcode( 'mapme-info', 'mapme_info_shortcode' );
