<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:permissions-read', ['only' => ['index']]);
        $this->middleware('permission:permissions-create', ['only' => ['store']]);
        $this->middleware('permission:permissions-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permissions-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['pageTitle'] = 'Permissions';
        $data['permissions'] = Permission::all();

        return view('permissions', $data);
    }

    public function store(Request $request)
    {
        Permission::create(['name' => Str::lower($request->nama)]);

        return redirect('/permissions')->with('message', 'Data telah ditambahkan');
    }

    public function edit($id)
    {
        $permission = Permission::find($id);
        
        return response()->json([
            'permission' => $permission,
        ]);
    }

    public function update(Request $request, Permission $permission)
    {
        $permission = Permission::find($permission->id);
        $permission->name = Str::lower($request->nama);
        $permission->save();

        return redirect('/permissions')->with('message', 'Data telah diubah');
    }

    public function destroy(Permission $permission)
    {
        $permission = Permission::find($permission->id);
        $permission->delete();

        return redirect('/permissions')->with('message', 'Data telah dihapus');
    }
}
