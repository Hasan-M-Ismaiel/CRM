<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $array = array();
        $roles = (array) DB::select('select id from roles');
        $rolesArrays = json_decode(json_encode($roles), true);
        foreach ($rolesArrays as $rolesArray){
            array_push($array,$rolesArray['id']);
        }

        $collection = collect((object) $array);

        return [
            'name'          => ['required', 'string', 'max:100'],
            'email'         => ['required', 'string', 'max:255', Rule::unique('users')->ignore($this->user)],
            // 'old_password'  => ['required', 'current_password'],   
            'password'      => ['required', 'confirmed', 'min:8',Password::defaults()],   
            'role_id'       => ['required', Rule::in($collection)],
            // "new_skills"    => "array",                  //not required but you should add something like - sometimes - if presented check about that 
            // "new_skills.*"  => "string|distinct|min:2", //least 2 characters
            "new_skills"    => "array",
            "new_skills.*"  => "required|string|distinct|min:2|unique:skills,name", //least 2 characters
        ];
    }
}
