<?php

namespace App\DAO;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class UserDAO
{
    /**
     * Cache key prefix for user data
     */
    const CACHE_PREFIX = 'user_';
    
    /**
     * Cache TTL in seconds (1 hour)
     */
    const CACHE_TTL = 3600;

    /**
     * Get all users with caching
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsers()
    {
        return Cache::remember('users_all', self::CACHE_TTL, function () {
            return User::all();
        });
    }

    /**
     * Get user by ID with caching
     * 
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): ?User
    {
        $cacheKey = self::CACHE_PREFIX . $id;
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($id) {
            return User::find($id);
        });
    }

    /**
     * Get user by email
     * 
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Create a new user
     * 
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $this->clearUserCache($user->id);
        
        return $user;
    }

    /**
     * Update an existing user
     * 
     * @param int $id
     * @param array $data
     * @return User|null
     */
    public function updateUser(int $id, array $data): ?User
    {
        $user = User::find($id);
        
        if (!$user) {
            return null;
        }

        $updateData = [
            'name' => $data['name'] ?? $user->name,
            'email' => $data['email'] ?? $user->email,
        ];

        if (isset($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);
        
        $this->clearUserCache($id);
        
        return $user->fresh();
    }

    /**
     * Delete a user
     * 
     * @param int $id
     * @return bool
     */
    public function deleteUser(int $id): bool
    {
        $user = User::find($id);
        
        if (!$user) {
            return false;
        }

        $result = $user->delete();
        
        if ($result) {
            $this->clearUserCache($id);
            Cache::forget('users_all');
        }
        
        return $result;
    }

    /**
     * Clear user cache
     * 
     * @param int $userId
     * @return void
     */
    private function clearUserCache(int $userId): void
    {
        Cache::forget(self::CACHE_PREFIX . $userId);
        Cache::forget('users_all');
    }
}