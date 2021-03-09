<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersListController extends Controller
{
    public function showUsersList()
    {
        return response()->json(['users' => User::all()->each(function ($user) {
            $user->avatar_path = $user->getAvatar();
        })]);
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
