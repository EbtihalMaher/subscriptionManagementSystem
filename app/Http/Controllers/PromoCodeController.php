<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PromoCodeController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:Read-Users', ['only' => ['index', 'show']]);
        $this->middleware('permission:Create-User', ['only' => ['create', 'store']]);
        $this->middleware('permission:Delete-User', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promo_codes = PromoCode::with('package')->withTrashed()->get();
        return response()->view('cms.promo_codes.index', ['promo_codes' => $promo_codes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packages = Package::ByEnterprise()->get();
        return response()->view('cms.promo_codes.create', ['packages' => $packages]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all(), [
            'package_id' => 'required|numeric|exists:packages,id',
            'name' => 'required|string',
            'discount_percent' => 'required|numeric',
        ]);

        if (!$validator->fails()) {
            $promo_code = new PromoCode();
            $promo_code->package_id = $request->input('package_id');
            $promo_code->name = $request->input('name');
            $promo_code->discount_percent = $request->input('discount_percent');
            $promo_code->enterprise_id = auth()->user()->enterprise_id;
            $isSaved = $promo_code->save();
            return response()->json(
                ['message' => $isSaved ? 'Saved successfully' : 'Save failed!'],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PromoCode  $promoCode
     * @return \Illuminate\Http\Response
     */
    public function show(PromoCode $promoCode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PromoCode  $promoCode
     * @return \Illuminate\Http\Response
     */
    public function edit(PromoCode $promoCode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PromoCode  $promoCode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PromoCode $promoCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PromoCode  $promoCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(PromoCode $promoCode)
    {
    }
}
