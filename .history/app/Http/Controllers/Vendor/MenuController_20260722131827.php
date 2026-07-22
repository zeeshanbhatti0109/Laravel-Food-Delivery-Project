<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class MenuController extends Controller
{
    public function index(): Response
    {
        $this->authorize('category.viewAny');

        $user = Auth::user();
        $restaurantId = $user?->restaurant?->id;

        return Inertia::render('Vendor/Menu', [
            'categories' => Category::query()
                ->when($restaurantId, function ($query, $restaurantId) {
                    $query->where('restaurant_id', $restaurantId);
                })
                ->with('products')
                ->get(),
        ]);
    }
}
