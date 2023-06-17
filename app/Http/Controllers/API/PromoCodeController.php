<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;


class PromoCodeController extends Controller
{
    public function show($name)
    {
        $promoCode = PromoCode::ByEnterpriseID()->where('name', $name)->first();
        return response()->json(['promo_code' => $promoCode]);
    }
}