<?php
namespace Born\SMSNotification\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Twilio\Rest\ClientFactory;
use Born\SMSNotification\Model\TemplatesFactory;
use Psr\Log\LoggerInterface;
class OrderPlaceAfter implements ObserverInterface
{
    
    public function __construct(
                                //Action\Context $context,
                                ClientFactory $clientFactory,
                                ScopeConfigInterface $scopeConfig,
                                \Magento\Sales\Model\OrderFactory $orderFactory,
                                LoggerInterface $logger,
                                TemplatesFactory $templatesFactory
                            )
    {
        $this->clientFactory = $clientFactory;
        $this->scopeConfig = $scopeConfig;
        $this->orderFactory = $orderFactory;
        $this->logger = $logger;
        $this->templatesFactory=$templatesFactory;
        //parent::__construct($context);
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        
    echo $this->getGeneralConfig('enable');
    if ($this->getGeneralConfig('enable')=='No') {
            return $this->getGeneralConfig('enable');      }
        $order = $observer->getEvent()->getOrder();
        $firstname=$order->getCustomerFirstName();
        $lastname=$order->getCustomerLasttName();
        $username=$this->getGeneralConfig('twiliosid');
        $password=$this->getGeneralConfig('twiliotoken');
        $number=$order->getShippingAddress()->getTelephone();
        $order_id=$order->getIncrementId();
        $totall = $order->getGrandTotal();
        foreach ($order->getAllVisibleItems() as $_item) {
                    $name=$_item->getName();
}
        $admin_number =  \Magento\Framework\App\ObjectManager::getInstance()
        ->get(\Magento\Framework\App\Config\ScopeConfigInterface::class)
        ->getValue(
            'SMSNotification/adminsms/phone',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
        );
        $objectManager =   \Magento\Framework\App\ObjectManager::getInstance();
        $connection = $objectManager->get('Magento\Framework\App\ResourceConnection')
        ->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');
        $body = $connection->fetchOne("SELECT template_content FROM sms_template where id=7");
        //$body1=$connection->fetchOne("SELECT template_content FROM sms_template where id=6");
        $newbody= str_replace(array('{firstname}','{lastname}','{order_id}','{total}','{orderitem}'), array($firstname, $lastname, $order_id, $totall,$name), $body);
       // $newbody1= str_replace(array('{order_id}','{total}'), array($order_id, $totall) , $body1);
        $client = $this->clientFactory->create([
            'username' => $this->getGeneralConfig('twiliosid'),
            'password' => $this->getGeneralConfig('twiliotoken'),
        ]);
        $params = [
            'from' => $this->getGeneralConfig('msgserviceid'),
            'body' => $newbody,
        ];
      /*  $param1=[
            'from' => $this->getGeneralConfig('msgserviceid'),
            'body' => $newbody1
        ];*/
        try{
            $client->messages->create($order->getShippingAddress()->getTelephone(), $params);
            
            
        }
        catch (\Exception $e) {
            $this->logger->critical('Error message', ['exception' => $e]);
        }
    }
        public function getGeneralConfig($value)
        {
        return $this->scopeConfig->getValue("SMSNotification/general/$value",ScopeInterface::SCOPE_STORE);
        }
}