<?php

namespace App\Containers\AppSection\UserSponsorship\UI\API\Requests;

use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Containers\AppSection\UserProfile\Traits\AccessTrait;
use App\Containers\AppSection\UserProfile\Traits\BorrowerTrait;
use App\Ship\Parents\Requests\Request;

class DeleteUserSponsorshipRequest extends Request
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
        'userId',
        'sponsorshipId'
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'userId',
        'sponsorshipId'
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // 'id' => 'required'
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
