<?php

namespace Born\Subscription\Cron;

use Magento\Framework\App\Helper\AbstractHelper;

class Cron extends AbstractHelper
{
    protected $emulation;

    public function __construct(\Magento\Framework\App\Helper\Context $context,
      \Magento\Store\Model\StoreManagerInterface $storeManager,
      \Magento\Catalog\Model\Product $product,
      \Magento\Framework\Data\Form\FormKey $formkey,
      \Magento\Quote\Model\QuoteFactory $quote,
      \Magento\Quote\Model\QuoteManagement $quoteManagement,
      \Magento\Customer\Model\CustomerFactory $customerFactory,
      \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
      \Magento\Sales\Model\Service\OrderService $orderService,
      \Magento\Store\Model\App\Emulation $emulation,
      \Born\Subscription\Model\ResourceModel\Subscription\CollectionFactory $collectionFactory,
      \Magento\Quote\Model\ResourceModel\Quote\Item\CollectionFactory $quoteFactory,
      \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $salescollectionFactory,
      \Magento\Quote\Model\ResourceModel\Quote\Address\CollectionFactory $quoteaddressFactory
      )
    {
        $this->storeManager = $storeManager;
        $this->product = $product;
        $this->formkey = $formkey;
        $this->quote = $quote;
        $this->quoteManagement = $quoteManagement;
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;
        $this->orderService = $orderService;
        $this->emulation = $emulation;
        $this->collectionFactory = $collectionFactory;
        $this->quoteFactory = $quoteFactory;
        $this->salescollectionFactory = $salescollectionFactory;
        $this->quoteaddressFactory = $quoteaddressFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $cronTime = \Magento\Framework\App\ObjectManager::getInstance()
        ->get(\Magento\Framework\App\Config\ScopeConfigInterface::class)
        ->getValue(
            'subscription/general/cron',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
        );
        $cronTime = explode(',', $cronTime);
       
        // $cronHour = (int) $cronTime[0];
        // $cronMinute = (int) $cronTime[1];

        $cronHour = (int)date('H');
        $cronMinute = (int)date('i');
    
        $currentHour = (int)date('H');
        $currentMinute = (int)date('i');

        if ($cronHour == $currentHour && $cronMinute == $currentMinute)
        {

            $subscriptions = $this->collectionFactory->create();
            $subscriptions->addFieldToFilter('next_occurance_date',['eq'=>"2021-10-29"]);

            if($subscriptions->getSize()>0)
            {
                foreach ($subscriptions as $subscription) 
                {   $orderId = $subscription->getOrderId();   

                    $quotemodels = $this->salescollectionFactory->create()->addFieldToFilter('increment_id',['eq'=>$orderId]);
                    $date = $subscription->getNextOccuranceDate();
                    $billingperiod = $subscription->getBillingPeriod();
                    foreach($quotemodels as $quotemodel)
                    {

                        $quoteId = $quotemodel->getQuoteId();

                        $quoteIdData = $this->quoteFactory->create()->addFieldToFilter('quote_id',['eq'=>$quoteId]);
                        // $quoteIdData = $quoteIdData->addFieldToFilter('quote_id',['eq'=>$quoteId]);
                            foreach($quoteIdData as $productdetails)
                            {
                                $product_id = $productdetails->getProductId();
                                $sku = $productdetails->getSku();
                                $qty = $productdetails->getQty();
                                $price = $productdetails->getPrice();

                            }

                        $customerDetails = $this->quoteaddressFactory->create()->addFieldToFilter('quote_id',['eq'=>$quoteId]);
                        // $customerDetails = $customerDetails->addFieldToFilter('quote_id',['eq'=>$quote_id]);
                            foreach($customerDetails as $customerDetail)
                            {
                                $first_name = $customerDetail->getFirstName();
                                $last_name = $customerDetail->getLastName();
                                $street = $customerDetail->getStreet();
                                $city = $customerDetail->getCity();
                                $region = $customerDetail->getRegion();
                                $country_id = $customerDetail->getCountryId();
                                $postcode = $customerDetail->getPostcode();
                                $telephone = $customerDetail->getTelephone();
                                $save_in_address_book = $customerDetail->getSaveInAddressBook();
                                $email = $customerDetail->getEmail();
                            }

                    }

                    $order = [
                    'currency_id' => 'USD',
                    'email' => $email,
                    'shipping_address' => [
                        'firstname' => $first_name,
                        'lastname' => $last_name,
                        'street' => $street,
                        'city' => $city,
                        'country_id' => $country_id,
                        'region' => $region,
                        'postcode' => $postcode,
                        'telephone' => $telephone,
                        'save_in_address_book' => $save_in_address_book],
                    'items' => [
                        ['product_id' => $product_id, 'qty' => $qty , 'price' =>$price]
                        ]
                    ];
                $_store = 1;
                $this->emulation->startEnvironmentEmulation($_store, \Magento\Framework\App\Area::AREA_FRONTEND, true);
                $store = $this->storeManager->getStore();
                $websiteId = $this->storeManager->getStore()->getWebsiteId();
                $customer = $this->customerFactory->create();
                $customer->setWebsiteId($websiteId);
                $customer->loadByEmail($order['email']);
                if (!$customer->getEntityId()) 
                {
                   $customer->setWebsiteId($websiteId)->setStore($store)->setFirstname($order['shipping_address']['firstname'])->setLastname($order['shipping_address']['lastname'])->setEmail($order['email'])->setPassword($order['email']);
                    $customer->save();
                }
                $quote = $this->quote->create();
                $quote->setStore($store);
                $customer = $this->customerRepository->getById($customer->getEntityId());
                $quote->setCurrency();
                $quote->assignCustomer($customer);
               foreach ($order['items'] as $item) 
               {
                    $product = $this->product->load($item['product_id']);
                    $product->setPrice($item['price']);
                    $quote->addProduct($product, intval($item['qty']));
                }
                $quote->getBillingAddress()->addData($order['shipping_address']);
                $quote->getShippingAddress()->addData($order['shipping_address']);
                $shippingAddress = $quote->getShippingAddress();
                $shippingAddress->setCollectShippingRates(true)->collectShippingRates()->setShippingMethod('flatrate_flatrate');
                $quote->setPaymentMethod('checkmo');
                $quote->setInventoryProcessed(false);
                $quote->save();
                $quote->getPayment()->importData(['method' => 'checkmo']);
                $quote->collectTotals()->save();
                $orderdata = $this->quoteManagement->submit($quote);
                $orderdata->setEmailSent(0);
                $increment_id = $orderdata->getIncrementId();
                $this->emulation->stopEnvironmentEmulation();
                if ($orderdata->getEntityId()) {
                    $result['order_id'] = $orderdata->getIncrementId();
                } else {
                    $result = ['error' => 1, 'msg' => 'Your custom message'];
                }
                $subscription->setNextOccuranceDate(date('Y-m-d', strtotime($date. ' +'.$billingperiod.' days')))->save();
                return $result;
            }

            }

          
        }
    }
}       