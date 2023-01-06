<?php

namespace App\Containers\AppSection\UserProfile\UI\API\Requests;

use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Containers\AppSection\UserProfile\Traits\LenderDealCriteriaTrait;
use App\Ship\Parents\Requests\Request;

class DeleteLenderDealCriteriaRequest extends Request
{
    use LenderDealCriteriaTrait;
    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
        'roles' => PermissionType::LENDER,
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     */
    protected array $decode = [
        'lender_deal_criteria_id',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'lender_deal_criteria_id',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'lender_deal_criteria_id' => 'required|exists:lender_deal_criteria,id'
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
                'hasLenderCriteria'
            ]
        );
    }
}
