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
        $count = 0;
        foreach ($allowed as $rating) {
            $count++;
            if ($last && $last+1 == $rating && $count != count($allowed)) {
                continue;
            } elseif ($last && $count != count($allowed)) {
                $out .= "-";
                for ($i = 0; $i < $last; $i++) {
                    $out .= "●";
                }
            } elseif ($last && $last+1 == $rating) {
                $out .= "-";
            } elseif ($last) {
                $out .= ", ";
            }

            for ($j = 0; $j < $rating; $j++) {
                $out .= "●";
            }

            $last = $rating;
        }

        return $out;
    }
}
