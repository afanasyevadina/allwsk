<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSessionRequest extends FormRequest
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
}
