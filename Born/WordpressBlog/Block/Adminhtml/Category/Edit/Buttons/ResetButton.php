<?php



namespace Born\WordpressBlog\Block\Adminhtml\Category\Edit\Buttons;



use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;




class ResetButton implements ButtonProviderInterface

{

    
    public function getButtonData()

    {

        return [

            'label' => __('Reset'),

            'class' => 'reset',

            'on_click' => 'location.reload();',

            'sort_order' => 30

        ];

    }

}