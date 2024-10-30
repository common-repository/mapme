<?php
/*
 * Prevent direct access to the file
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



/*
 * Add "companies" sitemap to wpseo sitemap index
 */
function mapme_companies_sitemap_index() {

	global $wpseo_sitemaps;
	$date = $wpseo_sitemaps->get_last_modified( 'companies' );

	$output  = '';
	$output .= '<sitemap>' . "\n";
	$output .= '<loc>' . site_url() .'/companies-sitemap.xml</loc>' . "\n";
	$output .= '<lastmod>' . htmlspecialchars( $date ) . '</lastmod>' . "\n";
	$output .= '</sitemap>' . "\n";

	return $output;

}
add_filter( 'wpseo_sitemap_index', 'mapme_companies_sitemap_index' );



/*
 * Add "companies" sitemap to wpseo
 *
 * https://www.snip2code.com/Snippet/384589/Wordpress-yoast-seo-plugin--generate-cus
 */
function mapme_companies_sitemap() {

	global $wpseo_sitemaps;

	// Load mapme site settings
	$options = get_option( 'mapme_settings' );
	$map_id  = $options['mapme_map_id'];

	// API call
	$api_url      = 'http://mapme.com/api/' . $map_id . '/places';
	$request      = wp_remote_get( $api_url );
	$request_body = wp_remote_retrieve_body( $request );
	$json         = json_decode( $request_body );

	// Set output
	$url    = array();
	$pri    = 1;
	$chf    = 'weekly';
	$output = '';
	foreach ( $json->places as $place ) {
		$url['loc'] = site_url() . '/company/' . str_replace( ' ', '_', $place->companyName );
		$url['pri'] = $pri;
		$url['mod'] = $mod;
		$url['chf'] = $chf;
		$output .= $wpseo_sitemaps->sitemap_url( $url );
	}

	// Bail, if sitemap is empty
	if ( empty( $output ) ) {
		$wpseo_sitemaps->bad_sitemap = true;
		return;
	}

	// Build the full sitemap
	$sitemap = '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ';
	$sitemap .= 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" ';
	$sitemap .= 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
	$sitemap .= $output;
	$sitemap .= '</urlset>';

	// Echo $sitemap;
	$wpseo_sitemaps->set_sitemap( $sitemap );

}
function mapme_companies_sitemap_actions() {

	add_action( 'wpseo_do_sitemap_companies', 'mapme_companies_sitemap' );

}
add_action( 'init', 'mapme_companies_sitemap_actions' );
