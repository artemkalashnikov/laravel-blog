<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use App\Filters\QueryFilterContract;

class QueryFiltersCollection extends Collection
{
    public function apply(Builder $query)
    {
        $this->each(function (QueryFilterContract $filter) use ($query) {
            $filter->apply($query);
        });
    }
}
