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
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use App\Notifications\RestaurantOwnerInvitation;

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
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'This action is unauthorized.');
        }

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
}
