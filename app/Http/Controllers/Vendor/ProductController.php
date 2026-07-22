<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\StoreProductRequest;
use App\Http\Requests\Vendor\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function create(): Response
    {
        $this->authorize('product.create');

        $restaurantId = request()->user()->restaurant->id;

        return Inertia::render('Vendor/Products/Create', [
            'categories' => Category::where('restaurant_id', $restaurantId)->get(['id', 'name']),
            'category_id' => request('category_id'),
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        // Security: ensure the chosen category belongs to the vendor's restaurant
        $restaurantId = $request->user()->restaurant->id;
        abort_if(
            !Category::where('id', $request->category_id)
                ->where('restaurant_id', $restaurantId)
                ->exists(),
            403,
            'Unauthorized action.'
        );

        Product::create($request->validated());

        return to_route('vendor.menu')
            ->withStatus('Product created successfully.');
    }

    public function edit(Product $product): Response
    {
        $this->authorize('product.update');

        $restaurantId = request()->user()->restaurant->id;
        abort_if($product->category->restaurant_id !== $restaurantId, 403, 'Unauthorized action.');

        return Inertia::render('Vendor/Products/Edit', [
            'categories' => Category::where('restaurant_id', $restaurantId)->get(['id', 'name']),
            'product'    => $product,
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $restaurantId = $request->user()->restaurant->id;
        abort_if($product->category->restaurant_id !== $restaurantId, 403, 'Unauthorized action.');

        // Security: ensure the new category also belongs to the vendor's restaurant
        abort_if(
            !Category::where('id', $request->category_id)
                ->where('restaurant_id', $restaurantId)
                ->exists(),
            403,
            'Unauthorized action.'
        );

        $product->update($request->validated());

        return to_route('vendor.menu')
            ->withStatus('Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('product.delete');

        $restaurantId = request()->user()->restaurant->id;
        abort_if($product->category->restaurant_id !== $restaurantId, 403, 'Unauthorized action.');

        $product->delete();

        return to_route('vendor.menu')
            ->withStatus('Product deleted successfully.');
    }
}
