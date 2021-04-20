<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'text',
        'category_id'
    ];

    //Return category of this topic
    public function category()
    {
        return $this->belongsTo(Category::class)->first();
    }

    //Return user, which created this topic
    public function user()
    {
        return $this->belongsTo(User::class)->first();
    }

    public function createTopic($categoryId, $title, $text)
    {
        $this->create([
            'user_id' => auth()->user()->id,
            'title' => $title,
            'text' => $text,
            'category_id' => $categoryId,
        ])->save();

    }

    //Return comments for topic
    public function comments()
    {
        $comments = $this->morphMany(Comment::class, 'commentable');
        return $comments;
    }

    //Return count of comments
    public function commentsCount()
    {
        return $this->comments()->count();
    }

    public function addComment($text)
    {
        return $this->comments()->create([
            'topic_id' => $this->id,
            'user_id' => auth()->id(),
            'text' => $text

        ])->save();
    }

    public function isTopicBy($userId)
    {
        return $this->user_id == $userId;
    }

    public function deleteTopic($topicId)
    {
        $topic = Topic::find($topicId);
        $topic->comments()->delete();
        $topic->likes()->delete();
        return $topic->delete();
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function likesUp($likeStatus = true)
    {
        return $this->likes()->where('is_like', $likeStatus)->count();
    }

    public function likesDown()
    {
        return $this->likesUp(false);
    }

    public function isDislikedBy(User $user)
    {
        return $this->isLikedBy($user, false);
    }

    public function like($likeStatus = true, $user = null)
    {
        $this->likes()->updateOrCreate(
            [
                'user_id' => $user ? $user->id : auth()->id()
            ],
            [
                'is_like' => $likeStatus
            ]
        );
    }

    public function dislike()
    {
        return $this->like(false);
    }

    public function isLikedBy(User $user, $likeStatus = true)
    {
        return (bool)$user->likes()
            ->where('likeable_type', Topic::class)
            ->where('likeable_id', $this->id)
            ->where('is_like', $likeStatus)->count();
    }

}
