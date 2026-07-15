<?php
$library_url  = home_url( '/library-of-measures/' );
$login_url    = home_url( '/login/' );
$register_url = home_url( '/register/' );
$submit_url   = home_url( '/submit-measure/' );
$my_url   = home_url( '/my-measures/' );
?>

<nav class="measure-library-subnav" aria-label="Measure library navigation">
  <div class="container">
    <div class="twelve columns">
      <ul>

        <?php
        $is_library = (
            is_page_template( 'templates/library-of-measures.php' ) ||
            is_singular( 'measure' )
        );
        ?>

        <li>
          <a class="<?php echo $is_library ? 'active' : ''; ?>" href="<?php echo esc_url( $library_url ); ?>">Browse Library</a>
        </li>

        <?php if ( is_user_logged_in() ) : ?>
          <li>
            <a class="<?php echo is_page( 'submit-measure' ) ? 'active' : ''; ?>" href="<?php echo esc_url( $submit_url ); ?>">Submit Measure</a>
          </li>
          <li>
            <a class="<?php echo is_page( 'my-measures' ) ? 'active' : ''; ?>" href="<?php echo esc_url( $my_url ); ?>">My Measures</a>
          </li>
            
          <?php // Comment on measure (current measure is pre-populated)
          $comment_url = home_url( '/library-of-measures/comment-on-measure/' );
          
          if ( is_singular( 'measure' ) ) {
            $comment_url = add_query_arg(
              [
                'aim_measure_title' => get_the_title(),
                'aim_measure_id'    => get_the_ID(),
              ],
              $comment_url
            );
          }
          ?>
      
          <li>
            <a class="<?php echo is_page( 'comment-on-measure' ) ? 'active' : ''; ?>" href="<?php echo esc_url( $comment_url ); ?>">Comment on Measure</a>
          </li>

          <li>
            <a href="<?php echo esc_url( wp_logout_url( $library_url ) ); ?>">Log Out</a>
          </li>
        <?php else : ?>
          <li>
            <a class="<?php echo is_page( 'login' ) ? 'active' : ''; ?>" href="<?php echo esc_url( $login_url ); ?>">Login</a>
          </li>

          <li>
            <a class="<?php echo is_page( 'register' ) ? 'active' : ''; ?>" href="<?php echo esc_url( $register_url ); ?>">Register</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
