<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CouponRepositoryInterface;
use App\Support\Discount\CouponValidator;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;

class CouponController extends Controller
{
    /**
     * @var CouponValidator
     */
    private $validator;
    private $couponRepository;

    public function __construct(CouponValidator $validator, CouponRepositoryInterface $couponRepository)
    {
        $this->middleware('auth');
        $this->validator = $validator;
        $this->couponRepository = $couponRepository;
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'coupon' => ['required', 'exists:coupons,code']
            ]);
            $coupon = $this->couponRepository->findBy(['code' => $request->coupon], null, true);
            $this->validator->isValid($coupon);

            session()->put(['coupon' => $coupon]);

            return redirect()->back()->withSuccess('کد تخفیف با موفقیت اعمال شد');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('کد تخفیف نامعتبر می باشد');
        }
    }

    public function remove()
    {
        session()->forget('coupon');
        return back();
    }
}
