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
            
            "deadlines"    => "required|array",
            "deadlines.*"  => "required|date|after:now",
            
            "user_ids"    => "required|array",
            "user_ids.*"  => "required|integer", //least 2 characters
        ];
    }

    public function withValidator ($validator)
    {
     $validator->setImplicitAttributesFormatter(function ($attribute){
        [$field, $line] = explode('.', $attribute);
        if($field == 'titles'){
            return 'title for task ' . ($line + 1 );
        } elseif($field == 'descriptions'){
            return 'description for task ' . ($line + 1 );
        } elseif($field == 'deadlines'){
            return 'deadlines for task ' . ($line + 1 );
        } elseif($field == 'user_ids'){
            return 'user for task ' . ($line + 1 );
        }
     });
    }

    
}
