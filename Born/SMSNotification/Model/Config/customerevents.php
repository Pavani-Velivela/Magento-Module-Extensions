<?php
namespace Born\SMSNotification\Model\Config;
 
class customerevents implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        $result = [];
        foreach ($this->getOptions() as $value => $label) {
            $result[] = [
                 'value' => $value,
                 'label' => $label,
             ];
        }

        return $result;
    }

    public function getOptions()
    {
        return [
            'Order Place' => __('Order Place'),
            'Contact' => __('Contact'),
            'Admin Order Cancel' => __('Admin Order Cancel'),
            'Admin Invoice Order' => __('Admin Invoice Order'),
            'Admin Creditmemo Order' => __('Admin Creditmemo Order'),
            'Admin Shipment Order' => __('Admin Shipment Order'),
            'Admin Shipment Tracking' => __('Admin Shipment Tracking'),
        ];
    }
}