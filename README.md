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

### Tokenized Charge

the feature allow you to charge customer card. It is usually used for recurring payment. Where you can automatically
charge customer card without physical interaction.
Customer must first make a payment on your website. After the payment was successful you can securely store teh customer
card token in you database.
This token will be used to chage customer card. And take note that the token must match the customer email every time
you want to initiate a tokenized charge.

```php
  $data = [
      'token' => "flw-t1nf-2dd950bd8f3c966d5a5453128c1ed517-m03k",
      'country' => 'NG',
      'first_name' => 'John',
      'last_name' => "Doe",
      'currency' => 'NGN',
      'tx_ref' => time(),
      'amount' => '500',
      'email' => 'johndoe@mail.com',
      'narration' => 'Cable subscription'
   ];

   echo '<pre>';
   var_dump(CollectPayment::tokenizeCharge($data));
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
	  echo $response->status();

	  // the response above give you an array of the transaction report
	  // You can now access each report value like this: $response->amount
	  // Remember to check if amount paid is same as you product amount.
   }
   catch (\Exception $e)
   {
      return $e->getMessage();
   }
```

#### Available methods for accessing verified transaction

| Method            | Type   | Description                                                         |
|-------------------|--------|---------------------------------------------------------------------|
| id                | int    | Return the id of the transaction                                    |
| transactionRef    | string | Return the transaction references                                   |
| flutterwaveRef    | string | Flutterwave transaction references                                  |
| deviceFingerprint | string | Return the device fingerptin of the customer                        |
| amount            | float  | Return the amount set by the merchant                               |
| currency          | string | Return the ISO currency of the transaction                          |
| chargeAmount      | float  | Return the actual amount paid by teh customer                       |
| fee               | float  | Return the application fee impose by flutterwave on teh transaction |
| merchantFee       | float  | Return the flutterwave charged the merchant not the customer        |
| processorResponse | string | Return the payment processor response                               |
| authModel         | string | Return the payment auth model                                       |
| ipAddress         | string | Return the ip address of teh customer                               |
| narration         | string | Return the narration of the transaction                             |
| status            | string | Return the transaction status                                       |
| paymentType       | string | Retun the payment type e.g card, ussd, bank, etc                    |
| accountId         | int    | Return teh flutterwave account id number                            |
| firstCardPan      | string | Return the customer card first six digit                            |
| lastCardPan       | string | Return teh customer card last four digit                            |
| cardIssuer        | String | Return the customer card issuer                                     |
| cardCountry       | string | Return the country name of the card                                 |
| cardType          | string | Return teh customer card type                                       |
| cardToken         | string | Return the token of the  card issue by flutterwave                  |
| cardExpire        | string | Return the card expiration date                                     |
| meta              | object | Return teh customer data you set when initializing the payment      |
| amountSettled     | float  | Return the total amount settle to the merchant account              |
| customerEmail     | string | Return customer email address                                       |
| customerName      | string | Return customer full name                                           |
| customerPhone     | string | Return customer phone number                                        |

### Refund a transaction

Whenever your customer pay you, it is advisable to store the transaction information return by flutterwave.
To create a refund we needed the amount paid and transaction id (transaction_id).

```php
  $transactionId = "4717164";
  $amount = 500;

  Transaction::refund($transactionId, $amount);
```

### List all transactions

You can retrieve all transactions carried out on you flutterwave account.

```php
  $transactions = Transaction::list(); // This return an object of array.
```

### List all refunds

You can retrieve all refunded transactions carried out on you flutterwave account.

```php
  $refunds = Transaction::refunds(); // This return an object of array.
```

### Get transaction fee

This methods helps you to query the fees expected to be paid for a particular transaction. This methods only returns
fees for collections i.e. inflows.

#### Flutterwave Fee

```php
  $data = [
      'amount' => 500,
      'currency' => 'NGN',
   ];
			
  Transaction::fees($data)->flutterwaveFee();
```

#### Merchant Fee

```php
  $data = [
      'amount' => 500,
      'currency' => 'NGN',
   ];
			
  Transaction::fees($data)->merchantFee();
```

#### Stamp duty Fee

```php
  $data = [
      'amount' => 500,
      'currency' => 'NGN',
   ];
			
  Transaction::fees($data)->stampDutyFee();
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
