<?php

namespace Imageplus\AuthScaffolding\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserSessionController extends Controller
{
    /**
     * Logout from other browser sessions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     */
    public function destroy(Request $request, StatefulGuard $guard)
    {
        if (! Hash::check($request->get('password'), Auth::user()->password)) {
            throw ValidationException::withMessages([
                'password' => [__('This password does not match our records.')],
            ])->errorBag('logoutOtherBrowserSessions');
        }

        $guard->logoutOtherDevices($request->get('password'));

        if (config('session.driver') === 'database') {
            DB::table('sessions')
                ->where('user_id', Auth::user()->getKey())
                ->where('id', '!=', $request->session()->getId())
                ->delete();
        }

        return redirect()->back(303);
    }
}
