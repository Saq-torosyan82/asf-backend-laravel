<?php

namespace App\Containers\AppSection\Deal\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

class UploadRequest extends Request
{
    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
        'roles' => '',
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     */
    protected array $decode = [
        'id',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'id',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:deals,id',
            'upload_type' => 'required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->check(
            [
                'hasAccess',
            ]
        );
    }

    protected function prepareForValidation()
    {
        if ($this->has('nx_data')) {
            $nx_data = json_decode($this->get('nx_data'), true);
            return $this->merge($nx_data);
        }
    }
}
