<?php

/**
 * @package StripeProcessor
 * @author TechVillage <support@techvill.org>
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 * @created 06-02-2022
 */

namespace Modules\Stripe\Processor;

use Modules\Gateway\Contracts\PaymentProcessorInterface;
use Modules\Gateway\Services\GatewayHelper;
use Modules\Stripe\Entities\Stripe as StripeModel;
use Modules\Stripe\Response\StripeResponse;
use Stripe\{Charge, Stripe};
use Stripe\Exception\AuthenticationException;
use Stripe\Exception\OAuth\InvalidRequestException;


class StripeProcessor implements PaymentProcessorInterface
{
    private $token;
    private $secret;
    private $key;
    private $helper;

    public function __construct()
    {
        $this->helper = GatewayHelper::getInstance();
    }


    /**
     * Handles payment for stripe
     *
     * @param \Illuminate\Http\Request
     *
     * @return StripeResponse
     */
    public function pay($request)
    {
        $this->stripeSetup($request);
        $charge = $this->charge();
        
        return new StripeResponse($charge);
    }


    /**
     * Stripe data setup
     *
     * @param \Illuminate\Http\Request
     *
     * return mixed
     */
    private function stripeSetup($request)
    {
        try {
            
            $stripe = StripeModel::firstWhere('alias', 'stripe')->data;
            $this->secret = $stripe->clientSecret;
            $this->token = $request->stripeToken;
            Stripe::setApiKey($this->secret);

        } catch (\Exception $e) {
            throw new \Exception(__('Error while trying to setup stripe.'));
        }
    }


    /**
     * Create charge for payment
     *
     * @return mixed
     */
    private function charge()
    {
        try {
            return Charge::create([
                "amount" => round(Session('amount') * 100, 0),
                "currency" => Session('currency'),
                "source" => $this->token,
            ]);
        } catch (InvalidRequestException $e) {
            throw new \Exception(__('Payment Request failed due to some issues. Please try again later.'));
        } catch (AuthenticationException $e) {
            throw new \Exception(__('Payment Request failed due to credentials mismatch.'));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
