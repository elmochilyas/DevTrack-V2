<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 
     * Note: We already check in controller with $this->authorize('create', Project::class)
     * So this just returns true. But good practice to have it.
     */
    public function authorize(): bool
    {
        return true; // Already authorized in controller
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|min:3',
            'description' => 'nullable|string|max:1000',
            'deadline' => 'required|date_format:Y-m-d\TH:i|after:now',
        ];
    }

    /**
     * Custom error messages (optional but recommended)
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Project title is required',
            'title.min' => 'Title must be at least 3 characters',
            'deadline.after' => 'Deadline must be in the future',
        ];
    }
}
