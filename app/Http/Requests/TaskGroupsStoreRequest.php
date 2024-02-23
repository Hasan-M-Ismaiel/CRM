<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskGroupsStoreRequest extends FormRequest
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
        return [
            "titles"    => "required|array",
            "titles.*"  => "required|string|min:2", //least 2 characters
            "descriptions"    => "required|array",
            "descriptions.*"  => "required|string|min:2", //least 2 characters
            "user_ids"    => "required|array",
            "user_ids.*"  => "required|integer", //least 2 characters
        ];
    }
}
