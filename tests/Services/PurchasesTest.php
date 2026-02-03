<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Wuro\Client;
use Wuro\Core\Util;
use Wuro\Purchases\PurchaseDeleteResponse;
use Wuro\Purchases\PurchaseGetResponse;
use Wuro\Purchases\PurchaseListResponse;
use Wuro\Purchases\PurchaseNewCreditResponse;
use Wuro\Purchases\PurchaseNewResponse;
use Wuro\Purchases\PurchaseUpdateResponse;

/**
 * @internal
 */
#[CoversNothing]
final class PurchasesTest extends TestCase
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
    public function testCreate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->purchases->create();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PurchaseNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->purchases->retrieve('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PurchaseGetResponse::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->purchases->update('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PurchaseUpdateResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->purchases->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PurchaseListResponse::class, $result);
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->purchases->delete('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PurchaseDeleteResponse::class, $result);
    }

    #[Test]
    public function testCreateCredit(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->purchases->createCredit('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PurchaseNewCreditResponse::class, $result);
    }

    #[Test]
    public function testGetStats(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->purchases->getStats();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }
}
