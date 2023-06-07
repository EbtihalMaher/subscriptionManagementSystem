<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PromoCode;
use App\Models\OnlinePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OnlinePaymentController extends Controller
{
   
    public function index()
    {
        //
    }

   
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        $client_id = $request->input('client_id');
        $package_id = $request->input('package_id');
        $payment_method = $request->input('payment_method');
        $promo_code = $request->input('promo_code');

        $package = Package::findOrFail($package_id);
        $amount = $package->price;

        if (!empty($promo_code)) {
            $promoCode = PromoCode::where('code', $promo_code)
                ->where('start_date', '<=', Carbon::now()->toDateString())
                ->where('end_date', '>=', Carbon::now()->toDateString())
                ->first();
    
            if ($promoCode) {
                if (!empty($promoCode->price_after_discount)) {
                    $amount = $promoCode->price_after_discount;
                } else {
                    $discount = ($promoCode->discount_percent / 100) * $package->price;
                    $amount = $package->price - $discount;
                }
            }
        }
        
        $transaction_number = Str::random(12);

    
        $onlinePayment = OnlinePayment::create([
            'client_id' => $client_id,
            'amount' => $amount,
            'transaction_number' => $transaction_number,
            'payment_method' => $payment_method,
        ]);

        return response()->json(['online_payment' => $onlinePayment], 201);
    }

    

    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
