<?php

namespace App\Services\SaleService;

interface SaleServiceInterface {

    public function create(array $data);
    public function update(int $id, array $data);
    public function get(int|null $id);
    public function delete(int $id);
    public function getSalesBySellerId(int $sellerId);
    public function getSalesBySellerIdAndDate(int $sellerId, string $date);
    public function getSalesBySellerIdGroupedByDate(int $sellerId);
    public function getByDate(string $date);
    public function deleteBySellerId(int $sellerId);
}