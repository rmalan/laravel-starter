<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MyAccountController extends Controller
{
    public function show()
    {
        $data['pageTitle'] = 'Akun Saya';

        return view('my_account', $data);
    }

    public function updateAccount(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => ['required', 'string', 'email', 'unique:users,email,' .$request->id],
            'username' => ['required', 'string', 'max:20', 'unique:users,username,' .$request->id],
        ];

        $customMessages = [
            'name.required' => 'Nama belum diisi!',
            'email.required' => 'Email belum diisi!',
            'email.unique' => 'Email telah digunakan!',
            'username.required' => 'Nama pengguna belum diisi!',
            'username.unique' => 'Nama pengguna telah digunakan!',
        ];

        $this->validate($request, $rules, $customMessages);

        $user = User::find($request->id);
        $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username
            ]);

        return redirect('/my-account')->with('message', 'Data telah diperbaharui');
    }

    public function updatePassword(Request $request)
    {
        $rules = [
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required', 'min:8', 'regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\x]).*$/'],
            'new_password_confirmation' => ['same:new_password'],
        ];

        $customMessages = [
            'current_password.required' => 'Kata sandi lama belum diisi!',
            'new_password.required' => 'Kata sandi baru belum diisi!',
            'new_password.min' => 'Kata sandi minimal :min karakter!',
            'new_password.regex' => 'Kata sandi harus mengandung huruf kapital, huruf kecil, dan angka!',
            'new_password_confirmation.same' => 'Kata sandi tidak cocok!',
        ];

        $this->validate($request, $rules, $customMessages);

        $user = User::find($request->id);
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect('/my-account')->with('message', 'Kata sandi telah diperbaharui');
    }
}
