<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Wuro\Client;
use Wuro\DeliveryReceipts\DeliveryReceiptDeleteResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptGenerateHTMLResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptGetResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptListResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptNewInvoiceResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptNewResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptUpdateResponse;

/**
 * @internal
 */
#[CoversNothing]
final class DeliveryReceiptsTest extends TestCase
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

        $result = $this->client->deliveryReceipts->create(client: 'client');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DeliveryReceiptNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->deliveryReceipts->create(
            client: 'client',
            clientAddress: 'client_address',
            clientCity: 'client_city',
            clientCountry: 'client_country',
            clientEmail: 'client_email',
            clientName: 'client_name',
            clientZipCode: 'client_zip_code',
            date: new \DateTimeImmutable('2019-12-27T18:11:19.117Z'),
            lines: [
                [
                    'description' => 'description',
                    'order' => 0,
                    'quantity' => 0,
                    'reference' => 'reference',
                    'title' => 'title',
                    'type' => 'product',
                    'weight' => 0,
                ],
            ],
            shippingDate: new \DateTimeImmutable('2019-12-27T18:11:19.117Z'),
            state: 'draft',
            title: 'title',
            type: 'delivery',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DeliveryReceiptNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->deliveryReceipts->retrieve('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DeliveryReceiptGetResponse::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->deliveryReceipts->update('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DeliveryReceiptUpdateResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->deliveryReceipts->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DeliveryReceiptListResponse::class, $result);
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->deliveryReceipts->delete('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DeliveryReceiptDeleteResponse::class, $result);
    }

    #[Test]
    public function testCreateInvoice(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->deliveryReceipts->createInvoice('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DeliveryReceiptNewInvoiceResponse::class, $result);
    }

    #[Test]
    public function testGenerateHTML(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->deliveryReceipts->generateHTML('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(
            DeliveryReceiptGenerateHTMLResponse::class,
            $result
        );
    }

    #[Test]
    public function testGeneratePdf(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism doesn\'t support application/pdf responses');
        }

        $result = $this->client->deliveryReceipts->generatePdf('uid');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertIsString($result);
    }
}
