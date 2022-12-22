<?php
namespace Born\SMSNotification\Model\Config;

use Magento\Framework\Option\ArrayInterface;

class adminevents implements ArrayInterface
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
            'New Registration' => __('New Registration'),
            'New Order' => __('New Order'),
            'Customer Contact' => __('Customer Contact'),
        ];
    }
}