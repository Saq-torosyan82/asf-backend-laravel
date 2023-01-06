<?php

namespace App\Containers\AppSection\UserProfile\UI\API\Requests;

use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Ship\Parents\Requests\Request;

class SaveOnboardingLenderRequest extends Request
{
    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
        'roles' => PermissionType::ADMIN,
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     */
    protected array $decode = [
        'lender.type',
        'lender.country',
        'criteria.*.dealType.id',
        'criteria.*.currency.*.id',
        'criteria.*.country.*.id',
        'criteria.*.sport.*.id',
        'criteria.*.minAmount.id',
        'criteria.*.maxAmount.id',
        'criteria.*.minTenor.id',
        'criteria.*.maxTenor.id',
        'criteria.*.minInterestRate.id',
        'criteria.*.interestRange.id'
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
            'lender.email' => 'required|email',
            'lender.name' => 'required',
            'lender.type' => 'required',
            'lender.country' => 'required',
            'lender.street' => 'required',
            'lender.city' => 'required',
            'lender.zip' => 'required',
            'lender.companyRegistrationNumber' => 'required',
            'lender.phone' => 'required',
            'lender.website' => 'required',
            'contact.firstName' => 'required',
            'contact.lastName' => 'required',
            'contact.position' => 'required',
            'contact.phoneNumber' => 'required',
            'contact.officeNumber' => 'required',
            'contact.email' => 'required',
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
