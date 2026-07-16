<?php

namespace App\Http\Controllers\Admin;
 
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
}