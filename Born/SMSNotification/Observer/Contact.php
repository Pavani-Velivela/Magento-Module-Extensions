<?php

namespace Born\SMSNotification\Observer;

use Magento\Framework\Event\ObserverInterface;

use Magento\Framework\App\Config\ScopeConfigInterface;

use Magento\Store\Model\ScopeInterface;

use Twilio\Rest\ClientFactory;



use Born\SMSNotification\Model\SmsFactory;

use Psr\Log\LoggerInterface;

class Contact implements ObserverInterface
{
	public function __construct(
								//Action\Context $context,
								ClientFactory $clientFactory,
								ScopeConfigInterface $scopeConfig,
								\Magento\Sales\Model\OrderFactory $orderFactory,
								LoggerInterface $logger,
								SmsFactory $smsFactory
							) 
	{
		$this->clientFactory = $clientFactory;
		$this->scopeConfig = $scopeConfig;
        $this->orderFactory = $orderFactory;
        $this->logger = $logger;
        $this->smsFactory=$smsFactory;
        
	}

	public function execute(\Magento\Framework\Event\Observer $observer)
	{

		
		$event = $observer->getEvent();
        $name = $event->getRequest()->getPost()['name'];
        $email = $event->getRequest()->getPost()['email'];
        $content = $event->getRequest()->getPost()['comment'];
        $phone=$event->getRequest()->getPost()['telephone'];


		$objectManager =   \Magento\Framework\App\ObjectManager::getInstance();
    	$connection = $objectManager->get('Magento\Framework\App\ResourceConnection')
    	->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION'); 
    	$body = $connection->fetchOne('SELECT template_content FROM sms_template where event_type="Customer Contact"');
    	$newbody= str_replace(array('{name}','{comment}'), array($name, $content), $body);
    	 $body1=$connection->fetchOne('SELECT template_content FROM sms_template where event_type="Contact"');
    	 $newbody1= str_replace(array('{name}','{comment}'), array($name, $content), $body1);

    	$admin_number =  \Magento\Framework\App\ObjectManager::getInstance()
        ->get(\Magento\Framework\App\Config\ScopeConfigInterface::class)
        ->getValue(
            'SMSNotification/adminSMS/adminphonenumber',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
        );





		$client = $this->clientFactory->create([
            'username' => $this->getGeneralConfig('adminusername'),
            'password' => $this->getGeneralConfig('adminpassword'),
        ]);
        $params = [
            'from' => $this->getGeneralConfig('msgserviceid'),
            'body' => $newbody,

        ];
        $param1=[
            'from' => $this->getGeneralConfig('msgserviceid'),
            'body' => $newbody1,

        ];


        try{
       		$client->messages->create($phone, $params);
       		$client->messages->create($admin_number, $param1);
       		$this->logger->info('name', ['name' => $name]);
       		$this->logger->info('comment', ['content' => $phone]);


       	}
       	catch (\Exception $e) {
            $this->logger->critical('Error message', ['exception' => $e]);
            $this->logger->info('name', ['name' => $phone]);
       		$this->logger->info('comment', ['content' => $content]);
        }

	}


	public function getGeneralConfig($value)

    	{

        return $this->scopeConfig->getValue("SMSNotification/twilio/$value",ScopeInterface::SCOPE_STORE);
    	}
}