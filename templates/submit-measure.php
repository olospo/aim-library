<?php
/**
 * Template Name: Submit Measure
 */

    // Redirect if not logged in
    if ( ! is_user_logged_in() ) {
        wp_safe_redirect( home_url( '/login/' ) );
        exit;
    }

    // Determine whether we're editing an existing post or creating a new one
    $edit_post_id = null;

    if ( isset( $_GET['post_id'] ) ) {
        $requested_id = intval( $_GET['post_id'] );
        $post         = get_post( $requested_id );

        // Validate: must exist, be a measure, and belong to the current user
        if (
                $post &&
                $post->post_type === 'measure' &&
                (int) $post->post_author === get_current_user_id()
        ) {
            $edit_post_id = $requested_id;
        } else {
            // Post doesn't belong to them — silently fall back to new post
            $edit_post_id = null;
        }
    }

    $form_args = $edit_post_id ? [
        // Editing an existing measure
            'post_id'         => $edit_post_id,
            'post_title'      => true,
            'post_content'    => false,
            'submit_value'    => 'Update Measure and revert to Draft status',
            'updated_message' => 'Your measure has been updated.',
            'return'          => home_url( '/library-of-measures/my-measures/?status=updated' ),
    ] : [
        // Creating a new measure
            'post_id'         => 'new_post',
            'post_title'      => true,
            'post_content'    => false,
            'new_post'        => [
                    'post_type'   => 'measure',
                    'post_status' => 'draft',
            ],
            'submit_value'    => 'Save Measure as Draft',
            'updated_message' => 'Your measure has been saved to your Measures page.',
            'return'          => home_url( '/library-of-measures/my-measures/?status=created' ),
    ];

    acf_form_head();
    get_header();
?>

<?php get_template_part( 'template-parts/library-nav' ); ?>

<section class="hero single">
  <div class="container">
    <div class="content ten columns">

        <h1><?php echo $edit_post_id ? 'Edit Measure' : 'Submit a Measure'; ?></h1>
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
              <h2>The Measure</h2>
              <p>
                Please fill out the details below. For title please give the Name and the abbreviation of the measure
            </div>

              <?php acf_form( $form_args ); ?>

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
<style>
    .acf-field {
        display: flex;
        flex-direction: column;
    }

    .acf-field .acf-label {
        order: 1;
    }

    .acf-field .accordionItem {
        order: 2;
    }

    .acf-field .acf-input {
        order: 3;
    }

    .acf-field .acf-label label {
        font-size: 16px;
        font-weight: 700;
    }
    .acf-field .acf-label p {
        font-size: 16px;
        font-style: italic;
        letter-spacing: 0.01em;
        line-height: 20px;
        margin-bottom: 4px;
    }
    .acf-input .acf-link a.button {
        border: 1px solid #0C7AB7;
        border-radius: 5px;
        color: #0E7BB8;
    }
    .accordionItem {
        border-bottom: 0;
    }
</style>
<?php get_footer();
