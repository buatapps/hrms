<?php
function shortenName(string $fullName): string
{
    $words = explode(' ', trim($fullName));
    $totalWords = count($words);

    if ($totalWords <= 2) {
        return $fullName;
    }

    return implode(' ', array_slice($words, 0, 2));
}
