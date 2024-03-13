<?php

namespace App\Filters\general;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class SearchByName
{
    public function handle(Builder $query, Closure $next)
    {
        if (request()->has('search_name'))
        {
            $search = request()->search_name;

            return $next($query)->where(function ($query){
                $query->where("name","like","%{$search}%");
            });
        }
        return $next($query);
    }
}
