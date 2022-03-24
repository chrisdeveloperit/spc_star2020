<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\MachineSpec;

class CreateMachineSpecRequest extends FormRequest
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
            'mach_make' => 'required|string',
			'model' => 'required|string',
			'min_speed' => 'nullable|sometimes|integer',
			'max_speed' => 'nullable|sometimes|integer',
			'features' => 'nullable|sometimes',
			'machine_image' => 'nullable|string',
			'life' => 'nullable|sometimes|integer'
        ];
    }
}
