<?php
namespace Born\SMSNotification\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Psr\Log\LoggerInterface;
use Twilio\Rest\ClientFactory;
class Adminordercancel implements ObserverInterface
{
	const TWILIO_SID = 'ACfcf0f9006b4eae7db26c7b4b282b70b3';
    const TWILIO_TOKEN = '974e3a1d613692694c41d96275ffa3bd';
    const TWILIO_NUMBER = '+16198285712';
    const SEND_TO_NUMBER = '+917989107422';

    private $clientFactory;
    private $logger;
	public function __construct(ClientFactory $clientFactory,LoggerInterface $logger)
	{
		$this->clientFactory = $clientFactory;
		$this->logger = $logger;
	}
	public function execute(\Magento\Framework\Event\Observer $observer)
	{
		$order = $observer->getData('order');
        $client = $this->clientFactory->create([
            'username' => self::TWILIO_SID,
            'password' => self::TWILIO_TOKEN,
        ]);
        $params = [
            'from' => self::TWILIO_NUMBER,
            'body' => $this->getBody($order),
        ];

        try {
            $client->messages->create(self::SEND_TO_NUMBER, $params);
        } catch (\Exception $e) {
            $this->logger->critical('Error message', ['exception' => $e]);
        }
	}
	public function getBody($order)
    {
		$incrementId = $order->getData('increment_id');
        $shippingDescription = $order->getData('shipping_description');
        $result = "Order cancel: #$incrementId" . PHP_EOL;
        $result .= PHP_EOL;
        $result .= "Shipping method: $shippingDescription" . PHP_EOL;
        $result .= PHP_EOL;

        foreach ($order->getData('items') as $item) {
            $qty = $item->getData('qty_ordered');
            $sku = $item->getData('sku');
            $name = $item->getData('name');
			$amount=$order->getBaseTotalDue();
            $result .= "Dear customer, Your order [$qty x $sku] $name amount $amount is cancelled." . PHP_EOL;
        }

        return $result;
    }

}