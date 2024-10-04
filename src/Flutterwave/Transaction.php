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
use Seunex17\FlutterwaveCi4\FlutterwaveConfig;

class Transaction extends FlutterwaveConfig
{
    private $transferFeeObjects;

    /**
     * @throws Exception
     */
    public static function refund(string $transactionId, int $amount)
    {
        $client = Services::curlrequest();

        $request = $client->request('POST', self::BASE_URL . "/transactions/{$transactionId}/refund", [
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
            throw new Exception($response->message);
        }

        return $response;
    }

    /**
     * @throws Exception
     */
    public static function list()
    {
        $client = Services::curlrequest();

        $request = $client->request('GET', self::BASE_URL . '/transactions', [
            'headers' => [
                'Authorization' => 'Bearer ' . self::secretKey(),
            ],
            'http_errors' => false,
        ]);

        $response = json_decode($request->getBody());

        if ($request->getStatusCode() !== 200) {
            throw new Exception($response->message);
        }

        return $response->data;
    }

    /**
     * @throws Exception
     */
    public static function refunds()
    {
        $client = Services::curlrequest();

        $request = $client->request('GET', self::BASE_URL . '/refunds', [
            'headers' => [
                'Authorization' => 'Bearer ' . self::secretKey(),
            ],
            'http_errors' => false,
        ]);

        $response = json_decode($request->getBody());

        if ($request->getStatusCode() !== 200) {
            if ($response->message === 'Not Found') {
                return [];
            }

            throw new Exception($response->message);
        }

        return $response->data;
    }

    /**
     * @throws Exception
     */
    public static function fees(array $data)
    {
        $instance = new self();
        $client   = Services::curlrequest();

        $request = $client->request('GET', self::BASE_URL . '/transactions/fee', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('FLUTTERWAVE_SECRET_KEY'),
            ],
            'query'       => $data,
            'http_errors' => false,
        ]);

        $response = json_decode($request->getBody());

        if ($request->getStatusCode() !== 200) {
            throw new Exception($response->message);
        }

        $instance->transferFeeObjects = $response->data;

        return $instance;
    }

    /**
     * @return mixed
     */
    public function merchantFee()
    {
        return $this->transferFeeObjects->merchant_fee;
    }

    /**
     * @return mixed
     */
    public function flutterwaveFee()
    {
        return $this->transferFeeObjects->flutterwave_fee;
    }

    /**
     * @return mixed
     */
    public function stampDutyFee()
    {
        return $this->transferFeeObjects->stamp_duty_fee;
    }
}
