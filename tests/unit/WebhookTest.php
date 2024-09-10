<?php

declare(strict_types=1);
/**
 * Copyright (C) ZubDev Digital Media - All Rights Reserved
 *
 * File: WebhookTest.php
 * Author: Zubayr Ganiyu
 *   Email: <seunexseun@gmail.com>
 *   Website: https://zubdev.net
 * Date: 7/7/24
 * Time: 11:03 AM
 */

namespace unit;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
final class WebhookTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testWebhookData(): void
    {
        $headers = [
            'verif-hash'   => 'seunex',
            'Content-Type' => 'application/json',
        ];

        $arrayVar = [
            'event' => 'charge.completed',
            'data'  => [
                'id'                 => 285959875,
                'tx_ref'             => 'Links-616626414629',
                'flw_ref'            => 'PeterEkene/FLW270177170',
                'device_fingerprint' => 'a42937f4a73ce8bb8b8df14e63a2df31',
                'amount'             => 100,
                'currency'           => 'NGN',
                'charged_amount'     => 100,
                'app_fee'            => 1.4,
                'merchant_fee'       => 0,
                'processor_response' => 'Approved by Financial Institution',
                'auth_model'         => 'PIN',
                'ip'                 => '197.210.64.96',
                'narration'          => 'CARD Transaction ',
                'status'             => 'successful',
                'payment_type'       => 'card',
                'created_at'         => '2020-07-06T19:17:04.000Z',
                'account_id'         => 17321,
                'customer'           => [
                    'id'           => 215604089,
                    'name'         => 'Yemi Desola',
                    'phone_number' => null,
                    'email'        => 'user@gmail.com',
                    'created_at'   => '2020-07-06T19:17:04.000Z',
                ],
                'card' => [
                    'first_6digits' => '123456',
                    'last_4digits'  => '7889',
                    'issuer'        => 'VERVE FIRST CITY MONUMENT BANK PLC',
                    'country'       => 'NG',
                    'type'          => 'VERVE',
                    'expiry'        => '02/23',
                ],
            ],
        ];

        $result = $this->withHeaders($headers)->withBody(json_encode($arrayVar))->post('/webhook');
        $result->assertOK();
    }
}
