<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreConsultationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only clients can create consultation requests
        return $this->user()->isClient();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'practitioner_id' => ['required', 'integer', 'exists:users,id'],
            'title' => ['required', 'string', 'max:100'],
            'question' => ['required', 'string', 'max:2000'],
        ];
    }

    /**
     * Validate that the practitioner exists and is a practitioner.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $practitionerId = $this->input('practitioner_id');
            $practitioner = User::find($practitionerId);
            
            if (!$practitioner || !$practitioner->isPractitioner()) {
                $validator->errors()->add('practitioner_id', '指定された鑑定師は存在しないか、鑑定師ではありません。');
            }
        });
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'practitioner_id.required' => '鑑定師を選択してください。',
            'practitioner_id.exists' => '指定された鑑定師は存在しません。',
            'title.required' => '相談タイトルを入力してください。',
            'title.max' => '相談タイトルは100文字以内で入力してください。',
            'question.required' => '相談内容を入力してください。',
            'question.max' => '相談内容は2000文字以内で入力してください。',
        ];
    }
}
