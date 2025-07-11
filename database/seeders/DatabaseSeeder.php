<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            // SupplierSeeder::class,
            ClientTypeSeeder::class,
            //ServiceSeeder::class,
            DiscountSeeder::class,
            //CustomerSeeder::class,
            // CategorySeeder::class,
            PeriodSeeder::class,
            // categorySupplierSeeder::class,
            //PaymentPlanSeeder::class,
            //PaymentSeeder::class,
            SeriesCorrelativeSeeder::class,
            MyCompanySeeder::class,
        ]);
    }
}
