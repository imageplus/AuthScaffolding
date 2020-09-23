<?php

namespace Imageplus\AuthScaffolding\Http\Responses;

use Inertia\Inertia;
use Laravel\Fortify\Contracts\ConfirmPasswordViewResponse;
use Laravel\Fortify\Contracts\LoginViewResponse;
use Laravel\Fortify\Contracts\RegisterViewResponse;
use Laravel\Fortify\Contracts\RequestPasswordResetLinkViewResponse;
use Laravel\Fortify\Contracts\ResetPasswordViewResponse;
use Laravel\Fortify\Contracts\TwoFactorChallengeViewResponse;
use Laravel\Fortify\Contracts\VerifyEmailViewResponse;

class InertiaViewResponse implements
    LoginViewResponse,
    ResetPasswordViewResponse,
    RegisterViewResponse,
    RequestPasswordResetLinkViewResponse,
    TwoFactorChallengeViewResponse,
    VerifyEmailViewResponse,
    ConfirmPasswordViewResponse
{
    /**
     * The name of the view or the callable used to generate the view.
     *
     * @var callable|string
     */
    protected $view;

    protected $data;

    /**
     * Create a new response instance.
     *
     * @param callable|string $view
     * @param array $data
     */
    public function __construct($view, $data = [])
    {
        $this->view = $view;
        $this->data = $data;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $data = $this->data;

        if(is_callable($this->data)){
            $data = call_user_func($this->data, $request);
        }

        return Inertia::render($this->view, $data)->toResponse($request);
    }
}
