<?php

namespace App;

use Sober\Controller\Controller;

class App extends Controller
{
    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'sage');
        }
        if (is_archive()) {
            return get_the_archive_title();
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'sage');
        }
        return get_the_title();
    }

    public static function newCharacterLink()
    {
        $posts = \get_posts(array(
            'post_type' => 'page',
            'posts_per_page' => 1,
            'meta_query' => array(
                array(
                    'key' => '_wp_page_template',
                    'value' => 'views/template-character-creation.blade.php'
                )
            )
        ));

        if ($posts && count($posts) > 0) {
            return \get_permalink($posts[0]);
        }

        return;
    }

    public static function downtimesLink()
    {
        $posts = \get_posts(array(
            'post_type' => 'page',
            'posts_per_page' => 1,
            'meta_query' => array(
                array(
                    'key' => '_wp_page_template',
                    'value' => 'views/template-downtime-actions.blade.php'
                )
            )
        ));

        if ($posts && count($posts) > 0) {
            return \get_permalink($posts[0]);
        }

        return;
    }

    public static function dashboardLink()
    {
        $posts = \get_posts(array(
            'post_type' => 'page',
            'posts_per_page' => 1,
            'meta_query' => array(
                array(
                    'key' => '_wp_page_template',
                    'value' => 'views/template-character-list.blade.php'
                )
            )
        ));

        if ($posts && count($posts) > 0) {
            return \get_permalink($posts[0]);
        }

        return;
    }
}
