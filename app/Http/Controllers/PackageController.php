<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::with('enterprise')->get();
        return response()->view('cms.packages.index', ['packages' => $packages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packages = Package::byEnterprise()->get();
        $packages = Package::where('active','=',true)->get();
        $packages = Package::where('is_unlimited','=',true)->get();

        return response()->view('cms.packages.create', ['packages' => $packages]);


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
            // 'package_id' => 'required|numeric|exists:packages,id',
            'name' => 'required|string',
            'description' => 'string',
            'price' => 'required|numeric',
            'duration' => 'required|numeric',
            'duration_unit' => 'required|string|in:d,m,y',
            'image' => 'required|string',
            'limit' => 'numeric',
            'is_unlimited' => 'required|boolean',
            'active' => 'required|boolean',

        ]);

        if (!$validator->fails()) {
            $package = new Package();
            if($request->hasFile('image'))
            {
                $file = $request->file('image');
                $extention = $file->getClientOriginalExtension();  // $ext
                $filename= time().'.'.$extention;
                $file->move('assets/uploads/packages/',$filename);
                $package->image = $filename; // to store in DB
            }
            $package->name = $request->input('name');
            $package->description = $request->input('description');
            // $package->package_id = $request->input('package_id');
            $package->price = $request->input('price');
            $package->duration = $request->input('duration');
            $package->duration_unit = $request->input('duration_unit');
            $package->limit = $request->input('limit');
            $package->is_unlimited = $request->input('is_unlimited');
            $package->active = $request->input('active') ;
            $isSaved = $package->save();
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
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        //
    }
}
