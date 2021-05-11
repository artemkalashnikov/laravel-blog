<?php

namespace App\Filters;

interface QueryFilterContract
{
    public function apply($query);
}
