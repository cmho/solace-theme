<?php

namespace App;

use Sober\Controller\Controller;

class Downtimes extends Controller
{
    public static function listDowntimes($character)
    {
        $games = \get_posts(array(
            'post_type' => 'game',
            'posts_per_page' => -1,
            'meta_key' => 'downtimes_open',
            'orderby' => 'meta_key',
            'order' => 'DESC'
        ));

        $user = \wp_current_user();
        $actions = array();

        foreach ($games as $game) {
            $args = array(
                'post_type' => 'downtime',
                'posts_per_page' => -1,
                'order_by' => 'date_modified',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key' => 'game',
                        'value' => $game->ID
                    )
                )
            );
            if (!App\App::isAdmin()) {
                array_push($args['meta_query'], array(
                    'key' => 'character',
                    'value' => $character
                ));
            }
            $act = get_posts();
            $actions[$game->ID] = $act;
        }

        return $actions;
    }
}
