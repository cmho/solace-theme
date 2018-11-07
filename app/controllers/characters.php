<?php

namespace App;

use Sober\Controller\Controller;

class Characters extends Controller
{
    public static function list()
    {
        $user = \wp_get_current_user();
        $is_admin = in_array('administrator', $user->roles);
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'character',
            'orderby' => 'title',
            'order' => 'ASC'
        );

        if (!$is_admin) {
            $args['post_author'] = $user->ID;
        }

        return \get_posts($args);
    }

    public static function activeList()
    {
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'character',
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'relation' => 'OR',
                    array(
                        'key' => 'is_secret',
                        'value' => true,
                        'compare' => '!='
                    ),
                    array(
                        'key' => 'is_secret',
                        'compare' => 'NOT EXISTS'
                    )
                ),
                array(
                    'key' => 'status',
                    'value' => 'active',
                    'compare' => '='
                )
            )
        );

        return \get_posts($args);
    }
}
