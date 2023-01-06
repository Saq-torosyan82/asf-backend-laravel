<?php

namespace App\Containers\AppSection\UserProfile\UI\API\Requests;

use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Containers\AppSection\UserProfile\Traits\BorrowerTrait;
use App\Ship\Parents\Requests\Request;

class AddPreviousTeamsRequest extends Request
{
    use BorrowerTrait;

    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
        'roles' => PermissionType::BORROWER,
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     */
    protected array $decode = [
        'user_id', 'teams.*'
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        // 'id',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'user_id' => 'exists:users,id',
            'teams' => 'required|array',
            'teams.*' => 'exists:sport_clubs,id'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->check([
            'hasAccess', 'isAthlete|isAgent',
        ]);
    }
}
