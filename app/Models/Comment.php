<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Traits\HasUuid;

class Comment extends Model
{
    use HasUuid;
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'post_id',
        'comment'
    ];

    public function post() {
       return  $this->belongsTo(Post::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
