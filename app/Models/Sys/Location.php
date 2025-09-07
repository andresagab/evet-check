<?php

namespace App\Models\Sys;

use App\Utils\CommonUtils;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Livewire\Wireable;
use OwenIt\Auditing\Contracts\Auditable;

class Location extends Model implements Auditable, Wireable
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
        'name',
        'address',
        'url',
        'is_map_location',
        'active',
    ];

    /// PRIVATE FUNCTIONS



    /// RELATIONAL FUNCTIONS

    /**
     * Load the Activities models
     * @return HasMany
     */
    public function activities() : HasMany
    {
        return $this->hasMany(Activity::class);
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
            'name' => $this->name,
            'address' => $this->address,
            'url' => $this->url,
            'is_map_location' => $this->is_map_location,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Load attributes from livewire
     * @param $value
     * @return Location
     */
    public static function fromLivewire($value)
    {

        $location = new Location();

        $location->id = $value['id'];
        $location->name = $value['name'];
        $location->addres = $value['address'];
        $location->url = $value['url'];
        $location->is_map_location = $value['is_map_location'];
        $location->active = $value['active'];

        $location->created_at = $value['created_at'];
        $location->updated_at = $value['updated_at'];

        return $location;

    }

    /// PUBLIC FUNCTIONS

    /**
     * Get the active status value
     * @param string $key => default 'all' to get all values of 'active', to get a single value set it to 'value', 'key', 'key_name' or 'color'
     * @return array => default return array with 'value', 'key', 'key_name' and 'color', return a single value if argument $key is not 'all'
     */
    public function get_active(string $key = 'all') : array
    {
        return CommonUtils::get_value_data_from_array($this->active, CommonUtils::COMMON_STATUSES, $key);
    }

    /**
     * Get the is_maps_location value
     * @param string $key => default 'all' to get all values of 'is_maps_location', to get a single value set it to 'value', 'key', 'affirmation_key_name' or 'color'
     * @return array => default return array with 'value', 'key', 'affirmation_key_name' and 'color', return a single value if argument $key is not 'all'
     */
    public function get_is_maps_location(string $key = 'all') : array
    {
        return CommonUtils::get_value_data_from_array($this->is_maps_location, CommonUtils::COMMON_STATUSES, $key);
    }

    /**
     * Determinate if record can be deleted
     * @return bool
     */
    public function can_delete() : bool
    {
        $can = true;

        # if count of activity attendances is greater than zero, then can as false
        if ($this->activities()->count() > 0)
            $can = false;

        return $can;
    }
}
