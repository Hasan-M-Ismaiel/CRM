<?php

namespace App\Http\Requests;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole('admin');
        // return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $users = User::pluck('id');
        $clients= Client::pluck('id');

        return [
            'title'   => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:255'],
            'deadline' => ['required', 'date'],   
            'client_id' => ['required', Rule::in($clients)],

            //check those
            // "assigned_users"    => "required|array",
            // "assigned_users.*"  => "required|string|distinct|min:2", //least 2 characters
            // "assigned_skills"    => "required|array",
            // "assigned_skills.*"  => "required|string|distinct|min:2", //least 2 characters
            "new_skills"    => "array",
            "new_skills.*"  => "required|string|distinct|min:2|unique:skills,name", //least 2 characters
        ];
    }
}
