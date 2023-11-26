<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Sys\Person;
use App\Utils\CommonUtils;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Livewire\Wireable;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements LaratrustUser, Auditable, Wireable
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
        'state',
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

    /**
     * Load the Person model
     * @return HasOne
     */
    public function person() : HasOne
    {
        return $this->hasOne(Person::class);
    }

    /// PUBLIC FUNCTIONS

    /**
     * Enable attributes for livewire
     * @return array
     */
    public function toLivewire()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'state' => $this->state,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Load attributes from livewire
     * @param $value
     * @return User
     */
    public static function fromLivewire($value)
    {
        #return new static($value);
        $user = new User();

        $user->id = $value['id'];
        $user->name = $value['name'];
        $user->code = $value['code'];
        $user->state = $value['state'];
        $user->created_at = $value['created_at'];
        $user->updated_at = $value['updated_at'];

        return $user;

    }

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

    /**
     * Determinate if record can be deleted
     * @return bool
     */
    public function can_delete() : bool
    {
        # define can as true
        $can = true;

        # if count of person is greater than zero, then can as false
        if ($this->person()->count() > 0 || $this->code === env('APP_SUPERUSER_CODE'))
            $can = false;

        return $can;
    }

    /// STATIC FUNCTIONS




}
