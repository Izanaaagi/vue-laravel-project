<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:Y.m.d H:i',
        'updated_at' => 'datetime:Y.m.d H:i'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
