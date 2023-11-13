<?php

namespace App\Auth;
use App\Models\User;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Hashing\Hasher;

class UserProvider extends EloquentUserProvider
{
    public function __construct(Hasher $hasher, User $model)
    {
        parent::__construct($hasher, $model);
    }
}