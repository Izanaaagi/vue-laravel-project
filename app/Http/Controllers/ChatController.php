<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
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
        $authUserMessages = auth()->user()->sentMessages()->groupBy('from')->get();
        $anotherUserMessages = auth()->user()->receivedMessages()->groupBy('to');

        return response()->json(['messages' => $authUserMessages]);
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
        $message = auth()->user()->sentMessages()->create([
            'message' => $request->message,
            'to' => $request->userId,
        ]);

        broadcast(new MessageEvent($message))->toOthers();

        return response()->json([
            'code' => 200
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $authUserMessages = auth()->user()->sentMessagesTo($id);
        $anotherUserMessages = auth()->user()->receivedMessagesFrom($id);
        $messages = $authUserMessages->merge($anotherUserMessages)->sortBy('created_at')->values()->all();
        return response()->json(['messages' => $messages]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
