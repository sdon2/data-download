<?php

namespace App\Http\Requests\Download;

use Illuminate\Foundation\Http\FormRequest;

class DataDownloadRequest extends FormRequest
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
            'identifier' => ['required'],
            'suppressions' => ['required', 'array'],
            'offer_id' => ['nullable', 'required_if:suppressions.offer,1']
        ];
    }

    public function messages()
    {
        return [
            'suppressions.required' => 'One of the suppressions must be selected',
            'offer_id.required_if' => 'Offer Id is required if offer suppression is selected',
        ];
    }
}