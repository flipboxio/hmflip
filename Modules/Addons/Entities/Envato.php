<?php

namespace Modules\Addons\Entities;

class Envato
{    
    /**
     * isValidPurchaseCode
     *
     * @param string $envatopurchasecode
     * @param string $domainName
     * @param string $domainIp
     * @return bool
     */
    public static function isValidPurchaseCode(string $envatopurchasecode, $domainName = null, $domainIp = null): bool
    {
        if (env('APP_ENV') !== 'production') {
            return true;
        }
        //Added curl extension check during installation
        if (!extension_loaded('curl')) {
            throw new \Exception('cURL extension seems not to be installed');
        }

        $data = array(
            'domain_name'        => is_null($domainName) ? request()->getHost() : $domainName,
            'domain_ip'          => is_null($domainIp) ? request()->ip() : $domainIp,
            'envatopurchasecode' => $envatopurchasecode,
        );

        $url = "https://envatoapi.techvill.org/";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_POSTREDIR, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);

        if ($output == 1) {
            return true;
        }
        return false;
    }
}