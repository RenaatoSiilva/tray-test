<?php

namespace App\Services\UserService;

use App\Repositories\UserRepository\UserRepositoryInterface;

class UserService implements UserServiceInterface
{

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(array $data)
    {
        return $this->userRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->userRepository->update($id, $data);
    }

    public function get(int|null $id)
    {
        return $this->userRepository->get($id);
    }

    public function delete(int $id)
    {
        return $this->userRepository->delete($id);
    }

    public function getUserByEmail(string $email)
    {
        return $this->userRepository->getUserByEmail($email);
    }
}
