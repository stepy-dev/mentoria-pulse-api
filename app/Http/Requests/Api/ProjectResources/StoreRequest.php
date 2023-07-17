<?php

namespace App\Http\Requests\Api\ProjectResources;

use App\Models\ProjectResource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'type_id' => ['required', Rule::in([ProjectResource::RESOURCE_TYPE_API, ProjectResource::RESOURCE_TYPE_WEB])],
            'name' => ['required', 'max:255'],
            'method' => ['required_if:type_id,' . ProjectResource::RESOURCE_TYPE_API, 'exclude_if:type_id,' . ProjectResource::RESOURCE_TYPE_WEB,'in:GET,POST,PUT,DELETE'],
            'endpoint' => ['required', 'url'],
            'settings' => ['required_if:type_id,' . ProjectResource::RESOURCE_TYPE_API, 'exclude_if:type_id,' . ProjectResource::RESOURCE_TYPE_WEB, 'json'],
        ];
    }
}
