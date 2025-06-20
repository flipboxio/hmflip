<?php
namespace Infoamin\Installer\Interfaces;

interface PurchaseInterface {
	function getPurchaseStatus($domainName, $domainIp, $envatopurchasecode, $envatoUsername);
}