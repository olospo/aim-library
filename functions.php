<?php

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'mhid-parent',
        get_template_directory_uri() . '/css/main.css'
    );

    wp_enqueue_style(
        'mhid-aim',
        get_stylesheet_directory_uri() . '/style.css',
        ['mhid-parent'],
        wp_get_theme()->get('Version')
    );

    wp_enqueue_script(
        'aim-library',
        get_stylesheet_directory_uri() . '/js/aim-library.js',
        [],
        wp_get_theme()->get('Version'),
        true
    );
});