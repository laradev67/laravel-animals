<?php

declare(strict_types=1);

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Passport\Client;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Token;

/**
 * App\User.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int $is_admin
 * @property Collection|Client[] $clients
 * @property Collection|Token[] $tokens
 * @method static Builder|User whereIsAdmin($value)
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    /** @var string[] */
    protected $fillable = ['name', 'email', 'password'];

    /** @var string[] */
    protected $hidden = ['password', 'remember_token'];

    /** @var string[] */
    protected $casts = ['email_verified_at' => 'datetime'];
}
