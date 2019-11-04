<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

abstract class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname'
    ];

    protected $hidden = [
        'tokenId', 'created_at', 'updated_at'
    ];

    public function getAuthToken()
    {
        $token = OAuthToken::firstOrCreate(['id' => $this->tokenId]);

        if ($token->isExpired()) {
            $token->updateToken();
        }

        if(!$this->tokenId) {
            $this->tokenId = $token->id;
            $this->save();
        }

        return $token->token;
    }
}
