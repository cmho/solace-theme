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
            } elseif ($last) {
                $out .= "-";
                for ($i = 0; $i < $last; $i++) {
                    $out .= "●";
                }
            }
            for ($i = 0; $i < $rating; $i++) {
                $out .= "●";
            }
        }

        return $out;
    }
}
