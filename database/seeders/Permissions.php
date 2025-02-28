<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class Permissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
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
         ];

         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
