<?php
/*
 * Prevent direct access to the file
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



/*
 * Mapme company rewrite rules
 */
function mapme_rewrite_rules() {

	add_rewrite_rule( 'company/?([^/]*)', 'index.php?pagename=company', 'top' );

}
add_action( 'init', 'mapme_rewrite_rules' );
