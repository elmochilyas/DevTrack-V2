<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Controller already authorizes with $this->authorize('update', $project)
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|min:3',
            'description' => 'nullable|string|max:1000',
            'deadline' => 'required|date_format:Y-m-d\TH:i|after:now',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Project title is required',
            'deadline.after' => 'Deadline must be in the future',
        ];
    }
}
