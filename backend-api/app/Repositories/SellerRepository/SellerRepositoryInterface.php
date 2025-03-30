<?php

namespace App\Repositories\SellerRepository;

interface SellerRepositoryInterface
{

    public function create(array $data);
    public function update(int $id, array $data);
    public function get(int|null $id);
    public function delete(int $id);
}
