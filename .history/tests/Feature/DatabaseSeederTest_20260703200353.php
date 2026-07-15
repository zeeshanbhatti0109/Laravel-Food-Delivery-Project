<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;

describe('database seeding', function () {
    it('can seed the database more than once without duplicate errors', function () {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        expect(User::where('email', 'admin@admin.com')->count())->toBe(1);
    });
});
