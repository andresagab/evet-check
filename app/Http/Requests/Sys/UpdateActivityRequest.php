<?php

namespace App\Http\Requests\Sys;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateActivityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Assuming there is a permission check for editing activities
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'event_id' => ['required', 'exists:events,id'],
            'name' => ['required', 'string', 'max:250'],
            'author_name' => ['required', 'string', 'max:250'],
            'slots' => ['required', 'numeric', 'min:0', 'max:99999'],
            'type' => ['required', 'string', 'max:2'],
            'modality' => ['required', 'string', 'max:1'],
            'status' => ['required', 'string', 'max:1'],
            'hide' => ['required', 'boolean'],
            'date' => ['required', 'date'],
            'location_id' => ['required', 'exists:locations,id'],
        ];
    }
} 