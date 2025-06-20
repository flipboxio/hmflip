<?php

/**
 * @package StripeController
 * @author TechVillage <support@techvill.org>
 * @contributor Muhammed Kamrul Hasan <[kamrul.techvill@gmail.com]>
 * @created 18-01-25
 */

namespace Modules\YooKassa\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Addons\Entities\Addon;
use Modules\YooKassa\Http\Requests\YooKassaRequest;
use Modules\YooKassa\Entities\{
    YooKassa,
    YooKassaBody
};

class YooKassaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param YooKassaRequest $request
     *
     * @return mixed
     */
    public function store(YooKassaRequest $request)
    {
        $yookassaBody = new YooKassaBody($request);

        YooKassa::updateOrCreate(
            ['alias' => config('yookassa.alias')],
            [
                'name' => $request->name,
                'instruction' => $request->instruction,
                'status' => $request->status,
                'sandbox' => $request->sandbox,
                'image' => 'thumbnail.png',
                'data' => json_encode($yookassaBody)
            ]
        );

        return back()->with(['AddonStatus' => 'success', 'AddonMessage' => __('YooKassa settings updated.')]);
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
            $module = optional(YooKassa::first())->data;
        } catch (\Exception $e) {
            $module = null;
        }
        $addon = Addon::findOrFail(config('yookassa.alias'));
        return response()->json(
            [
                'html' => view('gateway::partial.form', compact('module', 'addon'))->render(),
                'status' => true
            ],
            200
        );
    }
}
