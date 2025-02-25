<?php

declare(strict_types=1);

namespace Seunex17\FlutterwaveCi4\Flutterwave;

use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;
use Exception;
use Seunex17\FlutterwaveCi4\Config\Flutterwave;
use Seunex17\FlutterwaveCi4\FlutterwaveConfig;

class CollectPayment extends FlutterwaveConfig
{
    /**
     * @throws Exception
     */
    public static function standard(array $data, bool $redirect = true)
    {
        $client = Services::curlrequest();
        $config = new Flutterwave();

        $request = $client->request('POST', self::BASE_URL . '/payments', [
            'headers' => [
                'Authorization' => 'Bearer ' . self::secretKey(),
            ],
            'json' => [
                'tx_ref'          => (string) $data['tx_ref'] ?? null,
                'amount'          => $data['amount'] ?? null,
                'currency'        => $data['currency'] ?? null,
                'meta'            => $data['meta'] ?? null,
                'payment_options' => $data['payment_options'] ?? null,
                'redirect_url'    => $data['redirect_url'] ?? null,
                'customer'        => [
                    'email'       => $data['customer_email'] ?? null,
                    'phonenumber' => $data['customer_phone'] ?? null,
                    'name'        => $data['customer_name'] ?? null,
                ],
                'customizations' => [
                    'title' => self::paymentTitle(),
                    'logo'  => self::paymentLogo(),
                ],
            ],
            'http_errors' => false,
        ]);

        $response = json_decode($request->getBody());

        if ($request->getStatusCode() !== 200) {
            throw new Exception($response->message);
        }

        if ($redirect) {
            return redirect()->to($response->data->link);
        }

        return json_encode($response);
    }

    /**
     * @throws Exception
     */
    public static function card(array $data)
    {
        $client = Services::curlrequest();

        $request = $client->request('POST', self::BASE_URL . '/charges?type=card', [
            'headers' => [
                'Authorization' => 'Bearer ' . self::secretKey(),
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
        $client   = Services::curlrequest();
        $requests = Services::request();
        helper('flutterwave');

        $request = $client->request('POST', self::BASE_URL . '/charges?type=bank_transfer', [
            'headers' => [
                'Authorization' => 'Bearer ' . self::secretKey(),
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
                'fullname'           => $data['fullname'] ?? null,
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
        $client   = Services::curlrequest();
        $requests = Services::request();

        $request = $client->request('POST', self::BASE_URL . '/tokenized-charges', [
            'headers' => [
                'Authorization' => 'Bearer ' . self::secretKey(),
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

    /**
     * @throws Exception
     */
    public static function mobileMoneyUganda(array $data): RedirectResponse
    {
        $client = Services::curlrequest();

        $request = $client->request('POST', self::BASE_URL . '/charges?type=mobile_money_uganda', [
            'headers' => [
                'Authorization' => 'Bearer ' . self::secretKey(),
            ],
            'json' => [
                'tx_ref'       => (string) $data['tx_ref'] ?? null,
                'amount'       => $data['amount'] ?? null,
                'currency'     => 'UGX',
                'meta'         => $data['meta'] ?? null,
                'phone_number' => $data['phone_number'] ?? null,
                'redirect_url' => $data['redirect_url'] ?? null,
                'email'        => $data['email'] ?? null,
            ],
            'http_errors' => false,
        ]);

        $response = json_decode($request->getBody());

        if ($request->getStatusCode() !== 200) {
            throw new Exception($response->message);
        }

        return redirect()->to($response->meta->authorization->redirect);
    }
}
