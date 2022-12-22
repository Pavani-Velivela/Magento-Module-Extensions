<?php
namespace Born\Subscription\Plugin\Checkout\Model;
use Magento\Framework\App\Request\Http;
use Magento\Framework\DataObject\Factory as DataObjectFactory;
class Quote
{
    public function __construct(
        Http $request,
        DataObjectFactory $objectFactory
    ) {
        $this->request = $request;
        $this->objectFactory = $objectFactory;
    }
    public function beforeAddProduct($subject, $product, $request = null)
    {
        if ($request === null) {
            $request = 1;
        }
        if (is_numeric($request)) {
            $request = $this->objectFactory->create(['qty' => $request]);
        }
        if (!$request instanceof \Magento\Framework\DataObject) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('We found an invalid request for adding product to quote.')
            );
        }
        if($subscription = $request->getData('subscription')) {
            $info = [];
            $info[] = [
                'code' => 'subscription_details',
                'label' => "Subscription Details",
                'value' => $subscription
            ];
            $additionalInfo = json_encode($info);
            $product->addCustomOption('additional_options', $additionalInfo);
        }
    }
}