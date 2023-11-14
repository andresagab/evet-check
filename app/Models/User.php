<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Utils\CommonUtils;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements LaratrustUser, Auditable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRolesAndPermissions;
    use \OwenIt\Auditing\Auditable;

    /// CONST

    /**
     * The user states
     */
    const STATES = [
        'A' => [
            'es_name' => 'Activo',
            'en_name' => 'Active',
            'color' => 'green',
        ],
        'D' => [
            'es_name' => 'Deshabilitado',
            'en_name' => 'Disabled',
            'color' => 'red',
        ],
    ];

    /// PROPERTIES

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'password',
    ];

    /**
     * The attributes to exclude for audit
     * @var string[]
     */
    protected $auditExclude = ['password'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /// PRIVATE FUNCTIONS



    /// RELATIONAL FUNCTIONS



    /// PUBLIC FUNCTIONS

    /**
     * get state reference
     * @return string[]
     */
    public function getState() : array
    {
        # define default type response
        $type = [
            'es_name' => 'Desconocido',
            'en_name' => 'Unknow',
            'color' => 'zinc',
        ];

        if (array_key_exists($this->state, self::STATES))
            $type = self::STATES[$this->state];

        return $type;
    }

    /**
     * return url of profile photo
     * @return string
     */
    public function getProfilePhoto() : string
    {
        # get url image with CommonUtils
        $url = CommonUtils::getImage($this->profile_photo_path);

        # if profile_photo_path is null, then use jetstream img profile photo generator
        if (!$this->profile_photo_path)
            $url = $this->profilePhotoUrl;
        # return photo
        return $url;
    }

    /**
     * get main role of current user
     * @return Role|Null
     */
    public function getRole() : Role|Null
    {
        # define default value of role
        $role = null;

        if ($this->roles()->count() > 0)
            $role = $this->roles()->first();

        return $role;
    }

    /// STATIC FUNCTIONS




}
