<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store($categoryId, $topicId, Request $request)
    {
        $topic = Topic::find($topicId);
        if ($request->action == 'like') {
            $topic->like();
            return response()->json([
                'message' => 'topic liked',
                'likes' => $topic->likesUp(),
                'dislikes' => $topic->likesDown()]);
        } elseif ($request->action == 'dislike') {
            $topic->dislike();
            return response()->json([
                'message' => 'topic disliked',
                'likes' => $topic->likesUp(),
                'dislikes' => $topic->likesDown()]);
        }

        abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($categoryId, $topicId)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update($categoryId, $topicId)
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
