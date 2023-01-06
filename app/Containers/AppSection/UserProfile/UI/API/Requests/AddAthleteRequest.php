<?php

namespace App\Containers\AppSection\UserProfile\UI\API\Requests;

use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Containers\AppSection\UserProfile\Traits\BorrowerTrait;
use App\Ship\Parents\Requests\Request;

class AddAthleteRequest extends Request
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
//        'account.borrower_type',
        'address.country',
        'professional.sport',
        'professional.country',
        'professional.league',
        'professional.club',
//        'company.company_sports.*'
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
            'account.first_name' => 'required|min:2|max:50',
            'account.last_name' => 'required|min:2|max:50',
            'account.email' => 'required|email',
            'address.country' => 'exists:countries,id',
            'address.street' => 'required',
            'address.city' => 'required',
            'professional.sport' => 'exists:sports,id',
            'professional.country' => 'exists:countries,id',
            'professional.league' => 'exists:sport_leagues,id',
            'professional.club' => 'exists:sport_clubs,id',
            'contact.phone' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
//            'account.borrower_type.required' => 'Invalid borrower type',
            'account.first_name.required' => 'First Name is required',
            'account.last_name.required' => 'Last Name is required',
            'acount.email' => 'The email is invalid'
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
                'isAgent',
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
