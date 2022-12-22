<?php
namespace Born\SMSNotification\Observer;
use Magento\Framework\Event\ObserverInterface;
use Twilio\Rest\ClientFactory;
class Adminshipmentorder implements ObserverInterface
{
	public function __construct(ClientFactory $clientFactory)
	{
		$this->clientFactory = $clientFactory;
	}
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try {
            $shipment = $observer->getEvent()->getShipment();
            $tracksCollection = $shipment->getTracksCollection();

            foreach ($tracksCollection->getItems() as $track) {
                $track_number = $track->getTrackNumber();
                $carrier_name = $track->getTitle();
            }
        } catch (\Exception $e) {
        }
        $client = $this->clientFactory->create([
			    
            'username' => "ACfcf0f9006b4eae7db26c7b4b282b70b3",
            'password' => "974e3a1d613692694c41d96275ffa3bd",
        ]);
		$params = [
			"messagingServiceSid" => "MGe2fda5d6567617649b9d081571fac95a",
			'body' => "Dear Customer, Your order has been Shipped. your order tracking id $track_number ",
		];
		$client->messages->create("+917989107422", $params);
	
    }
}


?>