<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Category;


class MenuController extends Controller
{
    public function index(): Response
    {
        $this->authorize('category.viewAny');
 
        return Inertia::render('Vendor/Menu', [
            'categories' => Category::query()
                ->where('restaurant_id', auth()->user()->restaurant->id)
                ->with('products')
                ->get(),
        ]);
    }
}
