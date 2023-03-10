<?php

namespace App\Containers\AppSection\User\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

class RegisterUserRequest extends Request
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

    ];

    /**
     * Defining the URL parameters (`/stores/999/items`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [

    ];

    public function rules(): array
    {
        return [
            'email' => 'required|email|max:40|unique:users,email',
            'password' => 'required|min:8|max:30|regex:/^.*(?=.{3,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!$#%\?^@$%&-]).*$/',
            #'first_name' => 'required|min:2|max:50',
            #'last_name' => 'required|min:2|max:50',
        ];
    }

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
