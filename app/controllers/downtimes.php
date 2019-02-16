<?php

namespace App;

use Sober\Controller\Controller;

class Downtimes extends Controller
{
    public static function listDowntimes()
    {
        $tz = \DateTimeZone('America/Chicago');
        $date = \DateTime('now', $tz);
        $games = \get_posts(array(
            'post_type' => 'game',
            'posts_per_page' => -1,
            'meta_key' => 'downtimes_open',
            'orderby' => 'meta_key',
            'order' => 'DESC',
            'meta_query' => array(
                array(
                    'key' => 'downtimes_open',
                    'value' => $date->format('Y-m-d'),
                    'compare' => '<=',
                    'type' => 'DATE'
                )
            )
        ));

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
            if (!App::isAdmin()) {
                $args['post_author'] = wp_get_current_user();
            }
            $act = get_posts($args);
            $actions[$game->ID] = $act;
        }

        return $actions;
    }

    public static function listDowntimesForGame($game)
    {
        $downtimes = get_posts(array(
            'post_type' => 'downtime',
            'posts_per_page' => -1,
            'meta_query' => array(
                'game' => $game,
            )
        ));

        $grouped = array();
        foreach ($downtimes as $downtime) {
            if ($grouped[$downtime->post_author] == null) {
                $grouped[$downtime->post_author] = array();
            }
            array_push($grouped[$downtimes->post_author], $downtime);
        }

        return $grouped;
    }
}
