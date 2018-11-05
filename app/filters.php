<?php

namespace App;

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
    /** Add page slug if it doesn't exist */
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    /** Add class if sidebar is active */
    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    /** Clean up class names for custom templates */
    $classes = array_map(function ($class) {
        return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
    }, $classes);

    return array_filter($classes);
});

/**
 * Add "… Continued" to the excerpt
 */
add_filter('excerpt_more', function () {
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
});

/**
 * Template Hierarchy should search for .blade.php files
 */
collect([
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment'
])->map(function ($type) {
    add_filter("{$type}_template_hierarchy", __NAMESPACE__.'\\filter_templates');
});

/**
 * Render page using Blade
 */
add_filter('template_include', function ($template) {
    $data = collect(get_body_class())->reduce(function ($data, $class) use ($template) {
        return apply_filters("sage/template/{$class}/data", $data, $template);
    }, []);
    if ($template) {
        echo template($template, $data);
        return get_stylesheet_directory().'/index.php';
    }
    return $template;
}, PHP_INT_MAX);

/**
 * Tell WordPress how to find the compiled path of comments.blade.php
 */
add_filter('comments_template', function ($comments_template) {
    $comments_template = str_replace(
        [get_stylesheet_directory(), get_template_directory()],
        '',
        $comments_template
    );
    return template_path(locate_template(["views/{$comments_template}", $comments_template]) ?: $comments_template);
}, 100);

function update_character()
{
    $post_content = array(
        'post_title' => htmlspecialchars($_POST['post_title']),
        'post_author' => wp_current_user()->ID,
        'meta_input' => array(
            'intelligence' => htmlspecialchars($_POST['intelligence']),
            'wits' => htmlspecialchars($_POST['wits']),
            'resolve' => htmlspecialchars($_POST['resolve']),
            'strength' => htmlspecialchars($_POST['strength']),
            'dexterity' => htmlspecialchars($_POST['dexterity']),
            'stamina' => htmlspecialchars($_POST['stamina']),
            'presence' => htmlspecialchars($_POST['presence']),
            'manipulation' => htmlspecialchars($_POST['manipulation']),
            'composure' => htmlspecialchars($_POST['composure']),
            'family' => htmlspecialchars($_POST['family']),
            'status' => htmlspecialchars($_POST['status']),
            'virtue' => htmlspecialchars($_POST['virtue']),
            'vice' => htmlspecialchars($_POST['vice']),
            'quote' => htmlspecialchars($_POST['quote']),
            'public_blurb' => htmlspecialchars($_POST['public_blurb']),
            'academics' => htmlspecialchars($_POST['academics']),
            'computer' => htmlspecialchars($_POST['computer']),
            'crafts' => htmlspecialchars($_POST['crafts']),
            'investigation' => htmlspecialchars($_POST['investigation']),
            'medicine' => htmlspecialchars($_POST['medicine']),
            'occult' => htmlspecialchars($_POST['occult']),
            'politics' => htmlspecialchars($_POST['politics']),
            'science' => htmlspecialchars($_POST['science']),
            'athletics' => htmlspecialchars($_POST['athletics']),
            'brawl' => htmlspecialchars($_POST['brawl']),
            'drive' => htmlspecialchars($_POST['drive']),
            'firearms' => htmlspecialchars($_POST['firearms']),
            'larceny' => htmlspecialchars($_POST['larceny']),
            'stealth' => htmlspecialchars($_POST['stealth']),
            'survival' => htmlspecialchars($_POST['survival']),
            'weaponry' => htmlspecialchars($_POST['weaponry']),
            'merits' => $_POST['merits'],
            'size' => htmlspecialchars($_POST['size']),
            'armor' => htmlspecialchars($_POST['armor']),
            'integrity' => htmlspecialchars($_POST['integrity'])
        )
    );

    if (isset($_POST['id'])) {
        $post_content['ID'] = htmlspecialchars($_POST['id']);
    }

    $post = wp_insert_post($post_content);
    header('Location:'.get_the_permalink($post));
    die(1);
}

add_action('admin_post_update_character', __NAMESPACE__.'\\update_character');
