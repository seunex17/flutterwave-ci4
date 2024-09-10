<?php

declare(strict_types=1);
/**
 * Copyright (C) ZubDev Digital Media - All Rights Reserved
 *
 * File: VerificationTest.php
 * Author: Zubayr Ganiyu
 *   Email: <seunexseun@gmail.com>
 *   Website: https://zubdev.net
 * Date: 7/6/24
 * Time: 5:40 PM
 */

namespace unit;

use CodeIgniter\Test\CIUnitTestCase;
use Seunex17\FlutterwaveCi4\Flutterwave\Verification;

/**
 * @internal
 */
final class VerificationTest extends CIUnitTestCase
{
    public function testPaymentVerification(): void
    {
        $this->assertObjectHasProperty('data', Verification::transaction('5872857'));
    }
}
