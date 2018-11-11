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
        $attributes = ((get_field('intelligence')+get_field('wits')+get_field('resolve')
            +get_field('strength')+get_field('dexterity')+get_field('stamina')
            +get_field('presence')+get_field('manipulation')+get_field('composure'))
            - 10)*4;
        $skills = (get_field('academics')+get_field('computer')+get_field('crafts')
            +get_field('investigation')+get_field('medicine')+get_field('occult')
            +get_field('politics')+get_field('science')+get_field('athletics')
            +get_field('brawl')+get_field('drive')+get_field('firearms')
            +get_field('larceny')+get_field('stealth')+get_field('survival')
            +get_field('weaponry')+get_field('animal_ken')+get_field('empathy')
            +get_field('expression')+get_field('intimidation')+get_field('persuasion')
            +get_field('socialize')+get_field('streetwise')+get_field('subterfuge')-22)*2;
        $merits;
        foreach (get_field('merits') as $merit) {
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
