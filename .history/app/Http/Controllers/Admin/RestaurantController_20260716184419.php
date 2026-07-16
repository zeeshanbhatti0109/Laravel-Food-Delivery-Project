<?php

namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Inertia\Inertia;
use Inertia\Response;
 
class RestaurantController extends Controller
{
    public function index(): Response
    {
        if (! auth()->check()) {
            abort(403);
        }

        if (! auth()->user()->can('restaurant.viewAny')) {
            abort(403);
        }
 
        return Inertia::render('Admin/Restaurants/Index', [
            'restaurants' => Restaurant::with(['city', 'owner'])->get(),
        ]);
    }
}