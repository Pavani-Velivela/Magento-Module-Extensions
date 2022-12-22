<?php
 
namespace Born\GeoIp\Model\Config;
 
class redirectin implements \Magento\Framework\Option\ArrayInterface
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
            'Store view' => __('Store view'),
            'External link' => __('External link'),
        ];
    }
}