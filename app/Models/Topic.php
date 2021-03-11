<?php

namespace App\Models;

use App\Traits\Likeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'text',
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

    //Return comments for topic
    public function comments()
    {
        return $this->hasMany(Comment::class);
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
        return $this->find($topicId)->delete();
    }

}
