<?php

declare(strict_types=1);

namespace Seunex17\FlutterwaveCi4\Config;

use CodeIgniter\Config\BaseConfig;

class Flutterwave extends BaseConfig
{
    /*
     * This allow you to enable dynamic settings
     * if change from flase to true your api key will no longer be loaded from env file
     * It will now be loaded from this config file
     * If you have Codeigniter4 settings install it will be used instead.
     */
    public bool $enableDynamicSettings = false;

    /*
     * Set you flutterwave public key here
     * Note: dynamic setting must be enable to use this
     */
    public string $publicKey = '';

    /*
     * Set you flutterwave secrete key here
     * Note: dynamic setting must be enable to use this
     */
    public string $secretKey = '';

    /*
      * Set you flutterwave encryption key here
      * Note: dynamic setting must be enable to use this
      */
    public string $encryptionKey = '';

    /*
      * Set you flutterwave webhook secret here
      * Note: dynamic setting must be enable to use this
      */
    public string $webhookSecret = '';

    /*
      * Set you flutterwave payment title
      * Note: dynamic setting must be enable to use this
      */
    public string $paymentTitle = '';

    /*
      * Set you flutterwave logo url here
      * Note: dynamic setting must be enable to use this
      */
    public string $paymentLogoUrl = '';
}
