<?php


namespace App\Repositories\Eloquent;


use App\Models\User_data;
use App\Repositories\Contracts\UserDataRepositoryInterface;
use App\Repositories\Eloquent\Contracts\EloquentBaseRepository;

class EloquentUserDataRepository extends EloquentBaseRepository implements UserDataRepositoryInterface
{
    protected $model = User_data::class;

}
