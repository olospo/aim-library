<?php
/*
Template Name: MY Library of Measures
*/

get_header();


// fetch all measures
    $args = [
            'post_type'      => 'measure',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'post_status'    => [ 'draft', 'publish' ],
            'author'         => get_current_user_id(),
    ];

    $query   = new WP_Query( $args );
    $measures = $query->posts;
?>

<?php get_template_part( 'template-parts/library-nav' ); ?>
<section class="hero single">
  <div class="container">
    <div class="content ten columns">
      <h1>Library of Measures</h1>
    </div>
  </div>
</section>

<section class="measure-library">
  <div class="container">

  <div class="measure-results">
    <div class="results-summary">
        <h2>Showing <span class="js-count"><?php echo count($measures); ?></span> measure<?php echo (1 == count($measures) ? '' : 's'); ?> created by  <?php echo wp_get_current_user()->display_name; ?></h2>
    </div>

    <div class="table-wrap">
      <table class="measures-table">
        <thead>
          <tr>
            <th>
              <button class="sort-button is-sorted" data-direction="asc" type="button">
                Measure Title <span class="sort-icon">↑</span>
              </button>
            </th>

            <th>
              <button class="sort-button" data-direction="none" type="button">
                Age <span class="sort-icon">↕</span>
              </button>
            </th>

            <th>
              <button class="sort-button" type="button" aria-label="Sort by respondent">
                Respondent <span class="sort-icon">↕</span>
              </button>
            </th>

            <th>Problem Areas</th>
              <th>Status</th>
          </tr>
        </thead>

        <tbody class="js-measure-list">
        <?php foreach ($measures as $measure) {

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
            $status = ucwords($measure->post_status);
            $status = ('publish' == $status) ? 'Published' : $status;
            $status = ('pending' == $status) ? 'Pending Review' : $status;

            echo <<<MEASURE
          <tr>
            <td class="title"><a href="{$link}">{$measure->post_title}</a><br/><small><em>{$authors}</em></small></td>
            <td>{$ages}</td>
            <td class="respondent"><span class="tag tag-self">{$respondent}</span></td>
            <td class="problem-tags">
              {$problem_tags}
            </td>
            <td>{$status}<br/><a href="/library-of-measures/edit-measure/?post_id={$measure->ID}"><button>Edit</button></a><br/>
            <a href="/library-of-measures/edit-measure/?post_id={$measure->ID}"><button>Submit for Review</button></a></td>
            
          </tr>
MEASURE;
        }
        ?>



        </tbody>
      </table>
    </div>
  </div>
  </div>
</section>

<script>
document.querySelectorAll('.sort-button').forEach((button, colIndex) => {
  let direction = 'asc';

  button.addEventListener('click', () => {
    const table = button.closest('table');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));

    // Reset all buttons
    document.querySelectorAll('.sort-button').forEach(btn => {
      btn.classList.remove('is-sorted');
      btn.querySelector('.sort-icon').textContent = '↕';
    });

    // Toggle direction
    direction = button.dataset.direction === 'asc' ? 'desc' : 'asc';
    button.dataset.direction = direction;
    button.classList.add('is-sorted');
    button.querySelector('.sort-icon').textContent = direction === 'asc' ? '↑' : '↓';

    const sorted = rows.sort((a, b) => {
      const cellA = a.children[colIndex].innerText.trim();
      const cellB = b.children[colIndex].innerText.trim();

      // Special case: Age column
      if (colIndex === 1) {
        const getMinAge = (text) => {
          const match = text.match(/\d+/);
          return match ? parseInt(match[0], 10) : Infinity;
        };

        return direction === 'asc'
          ? getMinAge(cellA) - getMinAge(cellB)
          : getMinAge(cellB) - getMinAge(cellA);
      }

      // Default: text sort
      return direction === 'asc'
        ? cellA.localeCompare(cellB)
        : cellB.localeCompare(cellA);
    });

    // Re-append rows
    sorted.forEach(row => tbody.appendChild(row));
  });
});
</script>

<?php get_footer();
