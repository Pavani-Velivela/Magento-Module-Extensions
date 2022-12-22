<?php
namespace Born\Subscription\Observer;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
class OrderProduct implements ObserverInterface
{
    public function __construct(\Born\Subscription\Model\SubscriptionFactory $subscriptionFactory){
        $this->subscriptionFactory = $subscriptionFactory;
    }
    public function execute(EventObserver $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $items = $order->getAllVisibleItems();
        foreach ($items as $item)
        {
            $options=$item->getProductOptions();
            $subscription = $options['info_buyRequest']['subscription'] ?? false;
            $sub=(int)$subscription;
        }
        if($sub!=''){
            $model=$this->subscriptionFactory->create();
            $id=$order->getIncrementId();
            $date=$order->getCreatedAt();
            $model->setOrderId($id);
            $model->setSubscriptionPeriod($sub);
            $name=$order->getCustomerName();
            $model->setCustomername($name);
            $name=$order->getPaymentMethod();
            $model->setPaymentmethod($name);
            foreach($order->getData('items') as $item)
            {
                $product=$item->getName();
            }
            $model->setProductname($product);

            $model->setNextOccuranceDate(date('Y-m-d', strtotime($date. ' + '.$sub.'days')));
            $model->save();
        }
   
    }
}