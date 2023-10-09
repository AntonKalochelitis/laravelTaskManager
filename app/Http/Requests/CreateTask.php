<?php

namespace App\Http\Requests;

use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string title
 * @property string description
 * @property string status
 * @property string deadline
 */
class CreateTask extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * Валідація даних із форми створення завдання
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:' . implode(',', TaskStatus::getValues()),
            'deadline' => 'required|date',
        ];
    }
}
