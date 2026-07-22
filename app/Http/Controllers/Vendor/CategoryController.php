<?php
namespace App\Http\Controllers\Vendor;

use App\Http\Requests\Vendor\UpdateCategoryRequest;
use App\Http\Requests\Vendor\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create(): Response
    {
        $this->authorize('category.create');
 
        return Inertia::render('Vendor/Categories/Create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $request->user()->restaurant->categories()->create($request->only('name'));
 
        return to_route('vendor.menu')
            ->withStatus('Product Category created successfully.');
    }

    public function edit(Category $category): Response
    {
        $this->authorize('category.update');
        abort_if($category->restaurant_id !== request()->user()->restaurant->id, 403, 'Unauthorized action.');

        return Inertia::render('Vendor/Categories/Edit', [
            'category' => $category,
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        abort_if($category->restaurant_id !== $request->user()->restaurant->id, 403, 'Unauthorized action.');

        $category->update($request->only('name'));
 
        return to_route('vendor.menu')->withStatus('Product Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $this->authorize('category.delete');
        abort_if($category->restaurant_id !== request()->user()->restaurant->id, 403, 'Unauthorized action.');

        $category->delete();
 
        return to_route('vendor.menu')
            ->withStatus('Product Category deleted successfully.');
    }
}
