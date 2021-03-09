<?php

namespace App\Http\Controllers;

class FriendController extends Controller
{
    public function index()
    {
        $friends = auth()->user()->friends();
        $requests = auth()->user()->friendRequests();
        return response()->json(['friends' => $friends, 'requests' => $requests]);
    }

    public function acceptFriend($id)
    {
        auth()->user()->friendRequests()->find($id)->pivot->update(['accepted' => true]);
        $friends = auth()->user()->friends();
        $requests = auth()->user()->friendRequests();
        return response()->json(['message' => 'friend accepted', 'friends' => $friends, 'requests' => $requests]);
    }

    public function sendRequest($id)
    {
        if (auth()->user()->id != $id) {
            if (!auth()->user()->haveFriendOrRequest($id)) {
                auth()->user()->friendRequest($id);
            };
        }
        return redirect(route('friends'));
    }

    public function deleteFriend($id)
    {
        auth()->user()->deleteFriend($id);
        $friends = auth()->user()->friends();
        $requests = auth()->user()->friendRequests();
        return response()->json(['message' => 'friend deleted', 'friends' => $friends, 'requests' => $requests]);
    }
}
