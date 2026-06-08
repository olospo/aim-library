<?php
/**
 * Template Name: Submit Measure
 */

if ( ! is_user_logged_in() ) {
  wp_safe_redirect( home_url( '/login/' ) );
  exit;
}

get_header();
?>

<?php get_template_part( 'template-parts/library-nav' ); ?>

<section class="hero single">
  <div class="container">
    <div class="content ten columns">
      <h1>Submit a Measure</h1>
      <p>Contribute a new measure to the AIM Library.</p>
    </div>
  </div>
</section>

<section class="measure-library measure-library-auth">
  <div class="container">
    <div class="twelve columns">

      <div class="auth-layout">

        <div class="eight columns alpha">
          <div class="auth-card">

            <div class="auth-card-header">
              <h2>Measure submissions</h2>
              <p>
                Measure submission functionality is currently being developed.
              </p>
            </div>

            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

          </div>
        </div>

        <div class="four columns omega">
          <aside class="auth-side-panel">

            <h2>Review process</h2>

            <p>
              All submitted measures will be reviewed by the AIM team before publication.
            </p>

            <ul>
              <li>Submit a measure</li>
              <li>Administrator review</li>
              <li>Approval and publication</li>
            </ul>

          </aside>
        </div>

      </div>

    </div>
  </div>
</section>

<?php get_footer(); ?>