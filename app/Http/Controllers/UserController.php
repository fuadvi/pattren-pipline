<?php

namespace App\Http\Controllers;

use App\Filters\general\SearchByEmail;
use App\Filters\general\SearchByName;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class UserController extends Controller
{
    public function __construct(
        public User $user
    )
    {
    }


    public function getUsers()
    {
        $user = User::all();

        return response()->json([
            "user" => $user
        ]);
    }

    public function getUserWithWhen(Request $request)
    {
        $user = User::when(
            $request->has('search'),
            function (Builder $query) use ($request){
                $query->where("name","like","%{$request->search}%")
                    ->orWhere("address","like","%{$request->search}%")
                    ->orWhere("email","like","%{$request->search}%");
            }
        )
        ->when(
            $request->has('search_name'),
            fn(Builder $query) => $query->where("name","like","%{$request->search_name}%")
        )
            ->when(
                $request->has('search_email'),
                fn(Builder $query) => $query->where("email","like","%{$request->search_email}%")
            )
            ->when(
                $request->has('search_roles'),
                fn(Builder $query) => $query->whereHas('role', function (Builder $query, $search){
                    $query->where("name","like","%{request()->search_email}%");
                })
            )
            ->when(
                $request->has('search_address'),
                fn(Builder $query) =>  $query->where("address","like","%{$request->search_address}%")
            )
            ->get();

        return response()->json([
            "user" => $user
        ]);
    }

    public function getUserWithQuery(Request $request)
    {
        $user = User::query();

        if ( $request->has('search_name'))
            $user->where("name","like","%{$request->search_name}%");


        if ( $request->has('search_name'))
            $user->where("name","like","%{$request->search_name}%");


        if ( $request->has('search_email'))
            $user->where("email","like","%{$request->search_email}%");

        if ( $request->has('search_address'))
            $user->where("address","like","%{$request->search_addres}%");


        return response()->json([
            "user" => $user->get()
        ]);

    }

    public function getUserWithPipline(Request $request)
    {
       $user =  app(Pipeline::class)
        ->send(User::query())
            ->through([
                SearchByName::class,
                SearchByEmail::class,
                SearchByEmail::class,
                SearchByEmail::class,
            ])
            ->thenReturn()
            ->get();


        return response()->json([
            "user" => $user
        ]);
    }
}
