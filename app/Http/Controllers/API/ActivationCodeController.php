<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ActivationCodeGroup;
use App\Models\ActivationCode;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;



class ActivationCodeController extends Controller
{
    
    public function showGroupActivationCode($groupId)
    {
        
        $activationCodeGroup = ActivationCodeGroup::ByEnterpriseID()->findOrFail($groupId);
        $activationCode = $activationCodeGroup->activationCode;
        return response()->json(['activation_code' => $activationCode]);
    }
  
    public function showActivationCode($groupId, $activationCodeId)
    {
        $activationCode = ActivationCode::ByEnterpriseID()->where('group_id', $groupId)
            ->where('id', $activationCodeId)
            ->firstOrFail();
        return response()->json(['activation_code' => $activationCode]);
    }
}
