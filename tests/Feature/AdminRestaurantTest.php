<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\User;
use App\Models\City;
use App\Enums\RoleName;
use App\Models\Role;
class AdminRestaurantTest extends TestCase
{
    use \Illuminate\Foundation\Testing\RefreshDatabase;

    public function test_admin_can_create_restaurant()
    {
        $this->seed();
        $admin = User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->first();
        $this->actingAs($admin);
        
        $city = City::first();
        
        $response = $this->post('/admin/restaurants', [
            'restaurant_name' => 'New Rest',
            'email' => 'newrest@example.com',
            'owner_name' => 'John Doe',
            'city_id' => $city->id,
            'address' => '123 Main St'
        ]);
        
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin.restaurants.index'));
        
        $this->assertDatabaseHas('restaurants', [
            'name' => 'New Rest'
        ]);
    }
}
