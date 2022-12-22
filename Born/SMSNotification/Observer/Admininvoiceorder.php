<?php
namespace Born\SMSNotification\Observer;
use Magento\Framework\Event\ObserverInterface;
use Twilio\Rest\ClientFactory;
class Admininvoiceorder implements ObserverInterface
{
	public function __construct(ClientFactory $clientFactory)
	{
		$this->clientFactory = $clientFactory;
	}
	public function execute(\Magento\Framework\Event\Observer $observer)
	{
		 //$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
		 //$logger = new \Zend\Log\Logger();
		 //$logger->addWriter($writer);
		 //$logger->info($observer->getOrder()->getRealOrderId());
		$client = $this->clientFactory->create([
			    
            'username' => "ACfcf0f9006b4eae7db26c7b4b282b70b3",
            'password' => "974e3a1d613692694c41d96275ffa3bd",
        ]);
		$params = [
			"messagingServiceSid" => "MGe2fda5d6567617649b9d081571fac95a",
			'body' => "Dear Customer, Thank you for your payment. We have received payment of your order . ",
		];
		$client->messages->create("+917989107422", $params);
	}
}