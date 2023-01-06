<?php

namespace App\Containers\AppSection\User\UI\API\Tests\Functional;

use App\Containers\AppSection\User\Tests\ApiTestCase;

/**
 * Class FindUsersTest.
 *
 * @group user
 * @group api
 */
class FindUserTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/users/{id}';

    protected array $access = [
        'roles' => '',
        'permissions' => 'search-users',
    ];

    public function testFindUser(): void
    {
        $user = $this->getTestingUser();

        $response = $this->injectId($user->id)->makeCall();

        $response->assertStatus(200);
        $responseContent = $this->getResponseContentObject();
        self::assertEquals($user->first_name, $responseContent->data->first_name);
        self::assertEquals($user->last_name, $responseContent->data->last_name);
    }

    public function testFindFilteredUserResponse(): void
    {
        $user = $this->getTestingUser();

        $response = $this->injectId($user->id)->endpoint($this->endpoint . '?filter=email;first_name,last_name')->makeCall();

        $response->assertStatus(200);
        $responseContent = $this->getResponseContentObject();

        self::assertEquals($user->first_name, $responseContent->data->first_name);
        self::assertEquals($user->last_name, $responseContent->data->last_name);
        self::assertEquals($user->email, $responseContent->data->email);
        self::assertNotContains('id', json_decode($response->getContent(), true));
    }

    public function testFindUserWithRelation(): void
    {
        $user = $this->getTestingUser();

        $response = $this->injectId($user->id)->endpoint($this->endpoint . '?include=roles')->makeCall();

        $response->assertStatus(200);
        $responseContent = $this->getResponseContentObject();
        self::assertEquals($user->email, $responseContent->data->email);
        self::assertNotNull($responseContent->data->roles);
    }
}
