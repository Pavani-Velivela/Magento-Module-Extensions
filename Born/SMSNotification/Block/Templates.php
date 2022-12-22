<?php
namespace Born\SMSNotification\Block\Adminhtml;

class Templates extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_templates';
        $this->_blockGroup = 'Born_SMSNotification';
        $this->_headerText = __('General Information');

        parent::_construct();

        if ($this->_isAllowedAction('Born_SMSNotificaton::save')) {
            $this->buttonList->update('add', 'label', __('Add New'));
        } else {
            $this->buttonList->remove('add');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}