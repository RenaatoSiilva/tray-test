<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\User;
use App\Repositories\SellerRepository\SellerRepository;
use App\Repositories\UserRepository\UserRepository;
use App\Services\SellerService\SellerService;
use App\Services\UserService\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SellerController extends Controller
{

    public $sellerService;

    public function __construct()
    {
        $this->sellerService = new SellerService(new SellerRepository(new Seller()));
    }

    public function list(Request $request, $sellerId = null) {

        return $this->sellerService->get($sellerId);

    }

    public function store(Request $request)
    {

        $sellerValidatedData = $this->validateData($request);

        $seller = $this->sellerService->create($sellerValidatedData);

        return response()->json(
            [
                "success"  =>  true,
                "seller"   => [
                    "email" => $seller->email,
                    "name"  => $seller->name
                ]
            ],
            200
        );
    }


    public function update(Request $request, $sellerId)
    {

        $sellerValidatedData = $this->validateData($request, $sellerId);

        if (!$sellerValidatedData) {
            return response()->json(['errors' => 'Algo errado Aconteceu']);
        }

        $this->sellerService->update($sellerId, $sellerValidatedData);

        $updatedSeller = $this->sellerService->get($sellerId);

        return response()->json(
            [
                "success"  =>  true,
                "seller"   => [
                    "email" => $updatedSeller->email,
                    "name"  => $updatedSeller->name
                ]
            ],
            200
        );
    }


    public function destroy(int $sellerId)
    {

        $this->sellerService->delete($sellerId);

        return response()->json(
            [
                "success"  =>  true,
                "message"   => "Deletado com sucesso!",
            ],
            200
        );
    }


    public function validateData($request, $sellerId = null)
    {
        $rulesForValidation = [
            'name'  => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('sellers', 'email')->ignore($sellerId),
            ],
        ];

        $validator = Validator::make($request->all(), $rulesForValidation);

        if ($validator->fails()) {
            return false;
        }

        return $validator->validated();
    }
}
