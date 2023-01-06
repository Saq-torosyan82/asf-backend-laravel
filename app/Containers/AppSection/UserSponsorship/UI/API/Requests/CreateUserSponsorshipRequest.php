<?php

namespace App\Containers\AppSection\UserSponsorship\UI\API\Requests;

use App\Containers\AppSection\UserProfile\Traits\AccessTrait;
use App\Ship\Parents\Requests\Request;

class CreateUserSponsorshipRequest extends Request
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
        'id',
        'userId',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'userId',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'userId' => 'required|exists:users,id',
            'id' => 'required',
            'type' => 'required'
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
                'isAthletAgentAgencyOrAdmin'
            ]
        );
    }
}
