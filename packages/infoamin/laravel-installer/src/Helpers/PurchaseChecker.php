<?php
namespace Infoamin\Installer\Helpers;

use Infoamin\Installer\Interfaces\{PurchaseInterface, CurlRequestInterface};

class PurchaseChecker implements PurchaseInterface {

	protected $curlRequest;

    public function __construct(CurlRequestInterface $curlRequest) {
        $this->curlRequest = $curlRequest;
    }

	public function getPurchaseStatus($domainName, $domainIp, $envatopurchasecode, $envatoUsername)
    {
        if (env('APP_ENV') !== 'production') {
            return (object) [
                'status' => true,
                'data'=> md5(g_d() . 'e9bb27f750f897627caaba162c564334') . '.e9bb27f750f897627caaba162c564334'
            ];
        }
    	$data = array(
            'domain_name'        => $domainName,
            'domain_ip'          => $domainIp,
            'envatopurchasecode' => $envatopurchasecode,
            'envatoUsername' => $envatoUsername,
            'item_id' => config('installer.item_id') ?? ''
        );

        return $this->curlRequest->send($data);

    }
}
