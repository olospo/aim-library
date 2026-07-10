<?php
    /*
    Template Name: AIM Measure Prototype
    */

    get_header();

    $metas = [];
    $postmetas = get_post_meta($post->ID);

    foreach ($postmetas as $key => $value) {
        $field = str_contains($value[0], 'field_');
        if (!$field) {
            $metas[ $key ] = $value[0];
        }
    }

    $age_min                    = $metas['age_min'] ?? null;
    $age_max                    = $metas['age_max'] ?? null;
    $age_description            = $metas['age_description'] ?? null;
    $summary                    = $metas['summary'] ?? null;
    $time                       = $metas['time'] ?? null;
    $respondent                 = $metas['respondent'] ?? null;
    $respondent                 = ucwords(str_replace(['t-c', '-'], ['t / c', ' '], $respondent));
    $problem_tags               = get_problem_areas($post->ID);
    $overview                   = $metas['overview'] ?? null;
    $scoring                    = $metas['scoring'] ?? null;
    $internal_consistency       = $metas['internal_consistency'] ?? null;
    $test_retest_reliability    = $metas['test_retest_reliability'] ?? null;
    $factor_structure           = $metas['factor_structure'] ?? null;
    $validity                   = $metas['validity'] ?? null;
    $measurement_invariance     = $metas['measurement_invariance'] ?? null;
    $additional_psychometric    = $metas['additional_psychometric_information'] ?? null;
    $citation                   = $metas['citation'] ?? null;
    $original_reference         = $metas['original_reference'] ?? null;
    $references                 = $metas['references'] ?? null;
    $licensing                  = $metas['licensing'] ?? null;
    $acknowledgement            = $metas['acknowledgement'] ?? false;
    $acknowledgements           = $metas['acknowledgements'] ?? null;

    // post process custom metadata
    if(is_numeric($time)) {
        $time = $time . ' minutes';
    }

    $age_range = $age_min . ($age_min && $age_max ? ' &mdash; ' : '') . $age_max;
    $age_range = $age_range . ( $age_description ? '<br/>' . $age_description : '' );
    $age_rage  = ( ! empty ( $age_range ) ) ? $age_range : 'No information provided';

    ?>
    <?php get_template_part( 'template-parts/library-nav' ); ?>
    <section class="hero measure-hero">
        <div class="container">
            <div class="content twelve columns">

                <p class="eyebrow">Measure</p>

                <h1><?php echo $post->post_title; ?></h1>

                <p class="measure-summary">
                    <?php echo $summary; ?>
                </p>
            </div>
        </div>
    </section>

    <section class="measure-meta">
        <div class="container">
            <div class="measure-meta-card">
                <div class="meta-item">
                    <span class="meta-label">Age range</span>
                    <strong><?php echo $age_range; ?></strong>
                </div>

                <div class="meta-item">
                    <span class="meta-label">Completion time</span>
                    <strong><?php echo $time; ?></strong>
                </div>

                <div class="meta-item">
                    <span class="meta-label">Respondent</span>
                    <span class="tag tag-self"><?php echo $respondent; ?></span>
                </div>

                <div class="meta-item">
                    <span class="meta-label">Problem areas</span>
                    <div class="meta-tags">
                        <?php echo $problem_tags; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="measure-page">
        <div class="container">
            <div class="measure-shell">
                <article class="measure-main-card">
                   <?php if (! empty($overview )) {
 ?>
                   <section class="measure-section">
                        <h2>Overview</h2>
                        <?php echo $overview; ?>
                    </section>
                   <?php } ?>
                    <section class="measure-section">
                        <h2>Scoring &amp; Interpretation</h2>
                        <?php echo $scoring; ?>
                    </section>

                    <section class="measure-section">
                        <h2>Psychometric Properties</h2>

                        <div class="properties-list">
                            <div class="property-item">
                                <h3>Internal Consistency</h3>
                                <?php echo $internal_consistency; ?>
                            </div>

                            <div class="property-item">
                                <h3>Test-Retest Reliability</h3>
                                <?php echo $test_retest_reliability; ?>
                            </div>

                            <div class="property-item">
                                <h3>Factor Structure</h3>
                                <?php echo $factor_structure; ?>
                            </div>

                            <div class="property-item">
                                <h3>Validity</h3>
                                <?php the_field('validity'); ?>
                            </div>

                            <?php if (! empty ($additional_information)) { ?>
                            <div class="property-item">
                                <h3>Additional Information</h3>
                               <?php echo $additional_information; ?>
                            </div>
                            <?php } ?>
                            <div class="property-item">
                                <h3>Measurement Invariance</h3>
                                <?php echo $measurement_invariance; ?>
                            </div>
                        </div>
                    </section>

                    <section class="measure-section">
                        <h2>Access</h2>

                       <?php echo $licensing; ?>
                        <br/>
                        <a href="<?php echo get_field('paper'); ?>" target="_blank" ><?php echo get_field('paper'); ?></a>
                    </section>

                </article>

                <section class="measure-footer-card">

                    <div class="footer-section">
                        <h2>Citation</h2>

                        <div class="citation-box">
                            <p class="js-citation">
                                <?php echo $citation; ?>
                            </p>

                            <button class="copy-button js-share" data-clipboard-text='<?php echo $citation; ?>' type="button" alt="copy to clipboard" >Copy citation</button>
                        </div>
                    </div>

                    <div class="footer-section">
                        <h2>Original Reference</h2>

                        <p>
                            <?php echo $original_reference; ?>
                        </p>

                    </div>

                    <div class="footer-section">
                        <h2>References</h2>

                        <p>
                            <?php echo $references; ?>
                        </p>

                    </div>
<?php if( $acknowledgement ) { ?>
                    <div class="footer-section">
                        <h2>Acknowledgements</h2>

                        <p>
                            <?php echo $acknowledgements; ?>
                        </p>

                    </div>
<?php } ?>
                </section>

            </div>
        </div>
    </main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>

<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<script>
    var clipboard = new ClipboardJS('.copy-button');

    tippy('.copy-button', {
        // default
        trigger: 'click',
        content: 'Copied!',
        placement: 'bottom',
    });
</script>
<?php get_footer(); ?>
