<?php

declare(strict_types=1);
/**
 * Copyright (C) ZubDev Digital Media - All Rights Reserved
 *
 * File: FlutterwaveConfig.php
 * Author: Zubayr Ganiyu
 *   Email: <seunexseun@gmail.com>
 *   Website: https://zubdev.net
 * Date: 10/3/24
 * Time: 11:43 AM
 */

namespace Seunex17\FlutterwaveCi4;

class FlutterwaveConfig
{
    public const BASE_URL = 'https://api.flutterwave.com/v3';

    protected static function secretKey()
    {
        $config = config('Flutterwave');
        if ($config->enableDynamicSettings) {
            return service('settings')->get('Flutterwave.secretKey');
        }

        return env('FLUTTERWAVE_SECRET_KEY');
    }

    protected static function paymentTitle()
    {
        $config = config('Flutterwave');
        if ($config->enableDynamicSettings) {
            return service('settings')->get('Flutterwave.paymentTitle');
        }

        return env('FLUTTERWAVE_PAYMENT_TITLE');
    }

    protected static function paymentLogo()
    {
        $config = config('Flutterwave');
        if ($config->enableDynamicSettings) {
            return service('settings')->get('Flutterwave.paymentLogoUrl');
        }

        return env('FLUTTERWAVE_PAYMENT_LOGO');
    }

    protected static function webhookSecret()
    {
        $config = config('Flutterwave');
        if ($config->enableDynamicSettings) {
            return service('settings')->get('Flutterwave.webhookSecret');
        }

        return env('FLUTTERWAVE_WEBHOOK_SECRET');
    }
}
