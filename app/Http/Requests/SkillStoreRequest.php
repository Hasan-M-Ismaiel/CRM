<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkillStoreRequest extends FormRequest
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
            "names"    => "required|array",
            "names.*"  => "required|string|distinct|min:2", //least 2 characters
        ];
    }

    public function withValidator ($validator)
    {
        $validator->setImplicitAttributesFormatter(function ($attribute){
            [$field, $line] = explode('.', $attribute);
            if($field == 'names'){
                return 'the skill name number ' . ($line + 1 );
            }
        });
    }
}
