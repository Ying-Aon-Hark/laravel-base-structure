<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class OrSearchFilter implements Filter
{
    protected $fields;

    // Accept both direct fields and nested relationship fields (e.g. 'author.name')
    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function __invoke(Builder $query, $value, string $property): Builder
    {
        // Ensure that the $value is trimmed and sanitized.
        $value = trim($value);

        if (empty($value)) {
            return $query;
        }

        // Handle nested relationships of any depth 
        return $query->where(function ($query) use ($value) {
            foreach ($this->fields as $field) {
                $relations = explode('.', $field);
                $lastField = array_pop($relations);

                if (!empty($relations)) {
                    $query->orWhereHas(implode('.', $relations), function ($query) use ($lastField, $value) {
                        $query->where($lastField, 'like', "%{$value}%");
                    });
                } else {
                    $query->orWhere($lastField, 'like', "%{$value}%");
                }
            }
        });
    }
}
