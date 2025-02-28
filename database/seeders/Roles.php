<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class Roles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $SuperRole = Role::create(['name' => 'Super']);
        $SuperPermissions = Permission::pluck('id','id')->all();
        $SuperRole->syncPermissions($SuperPermissions);
        $superUser = User::first();
        $superUser->assignRole([$SuperRole->id]);

        $adminRole = Role::create(['name' => 'Admin']);
        $adminPermissions = Permission::pluck('id','id')->all();
        $adminRole->syncPermissions($adminPermissions);
        $adminUser = User::where('email', 'admin@admin.com')->first();
        $adminUser->assignRole([$adminRole->id]);

        $normalRole = Role::create(['name' => 'Cashier']);
        $normalRole->syncPermissions([
            'dashboard-list',

            'product-list',
            'product-create',
            'product-read',
            'product-update',
            'product-delete',

            'stock-list',
            'stock-edit',
            'stock-transfer',
            'stock-update',

            'pos-list',

            'order-list',
            'order-refund',

            'location-list',
            'location-create',
            'location-read',
            'location-update',
            'location-delete',

            'user-list',
            'user-create',
            'user-read',
            'user-update',
            'user-delete',
        ]);
        // $normalUser->assignRole([$normalRole->id]);



    }
}
