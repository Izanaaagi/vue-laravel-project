<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Topic $topic
     * @return \Illuminate\Http\Response
     */
    public function show($categoryId, $topicId)
    {
        $topic = Topic::find($topicId);
        $topic->user = User::find($topic->user_id);
        $topic->user->avatar_path = asset(Storage::url($topic->user->avatar_path));
        $topic->likes = $topic->likesUp();
        $topic->dislikes = $topic->likesDown();
        $topic->isLiked = $topic->isLikedBy(auth()->user());
        $topic->isDisliked = $topic->isDislikedBy(auth()->user());
        $topic->increment('views');
        return response()->json(['topic' => $topic]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\cr $cr
     * @return \Illuminate\Http\Response
     */
    public function edit(cr $cr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\cr $cr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cr $cr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Topic $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        if ($topic->isTopicBy(auth()->id())) {
            $topic->deleteTopic($topic->id);
            return redirect(route('forumCategory', ['category' => $topic->category()->id]))
                ->with('status', 'Topic was deleted');
        } else return redirect(route('forumCategory', ['category' => $topic->category()->id]))
            ->withErrors('It isn`t your topic');
    }
}
