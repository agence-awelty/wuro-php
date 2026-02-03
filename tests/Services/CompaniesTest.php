<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Wuro\Client;
use Wuro\Companies\CompanyConfirmDomainResponse;
use Wuro\Companies\CompanyGetByIDResponse;
use Wuro\Companies\CompanyGetCgvResponse;
use Wuro\Companies\CompanyGetExtraInfosResponse;
use Wuro\Companies\CompanyGetResponse;
use Wuro\Companies\CompanyListPositionsResponse;
use Wuro\Companies\CompanyNewResponse;
use Wuro\Companies\CompanyUpdateResponse;
use Wuro\Core\Util;

/**
 * @internal
 */
#[CoversNothing]
final class CompaniesTest extends TestCase
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

        $result = $this->client->companies->create(name: 'name', url: 'url');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CompanyNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->companies->create(
            name: 'name',
            url: 'url',
            addresses: [
                [
                    'city' => 'city',
                    'country' => 'country',
                    'street' => 'street',
                    'zipCode' => 'zip_code',
                ],
            ],
            commercialCourt: 'commercial_court',
            companyType: 'company_type',
            email: 'dev@stainless.com',
            nafApe: 'naf_ape',
            nic: 'nic',
            numRcs: 'num_rcs',
            numTradeDirectory: 'num_trade_directory',
            shareCapital: 0,
            siren: 'siren',
            siret: 'siret',
            tvaNumber: 'tva_number',
            website: 'website',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CompanyNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->companies->retrieve();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CompanyGetResponse::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->companies->update('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CompanyUpdateResponse::class, $result);
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->companies->delete('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testConfirmDomain(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->companies->confirmDomain('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CompanyConfirmDomainResponse::class, $result);
    }

    #[Test]
    public function testListPositions(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->companies->listPositions('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CompanyListPositionsResponse::class, $result);
    }

    #[Test]
    public function testRetrieveByID(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->companies->retrieveByID('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CompanyGetByIDResponse::class, $result);
    }

    #[Test]
    public function testRetrieveCgv(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->companies->retrieveCgv('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CompanyGetCgvResponse::class, $result);
    }

    #[Test]
    public function testRetrieveExtraInfos(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->companies->retrieveExtraInfos('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CompanyGetExtraInfosResponse::class, $result);
    }
}
