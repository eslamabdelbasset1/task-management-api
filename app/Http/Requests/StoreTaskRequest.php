<?php

namespace App\Http\Requests;

use App\Enums\Priority;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category_id' => 'required|exists:categories,id',
            'priority' => ['required','string','in:' . implode(',', Priority::values())],
            'completed' => 'sometimes|boolean',
            'image_url' => 'nullable|url|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Task title is required',
            'title.max' => 'Task title cannot exceed 255 characters',
            'category_id.required' => 'Category is required',
            'category_id.exists' => 'Selected category does not exist',
            'priority.in' => 'Priority must be: ' . implode(', ', Priority::values()),
            'description.max' => 'Description cannot exceed 1000 characters',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
