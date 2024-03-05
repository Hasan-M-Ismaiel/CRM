<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
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
        $projects = Project::pluck('id');
        // $project = Project::findOrFail($this->project_id);
        // $projectUsers = $project->users()->pluck('users.id');


        return [
            'title'   => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:255'],
            // 'project_id' => ['sometimes', Rule::in($projects)], 
            'project_id' => ['sometimes'], 
            // 'user_id' => ['required', Rule::in($projectUsers)],
            'user_id' => ['required'],
            'status' => ['required', 'string'],
            'deadline' => 'required|date|after:now', 
        ];
    }
}
