<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests.
    | The supporting logic is inlined to replace the legacy trait removed
    | in recent Laravel versions.
    |
    */

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Display the password reset view for the given token.
     */
    public function showResetForm(Request $request, ?string $token = null)
    {
        return view('auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Handle a reset password request.
     */
    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        $status = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);

                $this->guard()->login($user);
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return $this->sendResetResponse($request, $status);
        }

        return $this->sendResetFailedResponse($request);
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [
            'token.required' => 'Token kadaluarsa!',
            'email.required' => 'Email belum diisi!',
            'email.email' => 'Email tidak valid!',
            'password.required' => 'Kata sandi belum diisi!',
            'password.min' => 'Kata sandi minimal :min karakter!',
            'password.confirmed' => 'Kata sandi tidak cocok!',
        ];
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse(Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'message' => __('passwords.token'),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __('passwords.token')]);
    }

    /**
     * Get the response for a successful password reset.
     */
    protected function sendResetResponse(Request $request, string $status)
    {
        return $request->wantsJson()
            ? response()->json(['message' => __($status)], Response::HTTP_OK)
            : redirect($this->redirectPath())->with('status', __($status));
    }

    /**
     * Get the password reset credentials from the request.
     */
    protected function credentials(Request $request): array
    {
        return $request->only('email', 'password', 'password_confirmation', 'token');
    }

    /**
     * Reset the given user's password.
     */
    protected function resetPassword($user, string $password): void
    {
        $user->forceFill([
            'password' => Hash::make($password),
            'remember_token' => Str::random(60),
        ])->save();

        event(new PasswordReset($user));
    }

    /**
     * Get the broker to be used during password reset.
     */
    protected function broker()
    {
        return Password::broker();
    }

    /**
     * Get the guard to be used during password reset.
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Get the post reset redirect path.
     */
    protected function redirectPath(): string
    {
        return $this->redirectTo ?? RouteServiceProvider::HOME;
    }
}
