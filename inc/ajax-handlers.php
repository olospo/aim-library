<?php


	add_action('wp_enqueue_scripts', function () {
		wp_enqueue_script( 'aimlib', get_stylesheet_directory_uri() . '/js/aimlib.js', [ 'jquery' ], null, true );

		wp_localize_script( 'aimlib', 'aimConfig', [
			'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
			'security' => wp_create_nonce( 'filter_measures_nonce' ),
		] );
	});
	function search_measures() {
		// Verify the nonce before doing anything
		check_ajax_referer('filter_measures_nonce', 'nonce');

		// Sanitize incoming filter values
		$search = sanitize_text_field($_POST['search'] ?? '');

// Match against post title
		$title_query = new WP_Query([
			'post_type'      => 'measure',
			'posts_per_page' => -1,
			'fields'         => 'ids',
			's'              => $search,
			'search_columns' => ['post_title'], // WP 6.2+ — restricts 's' to title only
		]);

// Match against citation meta
		$meta_query = new WP_Query([
			'post_type'      => 'measure',
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'meta_query'     => [[
				'key'     => 'authors',
				'value'   => $search,
				'compare' => 'LIKE',
			]],
		]);

// Merge and deduplicate the matched IDs
		$matched_ids = array_unique(array_merge(
			$title_query->posts,
			$meta_query->posts
		));

// Final query to get the full post objects
		$args = [
			'post_type'      => 'measure',
			'posts_per_page' => -1,
			'post__in'       => !empty($matched_ids) ? $matched_ids : [0],
			'orderby'        => 'title',
			'order'          => 'ASC',
		];

		$query = new WP_Query($args);
		$measures = $query->posts;

		// Return HTML or JSON
		ob_start();
		foreach ($measures as $measure) {

			$link = get_permalink($measure->ID);

			// get key post metas
			$metas = get_post_meta( $measure->ID );
			$age_min = $metas['age_min'][0] ?? null;
			$age_max = $metas['age_max'][0] ?? null;
			$ages = $age_min ?? null;
			$ages = ($age_min && $age_max) ? $age_min . '&nbsp;&mdash;&nbsp;' . $age_max : $ages;
			$ages = $ages ? $ages : $age_max;
			$respondent = $metas['respondent'][0] ?? null;
			$respondent = ucwords(str_replace(['t-c', '-'], ['t / c', ' '], $respondent));

			$problem_tags = get_problem_areas($measure->ID);

			$authors = $metas['authors'][0] ?? null;
			echo <<<MEASURE
          <tr>
            <td><a href="{$link}">{$measure->post_title}</a><br/><small><em>{$authors}</em></small></td>
            <td>{$ages}</td>
            <td><span class="tag tag-self">{$respondent}</span></td>
            <td class="problem-tags">
              {$problem_tags}
            </td>
          </tr>
MEASURE;
		}
		$html = ob_get_clean();

		wp_send_json_success(['html' => $html]);
	}

	function filter_measures() {
		// Verify the nonce before doing anything
		check_ajax_referer('filter_measures_nonce', 'nonce');

		// Sanitize
		$age_min     = intval($_POST['age_min'] ?? null);
		$age_max      = intval($_POST['age_max'] ?? null);
		$problem_area = sanitize_text_field($_POST['problem_area'] ?? '');

		$respondents_raw = sanitize_text_field($_POST['respondents'] ?? '');

		$respondents = !empty($respondents_raw)
			? array_values(array_filter(
				array_map(
					fn($r) => sanitize_title(trim($r)),
					explode(',', $respondents_raw)
				),
				fn($r) => $r !== 'all-respondents'
			))
			: [];

		// Base args
		$args = [
			'post_type'      => 'measure',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
		];

		//  Build meta_query clauses ---
		$meta_clauses = [];

		// sanitize values
		$age_min = ($age_min < 5 || 0 == $age_min) ? 5 : $age_min;
		$age_max = ($age_max > 100 || 0 == $age_max) ? 100 : $age_max;

		if ($age_max) {
			$meta_clauses[] = [
				'key'     => 'age_max',
				'value'   => $age_max,
				'compare' => '<=',
				'type'    => 'NUMERIC',
			];
		}

		if ($age_min) {
			$meta_clauses[] = [
				'key'     => 'age_min',
				'value'   => $age_min,
				'compare' => '>=',
				'type'    => 'NUMERIC',
			];
		}


		if (!empty($respondents)) {
			if (count($respondents) === 1) {
				// Single value — simple equals
				$meta_clauses[] = [
					'key'     => 'respondent',
					'value'   => reset($respondents),
					'compare' => '=',
				];
			} else {
				// Multiple values — nest as OR
				$respondent_query = ['relation' => 'OR'];

				foreach ($respondents as $r) {
					$respondent_query[] = [
						'key'     => 'respondent',
						'value'   => $r,
						'compare' => '=',
					];
				}

				error_log( (string) $respondents ); // the full SQL string

				$meta_clauses[] = $respondent_query;
			}
		}

		if (!empty($meta_clauses)) {
			$args['meta_query'] = count($meta_clauses) > 1
				? array_merge(['relation' => 'AND'], $meta_clauses)
				: $meta_clauses;
		}

		if ($problem_area) {
			$args['tax_query'] = [
				[
					'taxonomy' => 'problem-area',
					'field'    => 'slug',
					'terms'    => $problem_area,
				],
			];
		}

		$query    = new WP_Query($args);
		$measures = $query->posts;

		// Return HTML or JSON
		ob_start();
		foreach ($measures as $measure) {

				$link = get_permalink($measure->ID);

				// get key post metas
				$metas = get_post_meta( $measure->ID );
				$age_min = $metas['age_min'][0] ?? null;
				$age_max = $metas['age_max'][0] ?? null;
				$ages = $age_min ?? null;
				$ages = ($age_min && $age_max) ? $age_min . '&nbsp;&mdash;&nbsp;' . $age_max : $ages;
				$ages = $ages ? $ages : $age_max;
				$respondent = $metas['respondent'][0] ?? null;
				$respondent = ucwords(str_replace(['t-c', '-'], ['t / c', ' '], $respondent));

				$problem_tags = get_problem_areas($measure->ID);

				$authors = $metas['authors'][0] ?? null;

				echo <<<MEASURE
          <tr>
            <td><a href="{$link}">{$measure->post_title}</a><br/><small><em>{$authors}</em></small></td>
            <td>{$ages}</td>
            <td><span class="tag tag-self">{$respondent}</span></td>
            <td class="problem-tags">
              {$problem_tags}
            </td>
          </tr>
MEASURE;
		}
		$html = ob_get_clean();

		wp_send_json_success(['html' => $html]);
	}

	add_action('wp_ajax_search_measures', 'search_measures');
	add_action('wp_ajax_nopriv_search_measures', 'search_measures');

	add_action('wp_ajax_filter_measures', 'filter_measures');
	add_action('wp_ajax_nopriv_filter_measures', 'filter_measures');
