<?php

declare(strict_types=1);
/**
 * Copyright (C) ZubDev Digital Media - All Rights Reserved
 *
 * File: CollectPaymentTest.php
 * Author: Zubayr Ganiyu
 *   Email: <seunexseun@gmail.com>
 *   Website: https://zubdev.net
 * Date: 7/6/24
 * Time: 2:21 PM
 */

namespace unit;

use CodeIgniter\Test\CIUnitTestCase;
use Exception;
use Seunex17\FlutterwaveCi4\Flutterwave\CollectPayment;

/**
 * @internal
 */
final class CollectPaymentTest extends CIUnitTestCase
{
    /**
     * @throws Exception
     */
    public function testCollectStandardPayment(): void
    {
        $data = [
            'tx_ref'   => time(),
            'amount'   => '500',
            'currency' => 'NGN',
            'meta'     => [
                'product_id'  => 1,
                'product_sku' => 'sku_1234',
            ],
            'customer_email' => 'johndoe@mail.com',
            'customer_name'  => 'John Doe',
            'redirect_url'   => base_url('verify'),
        ];

        $result = new \CodeIgniter\Test\TestResponse(CollectPayment::standard($data));
        $result->assertRedirect();
    }

    public function testBankTransferPayment(): void
    {
        $data = [
            'phone_number' => '070123456789',
            'narration'    => 'Bank transfer',
            'currency'     => 'NGN',
            'amount'       => '500',
            'email'        => 'john@mail.com',
            'tx_ref'       => time(),
        ];

        $this->assertObjectHasProperty('status', CollectPayment::bankTransfer($data));
    }

    public function testTokenizePayment(): void
    {
        $data = [
            'token'      => 'flw-t1nf-2dd950bd8f3c966d5a5453128c1ed517-m03k',
            'country'    => 'NG',
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'currency'   => 'NGN',
            'tx_ref'     => time(),
            'amount'     => '500',
            'email'      => 'johndoe@mail.com',
            'narration'  => 'Cable subscription',
        ];

        $this->assertObjectHasProperty('data', CollectPayment::tokenizeCharge($data));
    }
}
