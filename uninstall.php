<?php

// If uninstall not called from WordPress exit
if( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit ();

// Delete option from options table
delete_option( 'mapme_settings' );

// For site options in multisite
delete_site_option( 'mapme_settings' );
