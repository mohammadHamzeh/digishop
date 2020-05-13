<?php


namespace App\Support\Payment\Gateway;


use App\Models\Shop\Order;
use App\Support\Payment\Gateway\Contracts\Pay;
use Illuminate\Http\Request;

class Saman implements Pay
{

    private $merchantId;
    private $verifyRoute;

    public function __construct()
    {
        $this->merchantId = '10372149';
        $this->verifyRoute = route('payment.verify', $this->getName());
    }

    public function pay(Order $order, int $amount)
    {
        $this->redirectForm($order, $amount);
    }

    public function verify(Request $request)
    {
        if (!$request->has('state') || $request->input('state') !== 'OK') return $this->transactionFailed();
        $soapClient = new \SoapClient("https://acquirer.samanepay.com/payments/referencepayment.asmx?wsdl");
        $response = $soapClient->Verifytransaction($request->input('RefNum'), $this->merchant_id);
        $order = $this->getOrder($request->ResNum);
        /*for test*/
        //        $response = $order->amount + 10000;
        //        $request->merge(['RefNum' => '124234676']);
        /*end for test*/
        return $response == ($order->amount + 10000) ? $this->transactionSuccess($order, $request->input('RefNum')) :
            $this->transactionFailed();
    }

    public function getName(): string
    {
        return 'saman';
    }

    private function redirectForm(Order $order, $amount)
    {
        echo "<form id='saman' action='https://sep.shaparak.ir/payment.aspx' method='post'>
                   <input  type='hidden' name='Amount' value='$amount'>
                   <input  type='hidden' name='MID' value='$this->merchantId'>
                   <input  type='hidden' name='ResNum' value='$order->code'>
                   <input  type='hidden' name='RedirectURL' value='$this->verifyRoute'>     
               </form ><script >document.getElementById('saman').submit();</script>";
    }

    private function transactionFailed()
    {
        return [
            'status' => Pay::TRANSACTION_FAILED
        ];
    }

    private function getOrder($resNum)
    {
        return Order::where('code', $resNum)->firstOrFail();
    }

    private function transactionSuccess($order, $refNum)
    {
        return [
            'status' => self::TRANSACTION_SUCCESS,
            'order' => $order,
            'refNum' => $refNum,
            'gateway' => $this->getName()
        ];
    }
}
