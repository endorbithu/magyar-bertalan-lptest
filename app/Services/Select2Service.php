<?php

namespace App\Services;

class Select2Service
{
    public function getResultsForApi(string $eloquentModel, string $term, string $attribute = 'name'): array
    {
        $out = ['results' => []];

        if (strlen($term) > 0) {
            $results = $eloquentModel::query()->where($attribute, 'like', $term . '%')->get(['id', 'name']);
            foreach ($results as $result) {
                $select2Result = ['id' => $result->id, 'text' => $result->name];
                $out['results'][] = $select2Result;
            }
        }

        return $out;
    }
}
