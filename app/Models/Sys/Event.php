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
    ];

    /// PRIVATE FUNCTIONS



    /// RELATIONAL FUNCTIONS

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

        $event->created_at = $value['created_at'];
        $event->updated_at = $value['updated_at'];

        return $event;

    }


    /// STATIC FUNCTIONS




}
