<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\MachineType;
use Illuminate\Validation\Rule;

class CreateMachineTypeRequest extends FormRequest
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
            //'type_name' => ['required|unique:machine_types'],
        	'type_name' => ['required'],
        	//'type_name' => ['required', 'unique:machine_types,' . $machineType->type_name],
        
        	//'type_name' => ['required', Rule::unique('machine_types')->ignore($this->id)],
        	//'type_name' => ['required, unique:machine_types, type_name,'.$machineType->id],
			'machine_type' => ['required']
        ];
        
    }
}
