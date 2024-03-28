<?php

namespace App\Repositories;

use App\Abstracts\AbstractRepository;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository extends AbstractRepository
{
    public function findCurrentUser(): User
    {
        // ID текущего користувача
        $user_id = Auth::id();

        /** @var User $user */
        return User::find($user_id);
    }
}
