<?php

/**
 * @package StripeController
 * @author TechVillage <support@techvill.org>
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 * @created 06-02-2022
 */

namespace Modules\Stripe\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Addons\Entities\Addon;
use Modules\Stripe\Entities\{Stripe, StripeBody};
use Modules\Stripe\Http\Requests\StripeRequest;


class StripeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param StripeRequest $request
     *
     * @return mixed
     */
    public function store(StripeRequest $request)
    {
        $stripeBody = new StripeBody($request);

        Stripe::updateOrCreate(
            ['alias' => 'stripe'],
            [
                'name' => $stripeBody->name,
                'instruction' => $request->instruction,
                'status' => $request->status,
                'sandbox' => $request->sandbox,
                'image' => 'thumbnail.png',
                'data' => json_encode($stripeBody)
            ]
        );

        return back()->with(['AddonStatus' => 'success', 'AddonMessage' => __('Stripe settings updated.')]);
    }


    /**
     * Returns form for the edit modal
     *
     * @param \Illuminate\Http\Request
     *
     * @return JsonResponse
     */
    public function edit(Request $request)
    {
        try {
            $details = Stripe::first();

            $module = $details->data;

            if( !property_exists($details, 'name' )) {
                
                $module->name = $details->name;
            } 

        } catch (\Exception $e) {
            $module = null;
        }
        $addon = Addon::findOrFail('stripe');
        return response()->json(
            [
                'html' => view('gateway::partial.form', compact('module', 'addon'))->render(),
                'status' => true
            ],
            200
        );
    }
}
