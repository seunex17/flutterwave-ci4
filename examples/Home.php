<?php

	namespace examples;

	use App\Controllers\BaseController;
	use Seunex17\FlutterwaveCi4\Flutterwave\CollectPayment;
	use Seunex17\FlutterwaveCi4\Flutterwave\Transaction;
	use Seunex17\FlutterwaveCi4\Flutterwave\Verification;
	use Seunex17\FlutterwaveCi4\Flutterwave\Webhook;

	class Home extends BaseController {
		/**
		 * @throws \Exception
		 */
		public function index()
		: \CodeIgniter\HTTP\RedirectResponse
		{
			$data = [
				'tx_ref' => time(),
				'amount' => '500',
				'currency' => 'NGN',
				'meta' => [
					'product_id' => 1,
					'product_sku' => 'sku_1234',
				],
				'customer_email' => 'johndoe@mail.com',
				'customer_name' => 'John Doe',
				'redirect_url' => base_url('verify'),
			];

			return CollectPayment::standard($data);
		}


		/**
		 * @throws \Exception
		 */
		public function verify()
		{
			if (!$txn = $this->request->getGet('transaction_id'))
			{
				// Payment was cancel by customer or another thing else.
				// Redirect user to error page
				return 'payment was cancel';
			}

			try
			{
				$response = Verification::transaction($txn);

				// After receiving response from teh flutter wave
				// you then have access to the below methods

				// ID of the transaction
				echo $response->meta()->product_id;

				//

				// the response above give you an array of the transaction report
				// You can now access each report value like this: $response->amount
				// Remember to check if amount paid is same as you product amount.
			}
			catch (\Exception $e)
			{
				return $e->getMessage();
			}
		}

		public function card()
		{
			$data = [
				'card_number' => "5531886652142950",
				'cvv' => '564',
				'expiry_month' => '09',
				'expiry_year' => '24',
				'redirect_url' => base_url('verify'),
				'currency' => 'NGN',
				'amount' => '500',
				'fullname' => 'John Doe',
				'email' => 'john@mail.com',
				'tx_ref' => time(),
			];

			echo '<pre>';
			var_dump(CollectPayment::card($data));
			echo '<pre>';
		}


		/**
		 * @throws \Exception
		 */
		public function bank()
		{
			$data = [
				'phone_number' => "070123456789",
				'narration' => 'Bank transfer',
				'currency' => 'NGN',
				'amount' => '500',
				'email' => 'john@mail.com',
				'tx_ref' => time(),
			];

			echo '<pre>';
			var_dump(CollectPayment::bankTransfer($data));
			echo '<pre>';
		}


		/**
		 * @throws \Exception
		 */
		public function token()
		{
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
		}

		public function refund()
		{
			$transactionId = "4717164";
			$amount = 500;

			echo '<pre>';
			var_dump(Transaction::refund($transactionId, $amount));
			echo '<pre>';
		}


		/**
		 * @throws \Exception
		 */
		public function allTransactions()
		{
			echo '<pre>';
			var_dump(Transaction::list());
			echo '<pre>';
		}


		/**
		 * @throws \Exception
		 */
		public function allRefunds()
		{
			echo '<pre>';
			var_dump(Transaction::refunds());
			echo '<pre>';
		}

		public function transactionFee()
		{
			$data = [
				'amount' => 500,
				'currency' => 'NGN',
			];

			//echo Transaction::fees($data)->merchantFee();
			//echo Transaction::fees($data)->flutterwaveFee();
			echo Transaction::fees($data)->stampDutyFee();
		}

		public function webhook()
		{
			// Check if webhook secret matches
			if (Webhook::verifyWebhook())
			{
				$webhookEvent = Webhook::webhookEvent();
				return Webhook::data()->status();
			}

			return [];
		}
	}
