<?php

declare(strict_types=1);
/**
 * Copyright (C) ZubDev Digital Media - All Rights Reserved
 *
 * File: TransactionTest.php
 * Author: Zubayr Ganiyu
 *   Email: <seunexseun@gmail.com>
 *   Website: https://zubdev.net
 * Date: 7/6/24
 * Time: 5:11 PM
 */

namespace unit;

use CodeIgniter\Test\CIUnitTestCase;
use Exception;
use Seunex17\FlutterwaveCi4\Flutterwave\Transaction;

/**
 * @internal
 */
final class TransactionTest extends CIUnitTestCase
{
    /**
     * @throws Exception
     */
    public function testAllTransactions(): void
    {
        $transactionId = '4717164';
        $amount        = 500;

        $this->assertIsArray(Transaction::list());
    }

    /**
     * @throws Exception
     */
    public function testAllRefunds(): void
    {
        $this->assertIsArray(Transaction::refunds());
    }

    /**
     * @throws Exception
     */
    public function testTransactionFees(): void
    {
        $data = [
            'amount'   => 500,
            'currency' => 'NGN',
        ];

        $this->assertObjectHasProperty('transferFeeObjects', Transaction::fees($data));
    }
}
