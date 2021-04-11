<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Models\Room;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::where('from', auth()->user()->id)
            ->orWhere('to', auth()->user()->id)
            ->latest()
            ->get()
            ->unique('room_id');

        $chats = collect();
        $messages->each(function ($message) use ($chats) {
            if ($message->from !== auth()->user()->id xor $message->to !== auth()->user()->id) {
                $chats->push(collect([
                    'user' => User::find($message->to),
                    'last_message' => $message->message,
                    'created_at' => $message->created_at,
                    'chat_room' => $message->room_id
                ]));
            }
        });

        $chats->each(function ($chat) {
            $chat['user']->avatar_path = User::find($chat['user']->id)->getAvatar();
        });


        return response()->json(['chats' => $chats]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = Message::with('from', 'to')
            ->where(function ($query) use ($request) {
                $query->where('from', $request->to)
                    ->orWhere('from', auth()->user()->id);
            })->where(function ($query) use ($request) {
                $query->where('to', $request->to)
                    ->orWhere('to', auth()->user()->id);
            });

        $isMessages = $messages->count();
        $messages_room = 0;

        if ($isMessages > 0) {
            $messages_room = $messages->first()->room()->first();
        } else {
            $messages_room = Room::create();
        }

        $message = auth()->user()->sentMessages()->create([
            'message' => $request->message,
            'to' => $request->to,
            'room_id' => $messages_room->id
        ]);

        $message->from = $message->from()->first();
        $message->to = $message->to()->first();

        broadcast(new MessageEvent($message))->toOthers();

        return response()->json(['message' => $message]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        $authUserMessages = auth()->user()->sentMessagesTo($id)->get();
//        $anotherUserMessages = auth()->user()->receivedMessagesFrom($id)->get();
//        $messages = $authUserMessages->merge($anotherUserMessages)->sortBy('created_at')->values()->all();
//        return response()->json(['messages' => $messages]);

        $messages = Message::with('from', 'to')
            ->where(function ($query) use ($id) {
                $query->where('from', $id)
                    ->orWhere('from', auth()->user()->id);
            })->where(function ($query) use ($id) {
                $query->where('to', $id)
                    ->orWhere('to', auth()->user()->id);
            })
            ->oldest()
            ->get();

        return response()->json(['messages' => $messages]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }
}
