<?php



namespace Born\WordpressBlog\Block\Adminhtml\Category\Edit\Buttons;



use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;


class SaveAndContinueButton extends GenericButton implements ButtonProviderInterface

{

    public function getButtonData()

    {

        return [

            'label' => __('Save and Continue Edit'),

            'class' => 'save',

            'data_attribute' => [

                'mage-init' => [

                    'button' => ['event' => 'saveAndContinueEdit'],

                ],

            ],

            'sort_order' => 80,

        ];

    }

}