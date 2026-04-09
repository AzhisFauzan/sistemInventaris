<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserCtrl extends Controller
{
     public function data_user()
    {
        $data_user = DB::table('users')->get();
        return view("user.data_user",compact('data_user'));
    }

    public function store_user(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'password' => 'required',
            'role'     => 'required'
        ]);

        $user = User::create([
            'name'     => $request->name,
            'password' => $request->password,
            'role'     => $request->role,
        ]);

        return response()->json([
            'status' => 'success',
            'name'   => $user->name,
            'role'   => $user->role,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'role' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->role = $request->role;

        if ($request->password != '') {
            $user->password = $request->password;
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'name'   => $user->name,
            'role'   => $user->role,
        ]);
    }

    public function delete_user($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

       return response()->json([
            'status' => 'success',
            'id'     => $user->id,
            'name'   => $user->name,
            'role'   => $user->role,
        ]);
    }
}
