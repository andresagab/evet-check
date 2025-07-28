<?php

namespace App\Http\Requests\Sys;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateEventAttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->ability('*', 'event_attendances:edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        #dd($this->attendance);
        $rules = [
            'person_id' => [
                'required',
                'exists:people,id',
                Rule::unique('event_attendances', 'person_id')->where(function ($query) {
                    return $query->where('event_id', $this->event->id);
                })->ignore($this->attendance->id)
            ],
            'institution_id' => ['required'],
            'other_institution' => ['nullable', 'string', 'max:250', 'required_if:institution_id,1'],
            'participation_modality' => ['required', 'string', 'max:2'],
            'type' => ['required', 'string', 'max:2'],
            'stay_type' => ['required', 'string', 'max:1'],
            'payment_status' => ['string', 'max:2'],
            'approve_certificate_manually' => ['boolean'],
        ];

        if (Auth::user()->ability('*', 'event_attendances:set_as_paid')) {
            $rules['payment_status'][] = 'required';
        }

        if (Auth::user()->ability('*', 'event_attendances:set_approve_certificate_manually')) {
            $rules['approve_certificate_manually'][] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'person_id.unique' => 'La persona ya está registrada en este evento',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->input('participation_modality') === 'WS' || ($this->input('participation_modality') === 'AS' && in_array($this->input('type'), ['SL', 'EL']))) {
            $this->merge([
                'stay_type' => 'P',
            ]);
        }
    }
} 