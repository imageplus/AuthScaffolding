<?php


namespace Imageplus\AuthScaffolding;


use Imageplus\AuthScaffolding\Http\Responses\InertiaViewResponse;
use Laravel\Fortify\Contracts\ConfirmPasswordViewResponse;
use Laravel\Fortify\Contracts\LoginViewResponse;
use Laravel\Fortify\Contracts\RegisterViewResponse;
use Laravel\Fortify\Contracts\RequestPasswordResetLinkViewResponse;
use Laravel\Fortify\Contracts\ResetPasswordViewResponse;
use Laravel\Fortify\Contracts\TwoFactorChallengeViewResponse;
use Laravel\Fortify\Contracts\VerifyEmailViewResponse;

class ImageplusAuthScaffolding
{
    /**
     * Creates all the route functionality with the default views
     */
    public static function useDefaultViews(){
        self::loginView(
            config('imageplus-auth-scaffolding.defaults.login')
        );

        self::twoFactorChallengeView(
            config('imageplus-auth-scaffolding.defaults.two-factor-challenge')
        );

        self::resetPasswordView(
            config('imageplus-auth-scaffolding.defaults.reset-password'),
            function($request) {
                return [
                    'token' => $request->route()->parameter('token')
                ];
            }
        );

        self::registerView(
            config('imageplus-auth-scaffolding.defaults.register')
        );

        self::verifyEmailView(
            config('imageplus-auth-scaffolding.defaults.verify-email')
        );

        self::confirmPasswordView(
            config('imageplus-auth-scaffolding.defaults.confirm-password')
        );

        self::requestPasswordResetLinkView(
            config('imageplus-auth-scaffolding.defaults.request-reset-password')
        );

    }

    /**
     * Specify which view should be used as the login view.
     *
     * @param  callable|string  $view
     * @return void
     */
    public static function loginView($view, $data = [])
    {
        app()->singleton(LoginViewResponse::class, function () use ($view, $data) {
            return new InertiaViewResponse($view, $data);
        });
    }

    /**
     * Specify which view should be used as the two factor authentication challenge view.
     *
     * @param  callable|string  $view
     * @return void
     */
    public static function twoFactorChallengeView($view, $data = [])
    {
        app()->singleton(TwoFactorChallengeViewResponse::class, function () use ($view, $data) {
            return new InertiaViewResponse($view, $data);
        });
    }

    /**
     * Specify which view should be used as the new password view.
     *
     * @param  callable|string  $view
     * @return void
     */
    public static function resetPasswordView($view, $data = [])
    {
        app()->singleton(ResetPasswordViewResponse::class, function () use ($view, $data) {
            return new InertiaViewResponse($view, $data);
        });
    }

    /**
     * Specify which view should be used as the registration view.
     *
     * @param  callable|string  $view
     * @return void
     */
    public static function registerView($view, $data = [])
    {
        app()->singleton(RegisterViewResponse::class, function () use ($view, $data) {
            return new InertiaViewResponse($view, $data);
        });
    }

    /**
     * Specify which view should be used as the email verification prompt.
     *
     * @param  callable|string  $view
     * @return void
     */
    public static function verifyEmailView($view, $data = [])
    {
        app()->singleton(VerifyEmailViewResponse::class, function () use ($view, $data) {
            return new InertiaViewResponse($view, $data);
        });
    }

    /**
     * Specify which view should be used as the password confirmation prompt.
     *
     * @param  callable|string  $view
     * @return void
     */
    public static function confirmPasswordView($view, $data = [])
    {
        app()->singleton(ConfirmPasswordViewResponse::class, function () use ($view, $data) {
            return new InertiaViewResponse($view, $data);
        });
    }

    /**
     * Specify which view should be used as the request password reset link view.
     *
     * @param  callable|string  $view
     * @return void
     */
    public static function requestPasswordResetLinkView($view, $data = [])
    {
        app()->singleton(RequestPasswordResetLinkViewResponse::class, function () use ($view, $data) {
            return new InertiaViewResponse($view, $data);
        });
    }
}
