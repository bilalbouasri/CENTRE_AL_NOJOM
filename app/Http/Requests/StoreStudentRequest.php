<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Assuming authorization is handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('students')->ignore($this->student),
            ],
            'grade' => 'required|string',
            'joined_date' => 'required|date|before_or_equal:today',
            'notes' => 'nullable|string|max:1000',
            'subjects' => 'sometimes|array',
            'subjects.*' => 'exists:subjects,id',
        ];
    }

    /**
     * Get custom validation messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'The first name field is required.',
            'first_name.max' => 'The first name may not be greater than 255 characters.',
            'last_name.required' => 'The last name field is required.',
            'last_name.max' => 'The last name may not be greater than 255 characters.',
            'phone.required' => 'The phone number field is required.',
            'phone.unique' => 'This phone number is already registered.',
            'phone.max' => 'The phone number may not be greater than 20 characters.',
            'grade.required' => 'The grade field is required.',
            'joined_date.required' => 'The joined date field is required.',
            'joined_date.date' => 'The joined date must be a valid date.',
            'joined_date.before_or_equal' => 'The joined date cannot be in the future.',
            'notes.max' => 'The notes may not be greater than 1000 characters.',
            'subjects.array' => 'Subjects must be provided as an array.',
            'subjects.*.exists' => 'One or more selected subjects are invalid.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'first_name' => 'first name',
            'last_name' => 'last name',
            'phone' => 'phone number',
            'grade' => 'grade',
            'joined_date' => 'joined date',
            'notes' => 'notes',
            'subjects' => 'subjects',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Trim whitespace from string inputs
        $this->merge([
            'first_name' => trim($this->first_name),
            'last_name' => trim($this->last_name),
            'phone' => trim($this->phone),
            'grade' => trim($this->grade),
            'notes' => trim($this->notes),
        ]);
    }
}