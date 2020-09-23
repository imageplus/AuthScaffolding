<?php

use Imageplus\AuthScaffolding\Http\Controllers\UserProfileController;
use Imageplus\AuthScaffolding\Http\Controllers\UserSessionController;

Route::middleware(['web'])->group(function(){
    if(config('imageplus-auth-scaffolding.features.manage-profile')) {
        Route::get('/user/profile', [UserProfileController::class, 'index'])
            ->middleware(['auth'])
            ->name('user.profile');
    }

    if(config('imageplus-auth-scaffolding.features.logout-other-sessions')){
        Route::delete('/user/other-sessions', [UserSessionController::class, 'destroy'])
            ->name('user.other-sessions.destroy');
    }
});

