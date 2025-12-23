<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Wuro\AbsenceTypes\AbsenceTypeDeleteResponse;
use Wuro\AbsenceTypes\AbsenceTypeGetResponse;
use Wuro\AbsenceTypes\AbsenceTypeListResponse;
use Wuro\AbsenceTypes\AbsenceTypeNewResponse;
use Wuro\AbsenceTypes\AbsenceTypeUpdateResponse;
use Wuro\Client;

/**
 * @internal
 */
#[CoversNothing]
final class AbsenceTypesTest extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $testUrl = getenv('TEST_API_BASE_URL') ?: 'http://127.0.0.1:4010';
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

        $result = $this->client->absenceTypes->create(name: 'Congés payés');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AbsenceTypeNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->absenceTypes->create(
            name: 'Congés payés',
            backgroundColor: '#3498db',
            backgroundColorRgb: '52, 152, 219',
            color: '#ffffff',
            icon: 'fa-umbrella-beach',
            state: 'active',
            type: 'absence',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AbsenceTypeNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->absenceTypes->retrieve('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AbsenceTypeGetResponse::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->absenceTypes->update('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AbsenceTypeUpdateResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->absenceTypes->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AbsenceTypeListResponse::class, $result);
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->absenceTypes->delete('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AbsenceTypeDeleteResponse::class, $result);
    }
}
