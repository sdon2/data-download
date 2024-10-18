<?php

namespace App\Http\Requests\Download;

use Illuminate\Foundation\Http\FormRequest;

class SuppressionUploadRequest extends FormRequest
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
            'suppression_file' => ['required', 'file'],
            'type' => ['required', 'string'],
            'offer_id' => ['required_if:type,offer'],
        ];
    }

    public function attributes()
    {
        return [
            'suppression_file' => 'Suppression File',
            'type' => 'Suppression Type',
            'offer_id' => 'Offer Id',
        ];
    }
}
