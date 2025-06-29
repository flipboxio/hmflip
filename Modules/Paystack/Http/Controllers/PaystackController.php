<?php

/**
 * @package PaystackController
 * @author TechVillage <support@techvill.org>
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 * @created 14-2-22
 */

namespace Modules\Paystack\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Addons\Entities\Addon;
use Modules\Gateway\Entities\Gateway;
use Modules\Paystack\Entities\{ Paystack, PaystackBody};
use Modules\Paystack\Http\Requests\PaystackRequest;

class PaystackController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param PaystackRequest $request
     *
     * @return mixed
     */
    public function store(PaystackRequest $request)
    {
        $paystackBody = new PaystackBody($request);

        Paystack::updateOrCreate(
            ['alias' => config('paystack.alias')],
            [
                'name' => $paystackBody->name,
                'instruction' => $request->instruction,
                'status' => $request->status,
                'sandbox' => $request->sandbox,
                'image' => 'thumbnail.png',
                'data' => json_encode($paystackBody)
            ]
        );

        return back()->with(['AddonStatus' => 'success', 'AddonMessage' => __('Paystack settings updated.')]);
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
            $details = Paystack::first();
            $module = $details->data;

            if( !property_exists($details, 'name' )) {
                
                $module->name = $details->name;
            } 
        } catch (\Exception $e) {
            $module = null;
        }
        $addon = Addon::findOrFail('paystack');

        return response()->json(
            [
                'html' => view('gateway::partial.form', compact('module', 'addon'))->render(),
                'status' => true
            ],
            200
        );
    }
}
