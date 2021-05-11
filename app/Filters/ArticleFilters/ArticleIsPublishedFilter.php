<?php

namespace App\Filters\ArticleFilters;

use App\Filters\QueryFilterContract;

class ArticleIsPublishedFilter implements QueryFilterContract
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function apply($query)
    {
        if (isset($this->value)) {
            $query->where('is_published', '=', $this->value);
        }
    }
}
