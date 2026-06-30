<?php
/**
 * Template Name: AIM Library page with subnav
 */

get_header();
the_post();

get_template_part( 'template-parts/library-nav' );
?>

<section class="hero single">
  <div class="container">
    <div class="content ten columns">

        <h1><?php echo $post->post_title; ?></h1>
        <p>Contribute a new measure to the AIM Library.</p>
    </div>
  </div>
</section>
    <section class="post news">
        <div class="container flex">
            <div class="content twelve columns">
                <?php the_content(); ?>

            </div>
        </div>
    </section>

<?php get_footer();
