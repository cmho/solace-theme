<?php

namespace App;

use Sober\Controller\Controller;

class Experience extends Controller
{
    public static function getDiff()
    {
        $character = get_posts(array(
            'post_type' => 'character',
            'posts_per_page' => -1,
            'orderby' => 'date_modified',
            'order' => 'DESC',
            'meta_query' => array(
                array(
                    'key' => 'experience_expenditure',
                    'value' => get_the_ID()
                )
            )
        ));
        return wp_get_revision_ui_diff($character->post_parent, wp_get_post_revision($character), $character->ID);
    }

    public static function getcharacter()
    {
        $character = get_posts(array(
            'post_type' => 'character',
            'posts_per_page' => -1,
            'orderby' => 'date_modified',
            'order' => 'DESC',
            'meta_query' => array(
                array(
                    'key' => 'experience_expenditure',
                    'value' => get_the_ID()
                )
            )
        ));
        return get_post($character->post_parent);
    }
}
