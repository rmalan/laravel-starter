<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Show the application's registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? response()->json(['user' => $user], 201)
            : redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): ValidatorContract
    {
        $rules = [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'username' => ['required', 'max:20', 'unique:users'],
            'password' => ['required', 'min:8', 'regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\x]).*$/', 'confirmed'],
        ];

        $customMessages = [
            'name.required' => 'Nama belum diisi!',
            'email.required' => 'Email belum diisi!',
            'email.email' => 'Email tidak valid!',
            'email.unique' => 'Email telah digunakan!',
            'username.required' => 'Nama pengguna belum diisi!',
            'username.max' => 'Nama pengguna maksimal :max karakter!',
            'username.unique' => 'Nama pengguna telah digunakan!',
            'password.required' => 'Kata sandi belum diisi!',
            'password.min' => 'Kata sandi minimal :min karakter!',
            'password.regex' => 'Kata sandi harus mengandung huruf kapital, huruf kecil, dan angka!',
            'password.confirmed' => 'Kata sandi tidak cocok!',
        ];

        return Validator::make($data, $rules, $customMessages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);

        // return $user->assignRole('administrator');
    }

    /**
     * Get the post register / login redirect path.
     */
    protected function redirectPath(): string
    {
        return $this->redirectTo ?? RouteServiceProvider::HOME;
    }

    /**
     * Get the guard to be used during registration.
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has been registered.
     */
    protected function registered(Request $request, User $user)
    {
        return null;
    }
}
