<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'text', 'user_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y.m.d H:i',
        'updated_at' => 'datetime:Y.m.d H:i',
    ];

    //Return topic for this comment
    public function topic()
    {
        return $this->morphTo();
    }


    //Return user for this comment
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isCommentedBy($userId)
    {
        return $this->user_id == $userId;
    }

    public function deleteComment($commentId)
    {
        return $this->find($commentId)->delete();
    }
}
