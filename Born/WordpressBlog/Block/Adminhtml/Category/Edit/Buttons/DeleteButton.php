<?php



namespace Born\WordpressBlog\Block\Adminhtml\Category\Edit\Buttons;


use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;


class DeleteButton extends GenericButton implements ButtonProviderInterface

{


    public function getButtonData()

    {

        $data = [];

        if ($this->getItemId()) {

            $data = [

                'label' => __('Delete Item'),

                'class' => 'delete',

                'on_click' => 'deleteConfirm(\'' . __(

                    'Are you sure you want to do this?'

                ) . '\', \'' . $this->getDeleteUrl() . '\')',

                'sort_order' => 20,

            ];

        }

        return $data;

    }



    public function getDeleteUrl()

    {

        return $this->getUrl('*/*/delete', ['id' => $this->getItemId()]);

    }

}