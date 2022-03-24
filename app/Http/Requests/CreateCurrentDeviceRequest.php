<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Http\Requests\CreateCurrentDeviceRequest;

use App\Models\CurrentDevice;

class CreateCurrentDeviceRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
			'org_id' =>'required',
			'bldg_id' => 'required',
            'serial_number' => 'required'
        ];
    }
}
