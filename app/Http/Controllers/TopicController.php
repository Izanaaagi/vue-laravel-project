<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicRequest;
use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TopicRequest $request, $categoryId)
    {
        if ($categoryId == 1 && !auth()->user()->can('create admin\'s topics')) {
            return response()->json(['errors' => ['Permissions error' => ['You haven\'t permissions']]], 403);
        }

        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $topic = new Topic();
        $topic->createTopic($categoryId, $request->title, $request->text);

        Category::find($categoryId)
            ->update([
                'posts' => Topic::where('category_id', $categoryId)->count()
            ]);

        $topics = Category::find($categoryId)->topics()->paginate(5);
        foreach ($topics as $topic) {
            $user = User::find($topic->user_id);
            $topic->user_name = $user->name;
        }
        return response()->json(['topics' => $topics, 'message' => 'topic created successful']);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Topic $topic
     * @return \Illuminate\Http\Response
     */
    public
    function show($categoryId, $topicId)
    {
        $topic = Topic::findOrFail($topicId);
        $topic->user = User::find($topic->user_id);
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
    public
    function edit(cr $cr)
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
    public
    function update(Request $request, cr $cr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Topic $topic
     * @return \Illuminate\Http\JsonResponse
     */
    public
    function destroy($categoryId, $topicId)
    {
        $topic = Topic::find($topicId);
        if ($topic->isTopicBy(auth()->id()) || auth()->user()->can('delete articles')) {
            $topic->deleteTopic($topic->id);
            $topics = Category::find($categoryId)->topics()->paginate(5);
            foreach ($topics as $topic) {
                $user = User::find($topic->user_id);
                $topic->user_name = $user->name;
            }

            Category::find($categoryId)
                ->update([
                    'posts' => Topic::where('category_id', $categoryId)->count()
                ]);
            return response()->json(['topics' => $topics, 'message' => 'topic deleted']);
        }
        return response()->json(['errors' => ['Permissions error' => ['You haven\'t permissions']]], 403);
    }
}
