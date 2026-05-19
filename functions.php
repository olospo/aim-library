<?php

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'aim-library',
        get_stylesheet_uri(),
        [],
        filemtime(get_stylesheet_directory() . '/style.css')
    );

    if (is_page_template([
        'templates/aim-library.php',
        'templates/aim-measure.php',
    ])) {
        wp_enqueue_style(
            'aim-prototype',
            get_stylesheet_directory_uri() . '/css/library.css',
            [],
            filemtime(get_stylesheet_directory() . '/css/library.css')
        );
    }


}, 20);

/**
 * Include 'measure' custom post type in WordPress search results.
 */
add_action( 'pre_get_posts', 'aim_add_custom_types' );

function aim_add_custom_types( $query ) {
	if ( ! $query->is_search() || ! $query->is_main_query() || is_admin() ) {
			return;
		}

		$query->set( 'post_type', array('post', 'page', 'measure') );

		return $query;
};

// hide admin bar from subscribers after logging in
	add_action( 'after_setup_theme', function () {
		if ( !current_user_can( 'manage_options' ) ) {
			show_admin_bar( false );
		}
	} );

	function debug ( $msg, $exit = false ): void {
		echo '<pre>';
		print_r($msg);
		echo '</pre>';

		if ($exit) {
			die("Exiting");
		}
	}
