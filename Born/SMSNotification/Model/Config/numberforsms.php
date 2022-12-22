<?php

namespace Born\SMSNotification\Model\Config;

class numberforsms implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
        {        
             return [
                ['value' => 0, 'label' => __('Shipping Address Number')], 
                ['value' => 1, 'label' => __('Building Address Number')],
                ['value' => 2, 'label' => __('Both')]
             ];
        }
}    