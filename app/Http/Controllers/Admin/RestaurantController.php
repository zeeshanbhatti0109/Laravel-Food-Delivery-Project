<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Http\Requests\Admin\StoreRestaurantRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Enums\RoleName;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Inertia\Inertia;
use Inertia\Response;
use App\Notifications\RestaurantOwnerInvitation;
use App\Http\Requests\Admin\UpdateRestaurantRequest;

class RestaurantController extends Controller
{
    public function index(): Response
    {
        $this->authorize('restaurant.viewAny');

        return Inertia::render('Admin/Restaurants/Index', [
            'restaurants' => Restaurant::with(['city', 'owner'])->get(),
        ]);
    }

    public function create(): Response
    {
        $this->authorize('restaurant.create');

        return Inertia::render('Admin/Restaurants/Create', [
            'cities' => City::get(['id', 'name']),
        ]);
    }

    public function store(StoreRestaurantRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name'     => $validated['owner_name'],
                'email'    => $validated['email'],
                'password' => Hash::make(Str::random(64)),
            ]);

            $role = Role::where('name', RoleName::VENDOR->value)->first();
            if ($role) {
                $user->roles()->sync([$role->id]);
            }

            $user->restaurant()->create([
                'city_id' => $validated['city_id'],
                'name'    => $validated['restaurant_name'],
                'address' => $validated['address'],
            ]);

            $user->notify(new RestaurantOwnerInvitation($validated['restaurant_name']));
        });

        return to_route('admin.restaurants.index');
    }
    public function edit(Restaurant $restaurant): Response
    {
        $this->authorize('restaurant.update');
        
        $restaurant->load(['city', 'owner']);
        
        return Inertia::render('Admin/Restaurants/Edit', [
            'restaurant' => $restaurant,
            'cities'     => City::get(['id', 'name']),
        ]);
    }

    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant): RedirectResponse
    {
        $validated = $request->validated();
        
        $restaurant->update([
            'city_id' => $validated['city'],
            'name'    => $validated['restaurant_name'],
            'address' => $validated['address'],
        ]);
        
        return to_route('admin.restaurants.index')
            ->withStatus('Restaurant updated successfully.');
    }
}
