<?php

namespace Imageplus\AuthScaffolding\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Jenssegers\Agent\Facades\Agent;

class UserProfileController extends Controller
{
    public function index(){
        return Inertia::render('Auth/UserProfile', [
            'sessions' => $this->getSessions()
        ]);
    }

    protected function getSessions(){
        //if the session driver isn't database we can't check the users sessions
        if (config('session.driver') !== 'database') {
            return collect([]);
        }

        return collect(
            DB::table('sessions')
                ->where('user_id', Auth::user()->getKey())
                ->orderBy('last_activity', 'desc')
                ->get()
        )->map(function ($session) {
            return [
                'agent' => [
                    //OS X is an example
                    'platform' => Agent::platform($session->user_agent),

                    'browser' => Agent::browser($session->user_agent),

                    //don't care for anything apart from desktop/mobile so
                    //under the assumption if it isn't desktop its 'mobile'
                    'is_desktop' => Agent::isDesktop($session->user_agent),
                ],
                'ip_address' => $session->ip_address,
                'current_device' => $session->id === request()->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }
}
