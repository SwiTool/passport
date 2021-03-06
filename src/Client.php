<?php

namespace Laravel\Passport;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Client extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clients';

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'personal_access_client' => 'bool',
        'password_client' => 'bool',
        'revoked' => 'bool',
    ];

    /**
     * Creates a new Client instance and sets its table name.
     *
     * @param  array  $attributes
     * @return \Laravel\Passport\Client
     */
    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->table = config('passport.prefix').$this->table;
    }

    /**
     * Get all of the authentication codes for the client.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function authCodes()
    {
        return $this->hasMany(AuthCode::class);
    }

    /**
     * Get all of the tokens that belong to the client.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tokens()
    {
        return $this->hasMany(Token::class);
    }

    /**
     * Determine if the client is a "first party" client.
     *
     * @return bool
     */
    public function firstParty()
    {
        return $this->personal_access_client || $this->password_client;
    }
}
