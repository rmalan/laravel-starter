<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:roles-read', ['only' => ['index']]);
        $this->middleware('permission:roles-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:roles-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:roles-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['pageTitle'] = 'Roles';
        $data['roles'] = Role::all();

        return view('roles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['pageTitle'] = 'Tambah Data Role';
        $data['permissions'] = Permission::all();

        return view('roles.create', $data);
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
            'nama' => 'required',
            'permissions' => 'required',
        ];

        $customMessages = [
            'nama.required' => 'Nama belum diisi!',
            'permissions.required' => 'Permissions belum dipilih!',
        ];

        $this->validate($request, $rules, $customMessages);

        $role = Role::create(['name' => $request->nama]);
        $role->syncPermissions($request->permissions);

        return redirect('/roles')->with('message', 'Data telah ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['pageTitle'] = 'Ubah Data Role';
        $data['role'] = Role::find($id);
        $data['permissions'] = Permission::all();
        $data['rolePermissions'] = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $id)
                                    ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                                    ->all();

        return view('roles.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'nama' => 'required',
            'permissions' => 'required',
        ];

        $customMessages = [
            'nama.required' => 'Nama belum diisi!',
            'permissions.required' => 'Permissions belum dipilih!',
        ];

        $this->validate($request, $rules, $customMessages);

        $role = Role::find($id);
        $role->name = $request->nama;
        $role->save();

        $role->syncPermissions($request->permissions);

        return redirect('/roles')->with('message', 'Data telah diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::destroy($id);

        return redirect('/roles')->with('message', 'Data telah dihapus');
    }
}
