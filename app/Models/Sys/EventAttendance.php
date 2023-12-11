<?php

namespace App\Models\Sys;

use App\Utils\CommonUtils;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Lang;
use Livewire\Wireable;
use OwenIt\Auditing\Contracts\Auditable;

class EventAttendance extends Model implements Auditable, Wireable
{

    /// USING
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    /// CONST

    /**
     * The available participation modalities
     */
    const PARTICIPATION_MODALITIES = [
        'AS' => [
            'key' => 'AS',
            'key_name' => 'messages.models.event_attendance.participation_modalities.AS',
            'color' => 'blue',
        ],
        'SP' => [
            'key' => 'SP',
            'key_name' => 'messages.models.event_attendance.participation_modalities.SP',
            'color' => 'violet',
        ],
        'WS' => [
            'key' => 'WS',
            'key_name' => 'messages.models.event_attendance.participation_modalities.WS',
            'color' => 'orange',
        ],
        'LE' => [
            'key' => 'LE',
            'key_name' => 'messages.models.event_attendance.participation_modalities.LE',
            'color' => 'yellow',
        ],
    ];

    /**
     * The available states
     */
    const PAYMENT_STATUSES = [
        'NP' => [
            'key' => 'NP',
            'key_name' => 'messages.models.event_attendance.payment_statuses.NP',
            'color' => 'red',
        ],
        'NA' => [
            'key' => 'NA',
            'key_name' => 'messages.models.event_attendance.payment_statuses.NA',
            'color' => 'indigo',
        ],
        'PA' => [
            'key' => 'PA',
            'key_name' => 'messages.models.event_attendance.payment_statuses.PA',
            'color' => 'green',
        ],
    ];

    /**
     * The available institutions (temporary, replace it with schema in db)
     */
    const INSTITUTIONS = [
        1 => 'Otra',
        2 => 'Corporación Universitaria Minuto de Dios',
        3 => 'Fundación Universitaria Católica "Lumen Gentium"',
        4 => 'Universidad Católica de Manizales',
        5 => 'Universidad de Córdoba',
        6 => 'Universidad de Nariño',
        7 => 'Universidad del Magdalena',
        8 => 'Universidad Distrital Francisco José de Caldas',
        9 => 'Universidad Pedagógica Nacional',
        10 => 'Universidad Pedagógica y Tecnológica de Colombia',
    ];

    /// PROPERTIES

    /**
     * The fillable attributes
     * @var string[]
     */
    protected $fillable = [
        'event_id',
        'person_id',
        'institution',
        'other_institution',
        'participation_modality',
        'type',
        'stay_type',
        'payment_status',
    ];

    /// PRIVATE FUNCTIONS



    /// RELATIONAL FUNCTIONS

    /**
     * Load the Event model
     * @return BelongsTo
     */
    public function event() : BelongsTo
    {
        return $this->belongsTo(Event::class);
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
     * Enable attributes for livewire
     * @return array
     */
    public function toLivewire()
    {
        return [
            'id' => $this->id,
            'event_id' => $this->event_id,
            'person_id' => $this->person_id,
            'institution' => $this->institution_id,
            'other_institution' => $this->other_institution,
            'participation_modality' => $this->participation_modality,
            'type' => $this->type,
            'stay_type' => $this->stay_type,
            'payment_status' => $this->payment_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Load attributes from livewire
     * @param $value
     * @return EventAttendance
     */
    public static function fromLivewire($value)
    {

        $event_attendance = new EventAttendance();

        $event_attendance->id = $value['id'];
        $event_attendance->event_id = $value['event_id'];
        $event_attendance->person_id = $value['person_id'];
        $event_attendance->institution = $value['institution'];
        $event_attendance->other_institution = $value['other_institution'];
        $event_attendance->participation_modality = $value['participation_modality'];
        $event_attendance->type = $value['type'];
        $event_attendance->stay_type = $value['stay_type'];
        $event_attendance->payment_status = $value['payment_status'];

        $event_attendance->created_at = $value['created_at'];
        $event_attendance->updated_at = $value['updated_at'];

        return $event_attendance;

    }

    /**
     * Get participation modality
     * @param string $key => default 'all' to get an array of saved participation modality, else only use 'key_name', 'key' or 'color'
     * @return array|string|null
     */
    public function get_participation_modality(string $key = 'all') : array|string|null
    {
        # define default return value with unknown message
        $return_value = __('messages.data.unknown');

        # if saved key isset in participation modalities array
        if (isset(self::PARTICIPATION_MODALITIES[$this->participation_modality]))
            $return_value = self::PARTICIPATION_MODALITIES[$this->participation_modality];

        # if $key not is 'all', then set return value with data at key
        if ($key != 'all' && is_array($return_value))
            $return_value = $return_value[$key];

        return $return_value;
    }

    /**
     * Get payment status
     * @param string $key => default 'all' to get an array of saved participation modality, else only use 'key_name', 'key' or 'color'
     * @return array|string|null
     */
    public function get_payment_status(string $key = 'all') : array|string|null
    {
        # define default return value with unknown message
        $return_value = __('messages.data.unknown');

        # if saved key isset in participation modalities array
        if (isset(self::PAYMENT_STATUSES[$this->payment_status]))
            $return_value = self::PAYMENT_STATUSES[$this->payment_status];

        # if $key not is 'all', then set return value with data at key
        if ($key != 'all' && is_array($return_value))
            $return_value = $return_value[$key];

        return $return_value;
    }

    /**
     * Get institution name
     * @return string
     */
    public function get_institution() : string
    {

        # define default return value with unknown message
        $return_value = __('messages.data.unknown');

        # if 'institution' is not null and not is 1, then load key value
        if ($this->institution_id && $this->institution_id !== 1)
            $return_value = CommonUtils::getKeyValueFromArray($this->institution_id, self::INSTITUTIONS) ?? __('messages.data.unknown');
        # else, if 'other_institution' is not null, then set return value with this
        elseif ($this->other_institution)
            $return_value = $this->other_institution;

        return $return_value;

    }

    /**
     * Get translated type name
     * @return string
     */
    public function get_type() : string
    {

        # define default return value with unknown message
        $return_value = __('messages.data.unknown');

        # load types
        $types = self::get_types();

        # if 'type' is not null
        if ($this->type)
        {
            # if isset 'type' as key in $types, then load key value
            if (isset($types[$this->type]))
                $return_value = $types[$this->type];
        }

        return $return_value;

    }

    /**
     * Get translated stay type name
     * @return string
     */
    public function get_stay_type() : string
    {

        # define default return value with unknown message
        $return_value = __('messages.data.unknown');

        # load types
        $stay_types = self::get_stay_types();

        # if 'stay_type' is not null
        if ($this->stay_type)
        {
            # if isset 'stay_type' as key in $stay_types, then load key value
            if (isset($stay_types[$this->stay_type]))
                $return_value = $stay_types[$this->stay_type];
        }

        return $return_value;

    }

    /**
     * Determinate if person of attendance can get certificate, based on participation modality, payment status and attendances in activities of event
     * @return bool
     */
    public function can_get_certificate() : bool
    {

        # define can as false
        $can = false;

        # if person not is 'assistant' and payment status is 'paid'
        if ($this->participation_modality != 'AS' && $this->payment_status === 'PA')
            $can = true;
        # else, if payment status is 'paid'
        elseif ($this->payment_status === 'PA')
        {

            # load dates of event
            $dates = $this->event->get_days();
            # define schedule array
            $schedule = [];
            # define total of hours
            $total_hours = 0;

            # loop to generate schedule
            foreach ($dates as $date)
            {
                # load hours of date
                $hours = $this->event->get_hours_by_date($date);
                # loop hours and add into schedule
                foreach ($hours as $hour)
                    $schedule[] = $hour;
                # increment total of hours
                $total_hours += count($hours);
            }

            # load total done attendance of person in activities of event
            $total_done_attendance = $this->person->get_total_activities_attendance($this->event->id, $schedule);

            # minimum percent of attendance to enable certificate
            $min_percent = $this->event->min_percent;

            # calc min percent of attendance for current event
            $min_attendance = floor(($min_percent / 100) * $total_hours);

            # set can with logical operation
            $can = $total_done_attendance >= $min_attendance;

            return $can;

        }

        return $can;

    }

    /**
     * Get activity attendances filtering by exclude of state ('SU', 'DO', 'UN')
     * @param string|null $exclude_state => the exclude state only use ('SU', 'DO', 'UN'), null to ignore
     * @param bool $data => true to get collection of data, false to get count of data
     * @return mixed
     */
    public function get_activities_by_state(string $exclude_state = null, bool $data = false): mixed
    {
        # define base query
        $query = $this->person
            # from activity attendances
            ->activity_attendances()
            # link to activities
            ->join('activities as a', 'activity_attendances.activity_id', '=', 'a.id')
            # filter by event
            ->where('a.event_id', $this->event_id)
            # not list hidden activities
            ->where('a.hide', 0)
            # when exclude state, filter by different state
            ->when($exclude_state, function ($q, string $exclude_state) {
                $q->where('activity_attendances.state', '<>', $exclude_state);
            });

        # if data is true, then return all activity attendances from db
        if ($data)
            return $query->select('activity_attendances.*')->get();
        # else, return count of activity attendances
        else
            return $query->select('activity_attendances.id')->count();
    }

    /// STATIC FUNCTIONS

    /**
     * Get the array of available types
     * @return array
     */
    public static function get_types() : array
    {
        return Lang::get('messages.models.event_attendance.types');
    }

    /**
     * Get the array of available stay types
     * @return array
     */
    public static function get_stay_types() : array
    {
        return Lang::get('messages.models.event_attendance.stay_types');
    }

}
