<?php

namespace App;

use Sober\Controller\Controller;

class Character extends Controller
{
    public static function experienceRecords()
    {
        $character = get_the_ID();
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'experience',
            'meta_query' => array(
                array(
                    'key' => 'character',
                    'value' => $character
                )
            )
        );
        return \get_posts($args);
    }

    public static function sumExperience()
    {
        $character = get_the_ID();
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'experience',
            'meta_query' => array(
                array(
                    'key' => 'character',
                    'value' => $character
                )
            )
        );

        $exp = \get_posts($args);
        $sum = 0;
        foreach ($exp as $e) {
            $sum += get_field('amount', $e);
        }
        return $sum;
    }

    public static function getExperienceCost($character)
    {
        global $post;
        $post = $character;
        $attributes = ((get_field('intelligence', $post)+get_field('wits', $post)+get_field('resolve', $post)
            +get_field('strength', $post)+get_field('dexterity', $post)+get_field('stamina', $post)
            +get_field('presence', $post)+get_field('manipulation', $post)+get_field('composure', $post))
            - 10)*4;
        $skills = (get_field('academics', $post)+get_field('computer', $post)+get_field('crafts', $post)
            +get_field('investigation', $post)+get_field('medicine', $post)+get_field('occult', $post)
            +get_field('politics', $post)+get_field('science', $post)+get_field('athletics', $post)
            +get_field('brawl', $post)+get_field('drive', $post)+get_field('firearms', $post)
            +get_field('larceny', $post)+get_field('stealth', $post)+get_field('survival', $post)
            +get_field('weaponry', $post)+get_field('animal_ken', $post)+get_field('empathy', $post)
            +get_field('expression', $post)+get_field('intimidation', $post)+get_field('persuasion', $post)
            +get_field('socialize', $post)+get_field('streetwise', $post)+get_field('subterfuge', $post)-22)*2;
        $merits;
        foreach (get_field('merits', $post) as $merit) {
            $merits += $merit['rating'];
        }
        $merits -= 17;
        return $attributes + $skills + $merits;
    }

    public static function printDots($amt = 0)
    {
        for ($i = 1; $i <= 5; $i++) {
            if ($i > $amt) {
                echo '<i class="far fa-circle"></i>';
            } else {
                echo '<i class="fas fa-circle"></i>';
            }
        }
        echo '<span class="sr-only">'.$amt.'</span>';
    }

    public static function printDotsTen($amt = 0)
    {
        for ($i = 1; $i <= 10; $i++) {
            if ($i > $amt) {
                echo '<i class="far fa-circle"></i>';
            } else {
                echo '<i class="fas fa-circle"></i>';
            }
        }
        echo '<span class="sr-only">'.$amt.'</span>';
    }

    public static function printSquares($amt)
    {
        for ($i = 1; $i <= $amt; $i++) {
            echo '<i class="far fa-square"></i>';
        }
        echo '<span class="sr-only">'.$amt.'</span>';
    }
}
