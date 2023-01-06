<?php

namespace App\Containers\AppSection\UserProfile\UI\API\Requests;

use App\Containers\AppSection\UserProfile\Traits\LenderDealCriteriaTrait;
use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Ship\Parents\Requests\Request;

class UpdateLenderDealCriteriaRequest extends Request
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
        'id',
        'lender_deal_criteria_id',
        'type.id',
        'min_amount.id',
        'max_amount.id',
        'min_tenor.id',
        'max_tenor.id',
        'min_interest_rate.id',
        'interest_range.id',
        'country.*.id',
        'currency.*.id',
        'sport.*.id'
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
            'lender_deal_criteria_id' => 'required|exists:lender_deal_criteria,id',
            'country' => 'required',
            'currency' => 'required',
            'sport' => 'required',
            'min_amount' => 'required',
            'min_amount.id' => 'required|exists:lender_criteria,id',
            'max_amount' => 'required',
            'max_amount.id' => 'required|exists:lender_criteria,id',
            'min_tenor' => 'required',
            'min_tenor.id' => 'required|exists:lender_criteria,id',
            'max_tenor' => 'required',
            'max_tenor.id' => 'required|exists:lender_criteria,id',
            'min_interest_rate' => 'required',
            'min_interest_rate.id' => 'required|exists:lender_criteria,id',
            'interest_range' => 'required',
            'interest_range.id' => 'required|exists:lender_criteria,id',
            'type' => 'required',
            'type.id' => 'required|exists:lender_criteria,id',
            'note' => 'max:250',
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
