<?php

namespace App\Http\Requests\Download;

use Illuminate\Foundation\Http\FormRequest;

class DataUploadRequest extends FormRequest
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
            'data_file' => ['required', 'file'],
            'isp' => ['required', 'string'],
            'list_id' => ['required', 'string', 'size:2'],
            'sub_seg_id' => ['required', 'string', 'size:2'],
            'seg_id' => ['required', 'string', 'size:5'],
        ];
    }

    public function attributes()
    {
        return [
            'data_file' => 'Data File',
            'isp' => 'ISP',
            'list_id' => 'List ID',
            'sub_seg_id' => 'Sub Segment ID',
            'seg_id' => 'Segment ID',
        ];
    }
}
