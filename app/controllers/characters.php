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
        $characters = \App\Characters::getActivePCs();
        $chars_by_initiation = array();
        foreach ($initiation_merits as $initiation) {
            $chars_by_initiation[$initiation->post_title] = array();
            foreach ($characters as $char) {
                $mer = get_field('merits', $char->ID);
                $mer = array_values(array_filter($mer, function ($m) use ($initiation) {
                    if ($m['merit']->ID != $initiation->ID) {
                        return false;
                    }
                    return true;
                }));
                if ($mer) {
                    array_push($chars_by_initiation[$initiation->post_title], array(
                        'character' => $char->ID,
                        'link' => get_permalink($char->ID),
                        'name' => $char->post_title,
                        'rating' => $mer[0]['rating']
                    ));
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
        $characters = \App\Characters::getActivePCs();
        foreach ($skills as $sk) {
            $spreads[$sk] = array(
                'counts' => array(0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0),
                'characters' => array(0 => array(), 1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array())
            );
            foreach ($characters as $char) {
                $spreads[$sk]['counts'][get_field($sk, $char)]++;
                array_push($spreads[$sk]['characters'][get_field($sk, $char)], $char->post_title);
            }
        }
        return $spreads;
    }

    public static function getMeritSpreads()
    {
        $merits = get_posts(array(
            'posts_per_page' => -1,
            'post_type' => 'merit'
        ));
        $characters = \App\Characters::getActivePCs();
        $spreads = array();
        foreach ($merits as $merit) {
            $spreads[$merit->post_title] = array(
                'meritinfo' => array('allowed_ratings' => get_field('allowed_ratings', $merit), 'specification' => get_field('requires_specification', $merit)),
                'counts' => array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0),
                'characters' => array(1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array()),
                'total' => 0
            );

            foreach ($characters as $char) {
                foreach (get_field('merits', $char) as $cm) {
                    if ($cm['merit']->ID == $merit->ID) {
                        $spreads[$merit->post_title]['counts'][$cm['rating']]++;
                        array_push($spreads[$merit->post_title]['characters'][$cm['rating']], $char->post_title);
                        $spreads[$merit->post_title]['total']++;
                    }
                }
            }
        }
        return $spreads;
    }

    public static function getIntegrityTimeline()
    {
        $characters = \App\Characters::getActivePCs();
        $revisions = array();
        foreach ($characters as $char) {
            $revisions[$char->post_title] = array_map(function ($r) {
                return array(
                    'date' => get_the_date('Y-m-d h:i:s', $r),
                    'integrity' => get_field('integrity', $r)
                );
            }, get_posts(array(
                'post_type' => 'revision',
                'post_parent' => $char->ID,
                'posts_per_page' => -1,
                'order' => 'ASC',
                'orderby' => 'modified',
                'date_query' => array(
                    'after' => '2019-04-12',
                    'column' => 'post_modified'
                )
            )));
            array_push($revisions[$char->post_title], array(
                'date' => date('Y-m-d h:i:s'),
                'integrity' => get_field('integrity', $char)
            ));
        }
        return $revisions;
    }
}
