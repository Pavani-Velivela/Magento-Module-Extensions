<?php
namespace Born\SMSNotification\Observer;

use Magento\Framework\Event\ObserverInterface;

use Twilio\Rest\ClientFactory;

use Born\SMSNotification\Model\SmsFactory;

use Psr\Log\LoggerInterface;

use Magento\Framework\App\Config\ScopeConfigInterface;

use Magento\Store\Model\ScopeInterface;

class AdminOrderCancle implements ObserverInterface
{
    
    public function __construct(ClientFactory $clientFactory,ScopeConfigInterface $scopeConfig,
                                LoggerInterface $logger,
                                SmsFactory $smsFactory) 
    
    {
        
        $this->clientFactory = $clientFactory;
        $this->scopeConfig = $scopeConfig;
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
        $order = $observer->getEvent()->getOrder();
        $firstname= $order->getCustomerFirstname();
         $lastname= $order->getCustomerLastname();
         $orderid=$order->getIncrementId();
        // $order = $invoice->getOrder();

         $objectManager =   \Magento\Framework\App\ObjectManager::getInstance();
        $connection = $objectManager->get('Magento\Framework\App\ResourceConnection')
        ->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION'); 
        $body = $connection->fetchOne("SELECT template_content FROM sms_template where event_type='Admin Order Cancel'");
        $newbody= str_replace(array('{firstname}','{lastname}','{order_id}'), array($firstname, $lastname, $orderid), $body);
        
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
        catch (\Exception $e) {
            $this->logger->critical('Error message', ['exception' => $e]);
            $this->logger->info('first name', ['firstname'=> $firstname]);
            $this->logger->info('lastname', ['lastname'=> $lastname]);
            $this->logger->info('body',['Body'=> $newbody]);
        }
        
    }



    public function getGeneralConfig($value)

        {

        return $this->scopeConfig->getValue("SMSNotification/twilio/$value",ScopeInterface::SCOPE_STORE);
        }
}