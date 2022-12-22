<?php

namespace Born\Deliveryboy\Observer;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\ObserverInterface;

class Deliveryboy implements ObserverInterface
{
    protected $userCollection;
    public function __construct(\Magento\User\Model\ResourceModel\User\Collection $userCollection)
    {
        $this->userCollection = $userCollection;
    }
    public function execute(EventObserver $observer)
    {
       $order = $observer->getOrder();
       $postcode = $order->getShippingAddress()->getPostcode();
        $userData=$this->userCollection;
        $userData->addFieldToFilter('pincode',['finset' => $postcode]);
          foreach($userData as $data){
            $name=$data->getUsername();
         $order->setDeliveryBoy($name);
        }
      
     }
}

