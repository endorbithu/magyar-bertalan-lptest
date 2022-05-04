<?php

namespace App\Contracts\Services;

interface Select2ServiceInterface
{
    public static function getResultsForApi(string $eloquentModel, string $term, string $attribute = 'name'): array;
}
