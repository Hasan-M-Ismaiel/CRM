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
            // 'user_id' => ['required', Rule::in($users)],
            'client_id' => ['required', Rule::in($clients)],
        ];
    }
}
