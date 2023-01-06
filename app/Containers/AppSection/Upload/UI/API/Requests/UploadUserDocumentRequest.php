<?php

namespace App\Containers\AppSection\Upload\UI\API\Requests;

use App\Containers\AppSection\UserProfile\Traits\AccessTrait;
use App\Containers\AppSection\UserProfile\Traits\BorrowerTrait;
use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Ship\Parents\Requests\Request;

class UploadUserDocumentRequest extends Request
{
    use AccessTrait;

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
        'user_id',
        'deal_id'
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'user_id',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'file' => 'required',
            'document_type' => 'required',
            'user_id' => 'exists:users,id'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
            'isAthletAgentAgencyOrAdmin'
        ]);
    }

    protected function prepareForValidation()
    {
        if ($this->has('nx_data')) {
            $nx_data = json_decode($this->get('nx_data'), true);
            return $this->merge($nx_data);
        }
    }
}
