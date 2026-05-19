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
	add_action( 'pre_get_posts', function( WP_Query $query ) {

		if ( ! $query->is_search() || ! $query->is_main_query() || is_admin() ) {
			return;
		}

		$post_types = $query->get( 'post_type' );

		// If no post types are set, WordPress defaults to 'post' — make that explicit
		if ( empty( $post_types ) ) {
			$post_types = [ 'post' ];
		}

		if ( is_string( $post_types ) ) {
			$post_types = explode( ',', $post_types );
		}

		if ( ! in_array( 'measure', $post_types, true ) ) {
			$post_types[] = 'measure';
		}

		$query->set( 'post_type', $post_types );
	} );

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
