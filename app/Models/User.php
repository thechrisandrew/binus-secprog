<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;

use Exception;
use App\Traits\HasUuid;

class User extends Authenticatable
{
    use HasUuid;
    use HasApiTokens, HasFactory, Notifiable;

    protected $keyType = 'string';
    public $incrementing = false;

    public function avatar() {
        $user_id = $this->id;
        $active_filesystem = config('filesystems.default');

        try {
            if(Storage::exists('public/avatars/' . $user_id . '.png')) {
                if($active_filesystem == 's3') {
                    $avatar_url = Storage::temporaryUrl('public/avatars/' . $user_id . '.png', now()->addMinutes(5));
                } else {
                    $avatar_url = Storage::url('public/avatars/' . $user_id . '.png');
                }
            } else {
                throw new Exception("Avatar not found");
            }
        }catch(Exception $e) {
            $avatar_url = "/img/default.png";
        }

        return $avatar_url;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'string',
        'email_verified_at' => 'datetime',
    ];

    public function comments() {
        return $this->hasMany(Comment::class)->whereNull('id');
    }
}
