<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_path',
        'provider',
        'provider_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime:Y.m.d H:i',
        'updated_at' => 'datetime:Y.m.d H:i',
    ];

    protected $guard_name = 'api';

//    protected $appends = ['roles', 'permissions'];

    public function toArray()
    {
        $data = parent::toArray();

        $data['roles'] = $this->getRoleNames();
        $data['permissions'] = $this->getAllPermissions()->pluck('name');

        return $data;
    }


    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'from', 'id')->with('toContact');
    }


    public function getUserById($id)
    {
        $user = $this->findOrFail($id);
        $user->avatar_path = $user->getAvatar();
        return $user;
    }

    public function friendsOfMine()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id');
    }

    public function friendOf()
    {
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id');
    }

    public function friends()
    {
        return $this->friendsOfMine()->wherePivot('accepted', true)->get()
            ->merge($this->friendOf()->wherePivot('accepted', true)->get());
    }

    public function friendRequests()
    {
        return $this->friendsOfMine()->wherePivot('accepted', false)->get();
    }

    public function haveFriendOrRequest($id)
    {

        if (auth()->user()->friendsOfMine()->find($id) || $this->friendOf()->find($id)) {
            return true;
        } else return false;
    }

    public function friendRequest($id)
    {
        $this->friendOf()->attach($id);
    }

    public function deleteFriend($id)
    {
        $this->friendOf()->detach($id);
        $this->friendsOfMine()->detach($id);
    }

    public function uploadAvatar($file)
    {
        if (isset($this->avatar_path)) {
            Storage::disk('public')->delete($this->avatar_path);
        }
        $file_name = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('avatars', $file_name, 'public');
        $this->avatar_path = $path;
        $this->save();
    }

    public function getAvatar()
    {
        $path = $this->avatar_path;

        if (isset($path)) {
            return asset(Storage::url($path));
        }

        return $this->getDefaultAvatar();
    }

    private function getDefaultAvatar()
    {
        return asset(Storage::url('/avatars/default-avatar.jpg'));
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function getAvatarPathAttribute($path)
    {
        if (isset($path)) {
            if (explode(':', trim($path))[0] == 'https') {
                return $path;
            }
            return asset(Storage::url($path));
        }

        return asset(Storage::url('/avatars/default-avatar.jpg'));
    }

//    public function getRoleAttribute()
//    {
//        return $this->getRoleNames();
//    }
//
//    public function getPermissionAttribute()
//    {
//        return $this->getPermissionNames();
//    }
}
