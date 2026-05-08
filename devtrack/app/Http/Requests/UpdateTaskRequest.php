<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
 
    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'deadline'    => ['required', 'date', 'after:today'],
            'priority'    => ['required', 'in:low,medium,high'],
            'assigned_to' => ['nullable', 'integer', 'exists:users,id'],
            'status'      => ['nullable', 'in:todo,in_progress,done'],
        ];
    }
 
    public function messages(): array
    {
        return [
            'title.required'    => 'The task title is required.',
            'title.min'         => 'The title must be at least 3 characters long.',
            'deadline.required' => 'The deadline is required.',
            'deadline.after'    => 'The deadline must be a future date.',
            'priority.required' => 'The priority is required.',
            'priority.in'       => 'Invalid priority — accepted values: low, medium, high.',
            'assigned_to.exists' => 'This developer does not exist in our records.',
        ];
    }
}