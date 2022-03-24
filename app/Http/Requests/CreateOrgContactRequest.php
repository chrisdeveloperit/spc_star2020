<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\OrgContact;

class CreateOrgContactRequest extends FormRequest
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
            //'organizations_id' => 'required|integer',
			'first_name' => 'nullable|sometimes|string',
			'last_name' => 'nullable|sometimes|string',
			//'user_name'	=> 'required',
			'buildings_id' => 'nullable|sometimes|integer'
        ];
    }
}
