<?php
namespace Born\Deliveryboy\Block\Adminhtml\User\Edit\Tab;

use Magento\Backend\Block\Widget\Form;

class Main extends \Magento\User\Block\User\Edit\Tab\Main
{
    /**
     * Prepare form fields
     *
     * @return Form
     */
    protected function _prepareForm()
    {
        parent::_prepareForm();
        $form = $this->getForm();
        $model = $this->_coreRegistry->registry('permissions_user');
        $baseFieldset = $form->getElement('base_fieldset');
        $baseFieldset->addField(
            'pincode',
            'text',
            [
                'name' => 'pincode',
                'label' => __('Pincode'),
                'title' => __('Pincode'),
                'required' => true,
                'value' => $model->getPincode()
            ]
        );
        return $this;
    }
}