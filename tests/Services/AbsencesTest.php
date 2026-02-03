<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Wuro\Absences\AbsenceDeleteResponse;
use Wuro\Absences\AbsenceGetResponse;
use Wuro\Absences\AbsenceListResponse;
use Wuro\Absences\AbsenceNewResponse;
use Wuro\Absences\AbsenceUpdateResponse;
use Wuro\Client;
use Wuro\Core\Util;

/**
 * @internal
 */
#[CoversNothing]
final class AbsencesTest extends TestCase
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

        $result = $this->client->absences->create(
            from: new \DateTimeImmutable('2024-12-23T00:00:00.000Z'),
            to: new \DateTimeImmutable('2024-12-27T00:00:00.000Z'),
            type: 'type',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AbsenceNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->absences->create(
            from: new \DateTimeImmutable('2024-12-23T00:00:00.000Z'),
            to: new \DateTimeImmutable('2024-12-27T00:00:00.000Z'),
            type: 'type',
            fromMoment: 'half-am',
            logs: [['comment' => 'comment', 'file' => 'file']],
            positionTo: 'positionTo',
            state: 'waiting',
            toMoment: 'half-am',
            userTo: 'userTo',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AbsenceNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->absences->retrieve('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AbsenceGetResponse::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->absences->update('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AbsenceUpdateResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->absences->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AbsenceListResponse::class, $result);
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->absences->delete('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AbsenceDeleteResponse::class, $result);
    }
}
