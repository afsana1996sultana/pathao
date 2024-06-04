@extends('admin.admin_master')
@section('admin')
<style>
 .pass-btn-style{
     color: white;
    background: #049f04;
    padding: 3px 8px;
    border-radius: 5px;
    font-weight: bold;
 }
 .pas-btn {
    padding: 10px 0px;
}
</style>
<section class="content-main">
    <div>
        <h6 class="mb-2">Customer Name: <span class="badge rounded-pill alert-success" style="font-size:16px"> {{ $customer->name }} </span></h6>
        <h6 class="mb-2">Phone:{{ $customer->phone }}</h6>
        <h6 class="mb-2">Email:{{ $customer->email }}</h6>
        @php
            $address = App\Models\Address::where('user_id', $customer->id)->first();
            $city = null;
            $zone = null;
              if ($address) {
                    $district = App\Models\District::where('id', $address->district_id)->first();
                    $upazilla = App\Models\Upazilla::where('id', $address->upazilla_id)->first();
                    $pathao = new App\Http\Controllers\Frontend\PathaoController();
                    $cityResult = $pathao->getCities();
                    $cities = $cityResult->data->data;
                    foreach ($cities as $key => $cityItem) {
                        if ($cityItem->city_id == $address->division_id) {
                            $city = $cityItem;
                            break;
                        }
                    }
                    $pathao = new App\Http\Controllers\Frontend\PathaoController();
                    $zoneResult = $pathao->getZones($address->division_id);
                    $zones = $zoneResult->data->data;
                    foreach ($zones as $key => $zoneItem) {
                        if ($zoneItem->zone_id == $address->district_id) {
                            $zone = $zoneItem;
                            break;
                        }
                    }
                }
            @endphp
            <h6>Address :{{ isset($customer->address) ? $customer->address . ',' : 'No address' }}
                {{ isset($zone) && isset($zone->zone_name) ? ucwords($zone->zone_name) . ',' : '' }}
                {{ isset($city) && isset($city->city_name) ? ucwords($city->city_name) : '' }}</h6>
    </div>
    <div class="content-header">
        <h2 class="content-title">Customer Order</h2>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive-sm">
               <table id="example" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">Sl</th>
                            <th scope="col">Invoice No</th>
                            <th scope="col">Paid Amount</th>
                            <th scope="col">Due Amount</th>
                            <th scope="col">Total Amount</th>
                            <th scope="col">Transection Number</th>
                            @if(Auth::guard('admin')->user()->role != '2')
                                <th scope="col" class="text-end">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $key => $order)
                            <tr>
                                <td> {{ $key+1}} </td>
                                <td> {{ $order->invoice_no ?? '' }} </td>
                                <td> {{ $order->paid_amount ?? '' }} </td>
                                <td> {{ $order->due_amount ?? '' }} </td>
                                <td> {{ $order->grand_total ?? '' }} </td>
                                <td> {{ $order->transaction_no ?? '-' }} </td>
                                <td class="text-end">
                                    <a href="{{ route('customer.order.print',$order->id) }}" class="btn btn-md rounded font-sm"><i class="fa-solid fa-download"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- table-responsive //end -->
        </div>
        <!-- card-body end// -->
    </div>
    @if(count($payments) > 0)
    <div class="content-header">
        <h2 class="content-title">Customer Payment</h2>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive-sm">
               <table id="example" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">Sl</th>
                            <th scope="col">Invoice No</th>
                            <th scope="col">Paid Amount</th>
                            <th scope="col">Due Amount</th>
                            <th scope="col">Total Amount</th>
                            <th scope="col">Payment Method</th>
                            <th scope="col">Transection No</th>
                            @if(Auth::guard('admin')->user()->role != '2')
                                <th scope="col" class="text-end">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $key => $payment)
                            <tr>
                                <td> {{ $key+1}} </td>
                                <td> {{ $payment->invoice_no ?? '' }} </td>
                                <td> {{ $payment->paid ?? '' }} </td>
                                <td> {{ $payment->due ?? '' }} </td>
                                <td> {{ $payment->amount ?? '' }} </td>
                                <td> {{ $payment->payment_method ?? '' }} </td>
                                <td> {{ $payment->transaction_num ?? '-' }} </td>
                                <td class="text-end">
                                    <a href="{{ route('customer.payment.print',$payment->id) }}" class="btn btn-md rounded font-sm"><i class="fa-solid fa-download"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- table-responsive //end -->
        </div>
        <!-- card-body end// -->
    </div>
    @endif
</section>
@endsection