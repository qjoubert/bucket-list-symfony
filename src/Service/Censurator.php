<?php

namespace App\Service;

class Censurator
{
    public function purify($string): string {
        $words = explode(' ', $string);
        foreach ($words as $index => $word) {
            if ($word === 'fucking' || $word === 'fuck') {
                $words[$index] = str_repeat('*', strlen($word));
            }
        }
        return implode(' ', $words);
    }
}