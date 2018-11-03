<?php

namespace App;

use Sober\Controller\Controller;

class Merit extends Controller
{
    public static function dots()
    {
        $allowed = get_field('allowed_ratings');
        $out = "";
        $last;
        $count = 1;
        foreach ($allowed as $rating) {
            if ($last && $last+1 == $rating && $count != count($allowed)) {
                continue;
            } elseif ($last && $last+1 != $rating && $count != count($allowed)) {
                $out .= "a-";
                for ($i = 0; $i < $last; $i++) {
                    $out .= "●";
                }
            } elseif ($last && $last+1 == $rating) {
                $out .= "b-";
            } elseif ($last) {
                $out .= ", ";
            }

            for ($j = 0; $j < $rating; $j++) {
                $out .= "●";
            }

            $last = $rating;
            $count++;
        }

        return $out;
    }
}
