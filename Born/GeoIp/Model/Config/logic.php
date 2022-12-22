<?php
 
namespace Born\GeoIp\Model\Config;
 
class logic implements \Magento\Framework\Option\ArrayInterface
{
 
    public function toOptionArray()
    {
        return [
            ['value' => 0, 'label' => __('All URLs')],
           
         
        ];
    }
}