<?php

namespace App\Services\SaleService;

use App\Repositories\SaleRepository\SaleRepositoryInterface;

class SaleService implements SaleServiceInterface
{

    private $saleRepository;

    public function __construct(SaleRepositoryInterface $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    public function create(array $data)
    {
        return $this->saleRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->saleRepository->update($id, $data);
    }

    public function get(int|null $id)
    {
        return $this->saleRepository->get($id);
    }

    public function delete(int $id)
    {
        return $this->saleRepository->delete($id);
    }

    public function getSalesBySellerId(int $sellerId)
    {
        return $this->saleRepository->getSalesBySellerId($sellerId);
    }

    public function getSalesBySellerIdAndDate(int $sellerId, string $date)
    {
        return $this->saleRepository->getSalesBySellerIdAndDate($sellerId, $date);
    }

    public function getSalesBySellerIdGroupedByDate(int $sellerId)
    {
        return $this->saleRepository->getSalesBySellerIdGroupedByDate($sellerId);
    }

    public function getByDate(string $date){
        return $this->saleRepository->getByDate($date);

    }
}
