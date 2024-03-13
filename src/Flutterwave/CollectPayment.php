<?php

declare(strict_types=1);

namespace Seunex17\FlutterwaveCi4\Flutterwave;

use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;
use Exception;
use Seunex17\FlutterwaveCi4\Config\Flutterwave;

class CollectPayment
{
    /**
     * @throws Exception
     */
    public static function standard(array $data): RedirectResponse
    {
        $flutterwave = new Flutterwave();
        $client      = Services::curlrequest();

        $request = $client->request('POST', "{$flutterwave->baseUrl}/payments", [
            'headers' => [
                'Authorization' => 'Bearer ' . env('FLUTTERWAVE_SECRET_KEY'),
            ],
            'json' => [
                'tx_ref'       => (string) $data['tx_ref'] ?? null,
                'amount'       => $data['amount'] ?? null,
                'currency'     => $data['currency'] ?? null,
                'meta'         => $data['meta'] ?? null,
                'redirect_url' => $data['redirect_url'] ?? null,
                'customer'     => [
                    'email'       => $data['customer_email'] ?? null,
                    'phonenumber' => $data['customer_phone'] ?? null,
                    'name'        => $data['customer_name'] ?? null,
                ],
                'customizations' => [
                    'title' => env('FLUTTERWAVE_PAYMENT_TITLE'),
                    'logo'  => env('FLUTTERWAVE_PAYMENT_LOGO'),
                ],
            ],
            'http_errors' => false,
        ]);

        $response = json_decode($request->getBody());

        if ($request->getStatusCode() !== 200) {
            throw new Exception($response->message);
        }

        return redirect()->to($response->data->link);
    }

    /**
     * @throws Exception
     */
    public static function card(array $data)
    {
        $flutterwave = new Flutterwave();
        $client      = Services::curlrequest();

        $request = $client->request('POST', "{$flutterwave->baseUrl}/charges?type=card", [
            'headers' => [
                'Authorization' => 'Bearer ' . env('FLUTTERWAVE_SECRET_KEY'),
            ],
            'json' => [
                'card_number'  => $data['card_number'] ?? null,
                'cvv'          => $data['cvv'] ?? null,
                'expiry_month' => $data['expiry_month'] ?? null,
                'expiry_year'  => $data['expiry_year'] ?? null,
                'currency'     => $data['currency'] ?? null,
                'amount'       => $data['amount'] ?? null,
                'fullname'     => $data['fullname'] ?? null,
                'email'        => $data['email'] ?? null,
                'tx_ref'       => (string) $data['tx_ref'] ?? null,
                'redirect_url' => $data['redirect_url'] ?? null,
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
    public static function bankTransfer(array $data)
    {
        $flutterwave = new Flutterwave();
        $client      = Services::curlrequest();
        $requests    = Services::request();
        helper('flutterwave');

        $request = $client->request('POST', "{$flutterwave->baseUrl}/charges?type=bank_transfer", [
            'headers' => [
                'Authorization' => 'Bearer ' . env('FLUTTERWAVE_SECRET_KEY'),
            ],
            'json' => [
                'phone_number'       => $data['phone_number'] ?? null,
                'client_ip'          => $requests->getIPAddress(),
                'device_fingerprint' => generateDeviceFingerprint(),
                'narration'          => $data['narration'] ?? null,
                'currency'           => $data['currency'] ?? null,
                'amount'             => $data['amount'] ?? null,
                'is_permanent'       => false,
                'email'              => $data['email'] ?? null,
                'tx_ref'             => (string) $data['tx_ref'] ?? null,
            ],
            'http_errors' => false,
        ]);

        $response = json_decode($request->getBody());

        if ($request->getStatusCode() !== 200) {
            throw new Exception($response->message);
        }

        return $response;
    }

    public static function tokenizeCharge(array $data)
    {
        $flutterwave = new Flutterwave();
        $client      = Services::curlrequest();
        $requests    = Services::request();

        $request = $client->request('POST', "{$flutterwave->baseUrl}/tokenized-charges", [
            'headers' => [
                'Authorization' => 'Bearer ' . env('FLUTTERWAVE_SECRET_KEY'),
            ],
            'json' => [
                'token'      => $data['token'] ?? null,
                'first_name' => $data['first_name'] ?? null,
                'last_name'  => $data['last_name'] ?? null,
                'currency'   => $data['currency'] ?? null,
                'amount'     => $data['amount'] ?? null,
                'ip'         => $requests->getIPAddress(),
                'email'      => $data['email'] ?? null,
                'tx_ref'     => (string) $data['tx_ref'] ?? null,
                'narration'  => $data['narration'] ?? null,
            ],
            'http_errors' => false,
        ]);

        $response = json_decode($request->getBody());

        if ($request->getStatusCode() !== 200) {
            throw new Exception($response->message);
        }

        return $response;
    }
}
