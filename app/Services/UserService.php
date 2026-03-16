<?php

namespace App\Services;

use App\BO\UserBO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class UserService
{
    /**
     * @var UserBO
     */
    private UserBO $userBO;

    /**
     * UserService constructor.
     * 
     * @param UserBO $userBO
     */
    public function __construct(UserBO $userBO)
    {
        $this->userBO = $userBO;
    }

    /**
     * Get all users
     * 
     * @return Collection
     */
    public function getAllUsers(): Collection
    {
        return $this->userBO->getAllUsers();
    }

    /**
     * Get user by ID
     * 
     * @param int $id
     * @return array
     * @throws ValidationException
     */
    public function getUserById(int $id): array
    {
        $user = $this->userBO->getUserById($id);
        
        if (!$user) {
            throw ValidationException::withMessages([
                'id' => ['User not found.']
            ]);
        }

        return $user->toArray();
    }

    /**
     * Create a new user
     * 
     * @param array $data
     * @return array
     * @throws ValidationException
     */
    public function createUser(array $data): array
    {
        $user = $this->userBO->createUser($data);

        return $user->toArray();
    }

    /**
     * Update an existing user
     * 
     * @param int $id
     * @param array $data
     * @return array
     * @throws ValidationException
     */
    public function updateUser(int $id, array $data): array
    {
        $user = $this->userBO->updateUser($id, $data);

        return $user->toArray();
    }

    /**
     * Delete a user
     * 
     * @param int $id
     * @return bool
     * @throws ValidationException
     */
    public function deleteUser(int $id): bool
    {
        return $this->userBO->deleteUser($id);
    }
}