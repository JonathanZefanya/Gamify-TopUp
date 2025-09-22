<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GameStoreRequest extends FormRequest
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
        if ($this->method() == 'GET') {
            return [];
        }
        return [
            'category_id' => [
                'required',
                'numeric',
                Rule::exists('categories', 'id')->where(function ($query) {
                    $query->where('type', 'game');
                }),
            ],
            'name' => 'required|min:1',
            'region' => 'required|min:1',
            'video_link' => 'nullable|url',
        ];
    }
}
