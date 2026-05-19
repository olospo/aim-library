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
				'templates/library-of-measures.php',
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
* RL - Preload ajax handlers for measures library
*/
include_once(__DIR__ . '/inc/ajax_handlers.php');

/**
 * Include 'measure' custom post type in WordPress search results.
 */
// Search - override parent theme search customisation to include measures
	add_action( 'after_setup_theme', function() {

		// Remove the parent theme's function - you need the exact function name and priority
		remove_action( 'pre_get_posts', 'tg_include_custom_post_types_in_search_results', 10 );

		// Add your own replacement
		add_action( 'pre_get_posts', function( WP_Query $query ) {

			if ( ! $query->is_search() || ! $query->is_main_query() || is_admin() ) {
				return;
			}

			$post_types = $query->get( 'post_type' );

			if ( empty( $post_types ) ) {
				$post_types = [ 'post' ];
			}

			if ( is_string( $post_types ) ) {
				$post_types = explode( ',', $post_types );
			}

			$post_types[] = 'measure';
			$post_types[] = 'resource';

			$query->set( 'post_type', $post_types );

		} );

	} );

// hide admin bar from subscribers after logging in
	add_action( 'after_setup_theme', function () {
		if ( !current_user_can( 'manage_options' ) ) {
			show_admin_bar( false );
		}
	} );

	// retrieve a list of problem areas as a string of tags
	function get_problem_areas($ID = null): string {
		// get problem areas
		$terms = get_the_terms( $ID, 'problem-area' );

		$problem_areas = [];

		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			$problem_areas = wp_list_pluck( $terms, 'name' );
		}

		$problem_tags = null;
		foreach($problem_areas as $tag) {
			$problem_tags .= '<span class="problem-tag" data-tag="' . str_replace(' ', '-', strtolower($tag)) . '">' . $tag . '</span>' . "\r\n";
		}
		return $problem_tags;
	}

	function debug ( $msg, $exit = false ): void {
		echo '<pre>';
		print_r($msg);
		echo '</pre>';

		if ($exit) {
			die("Exiting");
		}
	}
