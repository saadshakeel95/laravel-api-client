<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriberRequest extends FormRequest
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
            'emailAddress' => 'required|email',
            'firstName' => 'nullable|string',
            'lastName' => 'nullable|string',
            'dateOfBirth' => 'required|date',
            'marketingConsent' => 'nullable|boolean',
            'message' => 'nullable|string',
            'lists' => 'nullable|array',
        ];
    }
}
