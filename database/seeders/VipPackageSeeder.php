<?php

use Illuminate\Database\Seeder;
use App\Models\VipPackage;

class VipPackageSeeder extends Seeder
{
    public function run()
    {
        VipPackage::create([
            'name' => 'Gói VIP 7 ngày',
            'duration' => 7,
            'price' => 20000
        ]);

        VipPackage::create([
            'name' => 'Gói VIP 30 ngày',
            'duration' => 30,
            'price' => 50000
        ]);
    }
}

