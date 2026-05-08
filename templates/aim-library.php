<?php
/*
Template Name: AIM Library Prototype
*/

get_header();
?>

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
      <p><strong>Showing 31 measures</strong></p>
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
          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Meta-Cognitions Questionnaire for Adolescents (MCQ-A)</a></td>
            <td>13–17 years</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Anxiety</span>
              <span class="problem-tag">Mood Problems</span>
              <span class="problem-tag">Obsessions and Compulsions</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Eating Disorder Inventory – Perfectionism Scale (EDI-P)</a></td>
            <td>12–53 years</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Body Image and Eating Difficulties</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Youth Intolerance of Uncertainty – Parent-Report (YIU-PR)</a></td>
            <td>6–17 years</td>
            <td><span class="tag tag-parent">Parent / Carer</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Anxiety</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Body Esteem Scale for Adolescents and Adults (BESAA)</a></td>
            <td>12–25 years</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Body Image and Eating Difficulties</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Bird Checklist of Adolescent Paranoia (B-CAP)</a></td>
            <td>11–17 years</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Unusual Experiences</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Situational Self-Awareness Scale (SSAS)</a></td>
            <td>Not specified</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Anxiety</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Focus of Attention Questionnaire (FAQ)</a></td>
            <td>Not specified</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Anxiety</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Childhood Anxiety Sensitivity Index (CASI)</a></td>
            <td>8–16 years</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Anxiety</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Trauma Memory Quality Questionnaire (TMQQ)</a></td>
            <td>8–18 years</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Trauma</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Children's Automatic Thoughts Scale (CATS)</a></td>
            <td>7–16 years</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Mood Problems</span>
              <span class="problem-tag">Anxiety</span>
              <span class="problem-tag">Behaviour Problems</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Children's Attributional Style Questionnaire</a></td>
            <td>8–13 years</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Mood Problems</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Spontaneous Use of Imagery Scale (SUIS)</a></td>
            <td>Not specified</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Other</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Self-Concept Clarity Scale (SCCS)</a></td>
            <td>Not specified</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Anxiety</span>
              <span class="problem-tag">Mood Problems</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Negative Problem Orientation Questionnaire (NPOQ)</a></td>
            <td>Not specified</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Anxiety</span>
              <span class="problem-tag">Mood Problems</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Child &amp; Adolescent Social Cognitions Questionnaire (CASCQ)</a></td>
            <td>11–18 years</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Anxiety</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">The Impact of Future Events Scale (IFES)</a></td>
            <td>Not specified</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Trauma</span>
              <span class="problem-tag">Mood Problems</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Difficulties with Emotion Regulation Scale (DERS)</a></td>
            <td>10–19 years</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Behaviour Problems</span>
              <span class="problem-tag">Self-harm and Suicidal Thoughts and Behaviour</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Repetitive Behaviour Questionnaire (RBQ-2)</a></td>
            <td>2–3 years</td>
            <td><span class="tag tag-parent">Parent / Carer</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Other</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Adolescent Cognitive Style Questionnaire</a></td>
            <td>13–18 years</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Mood Problems</span>
              <span class="problem-tag">Anxiety</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Children's Anger Rumination Scale (CARS)</a></td>
            <td>7–18 years</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Behaviour Problems</span>
              <span class="problem-tag">Mood Problems</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Repetitive Thinking Questionnaire-10 (RTQ-10)</a></td>
            <td>Not specified</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Anxiety</span>
              <span class="problem-tag">Mood Problems</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Emotion Regulation Questionnaire for Children and Adolescents (ERQ-CA)</a></td>
            <td>10–18 years</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Mood Problems</span>
              <span class="problem-tag">Self-harm and Suicidal Thoughts and Behaviour</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Child Post-Traumatic Cognitions Inventory</a></td>
            <td>6–18 years</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Trauma</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Children's Alexithymia Measure (CAM)</a></td>
            <td>5–17 years</td>
            <td><span class="tag tag-parent">Parent / Carer</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Other</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Co-Rumination Questionnaire</a></td>
            <td>8–13 years</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Anxiety</span>
              <span class="problem-tag">Mood Problems</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Child Avoidance Measure: CAM</a></td>
            <td>8–12 years</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Anxiety</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Child Avoidance Measure - Parent report: CAMP</a></td>
            <td>8–12 years</td>
            <td><span class="tag tag-parent">Parent / Carer</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Anxiety</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Intolerance of Uncertainty Scale for Children (IUSC) Child and Parent Report</a></td>
            <td>7–17 years</td>
            <td><span class="tag tag-parent">Parent / Carer</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Anxiety</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Responses to Uncertainty and Low Environmental Structure (RULES)</a></td>
            <td>3–10 years</td>
            <td><span class="tag tag-parent">Parent / Carer</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Anxiety</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Persistent and Intrusive Negative Thoughts Scale (PINTS)</a></td>
            <td>10–14 years</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Anxiety</span>
              <span class="problem-tag">Mood Problems</span>
              <span class="problem-tag">Body Image and Eating Difficulties</span>
              <span class="problem-tag">Self-harm and Suicidal Thoughts and Behaviour</span>
            </td>
          </tr>

          <tr>
            <td><a href="<?php echo esc_url( home_url('/aim-measure/') ); ?>">Perseverative Thinking Questionnaire-Child (PTQ-C)</a></td>
            <td>8–18 years</td>
            <td><span class="tag tag-self">Self-report</span></td>
            <td class="problem-tags">
              <span class="problem-tag">Anxiety</span>
              <span class="problem-tag">Mood Problems</span>
            </td>
          </tr>
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

<?php get_footer(); ?>