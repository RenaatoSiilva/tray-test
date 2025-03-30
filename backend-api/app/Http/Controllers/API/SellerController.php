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

    public function list(Request $request, $sellerId = null)
    {

        return $this->sellerService->get($sellerId);
    }

    public function store(Request $request)
    {

        $sellerValidatedData = $this->validateData($request);

        if (!is_array($sellerValidatedData)) {

            return response()->json(
                [
                    "success"  =>  false,
                    "messages"   => $sellerValidatedData->getMessages()
                ],
                403
            );
        }

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

        if (!is_array($sellerValidatedData)) {

            return response()->json(
                [
                    "success"  =>  false,
                    "messages"   => $sellerValidatedData->getMessages()
                ],
                403
            );
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

        $customMessages = [
            'name' => 'Você precisa inserir um nome.',
            'email' => 'Você precisa inserir um e-mail válido.',
        ];

        $validator = Validator::make($request->all(), $rulesForValidation, $customMessages);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return $validator->validated();
    }
}
