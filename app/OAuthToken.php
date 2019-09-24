<?php


namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OAuthToken extends Model
{
    protected $table = 'oauth_tokens';

    protected $fillable = [
        'userId', 'token', 'expiresAt'
    ];

    public function __construct(array $attributes = [])
    {
        $this->token = Str::random(60);
        $this->expiresAt = Carbon::today()->addDays(env('TOKEN_EXPIRATION_DAYS'));
        parent::__construct($attributes);
    }

    public function user()
    {
        $user = StudentUser::where(['tokenId' => $this->id])->first();

        if (!$user) {
            $user = TeacherUser::where(['tokenId' => $this->id])->first();
        }

        return $user;
    }

    public function isExpired()
    {
        return Carbon::today() === $this->expiresAt;
    }

    public function updateToken()
    {
        $this->token = Str::random(60);
        $this->expiresAt = Carbon::today()->addDays(env('TOKEN_EXPIRATION_DAYS'));
        $this->save();
    }

}