<?php

namespace Tests\Feature;

use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentServiceTest extends TestCase
{
    public function testGeneratePixPayment200(): void
    {
        $paymentService = new PaymentService();

        $paymentService->setCustomerId('cus_000006295204');

        $body = array(
            "billingType" => "PIX",
            "dueDate" => date_format(now(), 'Y-m-d'),
            "value" => "232.50"
        );

        $paymentService->generate($body);

        $statusCode = $paymentService->getStatusCode();

        $this->assertEquals(200, $statusCode, 'A API deve retornar status 200');
    }
}
