<?php

namespace App\Services\SellerService;

use App\Repositories\SellerRepository\SellerRepositoryInterface;

class SellerService implements SellerServiceInterface
{

    private $sellerRepository;

    public function __construct(SellerRepositoryInterface $sellerRepository)
    {
        $this->sellerRepository = $sellerRepository;
    }

    public function create(array $data)
    {
        return $this->sellerRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->sellerRepository->update($id, $data);
    }

    public function get(int|null $id)
    {
        return $this->sellerRepository->get($id);
    }

    public function delete(int $id)
    {
        return $this->sellerRepository->delete($id);
    }
}
