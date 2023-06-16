<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivationCodeGroup;
use App\Models\ActivationCode;

class ActivationCodeController extends Controller
{
    public function showGroupActivationCode($groupId)
    {
        $activationCodeGroup = ActivationCodeGroup::findOrFail($groupId);
        $activationCode = $activationCodeGroup->activationCode;
        return response()->json(['activation_code' => $activationCode]);
    }
  
    public function showActivationCode($groupId, $activationCodeId)
    {
        $activationCode = ActivationCode::where('group_id', $groupId)
            ->where('id', $activationCodeId)
            ->firstOrFail();
        return response()->json(['activation_code' => $activationCode]);
    }
}
