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
            $args['author'] = $user->ID;
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
                    'value' => 'Active',
                    'compare' => '='
                )
            )
        );

        return \get_posts($args);
    }

    public static function getActivePCs()
    {
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'character',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'status',
                    'value' => 'Active',
                    'compare' => '='
                ),
                array(
                    'relation' => 'OR',
                    array(
                        'key' => 'is_npc',
                        'value' => true,
                        'compare' => '!='
                    ),
                    array(
                        'key' => 'is_npc',
                        'compare' => 'NOT_EXISTS'
                    )
                )
            )
        );
        return get_posts($args);
    }

    public static function getInitiations()
    {
        $initiation_merits = get_posts(array(
            'posts_per_page' => -1,
            'post_type' => 'merit',
            'tax_query' => array(
                array(
                    'taxonomy' => 'merit_category',
                    'field' => 'slug',
                    'terms' => 'initiations'
                )
            )
        ));
        $characters = Characters::getActivePCs();
        $chars_by_initiation = array();
        foreach ($initiation_merits as $initiation) {
            $chars_by_initiation[$initiation->post_title] = array();
            foreach ($characters as $char) {
                foreach ($get_field('merits', $char->ID) as $merit) {
                    if ($merit['merit']->ID == $initiation->ID) {
                        array_push($chars_by_initiation[$initiation->post_title], array(
                            'character' => $char->ID,
                            'link' => get_permalink($char->ID),
                            'name' => $char->post_title,
                            'rating' => $merit['rating']
                        ));
                        break;
                    }
                }
            }
            usort($chars_by_initiation[$initiation->post_title], function ($a, $b) {
                if ($a['rating'] == $b['rating']) {
                    if ($a['name'] == $b['name']) {
                        return 0;
                    }
                    return $a['name'] > $b['name'] ? 1 : -1;
                }

                return $a['rating'] > $b['rating'] ? -1 : 1;
            });
        }
        return $chars_by_initiation;
    }

    public static function getSkillSpreads()
    {
        $skills = array(
            'academics',
            'computer',
            'crafts',
            'investigation',
            'medicine',
            'occult',
            'politics',
            'science',
            'athletics',
            'brawl',
            'drive',
            'firearms',
            'larceny',
            'stealth',
            'survival',
            'weaponry',
            'animal_ken',
            'empathy',
            'expression',
            'intimidation',
            'leadership',
            'persuasion',
            'streetwise',
            'subterfuge'
        );
        $spreads = array();
        $characters = Characters::getActivePCs();
        foreach ($skills as $sk) {
            $spreads[$sk] = array(0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0);
            foreach ($characters as $char) {
                $spreads[$sk][$char[$sk]]++;
            }
        }
        return $spreads;
    }
}
