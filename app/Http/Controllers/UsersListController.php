<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersListController extends Controller
{
    public function showUsersList()
    {
        $users = User::paginate(5);
        return response()->json(['users' => $users
        ]);
    }

    public function getUserInfo($id)
    {
        return view('userProfile', ['user' => User::where('id', $id)->first()]);
    }

    public function editUserName(User $user, Request $request)
    {
        $request->validate([
            'name' => 'required|max:15|min:3',
        ]);

        auth()->user()->editUserName($user, $request->get('name'));
        return redirect('/user/' . $user->id)->with('status', 'Name edited');
    }
}
