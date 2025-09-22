<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerSettingStoreRequest extends FormRequest
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
            'heading' => 'required',
            'title' => 'required',
            'button_name' => 'required',
            'button_link' => 'required',
            'image' => $this->routeIs('admin.banner.update') ? 'nullable|mimes:jpg,png,jpeg,webp' : 'required|mimes:jpg,png,jpeg,webp',
        ];
    }
}
