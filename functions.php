<?php

	add_action('wp_enqueue_scripts', function () {
		wp_enqueue_style(
			'aim-library',
			get_stylesheet_uri(),
			[],
			filemtime(get_stylesheet_directory() . '/style.css')
		);


		wp_enqueue_style(
			'aim-prototype',
			get_stylesheet_directory_uri() . '/css/library.css',
			[],
			filemtime(get_stylesheet_directory() . '/css/library.css')
		);

	}, 20);

	/**
	 * RL - Preload ajax handlers for measures library
	 */
	include_once(__DIR__ . '/inc/ajax-handlers.php');

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

		$problem_tags = '';
		foreach($problem_areas as $tag) {
			$problem_tags .= '<span class="problem-tag" data-tag="' . str_replace(' ', '-', strtolower($tag)) . '">' . $tag . '</span>' . "\r\n";
		}
		return $problem_tags;
	}


	/* RL HIDE YOAST */
	function hide_yoastseo() {
		if ( !current_user_can( 'administrator' ) ) :
			remove_action('admin_bar_menu', 'wpseo_admin_bar_menu',95);
			remove_menu_page('wpseo_dashboard');
		endif;
	}
	add_action( 'admin_init', 'hide_yoastseo');

	function yoast_is_toast(){
		//capability of 'manage_plugins' equals admin, therefore if NOT administrator
		//hide the meta box from all other roles on the following 'post_type'
		//such as post, page, custom_post_type, etc
		if (!current_user_can('activate_plugins')) {
			remove_meta_box('wpseo_meta', 'post_type', 'normal');
		}
	}
	add_action('add_meta_boxes', 'yoast_is_toast', 99);

	add_action( 'admin_post_submit_for_review', 'us_handle_submit_for_review' );

	/**
	 * Determine whether the current user owns a given draft post.
	 *
	 * @param int $post_id ID of the post to check.
	 *
	 * @return bool True if the post exists, is a draft, and is authored
	 *              by the current logged-in user; false otherwise.
	 */
	function us_user_owns_draft( int $post_id ): bool {
		$post = get_post( $post_id );

		return $post
		       && 'draft' === $post->post_status
		       && (int) $post->post_author === get_current_user_id();
	}

	/**
	 * Handle the front-end "Submit for Review" action.
	 *
	 * Triggered via admin-post.php for logged-in users only. Verifies the
	 * request nonce and confirms ownership of the draft via
	 * us_user_owns_draft(), then transitions the post status to 'pending'
	 * and redirects back to the referring listing page.
	 *
	 * Expects the following $_POST fields:
	 * - post_id  (int)    ID of the post to submit for review.
	 * - _wpnonce (string) Nonce generated with action 'submit_for_review_{post_id}'.
	 *
	 * @return void Redirects on success; calls wp_die() on failure.
	 */
	function us_handle_submit_for_review() {
		$post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;

		// Verify nonce.
		check_admin_referer( 'submit_for_review_' . $post_id );

		if ( ! us_user_owns_draft( $post_id ) ) {
			wp_die( __( 'You are not allowed to submit this post for review.' ) );
		}

		wp_update_post( [
			'ID'          => $post_id,
			'post_status' => 'pending',
		] );

		// Back to the listing page with a flag for an optional success notice.
		wp_safe_redirect( home_url( '/library-of-measures/my-measures/?status=pending' ) );
		exit;
	}


	function debug ( $msg, $exit = false ): void {
		echo '<pre>';
		print_r($msg);
		echo '</pre>';

		if ($exit) {
			die("Exiting");
		}
	}

/** Stop the News menu item appearing active on Measure pages. */
function aim_fix_news_menu_active_state( $classes, $menu_item ) {

		if ( is_singular( 'measure' ) || is_post_type_archive( 'measure' ) ) {
				$classes = array_diff(
						$classes,
						[
								'current_page_parent',
								'current-menu-parent',
								'current-menu-ancestor',
						]
				);
		}

		return $classes;
}
add_filter( 'nav_menu_css_class', 'aim_fix_news_menu_active_state', 10, 2 );

/**
 * Control menu item visibility using CSS classes:
 *
 * logged-out-only = hidden when logged in
 * logged-in-only  = hidden when logged out
 */
function aim_library_filter_menu_visibility( $items, $args ) {

		foreach ( $items as $key => $item ) {

				$classes = is_array( $item->classes ) ? $item->classes : [];

				if (
						is_user_logged_in()
						&& in_array( 'logged-out-only', $classes, true )
				) {
						unset( $items[ $key ] );
				}

				if (
						! is_user_logged_in()
						&& in_array( 'logged-in-only', $classes, true )
				) {
						unset( $items[ $key ] );
				}
		}

		return $items;
}
add_filter( 'wp_nav_menu_objects', 'aim_library_filter_menu_visibility', 10, 2 );