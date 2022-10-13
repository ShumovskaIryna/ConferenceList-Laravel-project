<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'topic'=> 'required|min:2|max:255',
            'time_start'=> 'required|date',
            'time_finish'=> 'required|date',
            'description'=> 'required|string',
            'file' => 'required|file|mimes:html'
        ];
    }
}
