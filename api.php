<?php
/*
 * Prevent direct access to the file
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



/*
 * Mapme API companies list
 */
function mapme_api_companies_list( $map_id, $info, $link ) {

	// Validate data, if no params set use default mapme settings
	$options = get_option( 'mapme_settings' );
	if ( empty( $map_id ) ) { $map_id  = $options['mapme_map_id']; }
	if ( empty( $info   ) ) { $info    = $options['mapme_companies_list']; }
	if ( empty( $link   ) ) { $link    = $options['mapme_company_link']; }

	// API call
	$api_url      = 'http://mapme.com/api/' . $map_id . '/places';
	$request      = wp_remote_get( $api_url );
	$request_body = wp_remote_retrieve_body( $request );
	$json         = json_decode( $request_body );

	// Build mapme array from the API result
	foreach ( $json->places as $place ) {

		$cat  = $place->companyCategory;
		$name = $place->companyName;
		$url  = esc_attr( rtrim( $link, '/' ) . '/' . str_replace( ' ', '_', $place->companyName ) );

		$mapme[$cat][] = array( 'name' => $name, 'url' => $url );

	}

	// Set output
	$output  = '';
	$output .= '<ul>';
	foreach ( $mapme as $category => $places ) {
		$output .= '<li class="mapme_category"><span style="font-weight: bold;">' . $category . '</span>';
		$output .= '<ul>';
		foreach ( $places as $place ) {
			if ( $info ) {
				$output .= '<li class="mapme_place"><a href="' . $place['url'] . '">' . $place['name'] . '</a></li>';
			} else {
				$output .= '<li class="mapme_place">' . $place['name'] . '</li>';
			}
		}
		$output .= '</ul>';
		$output .= '</li>';
	}
	$output .= '</ul>';

	// Return output
	return $output;

}



/*
 * Mapme API company info
 */
function mapme_api_company_info( $map_id, $company_id ) {

	// Validate data, if no params set use default mapme settings
	$options = get_option( 'mapme_settings' );
	if ( empty( $map_id ) ) { $map_id  = $options['mapme_map_id']; }

	// API call
	$api_url      = 'http://mapme.com/api/' . $map_id . '/' . $company_id;
	$request      = wp_remote_get( $api_url );
	$request_body = wp_remote_retrieve_body( $request );
	$json         = json_decode( $request_body );

	// Set output
	$output .= '<h2 class="mapme_company">' . $json->companyName . '</h2>';
	$output .= '<dl class="mapme_company">';
	if ( $json->websiteURL ) {
		$output .= '<dt>' . __( 'Website:', 'mapme' ) . '</dt>';
		$output .= '<dd><a href="' . $json->websiteURL . '">' . $json->websiteURL . '</a></dd>';
	}
	if ( $json->contactPhone ) {
		$output .= '<dt>' . __( 'Phone:', 'mapme' ) . '</dt>';
		$output .= '<dd>' . $json->contactPhone . '</dd>';
	}
	if ( $json->foundingYear ) {
		$output .= '<dt>' . __( 'Founding Year:', 'mapme' ) . '</dt>';
		$output .= '<dd>' . $json->foundingYear . '</dd>';
	}
	if ( $json->numberEmployees ) {
		$output .= '<dt>' . __( 'Number of Employees:', 'mapme' ) . '</dt>';
		$output .= '<dd>' . $json->numberEmployees . '</dd>';
	}
	if ( $json->addressDisplay ) {
		$output .= '<dt>' . __( 'Address:', 'mapme' ) . '</dt>';
		$output .= '<dd>' . $json->addressDisplay . '</dd>';
	}
	if ( $json->description ) {
		$output .= '<dt>' . __( 'About:', 'mapme' ) . '</dt>';
		$output .= '<dd>' . $json->description . '</dd>';
	}
	if ( $json->facebookPage ) {
		$output .= '<dt>' . __( 'Facebook Page:', 'mapme' ) . '</dt>';
		$output .= '<dd><a href="' . $json->facebookPage . '">' . $json->facebookPage . '</a></dd>';
	}
	if ( $json->linkedin ) {
		$output .= '<dt>' . __( 'Linkedin:', 'mapme' ) . '</dt>';
		$output .= '<dd><a href="' . $json->linkedin . '">' + esponse.linkedin . '</a></dd>';
	}
	if ( $json->twitter ) {
		$output .= '<dt>' . __( 'Twitter:', 'mapme' ) . '</dt>';
		$output .= '<dd><a href="' . $json->twitter . '">' . $json->twitter . '</a></dd>';
	}
	$output .= '</dl>';

	// Return output
	return $output;

}



/*
 * Mapme API return company field
 */
function mapme_api_company_field( $map_id, $company_id, $return_field ) {

	// Validate data, if no params set use default mapme settings
	$options = get_option( 'mapme_settings' );
	if ( empty( $map_id ) ) { $map_id  = $options['mapme_map_id']; }

	// API call
	$api_url      = 'http://mapme.com/api/' . $map_id . '/' . $company_id;
	$request      = wp_remote_get( $api_url );
	$request_body = wp_remote_retrieve_body( $request );
	$json         = json_decode( $request_body );

	// Set output
	$output = $json->$return_field;

	// Return output
	return $output;

}
