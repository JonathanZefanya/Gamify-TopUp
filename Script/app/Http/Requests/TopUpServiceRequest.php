<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopUpServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //dd($this->request->all());
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
            'name' => 'required|min:1|max:255',
            'image' => 'nullable|mimes:jpg,png,jpeg,webp',
            'price' => 'required|numeric|min:0',
            'discount' => 'numeric|min:0',
            'discount_type' => 'string|in:percentage,flat',
        ];

    }
}
