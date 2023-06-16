<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return response()->json(['packages' => $packages]);
    }

    public function show($id)
    {
        $package = Package::findOrFail($id);
        return response()->json(['package' => $package]);
    }
}


