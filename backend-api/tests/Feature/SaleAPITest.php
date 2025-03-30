<?php

namespace Tests\Feature;

use App\Models\Seller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory as Faker;

class SaleAPITest extends TestCase
{

    use RefreshDatabase;

    public function prepareUser()
    {
        $user = User::factory()->create();

        return $user;
    }

    public function prepareSaleData()
    {

        $faker = Faker::create();

        $seller = Seller::create([
            'name'  =>  $faker->name,
            'email' =>  $faker->email
        ]);

        $amount = $faker->numberBetween(10, 1000);
        $commission   = 8.5;
        $totalWithCommission = number_format(($amount * ($commission / 100)), 2);

        $saleData = [
            'seller_id'             =>  $seller->id,
            'amount'                =>  $amount,
            'commission'            =>  $commission,
            'commission_value'      =>  $totalWithCommission,
            'date'                  =>  Carbon::now()->toDateString()
        ];

        return $saleData;
    }

    public function prepareAPIRoutes()
    {
        $apiRoutes = [
            'list'      =>  "/api/sales/list",
            'store'     =>  "/api/sales/store",
            'update'    =>  "/api/sales/update",
            'destroy'   =>  "/api/sales/destroy"
        ];

        return $apiRoutes;
    }


    public function test_can_logged_user_list_sales(): void
    {

        $user     = $this->prepareUser();
        $saleData = $this->prepareSaleData();
        $apiRoutes = $this->prepareAPIRoutes();

        $saleAmount = $saleData['amount'];

        $storeRoute = $apiRoutes['store'];
        $listRoute = $apiRoutes['list'];

        $this->actingAs($user)->post($storeRoute, $saleData);

        $response = $this->actingAs($user)->get($listRoute);

        $response->assertStatus(200)->assertSee($saleAmount);
    }


    public function test_can_logged_user_store_sale(): void
    {

        $user     = $this->prepareUser();

        $apiRoutes = $this->prepareAPIRoutes();

        $saleData = $this->prepareSaleData();
        $saleData['amount'] = 1234;

        $storeRoute = $apiRoutes['store'];

        $responseStore = $this->actingAs($user)->post($storeRoute, $saleData);

        $responseStore->assertStatus(200)->assertSee($saleData['amount']);
    }

    public function test_can_logged_user_update_sale(): void
    {

        $user     = $this->prepareUser();

        $apiRoutes = $this->prepareAPIRoutes();

        $storeRoute  = $apiRoutes['store'];

        $saleData = $this->prepareSaleData();

        $this->actingAs($user)->post($storeRoute, $saleData);

        $saleUpdateData = $this->prepareSaleData();
        $saleUpdateData['amount'] = 99999;

        $updateRoute = $apiRoutes['update'];

        $responseUpdate = $this->actingAs($user)->put("{$updateRoute}/1", $saleUpdateData);

        $responseUpdate->assertStatus(200)->assertSee($saleUpdateData['amount']);
    }

    public function test_can_logged_user_delete_seller(): void
    {

        $user     = $this->prepareUser();

        $apiRoutes = $this->prepareAPIRoutes();

        $storeRoute  = $apiRoutes['store'];

        $saleData = $this->prepareSaleData();

        $this->actingAs($user)->post($storeRoute, $saleData);

        $deleteRoute = $apiRoutes['destroy'];

        $responseDelete = $this->actingAs($user)->delete("{$deleteRoute}/1");

        $responseDelete->assertStatus(200)->assertDontSee($saleData);

    }
}
