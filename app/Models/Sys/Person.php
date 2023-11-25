<?php

namespace App\Models\Sys;

use App\Models\User;
use App\Utils\CommonUtils;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Livewire\Wireable;
use OwenIt\Auditing\Contracts\Auditable;
use Picqer\Barcode\BarcodeGeneratorHTML;

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

    /**
     * Load Event Attendances models
     * @return HasMany
     */
    public function event_attendances() : HasMany
    {
        return $this->hasMany(EventAttendance::class);
    }

    /**
     * Load Activity Attendances models
     * @return HasMany
     */
    public function activity_attendances() : HasMany
    {
        return $this->hasMany(ActivityAttendance::class);
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

    /**
     * Determinate if the person can be register a one activity
     * @param Activity $activity => the activity to check
     * @return bool => true if person can register activity, false if not
     */
    public function can_register_activity(Activity $activity) : bool
    {
        # define $can as true
        $can = false;

        # load attendance of received activity for current person
        $activity_attendance = ActivityAttendance::query()->where('person_id', $this->id)->where('activity_id', $activity->id)->count();
        # load free slots of activity
        $free_slots = $activity->get_free_slots();
        # other attendance_at_same_date
        $attendances_same_date = ActivityAttendance::query()
            # link to activities
            ->join('activities as a', 'activity_attendances.activity_id', '=', 'a.id')
            # filter by person
            ->where('person_id', $this->id)
            # filter by activity date
            ->where('a.date', $activity->date)
            # custom select
            ->select('activity_attendances.id')->count();

        if ($activity_attendance === 0 && $activity->status === 'O' && $free_slots > 0 && $attendances_same_date === 0)
            # set can as true
            $can = true;

        return $can;
    }

    /**
     * Get bar code as HTML
     * @return string
     */
    public function get_bar_code(string $rgb_color = 'white')
    {
        # define generator
        $generator = new BarcodeGeneratorHTML();
        return $generator->getBarcode($this->nuip, $generator::TYPE_CODE_128, foregroundColor:$rgb_color);
    }

    /// STATIC FUNCTIONS




}
