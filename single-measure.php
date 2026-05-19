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

    $age_description            = $metas['age_description'] ?? null;
    $summary                    = $metas['summary'] ?? null;
    $time                       = $metas['time'] ?? null;
    $respondent                 = $metas['respondent'] ?? null;
    $problem_tags               = get_problem_areas($post->ID);
    $overview                   = $metas['overview'] ?? null;
    $scoring                    = $metas['scoring'] ?? null;
    $internal_consistency       = $metas['internal_consistency'] ?? null;
    $test_retest_reliability    = $metas['test_retest_reliability'] ?? null;
    $construct_validity         = $metas['construct_validity'] ?? null;
    $structural_validity        = $metas['structural_validity'] ?? null;
    $convergent_validity        = $metas['convergent_validity'] ?? null;
    $divergent_validity         = $metas['divergent_validity'] ?? null;
    $measurement_inveriance     = $metas['divergent_validity'] ?? null;
    $group_differences          = $metas['group_differences'] ?? null;
    $sensitivity                = $metas['sensitivity'] ?? null;
    $citation                   = $metas['citation'] ?? null;
    $original_reference         = $metas['original_reference'] ?? null;
    $references                 = $metas['references'] ?? null;
    $licensing                  = $metas['licensing'] ?? null;

    // post process custom metadata
    if(is_numeric($time)) {
        $time = $time . ' minutes';
    }

    ?>

    <section class="hero measure-hero">
        <div class="container">
            <div class="content twelve columns">
                <!-- <a href="<?php echo esc_url( home_url('/aim-library/') ); ?>" class="back-link">Back to Library</a> -->

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
                    <strong><?php echo $age_description; ?></strong>
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
                    <section class="measure-section">
                        <h2>Overview</h2>
                        <?php echo $overview; ?>
                    </section>

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
                                <h3>Test-retest Reliability</h3>
                                <?php echo $test_retest_reliability; ?>
                            </div>

                            <div class="property-item">
                                <h3>Construct Validity</h3>
                                <?php echo $construct_validity; ?>
                            </div>

                            <div class="property-item">
                                <h3>Structural Validity</h3>
                                <?php echo $structural_validity; ?>>
                            </div>

                            <div class="property-item">
                                <h3>Convergent Validity</h3>
                                <?php echo $convergent_validity; ?>
                            </div>

                            <div class="property-item">
                                <h3>Divergent Validity</h3>
                               <?php echo $divergent_validity; ?>
                            </div>

                            <div class="property-item">
                                <h3>Measurement Invariance</h3>
                                <?php echo $measurement_inveriance; ?>
                            </div>
                        </div>
                    </section>

                    <?php debug($group_differences);  if( $group_differences || $sensitivity) { ?>  <section class="measure-section">
                        <h2>Additional Psychometric Properties</h2>

                        <?php if($group_differences) { ?>
                        <div class="property-item">
                            <h3>Group Differences</h3>
                            <?php echo $group_differences; ?>>
                        </div>
                        <?php } ?>

                        <?php if($sensitivity) { ?>
                        <div class="property-item">
                            <h3>Sensitivity to Change</h3>
                            <?php echo $sensitivity; ?>>
                        </div>
                        <?php } ?>
                    </section>
                    <?php } ?>
                    <section class="measure-section">
                        <h2>Access</h2>

                       <?php echo $licensing; ?>
                    </section>

                </article>

                <section class="measure-footer-card">

                    <div class="footer-section">
                        <h2>Citation</h2>

                        <div class="citation-box">
                            <p>
                                NIHR Oxford Health Biomedical Research Centre, AIM Library. 2026. Information on:
                                <strong>Adolescent Cognitive Style Questionnaire</strong>
                            </p>

                            <button class="copy-button" type="button">Copy citation</button>
                        </div>
                    </div>

                    <div class="footer-section">
                        <h2>Original Reference</h2>

                        <p>
                            Hankin, B. L., &amp; Abramson, L. Y. (2002). Measuring Cognitive Vulnerability to Depression in Adolescence: Reliability, Validity, and Gender Differences. <em>Journal of Clinical Child and Adolescent Psychology, 31</em>(4), 491–504.
                        </p>

                    </div>

                    <div class="footer-section">
                        <h2>References</h2>

                        <p>
                            Metalsky, G. I., &amp; Joiner, T. E. (1992). Vulnerability to Depressive Symptomatology: A Prospective Test of the Diathesis-Stress and Causal Mediation Components of the Hopelessness Theory of Depression. <em>Journal of Personality and Social Psychology, 63</em>(4), 667–675.
                        </p>

                    </div>

                </section>

            </div>
        </div>
    </main>

<?php get_footer(); ?>
