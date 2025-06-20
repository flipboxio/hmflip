<?php
/**
 * @package DirectBankTransferProcessor
 * @author tehcvillage <support@techvill.org>
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @created 09-01-2023
 */
namespace Modules\DirectBankTransfer\Processor;

use Common, Validator;
use Modules\DirectBankTransfer\Response\DirectBankTransferResponse;
use Modules\Gateway\Contracts\PaymentProcessorInterface;
use Modules\Gateway\Services\GatewayHelper;

class DirectBankTransferProcessor implements PaymentProcessorInterface
{
    private $data;
    private $key;
    private $helper;
    private $help;

    /**
     * Undocumented function
     */
    public function __construct()
    {
        $this->helper = GatewayHelper::getInstance();
        $this->help = new Common;
    }


    /**
     * Handles payment for direct bank transfer.
     *
     * @param \Illuminate\Http\Request
     * @return DirectBankTransferResponse
     */
    public function pay($request)
    {

        $validate = Validator::make($request->all(), [
            'attachment' => 'required',
            'note' => 'required',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();

        }
        $attachment = $this->help->uploadMultipleImage($request, 'public/uploads/booking/');
        $charge = [
            'status' => 'succeeded',
            'amount' => Session('amount'),
            "currency" => Session('currency'),
            "attachments" => $attachment,
            "note" => $request->note,
        ];

        return new DirectBankTransferResponse($this->data, $charge);
    }
}
