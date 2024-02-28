<?php

namespace App\Http\Requests;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $users = User::pluck('id');
        $clients = Client::pluck('id');
        return [
            'title'         => ['sometimes', 'string', 'max:100'],
            'description'   => ['sometimes', 'string', 'max:255'],
            'deadline'      => ['sometimes', 'date'],   
            // 'user_id'       => ['sometimes', Rule::in($users)],
            'client_id'     => ['sometimes', Rule::in($clients)],
            'teamleader_id' => "sometimes",
            "new_skills"    => "array",
            "new_skills.*"  => "required|string|distinct|min:2|unique:skills,name",
        ];
    }
}
