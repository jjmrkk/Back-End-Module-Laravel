<?php

namespace App\Http\Requests\Api\Administrator\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
    	if($this->method() == 'POST')
		{
			return [
                'employee_no' => ['required', 'string', 'max:50', 'unique:user_profiles'],
	            'first_name' => ['required', 'string', 'max:50'],
	            'middle_name' => ['string', 'max:50', 'nullable'],
	            'last_name' => ['required', 'string', 'max:50'],
	            'contact_no' => ['required', 'string', 'max:50'],
	            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
				'business_unit_id' => ['required'],
				'department_id' => ['required'],
				'group_id' => [],
                'business_unit_position_id' => ['required'],
                'theme' => ['required', 'string', 'max:20']
	        ];
		}
		elseif($this->method() == 'PATCH')
		{
			return [
				'id' => ['required'],
				'employee_no' => ['required', 'string', 'max:50', 'unique:user_profiles,employee_no,' . $this->id],
	            'first_name' => ['required', 'string', 'max:50'],
	            'middle_name' => ['string', 'max:50', 'nullable'],
	            'last_name' => ['required', 'string', 'max:50'],
	            'contact_no' => ['required', 'string', 'max:50'],
	            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->id],
	            'password' => ['string', 'min:8', 'confirmed', 'nullable'],
				'business_unit_id' => ['required'],
				'department_id' => ['required'],
				'group_id' => [],
                'business_unit_position_id' => ['required'],
                'theme' => ['required', 'string', 'max:20']
	        ];
		}
    }
}
