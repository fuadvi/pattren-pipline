<?php

namespace App\Filters\general;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class SearchByEmail
{
    public function handle(Builder $query, Closure $next)
    {
        if (request()->has('search_email'))
        {
            $search = request()->search_email;

            return $next($query)->where("email","like","%{$search}%");
        }
        return $next($query);
    }
}
