<?php

namespace Tests\Feature;

use App\Models\Seller;
use App\Models\User;
use App\Repositories\SellerRepository\SellerRepository;
use App\Services\SellerService\SellerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory as Faker;

class SellerAPITest extends TestCase
{

    use RefreshDatabase;


    public function prepareUser()
    {
        $user = User::factory()->create();

        return $user;
    }

    public function prepareSellerData()
    {
        $faker = Faker::create();

        $sellerName = $faker->name;
        $sellerEmail = $faker->email;

        $sellerData = [
            'name'  =>  $sellerName,
            'email' =>  $sellerEmail
        ];

        return $sellerData;
    }

    public function prepareAPIRoutes()
    {
        $apiRoutes = [
            'list'      =>  "/api/seller/list",
            'store'     =>  "/api/seller/store",
            'update'    =>  "/api/seller/update",
            'destroy'   =>  "/api/seller/destroy"
        ];

        return $apiRoutes;
    }


    public function test_can_logged_user_list_sellers(): void
    {

        $user     = $this->prepareUser();

        $apiRoutes = $this->prepareAPIRoutes();

        $listRoute = $apiRoutes['list'];

        $storeRoute = $apiRoutes['store'];

        $sellerData = $this->prepareSellerData();

        $this->actingAs($user)->post($storeRoute, $sellerData);

        $response = $this->actingAs($user)->get($listRoute);

        $response->assertStatus(200)->assertSee($sellerData['name'])->assertSee($sellerData['email']);
    }

    public function test_can_logged_user_store_seller(): void
    {

        $user     = $this->prepareUser();

        $apiRoutes = $this->prepareAPIRoutes();

        $storeRoute = $apiRoutes['store'];

        $sellerData = $this->prepareSellerData();

        $response = $this->actingAs($user)->post($storeRoute, $sellerData);

        $response->assertStatus(200)->assertSee($sellerData['name'])->assertSee($sellerData['email']);
    }

    public function test_can_logged_user_update_seller(): void
    {

        $user     = $this->prepareUser();

        $apiRoutes = $this->prepareAPIRoutes();


        $storeRoute  = $apiRoutes['store'];

        $sellerData = $this->prepareSellerData();

        $this->actingAs($user)->post($storeRoute, $sellerData);

        $sellerNewName = 'Renato Silva';
        $sellerNewEmail = 'renato_silva94@live.com';

        $sellerUpdateData = [
            'name'  => $sellerNewName,
            'email' => $sellerNewEmail
        ];

        $updateRoute = $apiRoutes['update'];

        $responseUpdate = $this->actingAs($user)->put("{$updateRoute}/1", $sellerUpdateData);

        $responseUpdate->assertStatus(200)->assertSee($sellerNewName)->assertSee($sellerNewEmail);
    }

    public function test_can_logged_user_delete_seller(): void
    {


        $user     = $this->prepareUser();

        $apiRoutes = $this->prepareAPIRoutes();

        $storeRoute  = $apiRoutes['store'];

        $sellerData = $this->prepareSellerData();

        $this->actingAs($user)->post($storeRoute, $sellerData);

        $deleteRoute = $apiRoutes['destroy'];

        $responseUpdate = $this->actingAs($user)->delete("{$deleteRoute}/1");

        $responseUpdate->assertStatus(200)->assertDontSee($sellerData['name'])->assertDontSee($sellerData['email']);
    }
}
