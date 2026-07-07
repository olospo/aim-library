<?php
/**
 * Template Name: Login
 */

$allow_logged_in_testing = true;

if ( ! $allow_logged_in_testing && is_user_logged_in() ) {
  wp_safe_redirect( home_url( '/library-of-measures/' ) );
  exit;
}

get_header();
?>

<?php get_template_part( 'template-parts/library-nav' ); ?>

<section class="hero single">
  <div class="container">
    <div class="content ten columns">
      <h1>Login to your account</h1>
      <p>Access your account to submit measures.</p>
    </div>
  </div>
</section>

<section class="measure-library measure-library-auth">
  <div class="container">
    <div class="twelve columns">

      <div class="auth-layout">

        <div class="six columns alpha">
          <div class="auth-card">
            <?php
            wp_login_form([
              'redirect'       => home_url( '/aim-library/' ),
              'label_username' => 'Email address',
              'label_password' => 'Password',
              'label_remember' => 'Remember me',
              'label_log_in'   => 'Login',
              'remember'       => true,
            ]);
            ?>

            <div class="auth-card-footer">
              <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>">
                Forgotten password?
              </a>
            </div>
          </div>
        </div>

        <div class="six columns omega">
          <aside class="auth-side-panel">
            <h2>Researcher access</h2>

            <p>
              Researchers can submit new measures for review and help expand the AIM Library.
            </p>

            <ul>
              <li>Submit new measures</li>
              <li>Support the research community</li>
              <li>Help improve the library</li>
            </ul>

            <p class="auth-side-panel__note">
              New to the AIM Library? <a href="<?php echo esc_url( home_url( '/register/' ) ); ?>">Register for a contributor account</a>.
            </p>
          </aside>
        </div>

      </div>

    </div>
  </div>
</section>


<?php get_footer(); ?>
