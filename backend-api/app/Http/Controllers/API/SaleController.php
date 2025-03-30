<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\SendCommissionReport;
use App\Models\Sale;
use App\Models\Seller;
use App\Models\User;
use App\Repositories\SaleRepository\SaleRepository;
use App\Repositories\SellerRepository\SellerRepository;
use App\Repositories\UserRepository\UserRepository;
use App\Services\SaleService\SaleService;
use App\Services\SellerService\SellerService;
use App\Services\UserService\UserService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SaleController extends Controller
{

    public $saleService;
    public $commission;

    public function __construct()
    {
        $this->saleService = new SaleService(new SaleRepository(new Sale()));
        $this->commission = 8.5;
    }

    public function calculateTotalAmountWithCommission(float $amount)
    {
        $totalWithCommission = ($amount * ($this->commission / 100));

        return $totalWithCommission;
    }

    public function list($saleId = null)
    {

        return $this->saleService->get($saleId);
    }

    public function store(Request $request)
    {

        $saleValidatedData = $this->validateData($request);

        if (!is_array($saleValidatedData)) {

            return response()->json(
                [
                    "success"  =>  false,
                    "messages"   => $saleValidatedData->getMessages()
                ],
                403
            );
        }

        $saleValidatedData['commission'] = $this->commission;
        $saleValidatedData['commission_value'] = $this->calculateTotalAmountWithCommission($saleValidatedData['amount']);

        $sale = $this->saleService->create($saleValidatedData);

        return response()->json(
            [
                "success"  =>  true,
                "sale"   => [
                    "seller"                => $sale->seller->name,
                    "amount"                => $sale->amount,
                    "commission"            => $sale->commission,
                    "commission_value"      => $sale->commission_value,
                    "date"                  => $sale->date,
                ]
            ],
            200
        );
    }


    public function update(Request $request, $saleId)
    {

        $saleValidatedData = $this->validateData($request, $saleId);
        $saleValidatedData['commission'] = $this->commission;
        $saleValidatedData['commission_value'] = $this->calculateTotalAmountWithCommission($saleValidatedData['amount']);

        if (!$saleValidatedData) {
            return response()->json(['errors' => 'Algo errado Aconteceu']);
        }

        $this->saleService->update($saleId, $saleValidatedData);

        $updatedSale = $this->saleService->get($saleId);

        return response()->json(
            [
                "success"  =>  true,
                "sale"   => [
                    "seller"                => $updatedSale->seller->name,
                    "amount"                => $updatedSale->amount,
                    "commission"            => $updatedSale->commission,
                    "commission_value"      => $updatedSale->commission_value,
                    "date"                  => $updatedSale->date,
                ]
            ],
            200
        );
    }


    public function destroy(int $saleId)
    {

        $this->saleService->delete($saleId);

        return response()->json(
            [
                "success"  =>  true,
                "message"   => "Deletado com sucesso!",
            ],
            200
        );
    }

    public function listSalesBySellerId(int $sellerId)
    {

        $allSalesBySellerId = $this->saleService->getSalesBySellerId(sellerId: $sellerId);

        return $allSalesBySellerId;
    }


    public function sendCommissionReport(Request $request)
    {

        $sellerId = $request->seller_id;
        $date     = $request->date ?? Carbon::now()->toDateString();

        SendCommissionReport::dispatch($sellerId, $date);

        return response()->json(
            [
                "success"  =>  true,
                "message"   => "Relatório de comissões vai ser enviado em breve !",
            ],
            200
        );
    }

    public function listSalesBySellerIdWithGroupedByDays(int $sellerId){

        $salesGroupedDays = $this->saleService->getSalesBySellerIdGroupedByDate($sellerId);

        return $salesGroupedDays;

    }

    public function validateData($request)
    {
        $rulesForValidation = [
            'seller_id'  => 'required',
            'amount'     => 'required|numeric|gt:0',
            'date'       => 'required'
        ];

        $customMessages = [
            'seller_id' => 'Você precisa inserir um vendedor',
            'amount' => 'Você precisa inserir uma quantidade valida e maior do que 0',
            'date' => 'Você precisa inserir uma data valida',
        ];

        $validator = Validator::make($request->all(), $rulesForValidation, $customMessages);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return $validator->validated();
    }
}
