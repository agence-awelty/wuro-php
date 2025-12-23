<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Wuro\Client;
use Wuro\Clients\ClientDeleteResponse;
use Wuro\Clients\ClientGetResponse;
use Wuro\Clients\ClientImportFromCsvResponse;
use Wuro\Clients\ClientListResponse;
use Wuro\Clients\ClientMergeResponse;
use Wuro\Clients\ClientNewResponse;
use Wuro\Clients\ClientUpdateResponse;

/**
 * @internal
 */
#[CoversNothing]
final class ClientsTest extends TestCase
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

        $result = $this->client->clients->create(name: 'name');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ClientNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->clients->create(
            name: 'name',
            address: 'address',
            addressComplement: 'address_complement',
            addressEnd: 'address_end',
            analyticalCode: 'analytical_code',
            category: 'category',
            city: 'city',
            clientCode: 'client_code',
            country: 'country',
            description: 'description',
            email: 'dev@stainless.com',
            fax: 'fax',
            mobile: 'mobile',
            nic: 'nic',
            notes: 'notes',
            phone: 'phone',
            siren: 'siren',
            tags: ['string'],
            tvaNumber: 'tva_number',
            website: 'website',
            zipCode: 'zip_code',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ClientNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->clients->retrieve('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ClientGetResponse::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->clients->update('uid', name: 'name');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ClientUpdateResponse::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->clients->update(
            'uid',
            name: 'name',
            address: 'address',
            addressComplement: 'address_complement',
            addressEnd: 'address_end',
            analyticalCode: 'analytical_code',
            category: 'category',
            city: 'city',
            clientCode: 'client_code',
            country: 'country',
            description: 'description',
            email: 'dev@stainless.com',
            fax: 'fax',
            mobile: 'mobile',
            nic: 'nic',
            notes: 'notes',
            phone: 'phone',
            siren: 'siren',
            tags: ['string'],
            tvaNumber: 'tva_number',
            website: 'website',
            zipCode: 'zip_code',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ClientUpdateResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->clients->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ClientListResponse::class, $result);
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->clients->delete('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ClientDeleteResponse::class, $result);
    }

    #[Test]
    public function testImportFromCsv(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->clients->importFromCsv();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ClientImportFromCsvResponse::class, $result);
    }

    #[Test]
    public function testMerge(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->clients->merge(source: 'source', target: 'target');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ClientMergeResponse::class, $result);
    }

    #[Test]
    public function testMergeWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->clients->merge(source: 'source', target: 'target');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ClientMergeResponse::class, $result);
    }
}
