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
        $comments = Comment::where('commentable_id', $topicId)->with('user')->get();
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $categoryId, $topicId)
    {
        $validator = validator($request->all(), [
            'text' => 'required|min:2'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Topic::findOrFail($topicId)->addComment($request->text);
        $comments = Comment::where('commentable_id', $topicId)->with('user')->get();

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($categoryId, $topicId, $commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if ($comment->isCommentedBy(auth()->id())) {
            $comment->deleteComment($commentId);
            $comments = Comment::where('commentable_id', $topicId)->with('user')->get();
            return response()->json(['message' => 'comment deleted', 'comments' => $comments]);
        }

        return response()->json(['error' => [['It isn\'t your comment']]], 403);
    }
}
