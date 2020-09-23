<?php

namespace Imageplus\AuthScaffolding\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Laravel\Fortify\Features;

class ShareInertiaData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->shareData($request);

        return $next($request);
    }

    protected function shareData(Request $request){
        Inertia::share([
            'session' => function(){
                return Session::all();
            },

            'flash' => function() {
                return Session::get('flash', []);
            },

            'user' => Auth::user(),

            'errorBags' => function () {
                return Session::get('errors') != null
                    ? collect(Session::get('errors')->getBags())->mapWithKeys(function($errors, $key){
                        return [$key => $errors->messages()];
                    })
                    : [];
            },

            'currentRouteName' => Route::currentRouteName(),

            'features' => [
                'two-factor-auth' => Features::canManageTwoFactorAuthentication(),
                'update-profile' => Features::canUpdateProfileInformation(),
                'change-password' => Features::enabled(
                    Features::updatePasswords()
                ),
                'reset-password' => Features::enabled(
                    Features::resetPasswords()
                ),
                'registration' => Features::enabled(
                    Features::registration()
                ),
                'logout-other-sessions' => config('imageplus-auth-scaffolding.features.logout-other-sessions'),
                'manage-profile' => config('imageplus-auth-scaffolding.features.manage-profile'),
            ]
        ]);
    }
}
