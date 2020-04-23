<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $data['pageTitle'] = 'Permissions';
        $data['permissions'] = Permission::all();

        return view('permissions', $data);
    }

    public function store(Request $request)
    {
        Permission::create(['name' => $request->nama]);

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
        $permission->name = $request->nama;
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
