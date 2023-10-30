<p align="center">
    <img title="Flutterwave" height="200" src="https://flutterwave.com/images/logo/full.svg" width="50%"/>
</p>

# Flutterwave v3 PHP SDK for Codeigniter 4.

![Packagist Downloads](https://img.shields.io/packagist/dt/seunex17/flutterwave-ci4)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/seunex17/flutterwave-ci4)
![GitHub stars](https://img.shields.io/github/stars/seunex17/flutterwave-ci4)
![Packagist License](https://img.shields.io/packagist/l/seunex17/flutterwave-ci4)

This Flutterwave v3 PHP Library for Codeigniter4 provides easy access to Flutterwave for Business (F4B) v3 APIs from php
apps. It abstracts the complexity involved in direct integration and allows you to make quick calls to the APIs.

Available features include:

- Collections: Card, Account, Mobile money, Bank Transfers, USSD, Barter, NQR.
-
    - Flutterwave standard payment processing.
- Payouts and Beneficiaries.
- Recurring payments: Tokenization and Subscriptions.
- Split payments
- Card issuing
- Transactions dispute management: Refunds.
- Transaction reporting: Collections, Payouts, Settlements, and Refunds.
- Bill payments: Airtime, Data bundle, Cable, Power, Toll, E-bills, and Remitta.
- Identity verification: Resolve bank account, resolve BVN information.

## Table of Contents

1. [Requirements](#requirements)
2. [Installation](#installation)
3. [Initialization](#initialization)
4. [Usage](#usage)

<a id="requirements"></a>

# Requirements

1. Flutterwave for business [API Keys](https://developer.flutterwave.com/docs/integration-guides/authentication)
2. PHP >= 7.4
3. Codeigniter4

<a id="installation"></a>

## Installation

### Installation via Composer.

To install the package via Composer, run the following command.

```shell
composer require seunex17/flutterwave-ci4
```

<a id="initialization"></a>

## Initialization

Create a .env file and follow the format of the `env` file
Save your PUBLIC_KEY, SECRET_KEY in the `.env` file

```bash
cp .env.example .env
```

Your `.env` file should look this.

```env
FLUTTERWAVE_PUBLIC_KEY=<YOUR FLUTTERWAVE PUBLIC KEY>
FLUTTERWAVE_SECRET_KEY=<YOUR FLUTTERWAVE SECRET KEY>
FLUTTERWAVE_ENCRTYPTION_KEY=<YOUR FLUTTERWAVE ENCRYPTION KEY>
FLUTTERWAVE_PAYMENT_TITLE=<YOUR BUSINESS NAME>
FLUTTERWAVE_PAYMENT_LOGO=<YOUR BUSINESS LOGO URL>
```

<a id="usage"></a>

## Usage

### Collecting payment (Flutterwave standard)

he SDK provides you with the easy methods of making collections via the hosted flutterwave standard method.

```php 
  $payment = new CollectPayment();
   $data = [
	  'tx_ref' => time(), // Can be replace with your unique ref code
	  'amount' => '500',
	  'currency' => 'NGN', // or EUR or GBP for EU Collection.
	  'meta' => [
	      'product_id' => 1,
	      'product_sku' => 'sku_1234'
	    ], // This meta param is optional just to send extra info
	  'customer_email' => 'johndoe@mail.com',
	  'customer_name' => 'John Doe',
	  'redirect_url' => base_url('verify'),
	];

	return $payment::payment($data);
```
