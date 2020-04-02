<?php

namespace App\Http\Controllers;

use App\UserGroup;
use Illuminate\Http\Request;

class UserGroupsController extends Controller
{
    public function index()
    {
        $data['pageTitle'] = 'Grup Pengguna';
        $data['userGroups'] = UserGroup::all();

        return view('user_groups', $data);
    }

    public function store(Request $request)
    {
        $userGroup = new UserGroup;
        $userGroup->name = $request->nama;
        $userGroup->save();

        return redirect('/user-groups')->with('message', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $userGroup = UserGroup::find($id);
        
        return response()->json([
            'userGroup' => $userGroup,
        ]);
    }

    public function update(Request $request, UserGroup $userGroup)
    {
        $userGroup = UserGroup::find($userGroup->id);
        $userGroup->name = $request->nama;
        $userGroup->save();

        return redirect('/user-groups')->with('message', 'Data berhasil diubah');
    }

    public function destroy(UserGroup $userGroup)
    {
        $userGroup = UserGroup::find($userGroup->id);
        $userGroup->delete();

        return redirect('/user-groups')->with('message', 'Data telah dihapus');
    }
}
