<?php


namespace App\Repositories\Eloquent;


use App\Models\Admin;
use App\Repositories\Contracts\AdminRepositoryInterface;
use App\Repositories\Eloquent\Contracts\EloquentBaseRepository;

class EloquentAdminRepository extends EloquentBaseRepository implements AdminRepositoryInterface
{
    protected $model = Admin::class;
}
