<?php

declare(strict_types=1);
/**
     * Copyright (C) ZubDev Digital Media - All Rights Reserved
     *
     * File: Transaction.php
     * Author: Zubayr Ganiyu
     *   Email: <seunexseun@gmail.com>
     *   Website: https://zubdev.net
     * Date: 11/7/23
     * Time: 2:48 PM
     */

namespace Seunex17\FlutterwaveCi4\Flutterwave;

use Config\Services;
use Exception;
use Seunex17\FlutterwaveCi4\Config\Flutterwave;

class Transaction
{
	/**
	 * @throws \Exception
	 */
	public static function refund(string $transactionId, int $amount)
    {
        $flutterwave = new Flutterwave();
        $client      = Services::curlrequest();

        $request = $client->request('POST', "{$flutterwave->baseUrl}/transactions/{$transactionId}/refund", [
            'headers' => [
                'Authorization' => 'Bearer ' . env('FLUTTERWAVE_SECRET_KEY'),
            ],
            'json' => [
                'amount' => $amount,
            ],
            'http_errors' => false,
        ]);

        $response = json_decode($request->getBody());

        if ($request->getStatusCode() !== 200) {
            throw new Exception($response->data);
        }

        return $response;
    }
}
