<?php

namespace App\Filters\ArticleFilters;

use App\Filters\QueryFilterContract;

class ArticleCategoryFilter implements QueryFilterContract
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function apply($query)
    {
        if (isset($this->value)) {
            $query->where('category_id', '=', $this->value);
        }
    }
}
