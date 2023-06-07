<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Package;
use App\Models\PromoCode;
use App\Models\OnlinePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

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
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'package_id' => 'required',
            'payment_method' => 'required',
            'promo_code' => 'string|nullable',

        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], Response::HTTP_BAD_REQUEST);
        }

        $client_id = $request->input('client_id');
        $package_id = $request->input('package_id');
        $payment_method = $request->input('payment_method');

        $package = Package::findOrFail($package_id);
        $amount = $package->price;

        if ($request->has('promo_code')) {
            $promo_code = $request->input('promo_code');
            $promoCode = PromoCode::where('name', $promo_code)->first();

            if ($promoCode) {
                $today = Carbon::now()->toDateString();
                $start_date = $promoCode->start_date;
                $end_date = $promoCode->end_date;

                if ($start_date <= $today && $end_date >= $today) {
                    $discount_percent = $promoCode->discount_percent;

                    $discount_amount = $amount * ($discount_percent / 100);
                    $amount -= $discount_amount;
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

        return response()->json(['online_payment' => $onlinePayment], Response::HTTP_CREATED);
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
