<?php


namespace App\Presenter\Frontend;


use App\Support\Basket\Basket;
use Illuminate\Support\Facades\Auth;

class LayoutPresenter
{
    public function auth()
    {
        return Auth::check() ? $this->home() : $this->login();
    }

    public function ShowBasket()
    {
        $itemCount = resolve(Basket::class)->itemCount();
        $basketRoute = route('basket');
        return "<a href='$basketRoute'><button type='button' class='btn btn-info' style='font-family: IRANSans'>
                        <i class='fa fa-shopping-cart' aria-hidden='true'></i> سبد خرید <span
                                class='badge badge-pill badge-danger'>$itemCount</span>
                    </button>
                </a>";
    }

    /*
     * if Auth::check == true
     * return this
     * */
    private function home()
    {
        return [
            'route' => route('home'),
            'name' => 'پنل'
        ];
    }

    /*
     * if Auth::check == false
     * return this
     * */
    private function login()
    {
        return [
            'route' => route('login'),
            'name' => 'ورود'
        ];
    }
}
