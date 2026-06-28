<?php
    /**
     * Template Name: Register
     */

    $errors = [];

    if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['aim_register_nonce'] ) ) {

        if ( ! wp_verify_nonce( $_POST['aim_register_nonce'], 'aim_register_user' ) ) {
            $errors[] = 'Security check failed. Please try again.';
        } else {

            $name             = sanitize_text_field( $_POST['aim_name'] ?? '' );
            $email            = sanitize_email( $_POST['aim_email'] ?? '' );
            $password         = $_POST['aim_password'] ?? '';
            $confirm_password = $_POST['aim_confirm_password'] ?? '';

            if ( empty( $name ) ) {
                $errors[] = 'Please enter your name.';
            }

            if ( empty( $email ) || ! is_email( $email ) ) {
                $errors[] = 'Please enter a valid email address.';
            }

            if ( email_exists( $email ) ) {
                $errors[] = 'An account already exists with this email address.';
            }

            if ( username_exists( $email ) ) {
                $errors[] = 'An account already exists with this email address.';
            }

            if ( empty( $password ) ) {
                $errors[] = 'Please enter a password.';
            }

            if ( strlen( $password ) < 8 ) {
                $errors[] = 'Your password should be at least 8 characters.';
            }

            if ( $password !== $confirm_password ) {
                $errors[] = 'The passwords do not match.';
            }

            if ( empty( $errors ) ) {

                // On multisite, wp_create_user creates a network-level user.
                // We then explicitly add them to this site with the researcher role.
                $user_id = wp_create_user( $email, $password, $email );

                if ( is_wp_error( $user_id ) ) {
                    $errors[] = $user_id->get_error_message();
                } else {

                    // Set display name and other profile fields
                    wp_update_user( [
                            'ID'           => $user_id,
                            'display_name' => $name,
                            'first_name'   => $name,
                    ] );

                    // Assign the researcher role correctly for multisite
                    if ( is_multisite() ) {
                        // Add to this specific site with researcher role
                        // (network user exists but has no site access until this runs)
                        add_user_to_blog( get_current_blog_id(), $user_id, 'researcher' );
                    } else {
                        $user = new WP_User( $user_id );
                        $user->set_role( 'researcher' );
                    }

                    // Notify admin of new researcher registration
                    aim_notify_admin_new_researcher( $user_id, $name, $email );

                    wp_safe_redirect( home_url( '/login/?registered=1' ) );
                    exit;
                }
            }
        }
    }

    /**
     * Send admin notification email when a new researcher registers.
     */
    function aim_notify_admin_new_researcher( int $user_id, string $name, string $email ): void {
        $admin_email  = 'robin@ultrasimplified.com';
        $site_name    = get_bloginfo( 'name' );
        $edit_user_url = admin_url( 'user-edit.php?user_id=' . $user_id );

        $subject = sprintf( '[%s] New Researcher Registration', $site_name );

        $message = sprintf(
                "A new researcher has registered on %s.\n\n" .
                "Name:  %s\n"                                .
                "Email: %s\n\n"                              .
                "You can view their profile here:\n%s\n",
                $site_name,
                $name,
                $email,
                $edit_user_url
        );

        wp_mail( $admin_email, $subject, $message );
    }

    get_header();
?>

<?php get_template_part( 'template-parts/library-nav' ); ?>

<section class="hero single">
  <div class="container">
    <div class="content ten columns">
      <h1>Create an account</h1>
      <p>Register to submit new measures for review by the AIM team.</p>
    </div>
  </div>
</section>

<section class="measure-library measure-library-auth">
  <div class="container">
    <div class="twelve columns">

      <div class="auth-layout">

        <div class="six columns alpha">
          <div class="auth-card">
            <?php if ( ! empty( $errors ) ) : ?>
              <div class="auth-notice auth-notice-error">
                <?php foreach ( $errors as $error ) : ?>
                  <p><?php echo esc_html( $error ); ?></p>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <form method="post" class="aim-register-form">

              <?php wp_nonce_field( 'aim_register_user', 'aim_register_nonce' ); ?>

              <p>
                <label for="aim_name">Name</label>
                <input
                  type="text"
                  name="aim_name"
                  id="aim_name"
                  value="<?php echo esc_attr( $_POST['aim_name'] ?? '' ); ?>"
                  required
                >
              </p>

              <p>
                <label for="aim_email">Email address</label>
                <input
                  type="email"
                  name="aim_email"
                  id="aim_email"
                  value="<?php echo esc_attr( $_POST['aim_email'] ?? '' ); ?>"
                  required
                >
              </p>

              <p>
                <label for="aim_password">Password</label>
                <input
                  type="password"
                  name="aim_password"
                  id="aim_password"
                  required
                >
              </p>

              <p>
                <label for="aim_confirm_password">Confirm password</label>
                <input
                  type="password"
                  name="aim_confirm_password"
                  id="aim_confirm_password"
                  required
                >
              </p>

              <p class="login-submit">
                <input
                  type="submit"
                  value="<?php echo $registration_enabled ? 'Register' : 'Registration coming soon'; ?>"
                  <?php disabled( ! $registration_enabled ); ?>
                >
              </p>

            </form>

            <div class="auth-card-footer">
              <a href="<?php echo esc_url( home_url( '/login/' ) ); ?>">
                Already have an account? Login
              </a>
            </div>
          </div>
        </div>

        <div class="six columns omega">
          <aside class="auth-side-panel">
            <h2>Contribute to the AIM Library</h2>

            <p>
              Contributors can submit new measures for review before they are added to the library.
            </p>

            <ul>
              <li>Submit new measures</li>
              <li>Support the AIM research community</li>
              <li>Help expand the Library of Measures</li>
            </ul>

            <p class="auth-side-panel__note">
              All submissions are reviewed by the AIM team before being published in the library.
            </p>
          </aside>
        </div>

      </div>

    </div>
  </div>
</section>

<?php get_footer(); ?>
