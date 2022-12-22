<?php
namespace Born\SMSNotification\Observer;

use Magento\Framework\Event\ObserverInterface;

use Magento\Framework\App\Config\ScopeConfigInterface;

use Magento\Store\Model\ScopeInterface;

use Born\SMSNotification\Model\SmsFactory;

use Psr\Log\LoggerInterface;


use Twilio\Rest\ClientFactory;

class AdminShipmentTracking implements ObserverInterface
{
    
    public function __construct(ClientFactory $clientFactory, ScopeConfigInterface $scopeConfig,
                                
                                LoggerInterface $logger,
                                SmsFactory $smsFactory, \Magento\Sales\Model\OrderFactory $orderFactory) 
    
    {
        
        $this->clientFactory = $clientFactory;
        $this->scopeConfig = $scopeConfig;
        $this->orderFactory = $orderFactory;
        $this->logger = $logger;
        $this->smsFactory=$smsFactory;
    
    }


    /**
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $shipments = $observer->getEvent();
        $shipment=$observer->getEvent->getShipment();
        $order = $shipment->getOrder();
        $firstname=$order->getCustomerFirstName();
        $lastname=$order->getCustomerLasttName();
        $order_id=$order->getIncrementId();
        $tracksCollection = $shipment->getTracksCollection();
        foreach ($tracksCollection->getItems() as $track) {
                $track_number = $track->getTrackNumber();
                $track_title = $track->getTitle();
            }
        $objectManager =   \Magento\Framework\App\ObjectManager::getInstance();
        $connection = $objectManager->get('Magento\Framework\App\ResourceConnection')
        ->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION'); 
        $body = $connection->fetchOne("SELECT template_content FROM sms_template where event_type='Admin Shipment Tracking'");
        $newbody=str_replace(array('{firstname}','{lastname}','{order_id}','{trackingtitle}', '{tracknumber}'), array($firstname, $lastname, $order_id, $track_title, $track_number), $body);
        $client = $this->clientFactory->create([
                 
                 
            'username' => $this->getGeneralConfig('adminusername'),
            'password' => $this->getGeneralConfig('adminpassword'),
        ]);
        $params = [
            'from' => $this->getGeneralConfig('msgserviceid'),
            'body' => $newbody,
        ];
        try{
            $client->messages->create($order->getShippingAddress()->getTelephone(), $params);
            $this->logger->info('body',['Body'=> $newbody]);
        }
        catch(\Exception $e) {
            $this->logger->critical('Error message', ['exception' => $e]);

        }
    }

    public function getGeneralConfig($value)

        {

        return $this->scopeConfig->getValue("SMSNotification/twilio/$value",ScopeInterface::SCOPE_STORE);
        }


}