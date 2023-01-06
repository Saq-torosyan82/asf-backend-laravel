<?php

namespace App\Containers\AppSection\User\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

class CheckEmailAvailabilityRequest extends Request
{
    protected array $access = [
        'permissions' => '',
        'roles' => '',
    ];

    protected array $decode = [
    ];

    protected array $urlParameters = [
    ];

    public function rules(): array
    {
        return [
            'email' => 'required|email',
        ];
    }

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
