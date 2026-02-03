<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Wuro\Client;
use Wuro\Core\Util;
use Wuro\Users\UserGetByUidResponse;
use Wuro\Users\UserGetResponse;
use Wuro\Users\UserListInvitationsResponse;
use Wuro\Users\UserListNotificationsResponse;
use Wuro\Users\UserListPositionsResponse;
use Wuro\Users\UserUpdateResponse;

/**
 * @internal
 */
#[CoversNothing]
final class UsersTest extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $testUrl = Util::getenv('TEST_API_BASE_URL') ?: 'http://127.0.0.1:4010';
        $client = new Client(
            appID: 'My App ID',
            appSecret: 'My App Secret',
            baseUrl: $testUrl,
        );

        $this->client = $client;
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->users->retrieve();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserGetResponse::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->users->update('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserUpdateResponse::class, $result);
    }

    #[Test]
    public function testDeactivate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->users->deactivate('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testListInvitations(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->users->listInvitations('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserListInvitationsResponse::class, $result);
    }

    #[Test]
    public function testListNotifications(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->users->listNotifications('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserListNotificationsResponse::class, $result);
    }

    #[Test]
    public function testListPositions(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->users->listPositions('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserListPositionsResponse::class, $result);
    }

    #[Test]
    public function testRetrieveByUid(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->users->retrieveByUid('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserGetByUidResponse::class, $result);
    }
}
