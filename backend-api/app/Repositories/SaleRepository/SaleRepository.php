<?php

namespace App\Repositories\SaleRepository;

use App\Models\Sale;
use App\Repositories\Repository;


class SaleRepository extends Repository implements SaleRepositoryInterface
{
    protected $model;

    public function __construct(Sale $model)
    {
        parent::__construct($model);
    }

    public function create(array $data)
    {

        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {

        return $this->model->where('id', $id)->update($data);
    }


    public function get(int|null $id)
    {
        if (is_null($id)) {
            $get = $this->model->with('seller:id,name')->get();
        } else {
            $get = $this->model->with('seller:id,name')->findOrFail($id);
        }

        if ($get == null)
            return [];

        return $get;
    }

    public function delete(int $id)
    {
        return $this->model->find($id)->delete();
    }

    public function getSalesBySellerId(int $sellerId)
    {
        return $this->model->where('seller_id', $sellerId)->get();
    }

    public function getSalesBySellerIdAndDate(int $sellerId, string $date)
    {
        return $this->model->where('seller_id', $sellerId)->where('date', $date)->get();
    }

    public function getSalesBySellerIdGroupedByDate(int $sellerId)
    {
        $sales = $this->model->where('seller_id', $sellerId)->orderBy('date', 'desc')->get()->toArray();

        $salesData = [];

        foreach ($sales as $sale) {
            $salesData[$sale['date']][] = $sale;
        }

        return $salesData;
    }

    public function getByDate(string $date)
    {
        return $this->model->where('date', $date)->get();
    }

    public function deleteBySellerId(int $sellerId)
    {
        return $this->model->where('seller_id', $sellerId)->delete();
    }
}
