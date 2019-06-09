<?php declare(strict_types=1);

namespace BookLibrary\Services\Helpers;

class FileHelper
{
    public static function getExtension(string $filePath): string
    {
        return mb_strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    }
}
