<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\OpenSignalTokenRequest;
use App\Models\User;
use Illuminate\Http\Request;

class OpenSignalController extends Controller
{
    public function setToken(OpenSignalTokenRequest $request)
    {
        $user = auth()->user();
        $user->open_signal_token = $request->open_signal_token;
        $user->save();
        return ['status'=>'success'];

    }


}
