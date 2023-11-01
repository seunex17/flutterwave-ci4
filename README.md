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
5. [Contributing](#contribution-guidelines)
6. [License](#license)

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
cp env .env
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

	return CollectPayment::standard($data);
```

### Card charge

You can also charge customer card directly from you website using the Card charge method.

```php 
   $data = [
	  'card_number' => "***************",
	  'cvv' => '564',
	  'expiry_month' => '09',
	  'expiry_year' => '24',
	  'redirect_url' => base_url('verify'),
	  'currency' => 'NGN', // or EUR or GBP for EU Collection.
	  'amount' => '500',
	  'fullname' => 'John Doe',
	  'email' => 'john@mail.com',
	  'tx_ref' => time(), // Can be replace with your unique ref code
    ];

    echo '<pre>';
    var_dump(CollectPayment::card($data));
    echo '<pre>';
```

### Verify transaction

Next after collecting payment from our customer. In the above request we set a redirect page where flutterwave will send
our user to either complete payment or cancel it.
In the redrected page (method) add this below code to verify you payment.

```php
   if (!$txn = $this->request->getGet('transaction_id'))
   {
	  // Payment was cancel by customer or another thing else.
	  // Redirect user to error page
	  return 'payment was cancel';
   }

   try
   {
	  $response = Verification::transaction($txn);
	  echo '<pre>';
	  var_dump($response);
	  echo '</pre>';

	  // the response above give you an array of the transaction report
	  // You can now access each report value like this: $response->amount
	  // Remember to check if amount paid is same as you product amount.
   }
   catch (\Exception $e)
   {
      return $e->getMessage();
   }
```

<a id="contribution-guidelines"></a>

## Contribution guidelines
this library is open for public to contribute.


<a id="license"></a>

## License

By contributing to this library, you agree that your contributions will be licensed under its [MIT license](/LICENSE).

<a id="references"></a>

## Flutterwave API  References

- [Flutterwave API Documentation](https://developer.flutterwave.com)
- [Flutterwave Dashboard](https://app.flutterwave.com)  
