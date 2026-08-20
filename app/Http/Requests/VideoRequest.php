<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'url'         => 'required|url|max:500',
            'description' => 'nullable|string',
            'gallery_id'  => 'nullable|exists:galleries,id',
        ];
    }
}
