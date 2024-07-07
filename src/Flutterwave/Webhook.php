<?php

declare(strict_types=1);
/**
     * Copyright (C) ZubDev Digital Media - All Rights Reserved
     *
     * File: Webhook.php
     * Author: Zubayr Ganiyu
     *   Email: <seunexseun@gmail.com>
     *   Website: https://zubdev.net
     * Date: 7/7/24
     * Time: 11:01 AM
     */

namespace Seunex17\FlutterwaveCi4\Flutterwave;

use Config\Services;

class Webhook
{
    private $data;

    public static function data(): Webhook
    {
        $instance = new self();

        $request        = Services::incomingrequest();
        $receiveData    = $request->getJSON();
        $instance->data = $receiveData->data;

        return $instance;
    }

    public static function verifyWebhook(): bool
    {
        $request = Services::incomingrequest();

        if (! $request->hasHeader('verif-hash')) {
            return false;
        }

        $secret = $request->getHeaderLine('verif-hash');

        return ! ($secret !== env('FLUTTERWAVE_WEBHOOK_SECRET'));
    }

    public static function webhookEvent()
    {
        $request     = Services::incomingrequest();
        $receiveData = (object) $request->getJSON();

        return $receiveData->event;
    }

    public function id(): int
    {
        return (int) $this->data->id;
    }

    public function transactionRef(): string
    {
        return $this->data->tx_ref;
    }

    public function flutterwaveRef(): string
    {
        return $this->data->flw_ref;
    }

    public function deviceFingerprint(): string
    {
        return $this->data->device_fingerprint;
    }

    public function amount(): float
    {
        return (float) $this->data->amount;
    }

    public function currency(): string
    {
        return $this->data->currency;
    }

    public function chargeAmount(): float
    {
        return (float) $this->data->charged_amount;
    }

    public function fee(): float
    {
        return (float) $this->data->app_fee;
    }

    public function merchantFee(): float
    {
        return (float) $this->data->merchant_fee;
    }

    public function processorResponse(): string
    {
        return $this->data->processor_response;
    }

    public function authModel(): string
    {
        return $this->data->auth_model;
    }

    public function ipAddress(): string
    {
        return $this->data->ip;
    }

    public function narration(): string
    {
        return $this->data->narration;
    }

    public function status(): string
    {
        return $this->data->status;
    }

    public function paymentType(): string
    {
        return $this->data->payment_type;
    }

    public function accountId(): int
    {
        return (int) $this->data->account_id;
    }

    public function amountSettled(): float
    {
        return (float) $this->data->amount_settled;
    }

    public function firstCardPan(): ?string
    {
        return $this->data->card->first_6digits ?? null;
    }

    public function lastCardPan(): ?string
    {
        return $this->data->card->last_4digits ?? null;
    }

    public function cardIssuer(): ?string
    {
        return $this->data->card->issuer ?? null;
    }

    public function cardCountry(): ?string
    {
        return $this->data->card->country ?? null;
    }

    public function cardType(): ?string
    {
        return $this->data->card->type ?? null;
    }

    public function cardToken(): ?string
    {
        return $this->data->card->token ?? null;
    }

    public function cardExpire(): ?string
    {
        return $this->data->card->expiry ?? null;
    }

    public function meta(): object
    {
        return (object) $this->data->meta;
    }

    public function customerName(): ?string
    {
        return $this->data->customer->name ?? null;
    }

    public function customerEmail(): string
    {
        return $this->data->customer->email;
    }

    public function customerPhone(): ?string
    {
        return $this->data->customer->phone_number ?? null;
    }
}
