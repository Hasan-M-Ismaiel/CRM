<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileStoreRequest extends FormRequest
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
            'nickname'          => ['required', 'string', 'max:100'],
            'gender'            => ['required', 'string', 'max:100'],
            'age'               => ['required', 'numeric'],   
            'phone_number'      => ['required', 'numeric'],
            'city'              => ['required', 'string', 'max:100'],
            'country'           => ['required', 'string', 'max:100'],
            'postal_code'       => ['required', 'numeric'],
            'facebook_account'  => ['required', 'string', 'max:100'],
            'linkedin_account'  => ['required', 'string', 'max:100'],
            'github_account'    => ['required', 'string', 'max:100'],
            'twitter_account'   => ['required', 'string', 'max:100'],
            'instagram_account' => ['required', 'string', 'max:100'],
            'description'       => ['required', 'string', 'max:100'],
        ];
    }
}