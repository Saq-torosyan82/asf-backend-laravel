<?php

namespace App\Containers\AppSection\User\UI\API\Tests\Functional;

use App\Containers\AppSection\User\Tests\ApiTestCase;

/**
 * Class RegisterUserTest.
 *
 * @group user
 * @group api
 */
class RegisterUserTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/register';

    protected bool $auth = false;

    protected array $access = [
        'roles' => '',
        'permissions' => '',
    ];

    public function testRegisterNewUserWithCredentials(): void
    {
        $data = [
            'email' => 'apiato@mail.test',
            'first_name' => 'Apiato',
            'last_name' => 'ASF',
            'password' => 'secretpass',
        ];

        $response = $this->makeCall($data);

        $response->assertStatus(200);
        $this->assertResponseContainKeyValue([
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
        ]);
        $responseContent = $this->getResponseContentObject();
        self::assertNotEmpty($responseContent->data);
        $this->assertDatabaseHas('users', ['email' => $data['email']]);
    }

    public function testRegisterNewUserUsingGetVerb(): void
    {
        $data = [
            'email' => 'apiato@mail.test',
            'first_name' => 'Apiato',
            'last_name' => 'ASF',
            'password' => 'secret',
        ];

        $response = $this->endpoint('get@v1/register')->makeCall($data);

        $response->assertStatus(405);
        $this->assertResponseContainKeyValue([
            'message' => 'The GET method is not supported for this route. Supported methods: POST.',
        ]);
    }

    public function testRegisterExistingUser(): void
    {
        $userDetails = [
            'email' => 'apiato@mail.test',
            'first_name' => 'Apiato',
            'last_name' => 'ASF',
            'password' => 'secret',
        ];

        $this->getTestingUser($userDetails);

        $data = [
            'email' => $userDetails['email'],
            'first_name' => 'Apiato',
            'last_name' => 'ASF',
            'password' => $userDetails['password'],
        ];

        $response = $this->makeCall($data);

        $response->assertStatus(422);
        $this->assertValidationErrorContain([
            'email' => 'The email has already been taken.',
        ]);
    }

    public function testRegisterNewUserWithoutEmail(): void
    {
        $data = [
            'first_name' => 'Apiato',
            'last_name' => 'ASF',
            'password' => 'secret',
        ];

        $response = $this->makeCall($data);

        $response->assertStatus(422);
        // assert response contain the correct message
        $this->assertValidationErrorContain([
            'email' => 'The email field is required.',
        ]);
    }

    public function testRegisterNewUserWithoutFirstName(): void
    {
        $data = [
            'email' => 'apiato@mail.test',
            'last_name' => 'ASF',
            'password' => 'secret',
        ];

        $response = $this->makeCall($data);

        $response->assertStatus(422);
        $this->assertValidationErrorContain([
            'first_name' => 'The first_name field is required.',
        ]);
    }

    public function testRegisterNewUserWithoutLastName(): void
    {
        $data = [
            'email' => 'apiato@mail.test',
            'first_name' => 'Apiato',
            'password' => 'secret',
        ];

        $response = $this->makeCall($data);

        $response->assertStatus(422);
        $this->assertValidationErrorContain([
            'last_name' => 'The last_name field is required.',
        ]);
    }

    public function testRegisterNewUserWithoutPassword(): void
    {
        $data = [
            'email' => 'apiato@mail.test',
            'first_name' => 'Apiato',
            'last_name' => 'ASF',
        ];

        $response = $this->makeCall($data);

        $response->assertStatus(422);
        $this->assertValidationErrorContain([
            'password' => 'The password field is required.',
        ]);
    }

    public function testRegisterNewUserWithInvalidEmail(): void
    {
        $data = [
            'email' => 'missing-at.test',
            'first_name' => 'Apiato',
            'last_name' => 'ASF',
            'password' => 'secret',
        ];

        $response = $this->makeCall($data);

        $response->assertStatus(422);
        $this->assertValidationErrorContain([
            'email' => 'The email must be a valid email address.',
        ]);
    }
}
