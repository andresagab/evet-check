<?php

namespace App\Models\Sys;

use App\Models\User;
use App\Utils\CommonUtils;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Livewire\Wireable;
use OwenIt\Auditing\Contracts\Auditable;

class Person extends Model implements Auditable, Wireable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    /// CONST

    /**
     * define available sex types
     */
    const SEX_TYPES = [
        'M' => 'messages.collections.sex_types.male',
        'F' => 'messages.collections.sex_types.female',
    ];

    /// PROPERTIES

    protected $fillable = [
        'names',
        'surnames',
        'nuip',
        'sex',
        'cel',
        'phone',
        'email',
        # 'type',
        'user_id',
    ];

    /// PRIVATE FUNCTIONS

    /// LIVEWIRE FUNCTIONS

    /**
     * Enable attributes for livewire
     * @return array
     */
    public function toLivewire()
    {
        return [
            'id' => $this->id,
            'names' => $this->names,
            'surnames' => $this->surnames,
            'nuip' => $this->nuip,
            'sex' => $this->sex,
            'cel' => $this->cel,
            'phone' => $this->phone,
            'email' => $this->email,
            # 'type' => $this->type,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Load attributes from livewire
     * @param $value
     * @return Person
     */
    public static function fromLivewire($value)
    {

        $person = new Person();

        $person->id = $value['id'];
        $person->names = $value['names'];
        $person->surnames = $value['surnames'];
        $person->nuip = $value['nuip'];
        $person->sex = $value['sex'];
        $person->cel = $value['cel'];
        $person->phone = $value['phone'];
        $person->email = $value['email'];
        # $person->type = $value['type'];
        $person->user_id = $value['user_id'];
        $person->created_at = $value['created_at'];
        $person->updated_at = $value['updated_at'];

        return $person;

    }

    /// RELATIONAL FUNCTIONS

    /**
     * Load the User model
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /// PUBLIC FUNCTIONS

    /**
     * Get full name of person
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|\Illuminate\Foundation\Application|string|null
     */
    public function getFullName(): \Illuminate\Foundation\Application|array|string|\Illuminate\Contracts\Translation\Translator|\Illuminate\Contracts\Foundation\Application|null
    {
        # define full name of person
        $fullName = CommonUtils::ucwordsCustom($this->names . " " . $this->surnames);
        # if 'name' is not null
        if (!$this->names)
            $fullName = __('messages.data.unknown');
        return $fullName;
    }

    /**
     * Get sex string value
     * @return string
     */
    public function getSex() : string
    {
        # define default type value
        $type = __('messages.data.unknown');

        # if model have type
        if ($this->sex)
        {
            # if model type exist as key into TYPES, then get type translation
            if (array_key_exists($this->sex, self::SEX_TYPES))
                $type = __(self::SEX_TYPES[$this->sex]);
        }

        return $type;
    }


    /// STATIC FUNCTIONS




}
