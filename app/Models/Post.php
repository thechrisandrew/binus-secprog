<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Traits\HasUuid;

class Post extends Model
{
    use HasUuid;
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'message',
        'image_link',
        'like_count',
        'is_deleted',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

}
