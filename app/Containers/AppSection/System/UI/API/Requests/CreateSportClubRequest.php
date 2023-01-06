<?php

namespace App\Containers\AppSection\System\UI\API\Requests;

use App\Containers\AppSection\UserProfile\Traits\BorrowerTrait;
use App\Ship\Parents\Requests\Request;

class CreateSportClubRequest extends Request
{
    use BorrowerTrait;
    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     */
    protected array $decode = [
         'league_id',
         'country_id',
         'sport_id',
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
             'name' => 'required',
             'league_id' => 'required',
             'country_id' => 'required',
             'logo' => 'nullable|file',

        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->check([
            'hasAccess', 'isBorrower',
        ]);
    }
}
