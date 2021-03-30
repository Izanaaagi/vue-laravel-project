<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function fromContact()
    {
        return $this->belongsTo(User::class, 'from', 'id');
    }

    public function toContact()
    {
        return $this->belongsTo(User::class, 'to', 'id');
    }


}
