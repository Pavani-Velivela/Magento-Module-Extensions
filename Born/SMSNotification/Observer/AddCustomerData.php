<?php

namespace Born\SMSNotification\Observer;

use Magento\Framework\Event\ObserverInterface;

use Magento\Framework\App\Config\ScopeConfigInterface;

use Magento\Store\Model\ScopeInterface;

use Twilio\Rest\ClientFactory;

use Born\SMSNotification\Model\SmsFactory;

use Psr\Log\LoggerInterface;


class AddCustomerData implements ObserverInterface
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
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        
        $customer = $observer->getEvent()->getCustomer();
        $admin_number =  \Magento\Framework\App\ObjectManager::getInstance()
        ->get(\Magento\Framework\App\Config\ScopeConfigInterface::class)
        ->getValue(
            'SMSNotification/adminSMS/adminphonenumber',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
        );

        $objectManager =   \Magento\Framework\App\ObjectManager::getInstance();
        $connection = $objectManager->get('Magento\Framework\App\ResourceConnection')
        ->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION'); 
        $body = $connection->fetchOne("SELECT template_content FROM sms_template where event_type='New Registration'");
        

        $client = $this->clientFactory->create([
                 
            'username' => $this->getGeneralConfig('adminusername'),
            'password' => $this->getGeneralConfig('adminpassword'),
        ]);
        $params = [
            "messagingServiceSid" => $this->getGeneralConfig('msgserviceid'),
            'body' => $body,
        ];
        try{$client->messages->create($admin_number, $params);
            
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