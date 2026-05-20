<?php

	wp_enqueue_script('aimlib', get_stylesheet_directory_uri() . '/js/aimlib.js', ['jquery'], null, true);

	wp_localize_script('aimlib', 'aimConfig', [
		'ajaxUrl' => admin_url('admin-ajax.php'),
		'security'   => wp_create_nonce('filter_measures_nonce'),
	]);

	function search_measures() {
		// Verify the nonce before doing anything
		check_ajax_referer('filter_measures_nonce', 'nonce');

		// Sanitize incoming filter values
		$category = sanitize_text_field($_POST['category'] ?? '');

		// Run your query...
		$args = [
			'post_type'      => 'measure',
			'posts_per_page' => 20,
			'tax_query'      => $category ? [[
				'taxonomy' => 'resource_category',
				'field'    => 'slug',
				'terms'    => $category,
			]] : [],
		];

		$query = new WP_Query($args);

		// Return HTML or JSON
		ob_start();
		foreach ($query->posts as $post) {
			// render your row partial here
		}
		$html = ob_get_clean();

		wp_send_json_success(['html' => $html]);
	}

	add_action('wp_ajax_search_measures', 'search_measures');
	add_action('wp_ajax_nopriv_search_measures', 'search_measures');
