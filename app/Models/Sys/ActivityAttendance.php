<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Livewire\Wireable;
use OwenIt\Auditing\Contracts\Auditable;

class ActivityAttendance extends Model implements Auditable, Wireable
{

    /// USING
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    /// CONST

    /**
     * The available states
     */
    const STATES = [
        'SU' => [
            'key' => 'SU',
            'key_name' => 'messages.models.activity_attendance.states.SU',
            'color' => 'blue',
        ],
        'DO' => [
            'key' => 'DO',
            'key_name' => 'messages.models.activity_attendance.states.DO',
            'color' => 'green',
        ],
        'UR' => [
            'key' => 'UR',
            'key_name' => 'messages.models.activity_attendance.states.UR',
            'color' => 'rose',
        ],
    ];

    /// PROPERTIES

    /**
     * The fillable attributes
     * @var string[]
     */
    protected $fillable = [
        'activity_id',
        'person_id',
        'state',
        'attendance_date',
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
            'activity_id' => $this->activity_id,
            'person_id' => $this->person_id,
            'state' => $this->state,
            'attendance_date' => $this->attendance_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Load attributes from livewire
     * @param $value
     * @return ActivityAttendance
     */
    public static function fromLivewire($value)
    {

        $activity_attendance = new ActivityAttendance();

        $activity_attendance->id = $value['id'];
        $activity_attendance->activity_id = $value['activity_id'];
        $activity_attendance->person_id = $value['person_id'];
        $activity_attendance->state = $value['state'];
        $activity_attendance->attendance_date = $value['attendance_date'];

        $activity_attendance->created_at = $value['created_at'];
        $activity_attendance->updated_at = $value['updated_at'];

        return $activity_attendance;

    }

    /// RELATIONAL FUNCTIONS

    /**
     * Load the Activity model
     * @return BelongsTo
     */
    public function activity() : BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    /**
     * Load the Person model
     * @return BelongsTo
     */
    public function person() : BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /// PUBLIC FUNCTIONS

    /**
     * Get state key, key_name or color
     * @param string $key => default 'all' to get an array of saved state, else only use 'key_name', 'key' or 'color'
     * @return array|string|null
     */
    public function get_state(string $key = 'all') : array|string|null
    {
        # define default return value with unknown message
        $return_value = __('messages.data.unknown');

        # if saved key isset in participation modalities array
        if (isset(self::STATES[$this->state]))
            $return_value = self::STATES[$this->state];

        # if $key not is 'all', then set return value with data at key
        if ($key != 'all' && is_array($return_value))
            $return_value = $return_value[$key];

        return $return_value;
    }

    /// STATIC FUNCTIONS


}
