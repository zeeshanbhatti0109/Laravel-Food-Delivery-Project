<?php

namespace App\Http\Controllers\Admin;
 use App\Models\City;
use App\Http\Requests\Admin\StoreRestaurantRequest;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
 
class RestaurantController extends Controller
{
    public function index(): Response
    {
        if (! Auth::check()) {
            abort(403);
        }

        return Inertia::render('Admin/Restaurants/Index', [
            'restaurants' => Restaurant::with(['city', 'owner'])->get(),
        ]);
    }

    public function create()
{
    $this->authorize('restaurant.create');
 
    return Inertia::render('Admin/Restaurants/Create', [
        'cities' => City::get(['id', 'name']),
    ]);
}
}