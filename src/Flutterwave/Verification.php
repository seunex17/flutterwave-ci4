<?php

declare(strict_types=1);
/**
 * Copyright (C) ZubDev Digital Media - All Rights Reserved
 *
 * File: Verification.php
 * Author: Zubayr Ganiyu
 *   Email: <seunexseun@gmail.com>
 *   Website: https://zubdev.net
 * Date: 10/31/23
 * Time: 9:39 PM
 */

namespace Seunex17\FlutterwaveCi4\Flutterwave;

use Config\Services;
use Exception;
use Seunex17\FlutterwaveCi4\Config\Flutterwave;

class Verification
{
    /**
     * @throws Exception
     */
    public static function transaction(string $id)
    {
        $flutterwave = new Flutterwave();
        $client      = Services::curlrequest();

        $request = $client->request('GET', "{$flutterwave->baseUrl}/transactions/{$id}/verify", [
            'headers' => [
                'Authorization' => 'Bearer ' . env('FLUTTERWAVE_SECRET_KEY'),
                'Content-Type'  => 'application/json',
            ],
            'http_errors' => false,
        ]);

        $response = json_decode($request->getBody());
        if ($request->getStatusCode() !== 200) {
            throw new Exception($response->message);
        }

        return $response->data;
    }
}
