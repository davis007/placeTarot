<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only allow users to update their own profile
        return $this->user()->id === $this->route('profile');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bio' => ['nullable', 'string', 'max:1000'],
            'specialties' => ['nullable', 'array'],
            'specialties.*' => ['string', 'max:50'],
            'response_time' => ['nullable', 'string', 'max:100'],
            'is_available' => ['boolean'],
            'avatar' => ['nullable', 'image', 'max:2048'], // 2MB max
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'bio.max' => '自己紹介は1000文字以内で入力してください。',
            'specialties.*.max' => '得意な相談内容は50文字以内で入力してください。',
            'response_time.max' => '目安返信時間は100文字以内で入力してください。',
            'avatar.image' => 'アバター画像は画像ファイルを選択してください。',
            'avatar.max' => 'アバター画像は2MB以内のファイルを選択してください。',
        ];
    }
}
