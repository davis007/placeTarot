<?php

namespace App\Http\Requests;

use App\Models\Consultation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateConsultationStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $consultation = $this->route('consultation');
        
        // Only the practitioner assigned to this consultation can update its status
        return $this->user()->id === $consultation->practitioner_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', 'string', 'in:accepted,rejected'],
        ];
    }

    /**
     * Validate that the consultation is in a state that can be updated.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $consultation = $this->route('consultation');
            
            if ($consultation->status !== 'pending') {
                $validator->errors()->add('status', 'このリクエストは既に処理されています。');
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
            'status.required' => 'ステータスを選択してください。',
            'status.in' => '無効なステータスが選択されました。',
        ];
    }
}
