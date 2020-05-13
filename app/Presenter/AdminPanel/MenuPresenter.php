<?php

namespace App\Presenter\AdminPanel;

use App\Presenter\contracts\Presenter;

class MenuPresenter extends Presenter
{
    public function status()
    {
        if ($this->object->status == 1) {
            return '<span class="badge badge-pill badge-success">منتشر شده</span>';
        }
        return '<span class="badge badge-pill badge-danger">پیش نویس</span>';
    }
}
