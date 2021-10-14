<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepository as UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    private User $userModel;
    
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function updateModel(User $user, array $data): void
    {
        $user->name = $data['name'] ?? $user->name;
        $user->email = $data['email'] ?? $user->email;
        $user->phone = $data['phone'] ?? $user->phone;

        $user->save();
    }
}