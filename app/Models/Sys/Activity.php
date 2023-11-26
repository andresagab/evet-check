<?php

namespace App\Models\Sys;

use App\Utils\CommonUtils;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Lang;
use Livewire\Wireable;
use OwenIt\Auditing\Contracts\Auditable;

class Activity extends Model implements Auditable, Wireable
{

    /// USING
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    /// PROPERTIES

    /**
     * The fillable attributes
     * @var string[]
     */
    protected $fillable = [
        'event_id',
        'author_name',
        'name',
        'slots',
        'type',
        'modality',
        'status',
        'hide',
        'date',
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
     * Load the Activity Attendances models
     * @return HasMany
     */
    public function activity_attendances() : HasMany
    {
        return $this->hasMany(ActivityAttendance::class);
    }

    /// WIRE FUNCTIONS

    /**
     * Enable attributes for livewire
     * @return array
     */
    public function toLivewire()
    {
        return [
            'id' => $this->id,
            'event_id' => $this->event_id,
            'author_name' => $this->author_name,
            'name' => $this->name,
            'slots' => $this->slots,
            'type' => $this->type,
            'modality' => $this->modality,
            'status' => $this->status,
            'hide' => $this->hide,
            'date' => $this->date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Load attributes from livewire
     * @param $value
     * @return Activity
     */
    public static function fromLivewire($value)
    {

        $activity = new Activity();

        $activity->id = $value['id'];
        $activity->event_id = $value['event_id'];
        $activity->author_name = $value['author_name'];
        $activity->name = $value['name'];
        $activity->slots = $value['slots'];
        $activity->type = $value['type'];
        $activity->modality = $value['modality'];
        $activity->status = $value['status'];
        $activity->hide = $value['hide'];
        $activity->date = $value['date'];

        $activity->created_at = $value['created_at'];
        $activity->updated_at = $value['updated_at'];

        return $activity;

    }

    /// PUBLIC FUNCTIONS

    /**
     * Get type name
     * @return string
     */
    public function get_type() : string
    {
        # define default return value with unknown message
        $return_value = __('messages.data.unknown');

        # if 'institution' is not null and not is 1, then load key value
        if ($this->type)
            $return_value = CommonUtils::getKeyValueFromArray($this->type, self::get_types()) ?? __('messages.data.unknown');

        return $return_value;
    }

    /**
     * Get modality name
     * @return string
     */
    public function get_modality() : string
    {
        # define default return value with unknown message
        $return_value = __('messages.data.unknown');

        # if 'institution' is not null and not is 1, then load key value
        if ($this->modality)
            $return_value = CommonUtils::getKeyValueFromArray($this->modality, self::get_modalities()) ?? __('messages.data.unknown');

        return $return_value;
    }

    /**
     * Get status name
     * @return string
     */
    public function get_status() : string
    {
        # define default return value with unknown message
        $return_value = __('messages.data.unknown');

        # if 'institution' is not null and not is 1, then load key value
        if ($this->status)
            $return_value = CommonUtils::getKeyValueFromArray($this->status, self::get_status_types()) ?? __('messages.data.unknown');

        return $return_value;
    }

    /**
     * Get string value of hidden
     * @return string
     */
    public function get_hidden() : string
    {
        # if 'hidden' is true
        if ($this->hide === 1)
            return __('messages.data.actions.yes');
        else
            return __('messages.data.actions.not');
    }

    /**
     * Get amount of free slots to register in this activity
     * @return int
     */
    public function get_free_slots() : int
    {
        # define free slots as 0
        $free_slots = $this->slots;
        # count attendance of activity
        $total_attendance = $this->activity_attendances()->count();
        # if total of attendance is greater than zero
        if ($total_attendance > 0)
            $free_slots = $this->slots - $total_attendance;

        return $free_slots;
    }

    /// STATIC FUNCTIONS

    /**
     * Get the array of available types
     * @return array
     */
    public static function get_types() : array
    {
        return Lang::get('messages.models.activity.types');
    }

    /**
     * Get the array of available status types
     * @return array
     */
    public static function get_status_types() : array
    {
        return Lang::get('messages.models.activity.status_types');
    }

    /**
     * Get the array of available modalities
     * @return array
     */
    public static function get_modalities() : array
    {
        return Lang::get('messages.models.activity.modalities');
    }

}
