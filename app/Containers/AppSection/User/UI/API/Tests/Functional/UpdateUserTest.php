<?php

namespace App\Containers\AppSection\User\UI\API\Tests\Functional;

use App\Containers\AppSection\User\Tests\ApiTestCase;

/**
 * Class UpdateUserTest.
 *
 * @group user
 * @group api
 */
class UpdateUserTest extends ApiTestCase
{
    protected string $endpoint = 'patch@v1/users/{id}';

    protected array $access = [
        'roles' => '',
        'permissions' => 'update-users',
    ];

    public function testUpdateExistingUser(): void
    {
        $user = $this->getTestingUser();
        $data = [
            'first_name' => 'Updated First Name',
            'last_name' => 'Updated Last Name',
            'password' => 'updated#Password',
            'gender' => 'male',
            'birth' => '20151015'
        ];

        $response = $this->injectId($user->id)->makeCall($data);

        $response->assertStatus(200);
        $this->assertResponseContainKeyValue([
            'object' => 'User',
            'email' => $user->email,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'gender' => $data['gender'],
            'birth' => $data['birth']
        ]);
        $this->assertDatabaseHas('users', ['name' => $data['name']]);
    }

    public function testUpdateNonExistingUser(): void
    {
        $data = [
            'first_name' => 'Updated First Name',
            'last_name' => 'Updated Last Name',
        ];
        $fakeUserId = 7777;

        $response = $this->injectId($fakeUserId)->makeCall($data);

        $response->assertStatus(422);
        $this->assertResponseContainKeyValue([
            'message' => 'The given data was invalid.'
        ]);
    }

    public function testUpdateExistingUserWithoutData(): void
    {
        $response = $this->makeCall();

        $response->assertStatus(422);
        $this->assertResponseContainKeyValue([
            'message' => 'The given data was invalid.'
        ]);
    }

    public function testUpdateExistingUserWithEmptyValues(): void
    {
        $data = [
            'first_name' => '',
            'last_name' => '',
            'password' => '',
            'gender' => '',
            'birth' => ''
        ];

        $response = $this->makeCall($data);

        $response->assertStatus(422);
        $this->assertValidationErrorContain([
            // messages should be updated after modifying the validation rules, to pass this test
            'password' => 'The password must be at least 6 characters.',
            'first_name' => 'The first_name must be at least 2 characters.',
            'last_name' => 'The last_name must be at least 2 characters.',
            'gender' => 'The selected gender is invalid.',
            'birth' => 'The birth does not match the format Ymd.'
        ]);
    }
}
