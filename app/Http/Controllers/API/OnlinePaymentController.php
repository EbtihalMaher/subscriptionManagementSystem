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
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;


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
            'name' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], Response::HTTP_BAD_REQUEST);
        }
    
        $promo_code = $request->input('name');
        $subscription = Client::where('name', $promo_code)->first();
    
        if ($subscription) {
            $today = Carbon::now()->toDateString();
            $start_date = $subscription->start_date;
            $end_date = $subscription->end_date;
    
            if ($start_date <= $today && $end_date >= $today) {
                $amount = $request->input('amount');
                $discount_percent = $subscription->promo_code->discount_percent;
                $discount_amount = $amount * ($discount_percent / 100);
                $amount -= $discount_amount;
    
                $payment = new OnlinePayment();
                $payment->amount = $amount;
                $payment->save();
    
                return response()->json(['message' => 'Payment created successfully', 'payment' => $payment], Response::HTTP_CREATED);
            } else {
                return response()->json(['message' => 'Promo code is not valid for the current date'], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json(['message' => 'Promo code not found'], Response::HTTP_NOT_FOUND);
        }
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
