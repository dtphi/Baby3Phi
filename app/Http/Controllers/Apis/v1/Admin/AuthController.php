<?php

namespace App\Http\Controllers\Apis\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @author : Phi .
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $json        = [
            'message' => __('admins/auth.failed'),
            'errors'  => '',
            'code'    => 500
        ];

        $guard = Auth::guard('admin');

        if ($guard->attempt($credentials)) {
            $user = Auth::user();
            $user->last_logged_in_at = Carbon::now();
            $user->save();
            $request->session()->regenerate();
            $json['code'] = 200;
        }

        return \response()->json($json);
    }

    /**
     * [logout description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function logout(Request $request)
    {
        $json = [
            'message' => __('admins/auth.failed'),
            'errors'  => '',
            'code'    => 200
        ];
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        //Auth::logoutOtherDevices($currentPassword);

        return \response()->json($json);
    }
}
