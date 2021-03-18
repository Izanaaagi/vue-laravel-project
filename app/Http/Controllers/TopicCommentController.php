<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;

class TopicCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($categoryId, $topicId)
    {
        $topic = Topic::find($topicId);
        $comments = $topic->comments()->get();
        foreach ($comments as $comment) {
            $comment->user = $comment->user();
            $comment->user->avatar_path = User::find($comment->user_id)->getAvatar();
        }
        return response()->json(['comments' => $comments]);
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
    public function store(Request $request, $categoryId, $topicId)
    {
        $topic = Topic::find($topicId);
        $topic->addComment($request->text);
        $comments = $topic->comments()->get();
        foreach ($comments as $comment) {
            $comment->user = $comment->user();
            $comment->user->avatar_path = User::find($comment->user_id)->getAvatar();
        }
        return response()->json(['message' => 'comment \'' . $request->text . '\' created', 'comments' => $comments]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($categoryId, $topicId, $commentId)
    {
        $comment = Comment::find($commentId);
        $topic = Topic::find($topicId);
        if ($comment->isCommentedBy(auth()->id())) {
            $comment->deleteComment($commentId);
            $comments = $topic->comments()->get();
            foreach ($comments as $comment) {
                $comment->user = $comment->user();
                $comment->user->avatar_path = User::find($comment->user_id)->getAvatar();
            }
            return response()->json(['message' => 'comment deleted', 'comments' => $comments]);
        }
        return abort(404);
    }
}
