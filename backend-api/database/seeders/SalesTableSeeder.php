<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\Seller;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Sale::truncate();

        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {

            $seller = Seller::inRandomOrder()->first()->id;
            $amount = $faker->numberBetween(10, 1000);
            $commission   = 8.5;
            $totalWithCommission = number_format(($amount * ($commission / 100)), 2) ;

            Sale::firstOrCreate([
                'seller_id'             =>  $seller,
                'amount'                =>  $amount,
                'commission'            =>  $commission,
                'commission_value'      =>  $totalWithCommission,
                'date'                  =>  Carbon::now()->toDateString()
            ]);
        }
    }
}
