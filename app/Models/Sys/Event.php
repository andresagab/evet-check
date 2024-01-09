<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Livewire\Wireable;
use OwenIt\Auditing\Contracts\Auditable;

class Event extends Model implements Auditable, Wireable
{

    /// USING
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    /// CONST

    /**
     * The available states
     */
    const STATES = [
        'OP' => [
            'key' => 'OP',
            'key_name' => 'messages.models.event.states.OP',
            'color' => 'blue',
        ],
        'OG' => [
            'key' => 'OG',
            'key_name' => 'messages.models.event.states.OG',
            'color' => 'yellow',
        ],
        'CP' => [
            'key' => 'CP',
            'key_name' => 'messages.models.event.states.CP',
            'color' => 'green',
        ],
    ];

    /**
     * The available bar code positions
     */
    const BAR_CODE_POSITIONS = [
        'bottom' => 'messages.models.event.bar_code_positions.bottom',
        'top' => 'messages.models.event.bar_code_positions.top',
        'custom' => 'messages.models.event.bar_code_positions.custom',
    ];

    /// PROPERTIES

    /**
     * The fillable attributes
     * @var array
     */
    protected $fillable = [
        'name',
        'year',
        'banner_path',
        'poster_path',
        'virtual_card_path',
        'logo_path',
        'state',
        'symbolic_cost',
        'symbolic_cost',
        'certificate_path',
        'certificate_setup',
        'min_percent',
        'virtual_card_setup',
    ];

    /// PRIVATE FUNCTIONS



    /// RELATIONAL FUNCTIONS

    /**
     * Load all event attendances models
     * @return HasMany
     */
    public function event_attendances() : HasMany
    {
        return $this->hasMany(EventAttendance::class);
    }

    /**
     * Load all activities models
     * @return HasMany
     */
    public function activities() : HasMany
    {
        return $this->hasMany(Activity::class);
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
            'banner_path' => $this->banner_path,
            'poster_path' => $this->poster_path,
            'virtual_card_path' => $this->virtual_card_path,
            'logo_path' => $this->logo_path,
            'state' => $this->state,
            'symbolic_cost' => $this->symbolic_cost,
            'certificate_path' => $this->certificate_path,
            'certificate_setup' => $this->certificate_setup,
            'min_percent' => $this->min_percent,
            'virtual_card_setup' => $this->virtual_card_setup,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Load attributes from livewire
     * @param $value
     * @return Event
     */
    public static function fromLivewire($value)
    {

        $event = new Event();

        $event->id = $value['id'];
        $event->name = $value['name'];
        $event->banner_path = $value['banner_path'];
        $event->poster_path = $value['poster_path'];
        $event->virtual_card_path = $value['virtual_card_path'];
        $event->logo_path = $value['logo_path'];
        $event->state = $value['state'];
        $event->symbolic_cost = $value['symbolic_cost'];
        $event->certificate_path = $value['certificate_path'];
        $event->certificate_setup = $value['certificate_setup'];
        $event->min_percent = $value['min_percent'];
        $event->virtual_card_setup = $value['virtual_card_setup'];

        $event->created_at = $value['created_at'];
        $event->updated_at = $value['updated_at'];

        return $event;

    }

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

    /**
     * Determinate if record can be deleted
     * @return bool
     */
    public function can_delete() : bool
    {
        # define can as true
        $can = true;

        # if count of activities or event attendances is greater than zero, then can as false
        if ($this->activities()->count() > 0 || $this->event_attendances()->count() > 0)
            $can = false;

        return $can;
    }

    /**
     * Get dates of activities for current event
     * @return array
     */
    public function get_days() : array
    {

        # load activities dates of event
        return $this->activities()
            ->where('activities.hide', 0)
            ->selectRaw('DATE(activities.date) as activity_date')
            ->groupByRaw('activity_date')->orderBy('activity_date', 'ASC')->pluck('activity_date')->toArray();

    }

    /**
     * Get hour of activities by date of activity
     * @param string $date
     * @return mixed[]
     */
    public function get_hours_by_date(string $date) : array
    {
        return $this->activities()
            # filter by date
            ->whereRaw('DATE(date) = ?', $date)
            # not list hidden
            ->where('hide', 0)
            # custom select
            ->selectRaw('date')
            # group by
            ->groupByRaw('date')
            # order by
            ->orderBy('date', 'ASC')
            ->pluck('date')->toArray();
    }

    /**
     * Get the certificate setup as array
     * @return array
     */
    public function get_certificate_setup() : array
    {
        # define setup as empty array
        $setup = [];

        # if certificate_setup is not null
        if (strlen($this->certificate_setup) > 0)
            $setup = json_decode($this->certificate_setup, true);

        return $setup;
    }

    /**
     * Get the virtual card setup as array
     * @return array
     */
    public function get_virtual_card_setup() : array
    {
        # define setup as empty array
        $setup = [];

        # if virtual card setup is not null
        if (strlen($this->virtual_card_setup) > 0)
            $setup = json_decode($this->virtual_card_setup, true);

        return $setup;
    }

    /// STATIC FUNCTIONS




}
