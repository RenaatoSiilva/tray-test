<?php

namespace App\Repositories\SellerRepository;

use App\Models\Seller;
use App\Repositories\Repository;


class SellerRepository extends Repository implements SellerRepositoryInterface
{
    protected $model;

    public function __construct(Seller $model)
    {
        parent::__construct($model);
    }

    public function create(array $data)
    {

        return $this->model->create($data);

    }

    public function update(int $id, array $data){

        return $this->model->where('id', $id)->update($data);

    }


    public function get(int|null $id)
    {
        if (is_null($id)) {
            $get = $this->model->get();
        } else {
            $get = $this->model->findOrFail($id);
        }

        if ($get == null)
            return [];

        return $get;
    }

    public function delete(int $id){
        return $this->model->find($id)->delete();
    }



}