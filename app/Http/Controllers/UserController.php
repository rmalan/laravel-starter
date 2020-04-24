<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['pageTitle'] = 'Users';
        $data['users'] = User::all();

        return view('users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['pageTitle'] = 'Tambah Data Users';
        $data['roles'] = Role::all();

        return view('users.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => ['required', 'string', 'email', 'unique:users'],
            'username' => ['required', 'string', 'max:20', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
            'role' => 'required',
        ];

        $customMessages = [
            'name.required' => 'Nama belum diisi!',
            'email.required' => 'Email belum diisi!',
            'email.unique' => 'Email telah digunakan!',
            'username.required' => 'Nama pengguna belum diisi!',
            'username.unique' => 'Nama pengguna telah digunakan!',
            'password.required' => 'Kata sandi belum diisi!',
            'password.confirmed' => 'Kata sandi tidak cocok!',
            'role.required' => 'Role belum diisi!',
        ];

        $this->validate($request, $rules, $customMessages);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);
        $user->assignRole($request->role);

        return redirect('/users')->with('message', 'Data telah ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $data['pageTitle'] = 'Ubah Data Pengguna';
        $data['user'] = $user;
        $data['roles'] = Role::all();
        $data['userRole'] = User::find($user->id)->roles->pluck('name','name')->all();

        return view('users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required',
            'email' => ['required', 'string', 'email', 'unique:users,email,' .$user->id],
            'username' => ['required', 'string', 'max:20', 'unique:users,username,' .$user->id],
            'password' => 'confirmed',
            'role' => 'required',
        ];

        $customMessages = [
            'name.required' => 'Nama belum diisi!',
            'email.required' => 'Email belum diisi!',
            'email.unique' => 'Email telah digunakan!',
            'username.required' => 'Nama pengguna belum diisi!',
            'username.unique' => 'Nama pengguna telah digunakan!',
            'password.confirmed' => 'Kata sandi tidak cocok!',
            'role.required' => 'Role belum diisi!',
        ];

        $this->validate($request, $rules, $customMessages);

        DB::table('model_has_roles')->where('model_id', $user->id)->delete();

        $user = User::find($user->id);
        $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password)
            ]);
        $user->assignRole($request->role);

        return redirect('/users')->with('message', 'Data telah diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);

        return redirect('/users')->with('message', 'Data telah dihapus');
    }
}
