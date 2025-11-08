<?php

namespace App\Http\Requests\Taks;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TaksRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:pending,in_progress,completed'],
            'due_date' => ['nullable', 'date'],
            'project_id' => ['required', 'exists:projects,id'],
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Title is required.',
            'status.required' => 'Status is required.',
            'project_id.required' => 'Project ID is required.',
            'project_id.exists' => 'Project ID does not exist.',
        ];
    }
}
