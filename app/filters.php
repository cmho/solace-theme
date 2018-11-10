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
        'post_author' => htmlspecialchars($_POST['author']),
        'post_type' => 'character',
        'post_status' => 'publish',
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
            'merits' => intval(htmlspecialchars($_POST['merits'])),
            'size' => htmlspecialchars($_POST['size']),
            'armor' => htmlspecialchars($_POST['armor']),
            'integrity' => htmlspecialchars($_POST['integrity'])
        )
    );

    for ($i = 0; $i < intval(htmlspecialchars($_POST['merits'])); $i++) {
        $post_content['meta_input']['merits_'.$i.'_merit'] = htmlspecialchars($_POST['merits_'.$i.'_merit']);
        $post_content['meta_input']['merits_'.$i.'_rating'] = htmlspecialchars($_POST['merits_'.$i.'_rating']);
        $post_content['meta_input']['merits_'.$i.'_specification'] = htmlspecialchars($_POST['merits_'.$i.'_specification']);
        $post_content['meta_input']['merits_'.$i.'_description'] = htmlspecialchars($_POST['merits_'.$i.'_description']);
    }

    if (isset($_POST['id'])) {
        $post_content['ID'] = htmlspecialchars($_POST['id']);
    }

    $post = \wp_insert_post($post_content);
    header('Location:'.get_the_permalink($post));
    die(1);
}

add_action('admin_post_update_character', __NAMESPACE__.'\\update_character');

function get_merit_info()
{
    $id = intval($_POST['id']);
    $post = \get_post($id);
    \setup_postdata($post);
    $obj = array(
        'id' => $id,
        'ratings' => get_field('allowed_ratings', $post),
        'name' => get_the_title($post),
        'has_specification' => get_field('requires_specification', $post),
        'has_description' => get_field('requires_description', $post),
        'description' => get_field('description', $post),
        'prerequisites' => get_field('prerequisites', $post)
    );
    header('Content-type: application/json');
    echo json_encode($obj);
    die(1);
}

add_action('wp_ajax_get_merit_info', __NAMESPACE__.'\\get_merit_info');
add_action('wp_ajax_nopriv_get_merit_info', __NAMESPACE__.'\\get_merit_info');

function mass_add_experience()
{
    $characters = get_posts(array(
        'posts_per_page' => -1,
        'post_type' => 'character',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'is_npc',
                'compare' => 'NOT EXISTS'
            ),
            array(
                'key' => 'status',
                'value' => 'Active',
                'compare' => '='
            )
        )
    ));

    foreach ($characters as $character) {
        wp_insert_post(array(
            'post_type' => 'experience',
            'post_title' => htmlspecialchars($_POST['reason']),
            'meta_input' => array(
                'character' => $character->ID,
                'amount' => intval(htmlspecialchars($_POST['amount']))
            )
        ));
    }
    die(1);
}

function add_experience()
{
    wp_insert_post(array(
        'post_type' => 'experience',
        'post_title' => htmlspecialchars($_POST['reason']),
        'meta_input' => array(
            'character' => intval(htmlspecialchars($_POST['character'])),
            'amount' => intval(htmlspecialchars($_POST['amount']))
        )
    ));

    die(1);
}

function update_downtime()
{
    $args = array(
        'post_type' => 'downtime',
        'ID' => intval(htmlspecialchars($_POST['id'])),
        'post_status' => 'publish',
        'post_author' => htmlspecialchars($_POST['author']),
        'post_title' => htmlspecialchars($_POST['post_title']),
        'post_content' => htmlspecialchars($_POST['post_content']),
        'meta_input' => array(
            'character' => intval(htmlspecialchars($_POST['character'])),
            'game' => intval(htmlspecialchars($_POST['game'])),
            'goal' => htmlspecialchars($_POST['goal']),
            'assets' => htmlspecialchars($_POST['assets']),
            'action_type' => htmlspecialchars($_POST['action_type'])
        )
    );

    $action = wp_insert_post($args);
    header('Location:'.get_permalink($action));
    die(1);
}

add_action('admin_post_update_downtime', __NAMESPACE__.'\\update_downtime');

function respond_to_downtime()
{
    $args = array(
        'post_type' => 'downtime',
        'ID' => intval(htmlspecialchars($_POST['id'])),
        'meta_input' => array(
            'response' => htmlspecialchars($_POST['response'])
        )
    );
    $action = wp_insert_post($args);
    header('Location:'.get_permalink($action));
    die(1);
}

function delete_character()
{
    wp_delete_post($_POST['id'], false);
    header('Location:'.home_url('/')."dashboard/");
    die(1);
}

function delete_downtime()
{
    wp_delete_post($_POST['id'], false);
    header('Location:'.home_url('/')."downtimes/");
}

function custom_rewrite_tag()
{
    add_rewrite_tag('%game%', '([^&]+)');
    add_rewrite_tag('%character%', '([^&]+)');
    add_rewrite_tag('%mode%', '([^&]+)');
}
add_action('init', __NAMESPACE__.'\\custom_rewrite_tag', 10, 0);

function custom_rewrite_basic()
{
    add_rewrite_rule('characters\/([0-9a-zA-Z\-]+)\/edit\/?', 'index.php?character=$matches[1]&mode=edit', 'top');
}
add_action('init', __NAMESPACE__.'\\custom_rewrite_basic');
