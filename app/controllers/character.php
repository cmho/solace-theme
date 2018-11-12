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
        $attributes =
            ((get_field('intelligence', $character)+get_field('wits', $character)+get_field('resolve', $character)
            +get_field('strength', $character)+get_field('dexterity', $character)+get_field('stamina', $character)
            +get_field('presence', $character)+get_field('manipulation', $character)+get_field('composure', $character))
            - 10)*4;
        $skills =
            (get_field('academics', $character)+get_field('computer', $character)+get_field('crafts', $character)
            +get_field('investigation', $character)+get_field('medicine', $character)+get_field('occult', $character)
            +get_field('politics', $character)+get_field('science', $character)+get_field('athletics', $character)
            +get_field('brawl', $character)+get_field('drive', $character)+get_field('firearms', $character)
            +get_field('larceny', $character)+get_field('stealth', $character)+get_field('survival', $character)
            +get_field('weaponry', $character)+get_field('animal_ken', $character)+get_field('empathy', $character)
            +get_field('expression', $character)+get_field('intimidation', $character)+get_field('persuasion', $character)
            +get_field('socialize', $character)+get_field('streetwise', $character)+get_field('subterfuge', $character)
            - 22)*2;
        $merits;
        foreach (get_field('merits', $character) as $merit) {
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
