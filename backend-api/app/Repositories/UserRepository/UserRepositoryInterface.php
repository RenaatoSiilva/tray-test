<?php

namespace App\Repositories\UserRepository;

interface UserRepositoryInterface
{

    public function create(array $data);
    public function update(int $id, array $data);
    public function get(int|null $id);
    public function delete(int $id);
    public function getUserByEmail(string $email);
}
