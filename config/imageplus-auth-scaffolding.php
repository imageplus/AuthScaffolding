<?php
    return [
        /**
         * This config option allows you to modify the default views
         * used to handle the authentication process
         */
        'defaults' => [
            'login' => 'Auth/Login',
            'register' => 'Auth/Register',
            'two-factor-challenge' => 'Auth/TwoFactorChallenge',
            'reset-password' => 'Auth/ResetPassword',
            'verify-email' => 'Auth/VerifyEmail',
            'confirm-password' => 'Auth/ConfirmPassword',
            'request-reset-password' => 'Auth/RequestResetPassword'
        ],

        /**
         * This config options allows you to disabled/enable
         * the functionality provided by the imageplus/auth package
         */
        'features' => [
            'logout-other-sessions' => true,
            'manage-profile' => true
        ],
    ];
