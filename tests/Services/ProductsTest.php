<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Wuro\Client;
use Wuro\Core\Util;
use Wuro\Products\ProductDeleteResponse;
use Wuro\Products\ProductGetResponse;
use Wuro\Products\ProductImportFromCsvResponse;
use Wuro\Products\ProductListResponse;
use Wuro\Products\ProductNewResponse;
use Wuro\Products\ProductUpdateResponse;

/**
 * @internal
 */
#[CoversNothing]
final class ProductsTest extends TestCase
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

        $result = $this->client->products->create(name: 'name');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ProductNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->products->create(
            name: 'name',
            analyticalCode: 'analytical_code',
            buyingPrice: 0,
            category: 'category',
            costPrice: 0,
            description: 'description',
            ecotax: 0,
            electronic: true,
            hasSpecifications: true,
            hasStockManagement: true,
            hasVariations: true,
            isMarchandise: true,
            mandatoryMentions: 'mandatory_mentions',
            options: [['name' => 'name', 'values' => ['string']]],
            priceHt: 0,
            reference: 'reference',
            sku: 'sku',
            specifications: [
                'depth' => 0, 'height' => 0, 'weight' => 0, 'width' => 0,
            ],
            stock: [
                'forceSell' => true, 'nbAlert' => 0, 'nbMin' => 0, 'nbStock' => 0,
            ],
            suppliers: ['string'],
            tva: 'tva',
            tvaRate: 0,
            unit: 'unit',
            urlExt: 'url_ext',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ProductNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->products->retrieve('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ProductGetResponse::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->products->update('uid', name: 'name');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ProductUpdateResponse::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->products->update(
            'uid',
            name: 'name',
            analyticalCode: 'analytical_code',
            buyingPrice: 0,
            category: 'category',
            costPrice: 0,
            description: 'description',
            ecotax: 0,
            electronic: true,
            hasSpecifications: true,
            hasStockManagement: true,
            hasVariations: true,
            isMarchandise: true,
            mandatoryMentions: 'mandatory_mentions',
            options: [['name' => 'name', 'values' => ['string']]],
            priceHt: 0,
            reference: 'reference',
            sku: 'sku',
            specifications: [
                'depth' => 0, 'height' => 0, 'weight' => 0, 'width' => 0,
            ],
            stock: [
                'forceSell' => true, 'nbAlert' => 0, 'nbMin' => 0, 'nbStock' => 0,
            ],
            suppliers: ['string'],
            tva: 'tva',
            tvaRate: 0,
            unit: 'unit',
            urlExt: 'url_ext',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ProductUpdateResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->products->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ProductListResponse::class, $result);
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->products->delete('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ProductDeleteResponse::class, $result);
    }

    #[Test]
    public function testImportFromCsv(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->products->importFromCsv();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ProductImportFromCsvResponse::class, $result);
    }

    #[Test]
    public function testListVariants(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->products->listVariants('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }
}
