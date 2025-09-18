<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    /**
     * Display the form to request a password reset link.
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Send a reset link to the given user.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        if ($status === Password::RESET_LINK_SENT) {
            return $this->sendResetLinkResponse($status, $request);
        }

        return $this->sendResetLinkFailedResponse($request, $status);
    }

    /**
     * Get the needed authentication credentials from the request.
     */
    protected function credentials(Request $request): array
    {
        return $request->only('email');
    }

    /**
     * Get the broker to be used during password reset.
     */
    protected function broker()
    {
        return Password::broker();
    }

    /**
     * Get the response for a successful reset link.
     */
    protected function sendResetLinkResponse(string $status, Request $request)
    {
        return $request->wantsJson()
            ? response()->json(['message' => __($status)], Response::HTTP_OK)
            : back()->with('status', __($status));
    }

    /**
     * Get the response for a failed reset link.
     */
    protected function sendResetLinkFailedResponse(Request $request, string $status)
    {
        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }
}
