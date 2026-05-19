<?php
/*
Template Name: Library of Measures
*/

get_header();

// fetch all measures
    $args = [
            'post_type' => 'measure',
            'numberposts' => -1,
    ];

    $measures = get_posts($args);

?>

<section class="hero single">
  <div class="container">
    <div class="content ten columns">
      <h1>Library of Measures</h1>
    </div>
  </div>
</section>

<section class="measure-library">
  <div class="container">
  <div class="measure-filters">
    <div class="filter-inner">

      <div class="filter-block">
        <label class="filter-label" for="measure-search">Search measures</label>
        <input
          id="measure-search"
          type="search"
          class="measure-search"
          placeholder="Search by measure title"
        >
      </div>

      <div class="filter-row">
        <div class="filter-block respondent-filter">
          <span class="filter-label">Respondent</span>

          <div class="pill-group" role="group" aria-label="Filter by respondent">
            <button class="filter-pill is-active" type="button">All Respondents</button>
            <button class="filter-pill" type="button">Self-report</button>
            <button class="filter-pill" type="button">Parent / Carer</button>
            <button class="filter-pill" type="button">Clinician</button>
          </div>
        </div>

        <div class="filter-block age-filter">
          <span class="filter-label">Age range</span>

          <div class="age-selects">
            <select aria-label="Minimum age">
              <option>Minimum age</option>
              <option>0</option>
              <option>2</option>
              <option>3</option>
              <option>5</option>
              <option>6</option>
              <option>7</option>
              <option>8</option>
              <option>10</option>
              <option>11</option>
              <option>12</option>
              <option>13</option>
            </select>

            <select aria-label="Maximum age">
              <option>Maximum age</option>
              <option>3</option>
              <option>10</option>
              <option>12</option>
              <option>13</option>
              <option>14</option>
              <option>16</option>
              <option>17</option>
              <option>18</option>
              <option>19</option>
              <option>25</option>
              <option>53</option>
            </select>
          </div>
        </div>

        <div class="filter-block problem-filter">
          <label class="filter-label" for="problem-area">Problem area</label>
          <select id="problem-area">
            <option>All problem areas</option>
            <option>Anxiety</option>
            <option>Mood Problems</option>
            <option>Obsessions and Compulsions</option>
            <option>Body Image and Eating Difficulties</option>
            <option>Unusual Experiences</option>
            <option>Trauma</option>
            <option>Behaviour Problems</option>
            <option>Self-harm and Suicidal Thoughts and Behaviour</option>
            <option>Other</option>
          </select>
        </div>
      </div>

    </div>
  </div>

  <div class="measure-results">
    <div class="results-summary">
        <p><strong>Showing <span class="js-count"><?php echo count($measures); ?></span> measures</strong></p>
      <button type="button" class="clear-filters">Clear filters</button>
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
          </tr>
        </thead>

        <tbody>
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

            $problem_tags = get_problem_areas($measure->ID);

            echo <<<MEASURE
          <tr>
            <td><a href="{$link}">{$measure->post_title}</a></td>
            <td>{$ages}</td>
            <td><span class="tag tag-self">{$respondent}</span></td>
            <td class="problem-tags">
              {$problem_tags}
            </td>
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
