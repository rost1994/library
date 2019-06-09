<?php declare(strict_types=1);

namespace BookLibrary\Services\Helpers;

class ReporterHelper
{
    public static function getMaxIndex(array $array): string
    {
        $max = 0;
        $maxKey = '';

        foreach ($array as $key => $item) {
            if ($item <= $max) {
                continue;
            }

            $max = $item;
            $maxKey = $key;
        }

        return (string) $maxKey;
    }
}
