<?php

namespace App\BO;

use App\DAO\UserDAO;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class UserBO
{
    /**
     * @var UserDAO
     */
    private UserDAO $userDAO;

    /**
     * UserBO constructor.
     * 
     * @param UserDAO $userDAO
     */
    public function __construct(UserDAO $userDAO)
    {
        $this->userDAO = $userDAO;
    }

    /**
     * Get all users
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsers()
    {
        return $this->userDAO->getAllUsers();
    }

    /**
     * Get user by ID
     * 
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): ?User
    {
        return $this->userDAO->getUserById($id);
    }

    /**
     * Create a new user with business logic
     * 
     * @param array $data
     * @return User
     * @throws ValidationException
     */
    public function createUser(array $data): User
    {
        // Business logic: Check if email already exists
        $existingUser = $this->userDAO->getUserByEmail($data['email']);
        
        if ($existingUser) {
            throw ValidationException::withMessages([
                'email' => ['The email has already been taken.']
            ]);
        }

        // Business logic: Additional validation
        if (strlen($data['password']) < 8) {
            throw ValidationException::withMessages([
                'password' => ['The password must be at least 8 characters.']
            ]);
        }

        // Business logic: Format name (capitalize first letter of each word)
        $data['name'] = ucwords(strtolower($data['name']));

        return $this->userDAO->createUser($data);
    }

    /**
     * Update an existing user with business logic
     * 
     * @param int $id
     * @param array $data
     * @return User
     * @throws ValidationException
     */
    public function updateUser(int $id, array $data): User
    {
        $user = $this->userDAO->getUserById($id);
        
        if (!$user) {
            throw ValidationException::withMessages([
                'id' => ['User not found.']
            ]);
        }

        // Business logic: Check if email is being changed and if it's already taken
        if (isset($data['email']) && $data['email'] !== $user->email) {
            $existingUser = $this->userDAO->getUserByEmail($data['email']);
            
            if ($existingUser) {
                throw ValidationException::withMessages([
                    'email' => ['The email has already been taken.']
                ]);
            }
        }

        // Business logic: Password strength validation
        if (isset($data['password']) && strlen($data['password']) < 8) {
            throw ValidationException::withMessages([
                'password' => ['The password must be at least 8 characters.']
            ]);
        }

        // Business logic: Format name if provided
        if (isset($data['name'])) {
            $data['name'] = ucwords(strtolower($data['name']));
        }

        $updatedUser = $this->userDAO->updateUser($id, $data);
        
        if (!$updatedUser) {
            throw new \RuntimeException('Failed to update user.');
        }

        return $updatedUser;
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
        $user = $this->userDAO->getUserById($id);
        
        if (!$user) {
            throw ValidationException::withMessages([
                'id' => ['User not found.']
            ]);
        }

        // Business logic: Prevent deletion of the last admin (if implemented)
        // This is just an example of business logic

        return $this->userDAO->deleteUser($id);
    }
}