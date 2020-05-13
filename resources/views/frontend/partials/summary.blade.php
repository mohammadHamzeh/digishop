@inject('cost','App\Support\Costs\Contracts\CostInterface')

<div class="form-control">
    <table class="table" style="font-family: IRANSans">
        <h4 style="font-family: IRANSans">پرداخت</h4>
        @foreach($cost->getSummary() as $description => $price)
            <tr>
                <td>{{$description}}</td>
                <td> {{number_format($price)}} تومان</td>
            </tr>
        @endforeach
        <tr>
            <td>مجموع هزینه خرید</td>
            <td> {{number_format($cost->getTotalCost())}} تومان</td>
        </tr>
    </table>
</div>
