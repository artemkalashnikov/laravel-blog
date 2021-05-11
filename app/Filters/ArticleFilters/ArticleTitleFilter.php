<?php

namespace App\Filters\ArticleFilters;

use App\Filters\QueryFilterContract;

class ArticleTitleFilter implements QueryFilterContract
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function apply($query)
    {
        $query->where('title', 'LIKE', '%' . $this->value . '%');
    }
}
