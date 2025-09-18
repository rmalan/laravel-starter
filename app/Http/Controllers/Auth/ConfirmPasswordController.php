<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations.
    | The former framework trait has been replaced with inline logic to
    | stay compatible with the latest Laravel release.
    |
    */

    /**
     * Where to redirect users when the intended url fails.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the password confirmation form.
     */
    public function showConfirmForm()
    {
        return view('auth.passwords.confirm');
    }

    /**
     * Confirm the user's password.
     */
    public function confirm(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        $this->resetPasswordConfirmationTimeout($request);

        return $request->wantsJson()
            ? response()->noContent()
            : redirect()->intended($this->redirectPath());
    }

    /**
     * Get the password confirmation validation rules.
     */
    protected function rules(): array
    {
        return [
            'password' => ['required', 'string', 'current_password'],
        ];
    }

    /**
     * Get the validation error messages for confirmation.
     */
    protected function validationErrorMessages(): array
    {
        return [];
    }

    /**
     * Reset the password confirmation timeout.
     */
    protected function resetPasswordConfirmationTimeout(Request $request): void
    {
        $request->session()->put('auth.password_confirmed_at', time());
    }

    /**
     * Get the guard to be used during password confirmation.
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Get the redirect path after confirmation.
     */
    protected function redirectPath(): string
    {
        return $this->redirectTo ?? RouteServiceProvider::HOME;
    }
}
