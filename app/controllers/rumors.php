<?php

namespace App;

use Sober\Controller\Controller;

class Rumors extends Controller
{
    public static function listRumors($game = null, $char = null)
    {
        $args = array(
            'post_type' => 'rumor',
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'AND'
            )
        );

        if ($game) {
            array_push($args['meta_query'], array(
                'key' => 'game',
                'value' => $game
            ));
        }

        $rumors = get_posts($args);
        return $rumors;
    }
}
