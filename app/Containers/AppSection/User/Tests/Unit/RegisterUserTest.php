<?php

namespace App\Containers\AppSection\User\Tests\Unit;

use App\Containers\AppSection\User\Actions\RegisterUserAction;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\TestCase;
use App\Containers\AppSection\User\UI\API\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\App;

/**
 * Class CreateUserTest.
 *
 * @group user
 * @group unit
 */
class RegisterUserTest extends TestCase
{
    public function testCreateUser(): void
    {
        $data = [
            'email' => 'Mahmoud@test.test',
            'password' => 'so-secret',
            'first_name' => 'Mahmoud',
            'last_name' => 'John',
        ];

        $request = new RegisterUserRequest($data);
        $user = App::make(RegisterUserAction::class)->run($request);

        self::assertInstanceOf(User::class, $user);
        self::assertEquals($user->first_name, $data['first_name']);
        self::assertEquals($user->last_name, $data['last_name']);
    }
}
