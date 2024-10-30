<?php
/*
 * Prevent direct access to the file
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



/*
 * Mapme company canonical url manipulation
 */
function mapme_wpseo_canonical( $canonical ) {

	if ( is_page( 'company' ) && is_main_query() ) {
		$canonical  = ( $_SERVER["HTTPS"] != 'on' ) ? 'http://' : 'https://';
		$canonical .= $_SERVER["SERVER_NAME"];
		$canonical .= $_SERVER["REQUEST_URI"];
	}

	return $canonical;

}
add_filter( 'wpseo_canonical', 'mapme_wpseo_canonical', 1 );



/*
 * Mapme company title manipulation
 */
function mapme_wpseo_title( $title ) {

	if ( is_page( 'company' ) && is_main_query() ) {

		// Load mapme site settings
		$options = get_option( 'mapme_settings' );
		$link    = $options['mapme_company_link'];

		// Curent page title
		$page_title    = get_the_title();

		// Extract company name from the URL
		$url     = ( $_SERVER["HTTPS"] != 'on' ) ? 'http://' : 'https://';
		$url    .= $_SERVER["SERVER_NAME"];
		$url    .= $_SERVER["REQUEST_URI"];
		$url     = rtrim( $url, '/' );
		$company = ltrim( stripslashes( str_replace( $link, '', $url ) ), '/' );
		$company = str_replace( '_', ' ', $company );

		$title = str_replace( $page_title, $company, $title );
	}

	return $title;

}
add_filter( 'wpseo_title', 'mapme_wpseo_title', 10, 1 );



/*
 * Mapme company description manipulation
 */
function mapme_wpseo_description( $description ) {

	if ( is_page( 'company' ) && is_main_query() ) {

		// Load mapme site settings
		$options = get_option( 'mapme_settings' );
		$link    = $options['mapme_company_link'];

		// Curent page title
		$page_title    = get_the_title();

		// Extract company name from the URL
		$url     = ( $_SERVER["HTTPS"] != 'on' ) ? 'http://' : 'https://';
		$url    .= $_SERVER["SERVER_NAME"];
		$url    .= $_SERVER["REQUEST_URI"];
		$url     = rtrim( $url, '/' );
		$company = ltrim( stripslashes( str_replace( $link, '', $url ) ), '/' );
		$company = str_replace( '_', ' ', $company );

		$title = str_replace( $page_title, $company, $title );
	}

	return $description;

}
//add_filter( 'wpseo_metadesc', 'mapme_wpseo_description', 10, 1 );
