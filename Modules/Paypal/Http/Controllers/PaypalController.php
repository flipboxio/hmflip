<?php

/**
 * @package PaypalController
 * @author TechVillage <support@techvill.org>
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 * @created 15-2-22
 */

namespace Modules\Paypal\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Modules\Addons\Entities\Addon;
use Modules\Gateway\Entities\Gateway;
use Modules\Paypal\Entities\{
    Paypal,
    PaypalBody
};
use Modules\Paypal\Http\Requests\PaypalRequest;

class PaypalController extends Controller
{

    public function store(PaypalRequest $request)
    {
        
        $paypalBody = new PaypalBody($request);
        Paypal::updateOrCreate(
            ['alias' => config('paypal.alias')],
            [
                'name' => $paypalBody->name,
                'instruction' => $request->instruction,
                'status' => $request->status,
                'sandbox' => $request->sandbox,
                'image' => 'thumbnail.png',
                'data' => json_encode($paypalBody)
            ]
        );

        return back()->with(['AddonStatus' => 'success', 'AddonMessage' => __('Paypal settings updated.')]);
    }

    public function edit(Request $request)
    {
        try {
            $details = Paypal::first();
            $module = $details->data;

            if( !property_exists($details, 'name' )) {
                
                $module->name = $details->name;
            } 
        } catch (\Exception $e) {
            $module = null;
        }
        $addon = Addon::findOrFail('paypal');

        return response()->json(
            [
                'html' => view('gateway::partial.form', compact('module', 'addon'))->render(),
                'status' => true
            ],
            200
        );
    }
}
