<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    /**
     * Where to redirect users after verification.
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
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Show the email verification notice.
     */
    public function show(Request $request)
    {
        return $request->user() instanceof MustVerifyEmail && $request->user()->hasVerifiedEmail()
            ? redirect()->intended($this->redirectPath())
            : view('auth.verify');
    }

    /**
     * Mark the authenticated user's email address as verified.
     */
    public function verify(Request $request)
    {
        $user = $request->user();

        if (! $user instanceof MustVerifyEmail) {
            return redirect()->intended($this->redirectPath());
        }

        if ($user->hasVerifiedEmail()) {
            return $request->wantsJson()
                ? response()->json([], Response::HTTP_NO_CONTENT)
                : redirect()->intended($this->redirectPath());
        }

        if (! hash_equals((string) $request->route('id'), (string) $user->getKey())) {
            abort(Response::HTTP_FORBIDDEN);
        }

        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            abort(Response::HTTP_FORBIDDEN);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return $request->wantsJson()
            ? response()->json([], Response::HTTP_NO_CONTENT)
            : redirect()->intended($this->redirectPath())->with('verified', true);
    }

    /**
     * Resend the email verification notification.
     */
    public function resend(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return $request->wantsJson()
                ? response()->json([], Response::HTTP_NO_CONTENT)
                : redirect()->intended($this->redirectPath());
        }

        $user->sendEmailVerificationNotification();

        return $request->wantsJson()
            ? response()->json([], Response::HTTP_ACCEPTED)
            : back()->with('resent', true);
    }

    /**
     * Get the redirect path after verification.
     */
    protected function redirectPath(): string
    {
        return $this->redirectTo ?? RouteServiceProvider::HOME;
    }
}
