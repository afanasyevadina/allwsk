<?php

namespace App\Http\Requests;

use App\Models\Session;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CreateSessionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required',
            'speaker' => 'required',
            'cost' => 'sometimes',
            'start' => 'required|date',
            'end' => 'required|date',
            'description' => 'required',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            if (
                $this->input('start') && $this->input('end')
                &&
                Session::where('room_id', $this->input('room_id'))
                    ->where(function ($query) {
                        $query->whereBetween('start', [$this->input('start'), $this->input('end')])
                            ->orWhereBetween('end', [$this->input('start'), $this->input('end')]);
                    })->exists()
            ) {
                $validator->errors()->add('room_id', 'Room already booked during this time');
            }
        });
    }
}
